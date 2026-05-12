<?php

/**
 * ===========================================================
 *  FileRequest: Wrapper untuk upload file
 * ===========================================================
 */
class FileRequest
{
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function exists()
    {
        return ($this->file['error'] !== UPLOAD_ERR_NO_FILE);
    }

    public function extension()
    {
        return strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
    }

    public function mime()
    {
        return $this->file['type'] ?? '';
    }

    public function size()
    {
        return $this->file['size'] / 1024; // KB
    }

    public function store($path, $filename = null)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (!$filename) {
            $filename = uniqid() . '.' . $this->extension();
        }

        $destination = rtrim($path, '/') . '/' . $filename;
        move_uploaded_file($this->file['tmp_name'], $destination);
        return $filename;
    }

    public function storeAs($path, $filename)
    {
        // 1. Bersihkan path dari slash di awal dan akhir
        $cleanPath = trim($path, '/\\');

        // 2. Gunakan FCPATH untuk memastikan folder dibuat di dalam project
        // FCPATH adalah path absolut ke folder index.php Anda
        $fullPath = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $cleanPath;

        // 3. Cek apakah folder sudah ada
        if (!is_dir($fullPath)) {
            // Buat folder secara rekursif (true)
            // Gunakan @ untuk menekan warning karena kita sudah menangani error dengan Exception
            if (!@mkdir($fullPath, 0755, true)) {
                $error = error_get_last();
                throw new Exception("Gagal membuat folder di: " . $fullPath . ". Error: " . ($error['message'] ?? 'Unknown'));
            }
        }

        // 4. Cek apakah folder tersebut Writable
        if (!is_writable($fullPath)) {
            throw new Exception("Folder tidak dapat ditulisi (Permission Denied): " . $fullPath);
        }

        // 5. Tambahkan extension jika belum ada di nama file
        if (!pathinfo($filename, PATHINFO_EXTENSION)) {
            $filename .= '.' . $this->extension();
        }

        $destination = $fullPath . DIRECTORY_SEPARATOR . $filename;

        // 6. Pindahkan file
        if (!move_uploaded_file($this->file['tmp_name'], $destination)) {
            throw new Exception("Gagal memindahkan file ke: " . $destination);
        }

        return $filename;
    }

    public function getClientOriginalName()
    {
        return $this->file['name'] ?? null;
    }

    public function getClientOriginalExtension()
    {
        return strtolower(pathinfo($this->getClientOriginalName(), PATHINFO_EXTENSION));
    }

    public function getClientMimeType()
    {
        return $this->file['type'] ?? null;
    }

    public function guessExtension()
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        ];
        return $map[$this->mime()] ?? $this->extension();
    }

    public function isValid()
    {
        return isset($this->file['tmp_name']) && is_uploaded_file($this->file['tmp_name']);
    }
}


/**
 * ===========================================================
 *  REQUEST CLASS
 * ===========================================================
 */
class Request
{
    protected $CI;
    protected $method;
    protected $get;
    protected $post;
    protected $json;

    public function __construct()
    {
        $this->CI = &get_instance(); // Untuk CodeIgniter
        $this->CI->load->helper('security');
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->get  = $this->cleanArray($this->CI->input->get(NULL, TRUE));
        $this->post = $this->cleanArray($this->CI->input->post(NULL, TRUE));
        $this->json = $this->cleanArray($this->parseJsonBody());
    }

    protected function cleanArray($data)
    {
        if (!is_array($data)) return $this->cleanValue($data);
        $clean = [];
        foreach ($data as $k => $v) {
            $clean[$k] = is_array($v) ? $this->cleanArray($v) : $this->cleanValue($v);
        }
        return $clean;
    }

    protected function cleanValue($v)
    {
        if ($v === null) return null;
        if (is_string($v)) {
            return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
        }
        return $v;
    }

    public function all()
    {
        if ($this->isJson()) return $this->json;
        if ($this->isPost()) return $this->post;
        return $this->get;
    }

    public function input($key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }

    public function __get($key)
    {
        return $this->input($key);
    }

    public function method()
    {
        return strtolower($this->method);
    }

    public function isPost()
    {
        return $this->method === "POST";
    }

    protected function parseJsonBody()
    {
        $raw = file_get_contents('php://input');
        if (!$raw) return [];
        $json = json_decode($raw, true);
        return is_array($json) ? $json : [];
    }

    public function isJson()
    {
        $content = $_SERVER['CONTENT_TYPE'] ?? '';
        return strpos($content, "application/json") !== false;
    }

    public function file($key)
    {
        if (!isset($_FILES[$key])) return null;
        $file = new FileRequest($_FILES[$key]);
        return $file->exists() ? $file : null;
    }

    /**
     * Memvalidasi input (teks dan file) dengan aturan dan pesan kustom.
     *
     * @param array $rules Aturan validasi.
     * @param array $customMessages Pesan error kustom (opsional).
     * @return ValidatedData Objek hasil validasi.
     */
    public function validate(array $rules, array $customMessages = [])
    {
        $data = $this->all();
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $isFile = isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE;
            $file = $isFile ? new FileRequest($_FILES[$field]) : null;
            $value = $isFile ? $file : ($data[$field] ?? null);

            $ruleList = explode('|', $ruleString);
            $isNumericContext = in_array('numeric', $ruleList) || in_array('integer', $ruleList);

            foreach ($ruleList as $rule) {
                $param = null;
                if (strpos($rule, ':') !== false) {
                    list($rule, $param) = explode(':', $rule);
                }

                // Fungsi helper untuk mendapatkan pesan error yang tepat
                $getMessage = function ($ruleName, $defaultMessage, $replacements = []) use ($field, $customMessages) {
                    $key = "{$field}.{$ruleName}";
                    $message = $customMessages[$key] ?? $defaultMessage;
                    foreach ($replacements as $placeholder => $value) {
                        $message = str_replace($placeholder, $value, $message);
                    }
                    return $message;
                };

                if ($rule === 'nullable' && ($value === null || $value === '')) {
                    continue 2; // Lewati semua aturan lain untuk field ini
                }

                if ($rule === 'required') {
                    if ($isFile && !$file->exists()) {
                        $errors[$field][] = $getMessage('required', "The $field field is required.");
                    } elseif (!$isFile && ($value === null || $value === '')) {
                        $errors[$field][] = $getMessage('required', "The $field field is required.");
                    }
                }

                if ($rule === 'required_if') {
                    $params = explode(',', $param);
                    $dependentField = array_shift($params);
                    $requiredValues = $params;
                    $isDependentFile = isset($_FILES[$dependentField]);
                    $conditionMet = false;

                    if ($isDependentFile) {
                        $isFileUploaded = isset($_FILES[$dependentField]) && $_FILES[$dependentField]['error'] !== UPLOAD_ERR_NO_FILE;
                        if (in_array('null', $requiredValues) && !$isFileUploaded) {
                            $conditionMet = true;
                        }
                    } else {
                        $dependentValue = $data[$dependentField] ?? null;
                        if (in_array('null', $requiredValues) && ($dependentValue === null || $dependentValue === '')) {
                            $conditionMet = true;
                        } elseif (in_array($dependentValue, $requiredValues)) {
                            $conditionMet = true;
                        }
                    }

                    if ($conditionMet) {
                        if (($isFile && !$file->exists()) || (!$isFile && ($value === null || $value === ''))) {
                            $replacements = [':other' => $dependentField, ':value' => implode(' or ', $requiredValues)];
                            $errors[$field][] = $getMessage('required_if', "The $field field is required when $dependentField is empty.", $replacements);
                        }
                    }
                }


                if ($isFile) { // Aturan khusus file
                    if ($value === null || !$value->exists()) continue; // Jangan validasi file kosong kecuali untuk 'required'

                    if ($rule === 'image' && strpos($file->mime(), 'image/') !== 0) {
                        $errors[$field][] = $getMessage('image', 'The file must be an image.');
                    }
                    if ($rule === 'mimes') {
                        $allowed = explode(',', $param);
                        if (!in_array($file->extension(), $allowed)) {
                            $errors[$field][] = $getMessage('mimes', 'The file must be one of: :values.', [':values' => implode(', ', $allowed)]);
                        }
                    }
                    if ($rule === 'max' && $file->size() > (int)$param) {
                        $errors[$field][] = $getMessage('max', 'The file may not be larger than :max KB.', [':max' => $param]);
                    }
                    continue; // Lewati aturan teks jika ini adalah file
                }

                // Aturan khusus teks (hanya berjalan jika bukan file atau jika field kosong)
                if ($value === null || $value === '') continue;

                if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = $getMessage('email', 'The field must be a valid email address.');
                }
                if ($rule === 'min') {
                    if ($isNumericContext && is_numeric($value)) {
                        if ((float)$value < (float)$param) {
                            $errors[$field][] = $getMessage('min', 'The field must be at least :min.', [':min' => $param]);
                        }
                    } else {
                        if (strlen($value) < (int)$param) {
                            $errors[$field][] = $getMessage('min', 'The field must be at least :min characters.', [':min' => $param]);
                        }
                    }
                }

                if ($rule === 'max') {
                    if ($isNumericContext && is_numeric($value)) {
                        if ((float)$value > (float)$param) {
                            $errors[$field][] = $getMessage('max', 'The field may not be greater than :max.', [':max' => $param]);
                        }
                    } else {
                        if (strlen($value) > (int)$param) {
                            $errors[$field][] = $getMessage('max', 'The field may not be greater than :max characters.', [':max' => $param]);
                        }
                    }
                }
                if ($rule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = $getMessage('numeric', 'The field must be a number.');
                }
                if ($rule === 'confirmed') {
                    if (($data[$field . '_confirmation'] ?? null) !== $value) {
                        $errors[$field][] = $getMessage('confirmed', 'The confirmation does not match.');
                    }
                }
                if ($rule === 'unique') {
                    list($table, $column, $ignoreValue, $ignoreColumn) = array_pad(explode(',', $param), 4, null);
                    $column = $column ?? $field;
                    $ignoreColumn = $ignoreColumn ?? 'id';

                    $this->CI->db->where($column, $value);
                    if ($ignoreValue !== null) {
                        $this->CI->db->where("$ignoreColumn !=", $ignoreValue);
                    }
                    if ($this->CI->db->get($table)->num_rows() > 0) {
                        $errors[$field][] = $getMessage('unique', 'The value has already been taken.');
                    }
                }
            }

            if ($isFile) {
                $data[$field] = $file;
            }
        }

        if (!empty($errors)) {
            $obj = new ValidatedData([]);
            $obj->status = false;
            $obj->errors = $errors;
            return $obj;
        }

        $validated = new ValidatedData($data);
        $validated->status = true;
        return $validated;
    }
}


/**
 * ===========================================================
 *  ValidatedData: Objek hasil validasi
 * ===========================================================
 */
class ValidatedData implements ArrayAccess
{
    protected $data = [];
    public $status = true;
    public $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function all()
    {
        return $this->data;
    }
}
