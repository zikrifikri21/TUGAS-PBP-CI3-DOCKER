<?php

defined('BASEPATH') or exit('No direct script access allowed');


class MahasiswaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('SatuData');
        $this->load->model('m_default');
    }

    public function tableMahasiswa()
    {
        $jurusanId = auth()['jurusan_id'];
        $page      = zget('page') ?: 1;
        $limit     = zget('per_page') ?: 10;
        $offset    = ($page - 1) * $limit;

        $order_column = zget('order_column');
        $order_dir = zget('order_dir', 'ASC');
        $columns = ['id', 'nama_pengguna', 'username', 'jurusan.nama_jurusan', 'created_at'];
        $order_by = 'created_at';

        if (isset($columns[$order_column])) {
            $order_by = $columns[$order_column];
        }

        $model = User::table()
            ->with('jurusan')
            ->where(['tbl_user_level_id' => 5])
            ->when(!empty($jurusanId), function ($query) use ($jurusanId) {
                $query->where("jurusan_id = $jurusanId");
            })
            ->when(zget('search'), function ($query) {
                $query->search(['nama_pengguna', 'username'], zget('search'));
            })->when($order_column === "0", function ($query) {
                $query->orderBy('tbl_user.nama_pengguna', 'ASC');
            });

        if ($order_by === 'jurusan.nama_jurusan') {
            $model->orderBy('jurusan.nama_jurusan', $order_dir);
        } else {
            $model->orderBy($order_by, $order_dir);
        }

        $result = $model->paginate($limit, $offset)->getPaginated();

        return json_output([
            'draw' => (int)zget('draw', 1),
            'recordsTotal' => $result['pagination']['total'],
            'recordsFiltered' => $result['pagination']['total'],
            'data' => $result['data'] ?? [],
        ]);
    }

    public function index()
    {
        return view('mahasiswa.list');
    }

    public function delete()
    {
        $id = zpost('id');

        $mahasiswa = User::table();
        $find = $mahasiswa->where(['id' => $id])->first();
        if ($find) {
            $mahasiswa->delete($id);
        } else {
            redirect('daftar-mahasiswa');
        }

        redirect('daftar-mahasiswa');
    }

    public function aktifasi_mahasiswa()
    {
        try {
            $token        = Token::last();
            $getToken     = $token->token ?? null;
            $satu_data    = new SatuData();

            if (empty($token->token)) {
                $token    = $satu_data->login('fhil@uho.ac.id', 'OneDataUho5566*#');
                $getToken = $token;
            }

            $mahasiswa = $satu_data->getData('mahasiswa', $getToken, ['nama_singkat' => 'FHIL']);
            $user_mahasiswa = new User();

            $insertMahasiswa = [];
            foreach ($mahasiswa as $key) {
                $jurusanId = $key['id_prodi_pddikti'] == '2481b4ca-52c3-4f84-ac4d-6e04576b7583' ? 1 : 2;
                $save = $user_mahasiswa->updateOrCreate(
                    ['username' => $key['nim']],
                    [
                        'id_prodi_pddikti'  => $key['id_prodi_pddikti'],
                        'nama_pengguna'     => $key['nama_mahasiswa'],
                        'email'             => strtolower($key['nim']) . '@fhil.uho.ac.id',
                        'password'          => password_hash($key['nim'], PASSWORD_BCRYPT, array("cost" => 4)),
                        'tbl_user_level_id' => 5,
                        'jurusan_id'        => $jurusanId
                    ]
                );

                $insertMahasiswa[] = [
                    'nim'            => $key['nim'],
                    'nama_mahasiswa' => $key['nama_mahasiswa'],
                    'jurusan_id'     => $jurusanId,
                    'id'             => $save->id
                ];
            }

            $saveMahasiswa = new Mahasiswa();
            foreach ($insertMahasiswa as $key) {
                $saveMahasiswa->updateOrCreate(
                    ['nim' => $key['nim']],
                    [
                        'nama_mahasiswa' => $key['nama_mahasiswa'],
                        'nim'            => $key['nim'],
                        'status'         => 'aktif',
                        'jurusan_id'     => $key['jurusan_id'],
                        'tbl_user_id'    => $key['id']
                    ]
                );
            }

            json_output([
                'message' => 'berhasil'
            ]);
        } catch (\Throwable $th) {
            if ($th instanceof \Exception) {
                return json_output([
                    'message' => $th->getMessage()
                ]);
            }

            return json_output([
                'message' => $th->getMessage()
            ]);
        }
    }
}
