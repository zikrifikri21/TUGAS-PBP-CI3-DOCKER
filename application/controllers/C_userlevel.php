<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_userlevel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //is_login();

        //Cek login
        cek_session();

        $this->load->model('User_level_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template', 'userlevel/tbl_user_level_list');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->User_level_model->json();
    }

    public function read($id)
    {
        $row = $this->User_level_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'nama' => $row->nama,
            );
            $this->template->load('admin/template', 'admin/userlevel/tbl_user_level_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_userlevel'));
        }
    }

    function akses()
    {
        $data['level'] = $this->db->get_where('tbl_user_level', array('id' =>  $this->uri->segment(3)))->row_array();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die;

        $data['menu']       = $this->db->get('tbl_menu')->result();

        $this->template->load('template', 'userlevel/akses', $data);
    }

    function kasi_akses_ajax()
    {
        $tbl_menu_id        = $_GET['id_menu'];
        $tbl_user_level_id  = $_GET['level'];
        // chek data
        $params = array('tbl_menu_id' => $tbl_menu_id, 'tbl_user_level_id' => $tbl_user_level_id);

        $akses = $this->db->get_where('tbl_hak_akses', $params);
        if ($akses->num_rows() < 1) {
            // insert data baru
            $this->db->insert('tbl_hak_akses', $params);
        } else {
            $this->db->where('tbl_menu_id', $tbl_menu_id);
            $this->db->where('tbl_user_level_id', $tbl_user_level_id);
            $this->db->delete('tbl_hak_akses');
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('C_userlevel/create_action'),
            'id' => set_value('id'),
            'nama' => set_value('nama'),
        );
        $this->template->load('template', 'userlevel/tbl_user_level_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama' => $this->input->post('nama', TRUE),
            );

            $this->User_level_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('C_userlevel'));
        }
    }

    public function update($id)
    {
        $row = $this->User_level_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('C_userlevel/update_action'),
                'id' => set_value('id', $row->id),
                'nama' => set_value('nama', $row->nama),
            );
            $this->template->load('template', 'userlevel/tbl_user_level_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_userlevel'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'nama' => $this->input->post('nama', TRUE),
            );

            $this->User_level_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('C_userlevel'));
        }
    }

    public function delete($id)
    {
        $row = $this->User_level_model->get_by_id($id);

        if ($row) {
            $this->User_level_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('C_userlevel'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_userlevel'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'nama level', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_user_level.xls";
        $judul = "tbl_user_level";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Level");

        foreach ($this->User_level_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_user_level.doc");

        $data = array(
            'tbl_user_level_data' => $this->User_level_model->get_all(),
            'start' => 0
        );

        $this->load->view('admin/userlevel/tbl_user_level_doc', $data);
    }
}

/* End of file Userlevel.php */
/* Location: ./application/controllers/Userlevel.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-04 06:29:37 */
/* http://harviacode.com */