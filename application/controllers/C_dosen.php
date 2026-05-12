<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_dosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
    }

    // public function dosen_pembimbing_dan_penguji()
    // {
    //     $this->db->select('
    //         d.id,
    //         d.nama_dosen,
    //         j.nama_jurusan,
    //         COUNT(DISTINCT u1.id) AS jumlah_pembimbing_1,
    //         COUNT(DISTINCT u2.id) AS jumlah_pembimbing_2,
    //         COUNT(DISTINCT u1.id) + COUNT(DISTINCT u2.id) AS total_bimbingan,
    //         COUNT(DISTINCT uj1.id) AS jumlah_uji1,
    //         COUNT(DISTINCT uj2.id) AS jumlah_uji2,
    //         COUNT(DISTINCT uj3.id) AS jumlah_uji3,
    //         COUNT(DISTINCT uj1.id) + COUNT(DISTINCT uj2.id) + COUNT(DISTINCT uj3.id) AS total_pengujian
    //     ');

    //     $this->db->from('dosen d');
    //     $this->db->join('jurusan j', 'j.id = d.homebase', 'left');
    //     $this->db->join('ujian u1', 'u1.pembimbing_1 = d.id', 'left');
    //     $this->db->join('ujian u2', 'u2.pembimbing_2 = d.id', 'left');
    //     $this->db->join('ujian uj1', 'uj1.uji1 = d.id', 'left');
    //     $this->db->join('ujian uj2', 'uj2.uji2 = d.id', 'left');
    //     $this->db->join('ujian uj3', 'uj3.uji3 = d.id', 'left');
    //     $this->db->group_by('d.id, d.nama_dosen, j.nama_jurusan');
    //     $this->db->order_by('total_pengujian', 'desc');
    //     $data['data'] = $this->db->get()->result_array();

    //     $this->db->select('id, nama_jurusan');
    //     $this->db->from('jurusan');
    //     $data['jurusan'] = $this->db->get()->result_array();

    //     $this->template->load('template', 'dosen/dosen_pembimbing_dan_penguji', $data);
    // }
    public function dosen_pembimbing_dan_penguji()
    {
        $tahun = $this->input->get('tahun');
        if (empty($tahun)) {
            $tahun = date('Y');
        }

        $this->db->select('
            d.id,
            d.nama_dosen,
            j.nama_jurusan,
            COUNT(DISTINCT u1.id) AS jumlah_pembimbing_1,
            COUNT(DISTINCT u2.id) AS jumlah_pembimbing_2,
            (COUNT(DISTINCT u1.id) + COUNT(DISTINCT u2.id)) AS total_bimbingan,
            COUNT(DISTINCT uj1.id) AS jumlah_uji1,
            COUNT(DISTINCT uj2.id) AS jumlah_uji2,
            COUNT(DISTINCT uj3.id) AS jumlah_uji3,
            (COUNT(DISTINCT uj1.id) + COUNT(DISTINCT uj2.id) + COUNT(DISTINCT uj3.id)) AS total_pengujian
        ');

        $this->db->from('dosen d');
        $this->db->join('jurusan j', 'j.id = d.homebase', 'left');
        $this->db->join("ujian u1", "u1.pembimbing_1 = d.id AND YEAR(u1.hari_ujian) = $tahun", "left");
        $this->db->join("ujian u2", "u2.pembimbing_2 = d.id AND YEAR(u2.hari_ujian) = $tahun", "left");

        $this->db->join("ujian uj1", "uj1.uji1 = d.id AND YEAR(uj1.hari_ujian) = $tahun", "left");
        $this->db->join("ujian uj2", "uj2.uji2 = d.id AND YEAR(uj2.hari_ujian) = $tahun", "left");
        $this->db->join("ujian uj3", "uj3.uji3 = d.id AND YEAR(uj3.hari_ujian) = $tahun", "left");
        $this->db->group_by('d.id, d.nama_dosen, j.nama_jurusan');
        $this->db->order_by('total_pengujian', 'DESC');
        $data['data'] = $this->db->get()->result_array();

        $this->db->select('id, nama_jurusan');
        $this->db->from('jurusan');
        $data['jurusan'] = $this->db->get()->result_array();
        $data['tahun_selected'] = $tahun;

        $this->template->load('template', 'dosen/dosen_pembimbing_dan_penguji', $data);
    }


    public function index()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $option = array(
            'select' => 'dosen.*,jurusan.nama_jurusan',
            'table' => 'dosen',
            'join' => array('jurusan' => 'jurusan.id = dosen.homebase'),
            'order' => array('dosen.id' => 'desc'),
        );
        if ($this->session->userdata('tbl_user_level_id') == 2) {
            $option['where'] = array('dosen.homebase' => $this->session->userdata('jurusan_id'));
        }

        $data['dosen'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'dosen/list', $data);
    }

    public function create()
    {
        if (!empty($this->input->post('nama_dosen'))) {
            $option = array(
                'table' => 'dosen',
                'where' => array('nip' => $this->input->post('nip')),
            );

            $check_double = $this->m_default->fetch_data($option);
            if (!empty($this->input->post('nip')) and $check_double) {
                $this->session->set_flashdata('delete', 'Gagal Tambah Dosen, NIP Telah Digunakan');
                redirect('c_dosen');
            }

            $option = array(
                'table' => 'dosen',
                'where' => array('nidn' => $this->input->post('nidn')),
            );

            $check_double = $this->m_default->fetch_data($option);
            if (!empty($this->input->post('nidn')) and $check_double) {
                $this->session->set_flashdata('delete', 'Gagal Tambah Dosen, NIDN Telah Digunakan');
                redirect('c_dosen');
            }

            $datac['nama_pengguna']  = $this->input->post('nama_dosen');
            $datac['username']  = $this->input->post('username');
            $datac['password']  = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT, array("cost" => 4));
            $datac['email']  = '';
            $datac['jurusan_id']  = $this->input->post('homebase');
            $datac['no_hp']  = '';
            $datac['picture_profile']  = '';
            $datac['is_aktif']  = 'y';
            $datac['tbl_user_level_id']  = 4;
            $id_user = $this->m_default->input('tbl_user', $datac);

            $data['nama_dosen']  = $this->input->post('nama_dosen');
            $data['nidn']  = $this->input->post('nidn');
            $data['nip']  = $this->input->post('nip');
            $data['status']  = $this->input->post('status');
            $data['homebase']  = $this->input->post('homebase');
            $data['jabatan_akademik']  = $this->input->post('jabatan_akademik');
            $data['tmt_akademik']  = $this->input->post('tmt_akademik');
            $data['pangkat_tmt']  = $this->input->post('pangkat_tmt');
            $data['pangkat']  = $this->input->post('pangkat');
            $data['pendidikan_terakhir']  = $this->input->post('pendidikan_terakhir');
            $data['tbl_user_id']  = $id_user;
            $this->m_default->input('dosen', $data);

            $this->session->set_flashdata('input', 'Berhasil Tambah dosen ' . $data['nama_dosen']);
            redirect('c_dosen');
        } else {
            $data = array(
                'action'           => site_url('C_dosen/create'),
                'id'           => set_value('id'),
                'nama_dosen'  => set_value('nama_dosen'),
                'nidn'  => set_value('nidn'),
                'nip'  => set_value('nip'),
                'status'  => set_value('status'),
                'homebase'  => set_value('homebase'),
                'jabatan_akademik'  => set_value('jabatan_akademik'),
                'tmt_akademik'  => set_value('tmt_akademik'),
                'pangkat_tmt'  => set_value('pangkat_tmt'),
                'pangkat'  => set_value('pangkat'),
                'pendidikan_terakhir'  => set_value('pendidikan_terakhir'),
                'tbl_user_id'  => set_value('tbl_user_id'),
                'username'  => set_value('username'),
                'password'  => set_value('password'),
            );

            $option = array(
                'table' => 'jurusan',
            );
            $data['jurusan'] = $this->m_default->fetch_data($option);
            $this->template->load('template', 'dosen/form', $data);
        }
    }

    public function update($id = null)
    {
        if (!empty($this->input->post('nama_dosen'))) {
            $datac['id']  = $this->input->post('tbl_user_id');
            $datac['nama_pengguna']  = $this->input->post('nama_dosen');
            $datac['username']  = $this->input->post('username');
            if (!empty($this->input->post('password', TRUE)))
                $datac['password']  = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT, array("cost" => 4));

            $this->m_default->edit('tbl_user', $datac, array('id' => $datac['id']));


            $data['id']    = $this->input->post('id');
            $data['nama_dosen']  = $this->input->post('nama_dosen');
            $data['nidn']  = $this->input->post('nidn');
            $data['nip']  = $this->input->post('nip');
            $data['status']  = $this->input->post('status');
            $data['homebase']  = $this->input->post('homebase');
            // $data['jabatan_akademik']  = $this->input->post('jabatan_akademik');
            $data['tmt_akademik']  = $this->input->post('tmt_akademik');
            $data['pangkat_tmt']  = $this->input->post('pangkat_tmt');
            $data['pangkat']  = $this->input->post('pangkat');
            // $data['pendidikan_terakhir']  = $this->input->post('pendidikan_terakhir');
            $data['tbl_user_id']  = $this->input->post('tbl_user_id');
            $this->m_default->edit('dosen', $data, array('id' => $data['id']));
            $this->m_default->edit('tbl_user', ['jurusan_id' => $data['homebase']], array('id' => $data['tbl_user_id']));

            $this->session->set_flashdata('edit', 'Berhasil Update dosen ' . $data['nama_dosen']);
            redirect('c_dosen');
        } else {
            $option = array(
                'select' => 'dosen.*, tbl_user.username',
                'table' => 'dosen',
                'join' => array('jurusan' => 'jurusan.id = dosen.homebase', 'tbl_user' => 'tbl_user.id = dosen.tbl_user_id'),
                'where' => array('dosen.id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('C_dosen/update'),
                'id'               => set_value('id', $get->id),
                'nama_dosen'     => set_value('nama_dosen', $get->nama_dosen),
                'nidn'  => set_value('nidn', $get->nidn),
                'nip'  => set_value('nip', $get->nip),
                'status'  => set_value('status', $get->status),
                'homebase'  => set_value('homebase', $get->homebase),
                'jabatan_akademik'  => set_value('jabatan_akademik', $get->jabatan_akademik),
                'tmt_akademik'  => set_value('tmt_akademik', $get->tmt_akademik),
                'pangkat'  => set_value('pangkat', $get->pangkat),
                'pangkat_tmt'  => set_value('pangkat_tmt', $get->pangkat_tmt),
                'pendidikan_terakhir'  => set_value('pendidikan_terakhir', $get->pendidikan_terakhir),
                'tbl_user_id'  => set_value('tbl_user_id', $get->tbl_user_id),
                'username'  => set_value('username', $get->username),
                'password'  => set_value('password'),
            );

            $option = array(
                'table' => 'jurusan',
            );
            $data['jurusan'] = $this->m_default->fetch_data($option);
            $this->template->load('template', 'dosen/form', $data);
        }
    }

    public function delete()
    {
        $this->m_default->delete('dosen', array('id' => $this->input->post('id')));
        $this->m_default->delete('tbl_user', array('id' => $this->input->post('tbl_user_id')));
        $this->session->set_flashdata('delete', 'dosen ' . $this->input->post('nama_dosen') . " telah dihapus !");

        redirect('c_dosen');
    }
}

/* End of file C_dosen.php */
/* Location: ./application/controllers/C_dosen.php */
