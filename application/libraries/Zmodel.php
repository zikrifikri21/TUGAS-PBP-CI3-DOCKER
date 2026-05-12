<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './system/core/Model.php';

class ZModel extends CI_Model implements ArrayAccess
{
    // Tambahkan variabel static ini untuk menyimpan koneksi master
    protected static $_db_connections = [];

    protected $_table;
    protected $_primary_key = 'id';
    protected $_relations = array();
    protected $db_group = 'default';
    protected $_db_instance;
    protected $_wheres = array();
    protected $_joined_relations = array();
    protected $_joined_tables = array();

    public function __construct($db_group = 'default')
    {
        parent::__construct();
        $this->db_group = $db_group;

        // CEK 1: Apakah koneksi master untuk grup ini sudah ada di memori static?
        if (!isset(self::$_db_connections[$this->db_group])) {

            // Jika BELUM ada, kita buat koneksi baru dengan TRUE.
            // Ini hanya akan dieksekusi 1 kali saja selama request berjalan,
            // jadi aman dari "Too many connections".
            $db_object = $this->load->database($this->db_group, TRUE);

            // Simpan ke variabel static agar bisa dipakai ulang oleh instance lain
            self::$_db_connections[$this->db_group] = $db_object;
        }

        // CEK 2: Clone dari master connection
        // Kita mengambil object DB yang sudah tersimpan di static, lalu meng-CLONE-nya.
        // Hasil clone ini punya Query Builder sendiri (WHERE/SELECT terpisah),
        // tapi menggunakan 'conn_id' (kabel koneksi fisik) yang sama.
        $this->_db_instance = clone self::$_db_connections[$this->db_group];

        // Reset query builder untuk memastikan object clone benar-benar bersih saat baru dibuat
        if (method_exists($this->_db_instance, 'reset_query')) {
            $this->_db_instance->reset_query();
        }
    }

    protected function _autoJoinRelation($relation)
    {
        if (in_array($relation, $this->_joined_relations)) {
            return;
        }

        if (!method_exists($this, $relation)) {
            return;
        }

        $info = $this->{$relation}(null);
        $type = $info['type'] ?? null;
        $table = $info['relatedTable'] ?? null;

        if (!$table) return;

        if ($type === 'belongsTo' || $type === 'hasOne' || $type === 'hasMany') {

            if (!in_array($table, $this->_joined_tables)) {

                if ($type === 'belongsTo') {
                    $condition = "{$this->_table}.{$info['foreignKey']} = {$table}.{$info['ownerKey']}";
                } else {
                    $condition = "{$table}.{$info['foreignKey']} = {$this->_table}.{$info['localKey']}";
                }

                $this->_db_instance->join($table, $condition, 'left');
                $this->_joined_tables[] = $table;
            }
        } elseif ($type === 'hasOneThrough') {
            $interTable = $info['intermediateTable']; // Tabel Perantara (misal: mahasiswa)

            // 1. Join Tabel Perantara (Cek duplikasi dulu!)
            if (!in_array($interTable, $this->_joined_tables)) {
                $interJoinCond = "{$interTable}.{$info['foreignKeyOnIntermediate']} = {$this->_table}.{$info['localKey']}";
                $this->_db_instance->join($interTable, $interJoinCond, 'left');
                $this->_joined_tables[] = $interTable; // Tandai tabel perantara sudah di-join
            }

            // 2. Join Tabel Tujuan Akhir (Cek duplikasi dulu!)
            if (!in_array($table, $this->_joined_tables)) {
                $finalJoinCond = "{$table}.{$info['foreignKeyOnFinal']} = {$interTable}.{$info['intermediateKey']}";
                $this->_db_instance->join($table, $finalJoinCond, 'left');
                $this->_joined_tables[] = $table; // Tandai tabel akhir sudah di-join
            }
        }
        $this->_joined_relations[] = $relation;
    }

    protected function _parseColumnAndJoin($key)
    {
        if (strpos($key, '.') !== false) {
            list($relation, $column) = explode('.', $key, 2);

            if (method_exists($this, $relation)) {
                $this->_autoJoinRelation($relation);
                $info = $this->{$relation}(null);

                // SAFETY: Pastikan ada nama tabelnya
                if (!empty($info['relatedTable'])) {
                    return $info['relatedTable'] . '.' . $column;
                }
            }
        }
        return $key;
    }

    /**
     * Mengecek apakah sebuah offset ada (bagian dari ArrayAccess).
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->{$offset});
    }

    /**
     * Mendapatkan sebuah offset (bagian dari ArrayAccess).
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        // Juga memungkinkan akses ke relasi yang belum dimuat (lazy loading)
        if (method_exists($this, $offset) && !isset($this->{$offset})) {
            $this->loadRelation($offset);
        }
        return $this->{$offset} ?? null;
    }

    /**
     * Mengatur sebuah offset (bagian dari ArrayAccess).
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            // Perilaku ini tidak umum untuk model, jadi kita abaikan
        } else {
            $this->{$offset} = $value;
        }
    }

    /**
     * Menghapus sebuah offset (bagian dari ArrayAccess).
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->{$offset});
    }

    /**
     * Helper untuk memuat relasi tunggal secara on-demand (lazy loading).
     * @param string $relation
     */
    protected function loadRelation($relation)
    {
        if (method_exists($this, $relation)) {
            $relatedData = $this->{$relation}($this);
            $this->{$relation} = $relatedData;
        }
    }

    /**
     * Menambahkan klausa SELECT ke query.
     * Menerima berbagai format argumen:
     *  - select('kolom1', 'kolom2')
     *  - select(['kolom1', 'kolom2'])
     *  - select('kolom1, kolom2')
     *
     * @param mixed ...$columns Kolom yang ingin dipilih.
     * @return ZModel
     */
    public function select(...$columns)
    {
        if (count($columns) === 1 && is_array($columns[0])) {
            $columns = $columns[0];
        }

        $this->_db_instance->select($columns);

        return $this;
    }


    public function setDatabaseGroup($db_group)
    {
        $this->db_group = $db_group;
        $this->_db_instance = $this->load->database($this->db_group, TRUE);
        return $this;
    }

    public static function table($db_group = 'default')
    {
        return new static($db_group);
    }

    public static function all($db_group = 'default')
    {
        $instance = new static($db_group);
        return $instance->_db_instance->get($instance->_table)->result();
    }
    public function whereHas(string $relation, ?callable $callback = null)
    {
        if (!method_exists($this, $relation)) {
            log_message('error', "Relation method '{$relation}' not found in " . get_class($this));
            return $this;
        }

        $relation_info = $this->{$relation}(null);

        $relatedTable   = $relation_info['relatedTable'] ?? null;
        $relatedDbGroup = $relation_info['relatedDbGroup'] ?? $this->db_group;
        $type           = $relation_info['type'] ?? null;

        if (!$relatedTable || !$type) {
            log_message('error', "Incomplete relation information for '{$relation}' in " . get_class($this));
            return $this;
        }
        if ($type !== 'belongsTo') {
            log_message('error', "Multi-database whereHas currently only supports belongsTo relations.");
            return $this;
        }

        $keyForMainQuery = $relation_info['foreignKey'];
        $keyForSubQuery  = $relation_info['ownerKey'];
        $relatedDb = $this->load->database($relatedDbGroup, TRUE);

        $relatedDb->select($keyForSubQuery)->from($relatedTable);
        if ($callback) {
            $callback($relatedDb);
        }

        $subQueryResult = $relatedDb->get()->result_array();

        if (empty($subQueryResult)) {
            $this->_db_instance->where('1=0');
            return $this;
        }

        $validIds = array_column($subQueryResult, $keyForSubQuery);

        $this->_db_instance->where_in($keyForMainQuery, $validIds);

        $this->_wheres[] = [
            'type' => 'where_in',
            'key' => $keyForMainQuery,
            'values' => $validIds
        ];

        return $this;
    }

    public function where($key, $operator = null, $value = null, $escape = null)
    {
        // 1. Closure (Grouping)
        if (is_callable($key)) {
            $this->_db_instance->group_start();
            $key($this);
            $this->_db_instance->group_end();
            return $this;
        }

        // 2. Array
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $k = $this->_parseColumnAndJoin($k);
                $this->_db_instance->where($k, $v, $escape);
                $this->_wheres[] = ['key' => $k, 'value' => $v, 'type' => 'where'];
            }
            return $this;
        }

        // 3. Mode 3 Argumen (Laravel Style)
        if ($value !== null) {
            $key = $this->_parseColumnAndJoin($key);
            $operator = trim(strtolower($operator));

            if ($operator === 'like') {
                // UPDATE: Gunakan where manual agar % dari controller tidak di-escape
                $this->_db_instance->where("$key LIKE", $value, $escape);
            } elseif ($operator === 'not like') {
                $this->_db_instance->where("$key NOT LIKE", $value, $escape);
            } else {
                $this->_db_instance->where("$key $operator", $value, $escape);
            }

            $this->_wheres[] = ['key' => $key, 'operator' => $operator, 'value' => $value, 'type' => 'where_3_args'];
            return $this;
        }

        // 4. Mode 2 Argumen
        if ($operator !== null) {
            $realValue = $operator;
            $key = $this->_parseColumnAndJoin($key);
            $this->_db_instance->where($key, $realValue, $escape);
            $this->_wheres[] = ['key' => $key, 'value' => $realValue, 'type' => 'where'];
            return $this;
        }

        // 5. Raw String
        $this->_db_instance->where($key, null, $escape);
        $this->_wheres[] = ['condition' => $key, 'type' => 'where_raw'];
        return $this;
    }

    public function orWhere($key, $operator = null, $value = null, $escape = null)
    {
        // 1. Closure
        if (is_callable($key)) {
            $this->_db_instance->or_group_start();
            $key($this);
            $this->_db_instance->group_end();
            return $this;
        }

        // 2. Array
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $k = $this->_parseColumnAndJoin($k);
                $this->_db_instance->or_where($k, $v, $escape);
            }
            return $this;
        }

        // 3. Mode 3 Argumen (Laravel Style)
        if ($value !== null) {
            $key = $this->_parseColumnAndJoin($key);
            $operator = trim(strtolower($operator));

            if ($operator === 'like') {
                // UPDATE: Gunakan or_where manual
                $this->_db_instance->or_where("$key LIKE", $value, $escape);
            } elseif ($operator === 'not like') {
                $this->_db_instance->or_where("$key NOT LIKE", $value, $escape);
            } else {
                $this->_db_instance->or_where("$key $operator", $value, $escape);
            }
            return $this;
        }

        // 4. Mode 2 Argumen
        if ($operator !== null) {
            $realValue = $operator;
            $key = $this->_parseColumnAndJoin($key);
            $this->_db_instance->or_where($key, $realValue, $escape);
            return $this;
        }

        // 5. Raw String
        $this->_db_instance->or_where($key, null, $escape);
        return $this;
    }

    public function whereNotIn($field, array $values)
    {
        if (!empty($values)) {
            $this->_db_instance->where_not_in($field, $values);
        }
        return $this;
    }

    /**
     * @param string $field Nama kolom.
     * @param array $values Array nilai yang akan dikecualikan.
     * @return ZModel
     */
    public function orWhereNotIn($field, array $values)
    {
        if (!empty($values)) {
            $this->_db_instance->or_where_not_in($field, $values);
        }
        return $this;
    }

    /**
     * Menambahkan klausa WHERE IN ke query.
     * @param string $field Nama kolom.
     * @param array $values Array nilai yang akan dicari.
     * @return ZModel
     */
    public function whereIn($field, array $values)
    {
        $this->_db_instance->where_in($field, $values);
        $this->_wheres[] = ['type' => 'where_in', 'key' => $field, 'values' => $values];
        return $this;
    }

    /**
     * Menambahkan klausa OR WHERE IN ke query.
     * @param string $field Nama kolom.
     * @param array $values Array nilai yang akan dicari.
     * @return ZModel
     */
    public function orWhereIn($field, array $values)
    {
        $this->_db_instance->or_where_in($field, $values);
        $this->_wheres[] = ['type' => 'or_where_in', 'key' => $field, 'values' => $values];
        return $this;
    }

    /**
     * Menambahkan klausa WHERE column IS NULL ke query.
     * @param string $field Nama kolom.
     * @return ZModel
     */
    public function whereNull($field)
    {
        $this->_db_instance->where("{$field} IS NULL");
        return $this;
    }

    /**
     * Menambahkan klausa OR WHERE column IS NULL ke query.
     * @param string $field Nama kolom.
     * @return ZModel
     */
    public function orWhereNull($field)
    {
        // PERBAIKAN: Menggunakan or_where()
        $this->_db_instance->or_where("{$field} IS NULL");
        return $this;
    }

    /**
     * Menambahkan klausa WHERE column IS NOT NULL ke query.
     * @param string $field Nama kolom.
     * @return ZModel
     */
    public function whereNotNull($field)
    {
        $this->_db_instance->where("{$field} IS NOT NULL");
        return $this;
    }

    /**
     * Menambahkan klausa OR WHERE column IS NOT NULL ke query.
     * @param string $field Nama kolom.
     * @return ZModel
     */
    public function orWhereNotNull($field)
    {
        $this->_db_instance->or_where("{$field} IS NOT NULL");
        return $this;
    }


    /**
     * Terapkan callback scope jika kondisi yang diberikan adalah true.
     *
     * @param mixed $condition Kondisi yang akan dievaluasi.
     * @param callable $callback Fungsi callback yang akan dijalankan jika kondisi true.
     * @param callable|null $default Callback default yang akan dijalankan jika kondisi false (opsional).
     * @return $this
     */
    public function when($condition, callable $callback, callable $default = null)
    {
        if ($condition) {
            $callback($this);
        } elseif ($default) {
            $default($this);
        }
        return $this;
    }

    public function createOrUpdate(array $attributes, array $values = [])
    {
        $record = $this->_db_instance->where($attributes)->get($this->_table)->row();

        if ($record) {
            $this->update($record->{$this->_primary_key}, $values);
            return $this->_db_instance->where($this->_primary_key, $record->{$this->_primary_key})->get($this->_table)->row();
        } else {
            $data_to_insert = array_merge($attributes, $values);
            $insert_id = $this->insert($data_to_insert);
            return $this->_db_instance->where($this->_primary_key, $insert_id)->get($this->_table)->row();
        }
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        // Cari data berdasarkan attributes (hanya mencari dengan attributes)
        $query = $this->_db_instance->where($attributes)->get($this->_table);
        $record = $query->row();

        if ($record) {
            // Jika ditemukan → update
            $this->_db_instance
                ->where($this->_primary_key, $record->{$this->_primary_key})
                ->update($this->_table, $values);

            return $this->_db_instance
                ->where($this->_primary_key, $record->{$this->_primary_key})
                ->get($this->_table)
                ->row();
        }

        // Jika tidak ditemukan → insert
        $data = array_merge($attributes, $values);
        $this->_db_instance->insert($this->_table, $data);
        $insert_id = $this->_db_instance->insert_id();

        return $this->_db_instance
            ->where($this->_primary_key, $insert_id)
            ->get($this->_table)
            ->row();
    }

    public function with(...$relations)
    {
        foreach ($relations as $relation) {
            $baseRelation = strtok($relation, '.');
            if (method_exists($this, $baseRelation)) {
                $this->_relations[] = $relation;
            } else {
                log_message('error', "Relation method '{$baseRelation}' not found in " . get_class($this));
            }
        }
        return $this;
    }

    public function get($id = null)
    {
        if ($id !== null) {
            $this->_db_instance->where($this->_table . '.' . $this->_primary_key, $id);
        }

        if (empty($this->_db_instance->qb_select) && !empty($this->_joined_relations)) {
            $this->_db_instance->select($this->_table . '.*');
        }

        $rawResult = ($id !== null) ? $this->_db_instance->get($this->_table)->row() : $this->_db_instance->get($this->_table)->result();

        $result = $this->hydrate($rawResult);

        if ($result) {
            $this->applyRelations($result);
            $this->cleanupHelperProperties($result);
        }

        return $result;
    }

    /**
     * Titik awal untuk memuat relasi.
     * Mengubah daftar relasi menjadi array bersarang dan memulai proses rekursif.
     */
    protected function applyRelations(&$result)
    {
        if (empty($result) || empty($this->_relations)) {
            return;
        }

        // 1. Ubah daftar relasi menjadi array bersarang
        $parsedRelations = [];
        foreach ($this->_relations as $relation) {
            $parts = explode('.', $relation);
            $temp = &$parsedRelations;
            foreach ($parts as $part) {
                if (!isset($temp[$part])) {
                    $temp[$part] = [];
                }
                $temp = &$temp[$part];
            }
        }

        // 2. Mulai proses pemuatan rekursif
        $items = is_array($result) ? $result : [$result];
        $this->loadRelationsRecursively($items, $parsedRelations);
    }

    /**
     * Memuat relasi secara rekursif untuk setiap level.
     * @param array &$items Referensi ke array objek yang relasinya akan dimuat.
     * @param array $parsedRelations Array relasi bersarang untuk level saat ini.
     */
    protected function loadRelationsRecursively(array &$items, array $parsedRelations)
    {
        if (empty($items) || empty($parsedRelations)) {
            return;
        }

        // Tentukan model yang akan digunakan untuk memanggil metode relasi.
        // Untuk level pertama, gunakan '$this'. Untuk level berikutnya, gunakan model yang
        // sudah kita sisipkan ke dalam properti '_model' dari hasil relasi sebelumnya.
        $modelContext = isset($items[0]->_model) ? $items[0]->_model : $this;

        foreach ($parsedRelations as $relationName => $nested) {
            // Pastikan metode relasi ada di konteks model yang benar
            if (!method_exists($modelContext, $relationName)) {
                log_message('error', "Relation method '{$relationName}' not found in " . get_class($modelContext));
                continue;
            }

            $nextLevelItems = [];
            foreach ($items as &$item) {
                // Panggil metode relasi (misal: mahasiswa() atau jurusan()) dari model yang tepat
                $relatedData = $modelContext->{$relationName}($item);
                $item->{$relationName} = $relatedData;

                // Kumpulkan hasil dari relasi yang baru dimuat untuk diproses di level selanjutnya
                if (!empty($nested) && !is_null($relatedData)) {
                    if (is_array($relatedData)) {
                        $nextLevelItems = array_merge($nextLevelItems, $relatedData);
                    } else {
                        $nextLevelItems[] = $relatedData;
                    }
                }
            }
            unset($item); // Penting: Hapus referensi terakhir

            // Jika ada relasi bersarang untuk dimuat, panggil fungsi ini lagi (rekursif)
            // untuk hasil yang baru saja kita kumpulkan.
            if (!empty($nextLevelItems) && !empty($nested)) {
                $this->loadRelationsRecursively($nextLevelItems, $nested);
            }
        }
    }

    /**
     * Membersihkan properti internal (_model) dari hasil query secara rekursif.
     * @param mixed $data Objek atau array objek yang akan dibersihkan.
     */
    protected function cleanupHelperProperties(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$item) {
                $this->cleanupHelperProperties($item);
            }
        } elseif (is_object($data)) {
            // Hapus properti _model jika ada
            if (isset($data->_model)) {
                unset($data->_model);
            }

            // Lakukan pembersihan secara rekursif untuk properti lain yang mungkin berupa objek relasi
            foreach (get_object_vars($data) as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    $this->cleanupHelperProperties($data->{$key});
                }
            }
        }
    }

    protected function belongsTo($relatedModel, $foreignKey, $ownerKey, $result = null)
    {
        // 1. RESOLVE NAMA TABEL
        // Cek apakah input berupa Class Model atau String nama tabel
        $relatedTable = $relatedModel;
        if (class_exists($relatedModel)) {
            $instance = new $relatedModel();
            $relatedTable = $instance->_table;
        }

        // 2. MODE METADATA (Dipakai oleh Auto-Join & Search)
        // Jika result null, kembalikan info relasi agar ZModel tau tabel apa yang harus di-join
        if ($result === null) {
            return [
                'type'           => 'belongsTo',
                'relatedTable'   => $relatedTable,
                'foreignKey'     => $foreignKey, // Kolom di tabel saat ini (ex: jurusan_id)
                'ownerKey'       => $ownerKey,   // Kolom di tabel relasi (ex: id)
            ];
        }

        // 3. MODE DATA (Dipakai oleh With / Lazy Loading)
        // Eksekusi query untuk mengambil data
        if (isset($result->{$foreignKey})) {
            $db_relasi = $this->load->database($this->db_group, TRUE);

            $rawRelatedData = $db_relasi->where($ownerKey, $result->{$foreignKey})
                ->get($relatedTable)
                ->row();

            if ($rawRelatedData && class_exists($relatedModel)) {
                $relatedInstance = new $relatedModel();
                $relatedData = $relatedInstance->hydrate($rawRelatedData);

                $relatedData->_model = $relatedInstance;

                return $relatedData;
            }

            return $rawRelatedData ?: null;
        }
        return null;
    }

    protected function hasOne($relatedTable, $foreignKey, $localKey, $result = null)
    {
        $tableName = $relatedTable;
        if (class_exists($relatedTable)) {
            $instance = new $relatedTable();
            $tableName = $instance->_table;
        }

        if ($result === null) {
            return [
                'type' => 'hasOne',
                'relatedTable' => $tableName,
                'foreignKey' => $foreignKey,
                'localKey' => $localKey
            ];
        }

        if (isset($result->{$localKey})) {
            $db_relasi = $this->load->database($this->db_group, TRUE);
            $relatedData = $db_relasi->where($foreignKey, $result->{$localKey})
                ->get($tableName)
                ->row();

            if ($relatedData && class_exists($relatedTable)) {
                $relatedInstance = new $relatedTable();
                $data = $relatedInstance->hydrate($relatedData);
                $data->_model = $relatedInstance;
                return $data;
            }
            return $relatedData ?: null;
        }
        return null;
    }

    protected function hasMany($relatedTable, $foreignKey, $localKey, $result = null)
    {
        $tableName = $relatedTable;
        if (class_exists($relatedTable)) {
            $instance = new $relatedTable();
            $tableName = $instance->_table;
        }

        if ($result === null) {
            return [
                'type' => 'hasMany',
                'relatedTable' => $tableName,
                'foreignKey' => $foreignKey,
                'localKey' => $localKey
            ];
        }

        if (isset($result->{$localKey})) {
            $db_relasi = $this->load->database($this->db_group, TRUE);
            $relatedData = $db_relasi->where($foreignKey, $result->{$localKey})
                ->get($tableName)
                ->result();

            if (!empty($relatedData) && class_exists($relatedTable)) {
                foreach ($relatedData as &$rd) {
                    $rd->_model = new $relatedTable();
                }
            }
            return $relatedData ?: [];
        }
        return [];
    }

    static function last($db_group = 'default')
    {
        $instance = new static($db_group);
        return $instance->_db_instance->order_by($instance->_primary_key, 'desc')->limit(1)->get($instance->_table)->row();
    }

    public function first()
    {
        $rawResult = $this->_db_instance->order_by($this->_primary_key, 'asc')->limit(1)->get($this->_table)->row();
        $result = $this->hydrate($rawResult);

        if ($result) {
            $this->applyRelations($result);
            $this->cleanupHelperProperties($result);
        }
        return $result;
    }

    /**
     * Filter data dimana relasi TIDAK ditemukan (NOT EXISTS).
     *
     * @param string $relation Nama method relasi (misal: 'penilaian')
     * @param callable|null $callback Closure untuk filter tambahan di dalam subquery
     * @return ZModel
     */
    public function whereDoesntHave(string $relation, ?callable $callback = null)
    {
        if (!method_exists($this, $relation)) {
            log_message('error', "Relation '{$relation}' not found in " . get_class($this));
            return $this;
        }

        $relation_info = $this->{$relation}(null);

        $relatedTable = $relation_info['relatedTable'] ?? null;
        $foreignKey   = $relation_info['foreignKey'] ?? null;
        $localKey     = $relation_info['localKey'] ?? 'id';

        if ($relation_info['type'] === 'belongsTo') {
            $foreignKey = $relation_info['ownerKey'];
            $localKey   = $relation_info['foreignKey'];
        }

        if (!$relatedTable || !$foreignKey) {
            return $this;
        }

        $subDb = $this->load->database($this->db_group, TRUE);

        $subDb->select('1')->from($relatedTable);

        if ($callback) {
            $callback($subDb);
        }

        $subDb->where("{$relatedTable}.{$foreignKey} = {$this->_table}.{$localKey}", null, false);

        $subQuerySQL = $subDb->get_compiled_select();

        $this->_db_instance->where("NOT EXISTS ({$subQuerySQL})", null, false);

        return $this;
    }

    public function skip($offset)
    {
        $this->_db_instance->offset($offset);
        return $this;
    }

    public function take($limit)
    {
        $this->_db_instance->limit($limit);
        return $this;
    }

    public function insert($data)
    {
        foreach ($data as $key => $value) {
            if ($value === null) {
                $this->_db_instance->set($key, 'NULL', FALSE);
            } else {
                $this->_db_instance->set($key, $value);
            }
        }
        $this->_db_instance->insert($this->_table);
        return $this->_db_instance->insert_id();
    }

    public function update($where, $data)
    {
        if (is_array($where)) {
            $this->_db_instance->where($where);
        } else {
            $this->_db_instance->where($this->_primary_key, $where);
        }

        // Perulangan untuk menangani nilai NULL secara eksplisit
        foreach ($data as $key => $value) {
            if ($value === null) {
                // Memberitahu CI untuk menulis NULL tanpa petik (escape = false)
                $this->_db_instance->set($key, 'NULL', FALSE);
            } else {
                $this->_db_instance->set($key, $value);
            }
        }

        return $this->_db_instance->update($this->_table);
    }

    public function delete($id)
    {
        $this->_db_instance->where($this->_primary_key, $id);
        return $this->_db_instance->delete($this->_table);
    }

    public function setTable($table_name)
    {
        $this->_table = $table_name;
        return $this;
    }

    public function setPrimaryKey($key_name)
    {
        $this->_primary_key = $key_name;
        return $this;
    }

    protected $_limit = null;
    protected $_offset = null;
    protected $_total_records = 0;

    /**
     * Set limit dan offset untuk pagination
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function paginate($limit = 10, $offset = 0)
    {
        $this->_limit = $limit;
        $this->_offset = $offset;
        $this->_db_instance->limit($limit, $offset);
        return $this;
    }

    public function getTotalRecords()
    {
        $count_db = $this->load->database($this->db_group, TRUE);

        foreach ($this->_joined_relations as $relation) {
            if (method_exists($this, $relation)) {
                $info = $this->{$relation}(null);
                $table = $info['relatedTable'] ?? null;
                $type = $info['type'] ?? null;

                if ($table) {
                    if ($type === 'belongsTo') {
                        $condition = "{$this->_table}.{$info['foreignKey']} = {$table}.{$info['ownerKey']}";
                        $count_db->join($table, $condition, 'left');
                    } elseif ($type === 'hasOne' || $type === 'hasMany') {
                        $condition = "{$table}.{$info['foreignKey']} = {$this->_table}.{$info['localKey']}";
                        $count_db->join($table, $condition, 'left');
                    }
                }
            }
        }

        foreach ($this->_wheres as $where) {
            if ($where['type'] === 'where') {
                $count_db->where($where['key'], $where['value']);
            } elseif ($where['type'] === 'where_in') {
                $count_db->where_in($where['key'], $where['values']);
            } elseif ($where['type'] === 'search') {
                $count_db->group_start();
                foreach ($where['fields'] as $field) {
                    $count_db->or_like($field, $where['keyword']);
                }
                $count_db->group_end();
            } elseif ($where['type'] === 'where_3_args') {
                $op = $where['operator'];
                $k = $where['key'];
                $v = $where['value'];

                if ($op === 'like') {
                    $count_db->where("$k LIKE", $v);
                } elseif ($op === 'not like') {
                    $count_db->where("$k NOT LIKE", $v);
                } else {
                    $count_db->where("$k $op", $v);
                }

                $count_db->where("{$where['key']} {$where['operator']}", $where['value']);
            } elseif ($where['type'] === 'where_raw') {
                $count_db->where($where['condition']);
            }
        }

        return $count_db->count_all_results($this->_table);
    }

    /**
     * Mendapatkan hasil beserta informasi pagination
     * @return array ['data' => ..., 'pagination' => ...]
     */
    public function getPaginated()
    {
        $data = $this->get();
        if (!empty($this->_relations) && !empty($data)) {
            if (is_object($data)) {
                $this->applyRelations($data);
            } elseif (is_array($data)) {
                foreach ($data as &$row) {
                    $this->applyRelations($row);
                }
            }
        }

        $total_records = $this->getTotalRecords();
        $limit = $this->_limit ?: 10;
        $offset = $this->_offset ?: 0;
        $total_pages = ceil($total_records / $limit);

        return [
            'data' => $data,
            'pagination' => [
                'current_page' => (int)($offset / $limit) + 1,
                'per_page' => $limit,
                'total' => $total_records,
                'last_page' => $total_pages,
                'from' => $offset + 1,
                'to' => min($offset + $limit, $total_records),
            ]
        ];
    }

    /**
     * Order by clause yang dinamis - bisa handle relasi
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'ASC')
    {
        // Jika kolom mengandung titik, artinya relasi
        if (strpos($column, '.') !== false) {
            $this->handleOrderByRelation($column, $direction);
        } else {
            // Order by kolom tabel utama
            $this->_db_instance->order_by($column, $direction);
        }
        return $this;
    }

    /**
     * Handle order by untuk relasi
     * @param string $column (format: 'relation.field')
     * @param string $direction
     */
    protected function handleOrderByRelation($column, $direction)
    {
        list($relation, $field) = explode('.', $column, 2);

        // Cek apakah relasi tersedia
        if (!in_array($relation, $this->_relations) && !method_exists($this, $relation)) {
            // Jika tidak ada relasi, fallback ke order biasa
            $this->_db_instance->order_by($column, $direction);
            return;
        }

        // Dapatkan informasi relasi
        $relation_info = $this->{$relation}(null);
        $type = $relation_info['type'] ?? null;

        if ($type === 'belongsTo') {
            $this->orderByBelongsTo($relation_info, $field, $direction);
        } elseif ($type === 'hasOne') {
            $this->orderByHasOne($relation_info, $field, $direction);
        } else {
            // Untuk hasMany atau relasi lain, fallback
            $this->_db_instance->order_by($column, $direction);
        }
    }

    /**
     * Handle order by untuk belongsTo relation
     * @param array $relation_info
     * @param string $field
     * @param string $direction
     */
    protected function orderByBelongsTo($relation_info, $field, $direction)
    {
        $related_table = $relation_info['relatedTable'];
        $foreign_key = $relation_info['foreignKey'];
        $owner_key = $relation_info['ownerKey'];

        // Tambahkan JOIN
        $join_condition = "{$this->_table}.{$foreign_key} = {$related_table}.{$owner_key}";
        $this->_db_instance->join($related_table, $join_condition, 'left');

        // Order by field dari tabel relasi
        $this->_db_instance->order_by("{$related_table}.{$field}", $direction);
    }

    /**
     * Handle order by untuk hasOne relation
     * @param array $relation_info
     * @param string $field
     * @param string $direction
     */
    protected function orderByHasOne($relation_info, $field, $direction)
    {
        $related_table = $relation_info['relatedTable'];
        $foreign_key = $relation_info['foreignKey'];
        $local_key = $relation_info['localKey'];

        // Tambahkan JOIN
        $join_condition = "{$this->_table}.{$local_key} = {$related_table}.{$foreign_key}";
        $this->_db_instance->join($related_table, $join_condition, 'left');

        // Order by field dari tabel relasi
        $this->_db_instance->order_by("{$related_table}.{$field}", $direction);
    }

    /**
     * Search pada kolom tertentu
     * @param array $fields
     * @param string $keyword
     * @return $this
     */
    public function search(array $fields, $keyword)
    {
        if (!empty($keyword)) {
            $parsedFields = [];
            $this->_db_instance->group_start();
            foreach ($fields as $field) {
                $parsedField = $this->_parseColumnAndJoin($field);
                $parsedFields[] = $parsedField;

                $this->_db_instance->or_like($parsedField, $keyword);
            }
            $this->_db_instance->group_end();

            $this->_wheres[] = ['type' => 'search', 'fields' => $parsedFields, 'keyword' => $keyword];
        }
        return $this;
    }

    /**
     * Mendefinisikan relasi has-one-through.
     *
     * @param string $finalModel          Model akhir yang ingin diakses.
     * @param string $intermediateModel   Model perantara.
     * @param string $foreignKeyOnIntermediate Foreign key pada model perantara (e.g., country_id di tabel users).
     * @param string $foreignKeyOnFinal   Foreign key pada model akhir (e.g., user_id di tabel posts).
     * @param string $localKey            Primary key dari model saat ini (e.g., id di tabel countries).
     * @param string $intermediateKey     Primary key dari model perantara (e.g., id di tabel users).
     * @param object|null $result         Objek induk (diberikan secara internal saat eager loading).
     * @return mixed
     */
    protected function hasOneThrough($finalModel, $intermediateModel, $foreignKeyOnIntermediate, $foreignKeyOnFinal, $localKey, $intermediateKey, $result = null)
    {
        // 1. RESOLVE NAMA TABEL (Final & Intermediate)
        $finalTable = $finalModel;
        if (class_exists($finalModel)) {
            $instance = new $finalModel();
            $finalTable = $instance->_table;
        }

        $intermediateTable = $intermediateModel;
        if (class_exists($intermediateModel)) {
            $instance = new $intermediateModel();
            $intermediateTable = $instance->_table;
        }

        // 2. MODE METADATA (Dipakai oleh Auto-Join & Search)
        if ($result === null) {
            return [
                'type' => 'hasOneThrough',
                'relatedTable' => $finalTable,           // Tabel tujuan akhir
                'intermediateTable' => $intermediateTable, // Tabel perantara
                'foreignKeyOnIntermediate' => $foreignKeyOnIntermediate,
                'foreignKeyOnFinal' => $foreignKeyOnFinal,
                'localKey' => $localKey,
                'intermediateKey' => $intermediateKey
            ];
        }

        // 3. MODE DATA (Dipakai oleh With / Lazy Loading)
        if (isset($result->{$localKey})) {

            // Logika Query:
            // SELECT final.* FROM final
            // JOIN intermediate ON intermediate.inter_key = final.fk_final
            // WHERE intermediate.fk_inter = parent.local_key

            $relatedData = $this->_db_instance
                ->select("{$finalTable}.*")
                ->from($finalTable)
                ->join($intermediateTable, "{$intermediateTable}.{$intermediateKey} = {$finalTable}.{$foreignKeyOnFinal}")
                ->where("{$intermediateTable}.{$foreignKeyOnIntermediate}", $result->{$localKey})
                ->limit(1)
                ->get()
                ->row();

            // Hydrate hasil query menjadi Model Object
            if ($relatedData && class_exists($finalModel)) {
                $finalInstance = new $finalModel();
                $finalData = $finalInstance->hydrate($relatedData);
                $finalData->_model = $finalInstance;
                return $finalData;
            }

            return $relatedData;
        }

        return null;
    }

    /**
     * Mendefinisikan relasi has-many-through.
     *
     * @param string $finalModel          Model akhir yang ingin diakses.
     * @param string $intermediateModel   Model perantara.
     * @param string $foreignKeyOnIntermediate Foreign key pada model perantara (e.g., country_id di tabel users).
     * @param string $foreignKeyOnFinal   Foreign key pada model akhir (e.g., user_id di tabel posts).
     * @param string $localKey            Primary key dari model saat ini (e.g., id di tabel countries).
     * @param string $intermediateKey     Primary key dari model perantara (e.g., id di tabel users).
     * @param object|null $result         Objek induk (diberikan secara internal saat eager loading).
     * @return mixed
     */
    protected function hasManyThrough($finalModel, $intermediateModel, $foreignKeyOnIntermediate, $foreignKeyOnFinal, $localKey, $intermediateKey, $result = null)
    {
        // Mode Definisi
        if ($result === null) {
            return [
                'type' => 'hasManyThrough',
            ];
        }

        // Mode Eksekusi
        if (isset($result->{$localKey})) {
            $finalInstance = new $finalModel();
            $finalTable = $finalInstance->_table;

            $intermediateInstance = new $intermediateModel();
            $intermediateTable = $intermediateInstance->_table;

            $relatedData = $this->_db_instance
                ->select("{$finalTable}.*")
                ->from($finalTable)
                ->join($intermediateTable, "{$intermediateTable}.{$intermediateKey} = {$finalTable}.{$foreignKeyOnFinal}")
                ->where("{$intermediateTable}.{$foreignKeyOnIntermediate}", $result->{$localKey})
                ->get()
                ->result();

            // Sisipkan _model untuk mendukung nested eager loading
            if (!empty($relatedData) && class_exists($finalModel)) {
                foreach ($relatedData as &$data) {
                    $data->_model = new $finalModel();
                }
            }

            return $relatedData;
        }
        return [];
    }

    /**
     * Mengubah array/objek mentah dari database menjadi instance dari model ini.
     * @param array|object $data Data mentah.
     * @return array|object|null Instance model atau array instance model.
     */
    protected function hydrate($data)
    {
        if (!$data) {
            return null;
        }

        // Tentukan nama kelas model saat ini
        $modelClass = get_class($this);

        // Jika data adalah array dari objek (hasil dari result())
        if (is_array($data)) {
            $collection = [];
            foreach ($data as $row) {
                $instance = new $modelClass($this->db_group);
                foreach (get_object_vars($row) as $key => $value) {
                    $instance->{$key} = $value;
                }
                $collection[] = $instance;
            }
            return $collection;
        }

        // Jika data adalah objek tunggal (hasil dari row())
        if (is_object($data)) {
            $instance = new $modelClass($this->db_group);
            foreach (get_object_vars($data) as $key => $value) {
                $instance->{$key} = $value;
            }
            return $instance;
        }

        return $data;
    }

    /**
     * Alias untuk get($id) agar bisa dipanggil secara static: Model::find(1)
     */
    public static function find($id)
    {
        $instance = new static();
        return $instance->get($id);
    }

    /**
     * Menyimpan perubahan properti objek ke database (Otomatis Update atau Insert)
     */
    public function save()
    {
        $protected_properties = [
            '_table',
            '_primary_key',
            '_relations',
            'db_group',
            '_db_instance',
            '_limit',
            '_offset',
            '_total_records',
            '_wheres',
            '_db_connections',
            'load',
            'output',
            'input',
            'uri',
            'config',
            'lang',
            'db',
            'hooks',
            'benchmark',
            'utf8',
            'security',
            'router',
            'session'
        ];

        $data = get_object_vars($this);
        $attributes = [];

        foreach ($data as $key => $value) {
            if (!in_array($key, $protected_properties) && !is_array($value) && !is_object($value)) {
                $attributes[$key] = $value;
            }
        }

        if (isset($this->{$this->_primary_key}) && !empty($this->{$this->_primary_key})) {
            if (method_exists($this->_db_instance, 'reset_query')) {
                $this->_db_instance->reset_query();
            }

            $this->_db_instance->where($this->_primary_key, $this->{$this->_primary_key});
            return $this->_db_instance->update($this->_table, $attributes);
        } else {
            if (method_exists($this->_db_instance, 'reset_query')) {
                $this->_db_instance->reset_query();
            }

            $result = $this->_db_instance->insert($this->_table, $attributes);

            if ($result) {
                $this->{$this->_primary_key} = $this->_db_instance->insert_id();
            }

            return $result;
        }
    }

    /**
     * Mendapatkan string query SQL yang telah dibangun tanpa menjalankannya.
     * Berguna untuk debugging.
     * @return string
     */
    public function getCompiledSelect()
    {
        return $this->_db_instance->get_compiled_select();
    }
}
