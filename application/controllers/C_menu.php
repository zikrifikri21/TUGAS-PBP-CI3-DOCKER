<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();

        $this->load->model('Menu_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $this->template->load('template', 'kelolamenu/tbl_menu_list', $data);
    }

    function simpan_setting()
    {
        $value = $this->input->post('tampil_menu');
        $this->db->where('id_setting', 1);
        $this->db->update('tbl_setting', array('value' => $value));
        redirect('C_menu');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Menu_model->json();
    }


    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('C_menu/create_action'),
            'id' => set_value('id'),
            'title' => set_value('title'),
            'url' => set_value('url'),
            'icon' => set_value('icon'),
            'is_main_menu' => set_value('is_main_menu'),
            'is_aktif' => set_value('is_aktif'),
        );
        $this->template->load('template', 'kelolamenu/tbl_menu_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'title' => $this->input->post('title', TRUE),
                'url' => $this->input->post('url', TRUE),
                'icon' => $this->input->post('icon', TRUE),
                'is_main_menu' => $this->input->post('is_main_menu', TRUE),
                'is_aktif' => $this->input->post('is_aktif', TRUE),
            );

            $this->Menu_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('C_menu'));
        }
    }

    public function update($id)
    {
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('C_menu/update_action'),
                'id' => set_value('id', $row->id),
                'title' => set_value('title', $row->title),
                'url' => set_value('url', $row->url),
                'icon' => set_value('icon', $row->icon),
                'is_main_menu' => set_value('is_main_menu', $row->is_main_menu),
                'is_aktif' => set_value('is_aktif', $row->is_aktif),
            );
            $this->template->load('template', 'kelolamenu/tbl_menu_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_menu'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'title' => $this->input->post('title', TRUE),
                'url' => $this->input->post('url', TRUE),
                'icon' => $this->input->post('icon', TRUE),
                'is_main_menu' => $this->input->post('is_main_menu', TRUE),
                'is_aktif' => $this->input->post('is_aktif', TRUE),
            );

            $this->Menu_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('C_menu'));
        }
    }

    public function delete($id)
    {
        $row = $this->Menu_model->get_by_id($id);

        if ($row) {
            $this->Menu_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('C_menu'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_menu'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('url', 'url', 'trim|required');
        $this->form_validation->set_rules('icon', 'icon', 'trim|required');
        $this->form_validation->set_rules('is_main_menu', 'is main menu', 'trim|required');
        $this->form_validation->set_rules('is_aktif', 'is aktif', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file Kelolamenu.php */
/* Location: ./application/controllers/Kelolamenu.php */
