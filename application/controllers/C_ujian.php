<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ujian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
    }

    public function index()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $option = array(
            'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
            'order' => array('ujian.id' => 'desc'),
        );

        if ($this->session->userdata('tbl_user_level_id') == 5) {
            $mahasiswa = $this->m_default->fetch_data(array('table' => 'mahasiswa', 'where' => array('tbl_user_id' => $this->session->userdata('id')), 'single' => true));
            $option['where'] = ['mahasiswa.id' => $mahasiswa->id, 'ujian.akhiri_ujian' => 0];
        } elseif ($this->session->userdata('tbl_user_level_id') == 4) {
            $dosen = $this->m_default->fetch_data(array('table' => 'dosen', 'where' => array('tbl_user_id' => $this->session->userdata('id')), 'single' => true));
            $option['where'] = '';
        } elseif ($this->session->userdata('tbl_user_level_id') == 2) {
            $option['where'] = array('mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'));
        }

        $data['ujian'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'ujian/list', $data);
    }

    public function monitoring()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $option = array(
            'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
            'order' => array('ujian.id' => 'desc'),
        );

        if (
            $this->session->userdata('tbl_user_level_id') == 5 || auth('tbl_user_level_id') == 9 || auth('tbl_user_level_id') == 2
            || auth('tbl_user_level_id') == 4 || auth('tbl_user_level_id') == 10 || auth('tbl_user_level_id') == 8
        ) {
            //berdasarkan mahasiswa
            $mahasiswa   = $this->m_default->fetch_data(array('table' => 'mahasiswa', 'where' => array('tbl_user_id' => auth('id')), 'single' => true));
            $isStafKAjur = auth('tbl_user_level_id') == 9 || auth('tbl_user_level_id') == 2;
            $isMahasiswa = auth('tbl_user_level_id') == 5;
            $isDosen     = auth('tbl_user_level_id') == 4 || auth('tbl_user_level_id') == 10 || auth('tbl_user_level_id') == 8;
            $jurusanId   = (int) auth('jurusan_id');
            $dosen       = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();
            $dosenId     = $dosen->id ?? null;

            $data['ujian'] = Ujian::table()->with('mahasiswa.jurusan', 'sk_dekan', 'ujian_has_sk_dekan_b.skdekan', 'penilaian')
                ->when($isMahasiswa, function ($query) use ($mahasiswa) {
                    return $query->where(['mahasiswa_id' => $mahasiswa->id]);
                })
                ->when($isStafKAjur, function ($query) use ($jurusanId) {
                    return $query->where(function ($q) use ($jurusanId) {
                        $q->where('mahasiswa.jurusan_id', $jurusanId);
                    });
                })
                ->when($isDosen, function ($query) use ($dosenId) {
                    return $query->where(function ($q) use ($dosenId) {
                        return $q->where('pembimbing_1', $dosenId)
                            ->orWhere('pembimbing_2', $dosenId)
                            ->orWhere('uji1', $dosenId)
                            ->orWhere('uji2', $dosenId)
                            ->orWhere('uji3', $dosenId);
                    });
                })
                ->get();
            // dd($data['ujian']);
            // } elseif ($this->session->userdata('tbl_user_level_id') == 4) {
            //     //mungkin masing masing dosen ini
            //     $dosen = $this->m_default->fetch_data(array('table' => 'dosen', 'where' => array('tbl_user_id' => $this->session->userdata('id')), 'single' => true));
            //     $option['where'] = $dosen ? "(ujian.pembimbing_1 = '" . $dosen->id . "' or ujian.pembimbing_2 = '" . $dosen->id . "' or ujian.uji1 = '" . $dosen->id . "' or ujian.uji2 = '" . $dosen->id . "' or ujian.uji3 = '" . $dosen->id . "')" : '1=0';
            //     $data['ujian'] = $this->m_default->fetch_data($option) ?: array();
            // } elseif ($this->session->userdata('tbl_user_level_id') == 2) {
            //     // berdasarkan jurusan
            //     $option['where'] = array('mahasiswa.jurusan_id' => $this->session->userdata('jurusan_id'));
            //     $data['ujian'] = $this->m_default->fetch_data($option) ?: array();
        } elseif ($this->session->userdata('tbl_user_level_id') == 3) {
            // dekan?? admin fakultas??
            $option['where'] = array('ujian.jenis_ujian' => 'skripsi');
            $data['ujian'] = $this->m_default->fetch_data($option) ?: array();
        }

        $this->template->load('template', 'monitoring/mahasiswa', $data);
    }

    public function create()
    {
        if (!empty($this->input->post('judul'))) {
            $option = array(
                'table' => 'mahasiswa',
                'where' => array('tbl_user_id' => $this->session->userdata('id')),
                'single' => true
            );
            $mahasiswa = $this->m_default->fetch_data($option);

            $option = array(
                'table' => 'ujian',
                'where' => array('jenis_ujian' => $this->input->post('jenis_ujian'), 'mahasiswa_id' => $mahasiswa->id),
            );
            // $check_double = $this->m_default->fetch_data($option);
            // if ($check_double) {
            //     $this->session->set_flashdata('delete', 'Gagal Menambahkan Data, Ujian ' . ucwords($this->input->post('jenis_ujian')) . ' Sudah Pernah Ditambahkan');
            //     redirect('c_ujian');
            // }

            $data['judul']  = $this->input->post('judul');
            $data['jenis_ujian']  = $this->input->post('jenis_ujian');
            $data['ipk_sementara']  = $this->input->post('ipk_sementara');
            $data['mahasiswa_id']  = $mahasiswa->id;
            $this->m_default->input('ujian', $data);

            $this->session->set_flashdata('input', 'Berhasil Tambah ujian ' . $data['judul']);
            redirect('c_ujian');
        } else {
            $data = array(
                'action'           => site_url('C_ujian/create'),
                'id'           => set_value('id'),
                'judul'  => set_value('judul'),
                'jenis_ujian'  => set_value('jenis_ujian'),
                'pembimbing_1'  => set_value('pembimbing_1'),
                'pembimbing_2'  => set_value('pembimbing_2'),
                'uji1'  => set_value('uji1'),
                'uji2'  => set_value('uji2'),
                'uji3'  => set_value('uji3'),
                'mahasiswa_id'  => set_value('mahasiswa_id'),
                'ipk_sementara'  => set_value('ipk_sementara'),
            );

            $option = array(
                'table' => 'dosen',
                'where' => array('status' => 'aktif')
            );
            $data['dosen']        = $this->m_default->fetch_data($option);
            $data['mahasiswa']    = Mahasiswa::table()->select('id')->where(['tbl_user_id' => auth('id')])->first();
            $data['ujian']        = Ujian::table()->select('judul')->where(["mahasiswa_id !=" => "{$data['mahasiswa']->id}"])->get();
            $this->template->load('template', 'ujian/form', $data);
        }
    }

    public function update($id = null)
    {
        if (!empty($this->input->post('jenis_ujian'))) {
            $data['id']    = $this->input->post('id');
            $data['jenis_ujian']  = $this->input->post('jenis_ujian');
            $data['judul']  = $this->input->post('judul');
            $data['ipk_sementara']  = $this->input->post('ipk_sementara');
            $this->m_default->edit('ujian', $data, array('id' => $data['id']));

            $this->session->set_flashdata('edit', 'Berhasil Update ujian ' . $data['jenis_ujian']);
            redirect('c_ujian');
        } else {
            $option = array(
                'select' => '*',
                'table' => 'ujian',
                'where' => array('ujian.id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('C_ujian/update'),
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
            );

            $option = array(
                'table' => 'dosen',
                'where' => array('status' => 'aktif')
            );
            $data['dosen']        = $this->m_default->fetch_data($option);
            $data['mahasiswa']    = Mahasiswa::table()->select('id')->where(['tbl_user_id' => auth('id')])->first();
            $data['ujian']        = Ujian::table()->select('judul')->where(["mahasiswa_id !=" => "{$data['mahasiswa']->id}"])->get();
            $this->template->load('template', 'ujian/form', $data);
        }
    }

    public function delete()
    {
        $this->m_default->delete('bukti_dukung', array('ujian_id' => $this->input->post('id')));
        $this->m_default->delete('ujian', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'ujian ' . $this->input->post('ujian') . " telah dihapus !");

        redirect('c_ujian');
    }
}

/* End of file C_ujian.php */
/* Location: ./application/controllers/C_ujian.php */
