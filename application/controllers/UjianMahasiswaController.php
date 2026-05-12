<?php

defined('BASEPATH') or exit('No direct script access allowed');


class UjianMahasiswaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('dosen.ujian-mhs');
    }

    public function store()
    {
        // dd(request()->all());
        $validate = request()->validate([
            'nilai' => 'required|numeric|min:10|max:100',
            'ujian_id' => 'required',
            'penilai_id' => 'required',
        ], [
            'nilai.required' => 'Nilai harus diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 10',
            'nilai.max' => 'Nilai maksimal 100',
            'ujian_id.required' => 'Ujian harus dipilih',
            'penilai_id.required' => 'Penilai harus dipilih',
        ]);


        if (!$validate->status) {
            zalert('errors', $validate->errors);
            return back();
        }

        $ujian =  PenilaianUjian::table();
        $ujian->insert(
            [
                'ujian_id' => $validate->ujian_id,
                'penilai_id' => $validate->penilai_id,
                'nilai' => $validate->nilai
            ]
        );

        zalert('success', 'Penilaian berhasil disimpan');
        return back();
    }

    public function nilaiUjian()
    {
        $validate = request()->validate([
            'id' => 'required',
            'pembimbing_1' => 'required',
            'pembimbing_2' => 'required',
            'uji_1' => 'required',
            'uji_2' => 'required',
            'uji_3' => 'required',
            'nilai_pembimbing_1' => 'required|min:0|max:100',
            'nilai_pembimbing_2' => 'required|min:0|max:100',
            'nilai_uji_1' => 'required|min:0|max:100',
            'nilai_uji_2' => 'required|min:0|max:100',
            'nilai_uji_3' => 'required|min:0|max:100',
        ]);

        if (!$validate->status) {
            zalert('errors', $validate->errors);
            return back();
        }

        $ujian = Ujian::find($validate->id);
        $ujian->penilai_id = auth('id');
        $ujian->save();

        $penilaian = new PenilaianUjian();

        $penilaiIds = [
            'pembimbing_1' => [
                $validate->pembimbing_1,
                'nilai' => $validate->nilai_pembimbing_1
            ],
            'pembimbing_2' => [
                $validate->pembimbing_2,
                'nilai' => $validate->nilai_pembimbing_2
            ],
            'uji_1' => [
                $validate->uji_1,
                'nilai' => $validate->nilai_uji_1
            ],
            'uji_2' => [
                $validate->uji_2,
                'nilai' => $validate->nilai_uji_2
            ],
            'uji_3' => [
                $validate->uji_3,
                'nilai' => $validate->nilai_uji_3
            ]
        ];
        // dd($penilaiIds);

        foreach ($penilaiIds as $key => $value) {
            $penilaian->updateOrCreate(
                [
                    'ujian_id'   => $validate->id,
                    'penilai_id' => $value[0]
                ],
                [
                    'ujian_id'   => $validate->id,
                    'penilai_id' => $value[0],
                    'nilai'      => $value['nilai']
                ]
            );
        }

        return back();
    }

    public function getUjianMahasiswa()
    {
        $userId    = auth('id');
        $dosenId   = DosenFhil::table()->where(['tbl_user_id' => $userId])->first()->id;
        // dd([$userId, $dosenId]);
        $page      = zget('page') ?: 1;
        $limit     = zget('per_page') ?: 10;
        $offset    = ($page - 1) * $limit;

        $order_column = zget('order_column');
        $order_dir = zget('order_dir', 'ASC');
        $columns = ['id', 'judul', 'mahasiswa.nama_mahasiswa', 'jurusan.nama_jurusan'];
        $order_by = 'id';

        if (isset($columns[$order_column])) {
            $order_by = $columns[$order_column];
        }

        $dosenId = (int) $dosenId;
        $keyword = zget('search');
        // dd($dosenId);

        $ujian = Ujian::table()
            ->select('ujian.*')
            ->with('mahasiswa', 'jurusan', 'penilaian')
            ->where('akhiri_ujian', 0)
            ->where(function ($q) use ($dosenId) {
                $q->where('pembimbing_1', $dosenId)
                    ->orWhere('pembimbing_2', $dosenId)
                    ->orWhere('uji1', $dosenId)
                    ->orWhere('uji2', $dosenId)
                    ->orWhere('uji3', $dosenId);
            })->whereDoesntHave('penilaian', function ($q) use ($dosenId) {
                $q->where('penilai_id', $dosenId);
            })
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where(function ($q) use ($keyword) {
                    $q->where('judul', 'like', '%' . $keyword . '%')
                        ->orWhere('mahasiswa.nama_mahasiswa', 'like', '%' . $keyword . '%')
                        ->orWhere('jurusan.nama_jurusan', 'like', '%' . $keyword . '%');
                });
            });

        if ($order_by === 'jurusan.nama_jurusan') {
            $ujian->orderBy('jurusan.nama_jurusan', $order_dir);
        } else {
            $ujian->orderBy($order_by, $order_dir);
        }

        $result = $ujian->paginate($limit, $offset)->getPaginated();

        return json_output([
            'draw' => (int)zget('draw', 1),
            'recordsTotal' => $result['pagination']['total'],
            'recordsFiltered' => $result['pagination']['total'],
            'data' => $result['data'] ?? []
        ]);
    }
}
