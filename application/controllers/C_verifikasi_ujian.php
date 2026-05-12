<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_verifikasi_ujian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
        $this->load->library('upload');
    }

    public function index()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $authUser        = auth();
        $jurusanId       = $authUser['jurusan_id'];
        $isStafJurusan   = $authUser['nama_level'] === 'Staf Jurusan';
        $data['ujian']   = Ujian::table()
            ->with('mahasiswa', 'jurusan', 'penilaian', 'pembimbing_1', 'pembimbing_2', 'uji1', 'uji2', 'uji3')
            ->when($authUser['nama_level'] === 'kajur', function ($query) {
                $query->where(['status_putusan' => 'terkirim']);
            })->when($isStafJurusan, function ($query) use ($jurusanId) {
                $query->where(function ($q) {
                    $q->where(function ($q1) {
                        $q1->whereNotIn('jenis_ujian', ['skripsi'])
                            ->where(function ($q_inner) {
                                $q_inner->whereNull('no_st')->orWhere('no_st', '')
                                    ->orWhereNull('no_sp')->orWhere('no_sp', '');
                            });
                    })->orWhere(function ($q2) {
                        $q2->whereIn('jenis_ujian', ['skripsi'])
                            ->where(function ($q_inner) {
                                $q_inner->whereNull('no_st')->orWhere('no_st', '')
                                    ->orWhereNull('no_sp')->orWhere('no_sp', '')
                                    ->orWhereNull('nilai_ujian')->orWhere('nilai_ujian', '');
                            });
                    })->orWhere('akhiri_ujian', 0);
                })->whereHas('mahasiswa', function ($q) use ($jurusanId) {
                    $q->where('mahasiswa.jurusan_id', $jurusanId);
                });
            })->get();

        // dd([$data['ujian'], 'status_putusan', "$userHasStatus",  $jurusanId]);
        $option = array(
            'select' => 'dosen.*',
            'table' => 'jurusan',
            'join' => array('dosen' => 'jurusan.sekretaris_jurusan = dosen.id'),
            'where' => array('jurusan.id' => auth('jurusan_id'))
        );
        $data['dosen'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'verifikasi_ujian/list', $data);
    }

    public function selesaikan()
    {
        $req = request()->validate([
            'id' => 'required'
        ]);

        if (!$req->status) {
            zalert('errors', $req->errors);
            return back();
        }

        $ujian = Ujian::find($req->id);
        $ujian->akhiri_ujian = 1;
        $ujian->save();

        return back();
    }

    public function filter()
    {

        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $authUser      = auth();
        $jurusanId     = $authUser['jurusan_id'];
        $data['ujian'] = Ujian::table()->with('mahasiswa', 'jurusan')->when($authUser['nama_level'] === 'kajur', function ($query) {
            $query->where(['status_putusan' => 'terkirim']);
        })->when($authUser['nama_level'] !== 'kajur', function ($query) use ($jurusanId) {
            $query->where(function ($q) {
                $q->where(function ($q1) {
                    $q1->whereNotIn('jenis_ujian', ['skripsi'])
                        ->where(function ($q_inner) {
                            $q_inner->whereNull('no_st')->orWhere('no_st', '')
                                ->orWhereNull('no_sp')->orWhere('no_sp', '');
                        });
                })->orWhere(function ($q2) {
                    $q2->whereIn('jenis_ujian', ['skripsi'])
                        ->where(function ($q_inner) {
                            $q_inner->whereNull('no_st')->orWhere('no_st', '')
                                ->orWhereNull('no_sp')->orWhere('no_sp', '')
                                ->orWhereNull('nilai_ujian')->orWhere('nilai_ujian', '');
                        });
                });
            })->whereHas('mahasiswa', function ($q) use ($jurusanId) {
                $q->where('mahasiswa.jurusan_id', $jurusanId);
            });
        })->when(isset($_GET['jenis_ujian']), function ($query) {
            $query->where(['jenis_ujian' => zget('jenis_ujian')]);
        })->get();


        // $option = array(
        //     'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
        //     'table' => 'ujian',
        //     'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
        //     'order' => array('ujian.id' => 'desc'),
        //     'where' => array('mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'), 'ujian.jenis_ujian' => $_GET['jenis_ujian'])
        // );

        // $data['ujian'] = $this->m_default->fetch_data($option);
        $option = array(
            'select' => 'dosen.*',
            'table' => 'jurusan',
            'join' => array('dosen' => 'jurusan.sekretaris_jurusan = dosen.id'),
            'where' => array('jurusan.id' => $this->session->userdata('jurusan_id'))
        );
        $data['dosen'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'verifikasi_ujian/list', $data);
    }

    public function monitoring_dosen()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $option = array(
            'select' => 'dosen.*,jurusan.nama_jurusan',
            'table' => 'dosen',
            'join' => array('jurusan' => 'dosen.homebase = jurusan.id'),
            'where' => array('jurusan.id' => $this->session->userdata('jurusan_id'))
        );

        $data['dosen'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'monitoring/dosen', $data);
    }

    public function update($id = null)
    {
        if (!empty($this->input->post('hari_ujian'))) {
            $data['id']  = $this->input->post('id');
            $data['pembimbing_1']  = $this->input->post('pembimbing_1');
            $data['pembimbing_2']  = $this->input->post('pembimbing_2');
            $data['uji1']  = $this->input->post('uji1');
            $data['uji2']  = $this->input->post('uji2');
            $data['uji3']  = $this->input->post('uji3');
            $data['ketua']  = $this->input->post('ketua');
            $data['sekretaris']  = $this->input->post('sekretaris');
            $data['anggota_1']  = $this->input->post('anggota_1');
            $data['anggota_2']  = $this->input->post('anggota_2');
            $data['anggota_3']  = $this->input->post('anggota_3');
            $data['hari_ujian']  = $this->input->post('hari_ujian');
            $data['jam_ujian']  = $this->input->post('jam_ujian');
            $data['tempat_ujian']  = $this->input->post('tempat_ujian');
            $this->m_default->edit('ujian', $data, array('id' => $data['id']));

            $this->session->set_flashdata('edit', 'Berhasil Verifikasi Ujian ');
            redirect('c_verifikasi_ujian');
        } else {
            $option = array(
                'select' => '*',
                'table' => 'ujian',
                'where' => array('ujian.id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('c_verifikasi_ujian/update'),
                'id'               => set_value('id', $get->id),
                'judul'     => set_value('judul', $get->judul),
                'jenis_ujian'     => set_value('jenis_ujian', $get->jenis_ujian),
                'pembimbing_1'  => set_value('pembimbing_1', $get->pembimbing_1),
                'pembimbing_2'  => set_value('pembimbing_2', $get->pembimbing_2),
                'uji1'  => set_value('uji1', $get->uji1),
                'uji2'  => set_value('uji2', $get->uji2),
                'uji3'  => set_value('uji3', $get->uji3),
                'mahasiswa_id'  => set_value('mahasiswa_id', $get->mahasiswa_id),
                'ipk_sementara'  => set_value('ipk_sementara', $get->ipk_sementara),
                'ketua'     => set_value('ketua', $get->ketua),
                'sekretaris'     => set_value('sekretaris', $get->sekretaris),
                'anggota_1'  => set_value('anggota_1', $get->anggota_1),
                'anggota_2'  => set_value('anggota_2', $get->anggota_2),
                'anggota_3'  => set_value('anggota_3', $get->anggota_3),
                'hari_ujian'  => set_value('hari_ujian', $get->hari_ujian),
                'jam_ujian'  => set_value('jam_ujian', $get->jam_ujian),
                'tempat_ujian'  => set_value('tempat_ujian', $get->tempat_ujian),
            );

            $option = array(
                'table' => 'dosen',
                'where' => array('status' => 'aktif')
            );
            // $data['dosen'] = $this->m_default->fetch_data($option);
            $data['dosen'] = DosenFhil::table()->where('status', 'aktif')->get();
            $this->template->load('template', 'verifikasi_ujian/form', $data);
        }
    }
    //pastikan proses ujian telah selesai dilaksanakan sebelum memverifikasi ujain ini telah selesai
    public function upload_file()
    {
        // $upload_var = '';
        // if (!empty($_FILES['upload_ba']['name'])) {
        //     $upload_var = 'upload_ba';
        // }
        // if (!empty($_FILES['upload_st']['name'])) {
        //     $upload_var = 'upload_st';
        // }
        // if (!empty($_FILES['upload_sp']['name'])) {
        //     $upload_var = 'upload_sp';
        // }
        if ($this->input->post('nilai_ujian'))
            $data['nilai_ujian']  = $this->input->post('nilai_ujian');

        if ($this->input->post('no_ba'))
            $data['no_ba']  = $this->input->post('no_ba');
        if ($this->input->post('no_st'))
            $data['no_st']  = $this->input->post('no_st');
        if ($this->input->post('no_sp'))
            $data['no_sp']  = $this->input->post('no_sp');

        if ($this->input->post('plh_plt_st'))
            $data['plh_plt_st']  = $this->input->post('plh_plt_st');
        if ($this->input->post('plh_plt_sp'))
            $data['plh_plt_sp']  = $this->input->post('plh_plt_sp');

        if ($this->input->post('ttd_ba'))
            $data['ttd_ba']  = $this->input->post('ttd_ba');
        if ($this->input->post('ttd_st'))
            $data['ttd_st']  = $this->input->post('ttd_st');
        if ($this->input->post('ttd_sp'))
            $data['ttd_sp']  = $this->input->post('ttd_sp');

        // if (!empty($_FILES[$upload_var]['name'])) {
        //     $config['upload_path']   = '/upload/file/';
        //     $config['allowed_types'] = 'pdf';
        //     $config['file_name']     = $this->input->post($upload_var) . '-' . date('YmdHis') . "-" . rand(1000, 9999);
        //     $this->upload->initialize($config);
        //     $this->upload->do_upload($upload_var);

        //     $data[$upload_var]  = $this->upload->data('file_name');
        // }

        $data['status_putusan']  = 'terkirim';
        $this->m_default->edit('ujian', $data, array('id' => $this->input->post('id')));
        $this->session->set_flashdata('input', 'Berhasil Update Berkas');
        redirect('C_verifikasi_ujian');
    }
}

/* End of file c_verifikasi_ujian.php */
/* Location: ./application/controllers/c_verifikasi_ujian.php */
