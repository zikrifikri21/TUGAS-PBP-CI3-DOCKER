<?php

defined('BASEPATH') or exit('No direct script access allowed');


class DosenController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_session();
        $this->load->library('SatuData');
    }

    public function tableDosen()
    {
        $jurusanId = auth()['jurusan_id'];
        $page      = zget('page') ?: 1;
        $limit     = zget('per_page') ?: 10;
        $offset    = ($page - 1) * $limit;

        $order_column = zget('order_column');
        $order_dir = zget('order_dir', 'ASC');
        $columns = ['nama_pengguna', 'username', 'jurusan.nama_jurusan', 'created_at'];
        $order_by = 'nama_pengguna';

        if (isset($columns[$order_column])) {
            $order_by = $columns[$order_column];
        }

        $model = User::table()
            ->with('dosen.jurusan')
            ->whereIn('tbl_user_level_id', [4, 8, 9, 10])
            ->whereHas('dosen', function ($query) {
                $query->where('status', 'aktif');
            })
            ->when($jurusanId, function ($query) use ($jurusanId) {
                $query->where("jurusan_id = $jurusanId");
            })
            ->when(zget('search'), function ($query) {
                $query->search(['nama_pengguna', 'username', 'dosen.jabatan_akademik'], zget('search'));
            });

        $model->orderBy($order_by, $order_dir);

        $result = $model->paginate($limit, $offset)->getPaginated();

        return json_output([
            'draw' => (int)zget('draw', 1),
            'recordsTotal' => $result['pagination']['total'],
            'recordsFiltered' => $result['pagination']['total'],
            'data' => $result['data'] ?? []
        ]);
    }

    public function index()
    {
        return view('dosen/list');
    }
    public function addJabatan()
    {
        $req = request()->validate([
            'id'         => 'required',
            'jabatan'    => 'nullable',
            'jurusan_id' => 'required',
            'dosen_id'   => 'required'
        ]);


        if (!$req->status) {
            zalert('errors', $req->errors);
            return back();
        }

        $user       = new User();
        $jurusan    = new Jurusan();
        $dosen      = new DosenFhil();
        $cekJabatan = $dosen->where('homebase', $req->jurusan_id)->where('jabatan_akademik', $req->jabatan)->get();
        $jabatanSekarang = $dosen->where('id', $req->dosen_id)->where('jabatan_akademik', $req->jabatan)->first();

        // hapus jabatan
        if (!$req->jabatan) {
            $user->update(['id' => $req->id], ['tbl_user_level_id' => 4]);
            $dosen->update(['tbl_user_id' => $req->id], ['jabatan_akademik' => null]);
            zalert('success', 'Jabatan berhasil dihapus');
            return back();
        }

        // if ($jabatanSekarang->jabatan_akademik === $req->jabatan) {
        //     zalert('success', 'Tidak ada perubahan jabatan');
        //     return back();
        // }

        if (count($cekJabatan) == 1) {
            zalert('error', $req->jabatan . ' hanya boleh ada satu per jurusan');
            return back();
        }

        if ($req->jabatan === 'kajur' || $req->jabatan === 'sekjur' || $req->jabatan === 'kaprodi') {
            $column_jabatan = $req->jabatan === 'kajur' ? 'ketua_jurusan' : 'sekretaris_jurusan';
            $role_jabatan   = $req->jabatan === 'kajur' ? 9 : 10;
            $user->update($req->id, ['tbl_user_level_id' => $role_jabatan]);
            $jurusan->update($req->jurusan_id, [$column_jabatan => $req->dosen_id]);
            $dosen->update(['tbl_user_id' => $req->id], ['jabatan_akademik' => $req->jabatan]);
        } elseif ($req->jabatan === 'dekan') {
            $user->update($req->id, ['tbl_user_level_id' => 8]);
            $dosen->update(['tbl_user_id' => $req->id], ['jabatan_akademik' => $req->jabatan]);
        } else {
            $dosen->update(['tbl_user_id' => $req->id], ['jabatan_akademik' => $req->jabatan]);
        }

        return back();
    }

    public function delete()
    {
        $id = zpost('id');
        $user = new User();
        $user->where(['id' => $id, 'tbl_user_level_id' => 4])->delete($id);

        zalert('success', 'Data berhasil dihapus');
        return back();
    }

    public function update()
    {
        $id   = param_id();
        $data = request()->validate([
            'file' => 'required|image|mimes:jpg,png|max:2048'
        ]);

        if (!$data->status) {
            zalert('errors', $data->errors);
            return back();
        }

        $name = $id . '_' . time() . '.' . $data->file->extension();
        $filename = $data->file->storeAs('upload/ttd_dosen', "ttd_{$name}");

        $user = new DosenFhil();
        $user->update($id, ['ttd_dosen' => $filename]);

        zalert('success', 'Data berhasil disimpan');
        return back();
    }

    public function aktifasi_dosen()
    {
        try {
            $token        = Token::last();
            $getToken     = $token->token ?? null;
            $satu_data    = new SatuData();
            $linkunganId  = '2481b4ca-52c3-4f84-ac4d-6e04576b7583'; // 1
            $kehutananId  = '9cd42009-a792-4756-8197-9f5e1e51c99e'; // 2
            //9cd42009-a792-4756-8197-9f5e1e51c99e = 2 -> kehutanan
            if (empty($token->token)) {
                $token    = $satu_data->login('fhil@uho.ac.id', 'OneDataUho5566*#');
                // $token    = $satu_data->login('fhil@uho.ac.id', 'fhil#uhohebat');
                $getToken = $token;
            }

            $dosen = $satu_data->getData('dosen', $getToken);
            $user_dosen  = new User();
            $insertDosen = [];
            foreach ($dosen as $key) {
                if (in_array($key['id_prodi'], [$kehutananId, $linkunganId])) {
                    $mappingJurusan  = [
                        $linkunganId => 2,
                        $kehutananId => 1
                    ];
                    $jurusanId = $mappingJurusan[$key['id_prodi']];
                } else {
                    $jurusanId = null;
                }
                if (empty($key['nidn'])) continue;

                $nip = ($key['nip'] !== null && trim($key['nip']) !== '') ? $key['nip'] : $key['nidn'];

                $email = $nip . '@fhil.uho.ac.id';

                $save = $user_dosen->updateOrCreate(
                    ['username' => $nip],
                    [
                        'email'             => $email,
                        'id_prodi_pddikti'  => $key['id_prodi'],
                        'nama_pengguna'     => $key['nama_dosen'],
                        'password'          => password_hash($nip, PASSWORD_BCRYPT, ['cost' => 4]),
                        'tbl_user_level_id' => 4,
                        'jurusan_id'        => $jurusanId
                    ]
                );

                $insertDosen[] = [
                    'nidn'         => $key['nidn'],
                    // 'nip'          => ($key['nip'] !== null && trim($key['nip']) !== '') ? $key['nip'] : $key['nidn'],
                    'nip'          => $nip,
                    'nama_dosen'   => $key['nama_dosen'],
                    'user_id'      => $save->id,
                    'tmt_akademik' => $key['tanggal_mulai'],
                    'pangkat'      => $key['pangkat_golongan'],
                    'homebase'     => $jurusanId
                ];
            }

            $saveDosen = new DosenFhil();
            foreach ($insertDosen as $key) {
                $saveDosen->updateOrCreate(
                    ['nidn' => $key['nidn']],
                    [
                        'nidn'         => $key['nidn'],
                        'nip'          => $key['nip'],
                        'nama_dosen'   => $key['nama_dosen'],
                        'tbl_user_id'  => $key['user_id'],
                        'homebase'     => $key['homebase'],
                        'tmt_akademik' => $key['tmt_akademik'],
                        'pangkat'      => $key['pangkat']
                    ]
                );
            }

            json_output([
                'message' => 'berhasil',
                'error'   => false
            ]);
        } catch (\Throwable $th) {
            return json_output([
                'message' => $th->getMessage(),
                'error'   => true
            ]);
        }
    }
}
