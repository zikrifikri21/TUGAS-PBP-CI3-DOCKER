<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VerifikasiSk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('m_default');
        cek_session();
    }

    public function index()
    {
        return view('sk_dekan.verifikasi-sk');
    }

    public function getVerifikasiSk()
    {
        $page      = zget('page') ?: 1;
        $limit     = zget('per_page') ?: 10;
        $offset    = ($page - 1) * $limit;

        $order_column = zget('order_column');
        $order_dir    = zget('order_dir', 'ASC');
        $columns      = ['id', 'no_sk', 'ujian.jenis_ujian', 'created', 'status_putusan'];
        $order_by     = 'created';

        if (isset($columns[$order_column])) {
            $order_by = $columns[$order_column];
        }

        $isDekan  = auth('tbl_user_level_id') == "8";
        $isWDekan = auth('tbl_user_level_id') == "4";

        $data = SkDekan::table()
            ->with('ujian')
            ->when($isDekan, function ($q) {
                return $q->orWhere('status_putusan', 'v2');
            })
            ->when($isWDekan, function ($q) {
                return $q->where('status_putusan', 'v1');
            })
            ->when(zget('search'), function ($query) {
                $query->search(['no_sk'], zget('search'));
            })
            ->when($order_column === "0", function ($query) {
                $query->orderBy('no_sk', 'ASC');
            });

        $data->orderBy($order_by, $order_dir);

        $data = $data->paginate($limit, $offset)->getPaginated();

        return json_output([
            'draw' => (int)zget('draw', 1),
            'recordsTotal' => $data['pagination']['total'],
            'recordsFiltered' => $data['pagination']['total'],
            'data' => $data['data'] ?? [],
        ]);
    }

    public function verifikasi()
    {
        $dosen = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();
        $validate = request()->validate([
            'id'             => 'required',
            'status_putusan' => 'required'
        ]);

        if (!$validate->status) {
            zalert('errors', $validate->errors);
            return back();
        }

        $skDekan = SkDekan::find($validate->id);
        $skDekan->status_putusan = $validate->status_putusan;
        $skDekan->catatan = $validate->catatan ?? null;
        if ($dosen->jabatan_akademik == "wd1") {
            $skDekan->ttd_wd1 = $dosen->id;
        } elseif ($dosen->jabatan_akademik == "dekan") {
            $skDekan->ttd_dekan = $dosen->id;
        }
        $skDekan->save();

        return back();
    }
}
