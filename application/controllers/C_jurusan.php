<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_jurusan extends CI_Controller
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
            'select' => 'jurusan.*,ketua.nama_dosen as nama_ketua,sekretaris.nama_dosen as nama_sekretaris',
            'table' => 'jurusan',
            'join' => array('dosen as ketua' => 'ketua.id = jurusan.ketua_jurusan', 'dosen as sekretaris' => 'sekretaris.id = jurusan.sekretaris_jurusan'),
        );
        if ($this->session->userdata('tbl_user_level_id') == 2) {
            $option['where'] = array('jurusan.id' => $this->session->userdata('jurusan_id'));
        }
        $data['jurusan'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'jurusan/list', $data);
    }

    public function create()
    {
        if (!empty($this->input->post('nama_jurusan'))) {
            $data['nama_jurusan']  = $this->input->post('nama_jurusan');
            $data['ketua_jurusan']  = $this->input->post('ketua_jurusan');
            $data['sekretaris_jurusan']  = $this->input->post('sekretaris_jurusan');
            $this->session->set_flashdata('input', 'Berhasil Tambah jurusan ' . $data['nama_jurusan']);

            $this->m_default->input('jurusan', $data);
            redirect('c_jurusan');
        } else {
            $data = array(
                'action'           => site_url('C_jurusan/create'),
                'id'           => set_value('id'),
                'nama_jurusan'  => set_value('nama_jurusan'),
                'ketua_jurusan'     => set_value('ketua_jurusan'),
                'sekretaris_jurusan'     => set_value('sekretaris_jurusan'),
            );
            $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
            $this->template->load('template', 'jurusan/form', $data);
        }
    }

    public function update($id = null)
    {
        if (!empty($this->input->post('nama_jurusan'))) {
            $data['id']    = $this->input->post('id');
            $data['nama_jurusan']  = $this->input->post('nama_jurusan');
            $data['ketua_jurusan']  = $this->input->post('ketua_jurusan');
            $data['sekretaris_jurusan']  = $this->input->post('sekretaris_jurusan');
            $this->m_default->edit('jurusan', $data, array('id' => $data['id']));

            $this->session->set_flashdata('edit', 'Berhasil Update jurusan ' . $data['nama_jurusan']);
            redirect('c_jurusan');
        } else {
            $option = array(
                'table' => 'jurusan',
                'where' => array('id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);
            $data = array(
                'action'           => site_url('C_jurusan/update'),
                'id'               => set_value('id', $get->id),
                'nama_jurusan'     => set_value('nama_jurusan', $get->nama_jurusan),
                'ketua_jurusan'     => set_value('ketua_jurusan', $get->ketua_jurusan),
                'sekretaris_jurusan'     => set_value('sekretaris_jurusan', $get->sekretaris_jurusan),
            );
            $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
            $this->template->load('template', 'jurusan/form', $data);
        }
    }

    public function delete()
    {
        $this->m_default->delete('jurusan', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'jurusan ' . $this->input->post('nama_jurusan') . " telah dihapus !");

        redirect('c_jurusan');
    }
}

/* End of file C_jurusan.php */
/* Location: ./application/controllers/C_jurusan.php */