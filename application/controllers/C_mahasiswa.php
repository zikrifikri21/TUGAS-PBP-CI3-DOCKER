<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_mahasiswa extends CI_Controller
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
            'select' => 'mahasiswa.*,jurusan.nama_jurusan',
            'table' => 'mahasiswa',
            'join' => array('jurusan' => 'jurusan.id = mahasiswa.jurusan_id'),
            'order' => array('mahasiswa.id' => 'desc'),
        );
        if ($this->session->userdata('tbl_user_level_id') == 2) {
            $option['where'] = array('jurusan_id' => $this->session->userdata('jurusan_id'));
        }
        // printr($this->session->userdata('jurusan_id'));
        // die;
        $data['mahasiswa'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'mahasiswa/list', $data);
    }

    public function create()
    {
        if (!empty($this->input->post('nama_mahasiswa'))) {
            $option = array(
                'table' => 'mahasiswa',
                'where' => array('nim' => $this->input->post('nim')),
            );

            $check_double = $this->m_default->fetch_data($option);
            if ($check_double) {
                $this->session->set_flashdata('delete', 'Gagal Tambah mahasiswa, NIM ' . $this->input->post('nim') . ' Telah Digunakan Sebelumnya.');
                redirect('c_mahasiswa');
            }

            $datac['nama_pengguna']  = $this->input->post('nama_mahasiswa');
            $datac['username']  = $this->input->post('username');
            $datac['password']  = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT, array("cost" => 4));
            $datac['email']  = '';
            $datac['jurusan_id']  = $this->input->post('jurusan_id');
            $datac['no_hp']  = '';
            $datac['picture_profile']  = '';
            $datac['is_aktif']  = 'y';
            $datac['tbl_user_level_id']  = 5;
            $id_user = $this->m_default->input('tbl_user', $datac);

            $data['nama_mahasiswa']  = $this->input->post('nama_mahasiswa');
            $data['nim']  = $this->input->post('nim');
            $data['status']  = $this->input->post('status');
            $data['jurusan_id']  = $this->input->post('jurusan_id');
            $data['tbl_user_id']  = $id_user;
            $this->m_default->input('mahasiswa', $data);

            $this->session->set_flashdata('input', 'Berhasil Tambah mahasiswa ' . $data['nama_mahasiswa']);
            redirect('c_mahasiswa');
        } else {
            $data = array(
                'action'           => site_url('C_mahasiswa/create'),
                'id'           => set_value('id'),
                'nama_mahasiswa'  => set_value('nama_mahasiswa'),
                'nim'  => set_value('nim'),
                'status'  => set_value('status'),
                'jurusan_id'  => set_value('jurusan_id'),
                'tbl_user_id'  => set_value('tbl_user_id'),
                'username'  => set_value('username'),
                'password'  => set_value('password'),
            );

            $option = array(
                'table' => 'jurusan',
            );
            $data['jurusan'] = $this->m_default->fetch_data($option);
            $this->template->load('template', 'mahasiswa/form', $data);
        }
    }

    public function update($id = null)
    {
        if (!empty($this->input->post('nama_mahasiswa'))) {
            $datac['id']  = $this->input->post('tbl_user_id');
            $datac['nama_pengguna']  = $this->input->post('nama_mahasiswa');
            $datac['username']  = $this->input->post('username');
            if (!empty($this->input->post('password', TRUE)))
                $datac['password']  = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT, array("cost" => 4));

            $this->m_default->edit('tbl_user', $datac, array('id' => $datac['id']));


            $data['id']    = $this->input->post('id');
            $data['nama_mahasiswa']  = $this->input->post('nama_mahasiswa');
            $data['nim']  = $this->input->post('nim');
            $data['status']  = $this->input->post('status');
            $data['jurusan_id']  = $this->input->post('jurusan_id');
            $data['tbl_user_id']  = $this->input->post('tbl_user_id');
            $this->m_default->edit('mahasiswa', $data, array('id' => $data['id']));

            $this->session->set_flashdata('edit', 'Berhasil Update mahasiswa ' . $data['nama_mahasiswa']);
            redirect('c_mahasiswa');
        } else {
            $option = array(
                'select' => 'mahasiswa.*, tbl_user.username',
                'table' => 'mahasiswa',
                'join' => array('jurusan' => 'jurusan.id = mahasiswa.jurusan_id', 'tbl_user' => 'tbl_user.id = mahasiswa.tbl_user_id'),
                'where' => array('mahasiswa.id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('C_mahasiswa/update'),
                'id'               => set_value('id', $get->id),
                'nama_mahasiswa'     => set_value('nama_mahasiswa', $get->nama_mahasiswa),
                'nim'  => set_value('nim', $get->nim),
                'status'  => set_value('status', $get->status),
                'jurusan_id'  => set_value('jurusan_id', $get->jurusan_id),
                'tbl_user_id'  => set_value('tbl_user_id', $get->tbl_user_id),
                'username'  => set_value('username', $get->username),
                'password'  => set_value('password'),
            );

            $option = array(
                'table' => 'jurusan',
            );
            $data['jurusan'] = $this->m_default->fetch_data($option);
            $this->template->load('template', 'mahasiswa/form', $data);
        }
    }

    public function delete()
    {
        $this->m_default->delete('mahasiswa', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'mahasiswa ' . $this->input->post('nama_mahasiswa') . " telah dihapus !");

        redirect('c_mahasiswa');
    }
}

/* End of file C_mahasiswa.php */
/* Location: ./application/controllers/C_mahasiswa.php */
