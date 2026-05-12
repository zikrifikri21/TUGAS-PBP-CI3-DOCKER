<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //Cek login
        cek_session();

        $this->load->model('m_default');
        $this->load->model('User_model');
        $this->load->model('User_level_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template', 'user/tbl_user_list');
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->User_model->json();
    }



    public function create()
    {
        $data = array(
            'button'            => 'Create',
            'action'            => site_url('C_user/create_action'),
            'id'           => set_value('id'),
            'nama_pengguna'  => set_value('nama_pengguna'),
            'username'         => set_value('username'),
            'email'        => set_value('email'),
            'password'     => set_value('password'),
            'tbl_user_level_id'     => set_value('tbl_user_level_id'),
            'jurusan_id'   => set_value('jurusan_id'),
            'no_hp'           => set_value('no_hp'),
            'is_aktif'          => set_value('is_aktif')
        );
        $data['user_level']          = $this->User_level_model->get_all();
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));
        $this->template->load('template', 'user/tbl_user_form', $data);
    }


    public function create_action()
    {
        // echo "<pre>";
        //  print_r($_POST);
        //  // print_r($_FILES);
        //  echo "</pre>";
        //  die;

        $this->_rules();
        $foto = $this->upload_foto();

        if ($this->form_validation->run() == FALSE) {
            // echo "belum berhasil validasi";
            $this->create();
        } else {
            $password       = $this->input->post('password', TRUE);
            $options        = array("cost" => 4);
            $hashPassword   = password_hash($password, PASSWORD_BCRYPT, $options);

            $data = array(
                'nama_pengguna'   => $this->input->post('nama_pengguna', TRUE),
                'username'           => $this->input->post('username', TRUE),
                'email'          => $this->input->post('email', TRUE),
                'password'       => $hashPassword,
                'jurusan_id'         => $this->input->post('jurusan_id', TRUE),
                'no_hp'             => $this->input->post('no_hp', TRUE),
                'picture_profile'         => $foto['file_name'],
                'is_aktif'            => $this->input->post('is_aktif', TRUE),
                'tbl_user_level_id'       => $this->input->post('tbl_user_level_id', TRUE),
            );

            $id = $this->User_model->insert($data);
            if ($this->input->post('tbl_user_level_id', TRUE) == 5) {
                $data = [];
                $data['nama_mahasiswa']  = $this->input->post('nama_pengguna');
                $data['jurusan_id']  = $this->input->post('jurusan_id');
                $data['tbl_user_id']  = $id;
                $this->m_default->input('mahasiswa', $data);
            } elseif ($this->input->post('tbl_user_level_id', TRUE) == 4) {
                $data = [];
                $data['nama_dosen']  = $this->input->post('nama_pengguna');
                $data['homebase']  = $this->input->post('jurusan_id');
                $data['tbl_user_id']  = $id;
                $this->m_default->input('dosen', $data);
            }

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('C_user'));
        }
    }

    function upload_foto()
    {
        $config['upload_path']          = './assets/foto_profil';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['remove_spaces']        = TRUE;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);
        $this->upload->do_upload('picture_profile');
        return $this->upload->data();
    }

    public function update($id)
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button'                => 'Update',
                'action'                => site_url('C_user/update_action'),
                'id'               => set_value('id', $row->id),
                'nama_pengguna'      => set_value('nama_pengguna', $row->nama_pengguna),
                'username'             => set_value('username', $row->username),
                'email'            => set_value('email', $row->email),
                'password'         => set_value('password'),
                'tbl_user_level_id'         => set_value('tbl_user_level_id', $row->tbl_user_level_id),
                'jurusan_id'           => set_value('jurusan_id', $row->jurusan_id),
                'no_hp'               => set_value('no_hp', $row->no_hp),
                'picture_profile'           => set_value('picture_profile', $row->picture_profile),

                'is_aktif'              => set_value('is_aktif', $row->is_aktif),

            );
            $data['user_level']          = $this->User_level_model->get_all();
            $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));
            $this->template->load('template', 'user/tbl_user_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_user'));
        }
    }

    public function update_action()
    {

        $this->_rules_update();
        $foto = $this->upload_foto();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $password       = $this->input->post('password', TRUE);

            if ($foto['file_name'] != '') {
                $data['picture_profile'] = $foto['file_name'];
                $this->session->set_userdata('picture_profile', $foto['file_name']);
            }

            $data = array(
                'id'    => $this->input->post('id', TRUE),
                'nama_pengguna'    => $this->input->post('nama_pengguna', TRUE),
                'username'           => $this->input->post('username', TRUE),
                'email'          => $this->input->post('email', TRUE),
                'tbl_user_level_id'       => $this->input->post('tbl_user_level_id', TRUE),
                'no_hp'             => $this->input->post('no_hp', TRUE),
                'is_aktif'            => $this->input->post('is_aktif', TRUE),
            );

            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT, array("cost" => 4));
            }

            $this->User_model->update($this->input->post('id', TRUE), $data);

            if ($this->input->post('tbl_user_level_id', TRUE) == 5) {
                $data = [];
                $data['nama_mahasiswa']  = $this->input->post('nama_pengguna');
                $data['jurusan_id']  = $this->input->post('jurusan_id');
                $this->m_default->edit('mahasiswa', $data, array('tbl_user_id' => $this->input->post('id', TRUE)));
            } elseif ($this->input->post('tbl_user_level_id', TRUE) == 4) {
                $data = [];
                $data['nama_dosen']  = $this->input->post('nama_pengguna');
                $data['homebase']  = $this->input->post('jurusan_id');
                $this->m_default->edit('dosen', $data, array('tbl_user_id' => $this->input->post('id', TRUE)));
            }

            $this->session->set_flashdata('message', 'Update Profil Berhasil');
            redirect(site_url('C_user'));
        }
    }


    public function delete($id)
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('C_user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_user'));
        }
    }



    public function _rules()
    {

        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tbl_user.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]');

        $this->form_validation->set_rules('password', 'password', 'trim|required');

        $this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required');


        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_update()
    {

        // $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tbl_user.username]');
        // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]');

        // $this->form_validation->set_rules('password', 'password', 'trim|required');

        $this->form_validation->set_rules('no_hp', 'no_hp', 'trim|required');


        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_user.xls";
        $judul = "tbl_user";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Lengkap");
        xlsWriteLabel($tablehead, $kolomhead++, "Email");
        xlsWriteLabel($tablehead, $kolomhead++, "Level User");
        xlsWriteLabel($tablehead, $kolomhead++, "Jabatan");
        xlsWriteLabel($tablehead, $kolomhead++, "No HP");
        xlsWriteLabel($tablehead, $kolomhead++, "Status User");

        foreach ($this->User_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->username);
            xlsWriteLabel($tablebody, $kolombody++, $data->email);
            xlsWriteLabel($tablebody, $kolombody++, $data->tbl_user_level_id);
            xlsWriteLabel($tablebody, $kolombody++, $data->jurusan_id);
            xlsWriteLabel($tablebody, $kolombody++, $data->no_hp);
            xlsWriteLabel($tablebody, $kolombody++, $data->is_aktif);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }


    function profile()
    {
    }

    public function change_pass()
    {

        $data['user'] = $this->db->get_where('tbl_user', ['username' => $this->session->userdata('username')])->row_array();

        // print_r($data);
        // die;

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            # code...
            $this->template->load('template', 'user/ganti_password');
        } else {
            # code...
            $current_password       = $this->input->post('current_password');

            $new_password           = $this->input->post('new_password1');
            $password_lama          = $data['user']['password'];

            // print_r($password_lama);
            // die;

            if (password_verify($current_password, $password_lama)) {
                if ($current_password == $new_password) {
                    # code...
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password yang lama</div>');
                    redirect('C_user/change_pass');
                } else {
                    # password sudah ok
                    $options        = array("cost" => 4);

                    $password_hash = password_hash($new_password, PASSWORD_BCRYPT, $options);

                    $email = $this->session->userdata('reset_email');

                    $this->db->set('password', $password_hash);
                    $this->db->where('username', $this->session->userdata('username'));
                    $this->db->update('tbl_user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diubah !</div>');
                    redirect('C_user/change_pass');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Salah password lama!</div>');
                redirect('C_user/change_pass');
            }
        }
    }


    public function reset_password($id)
    {

        $row = $this->User_model->get_by_id($id);

        // print_r($row->id);
        // die;

        if ($row) {

            $password_reset = "tvri123";
            $options        = array("cost" => 4);

            $hashPassword   = password_hash($password_reset, PASSWORD_BCRYPT, $options);

            $this->db->set('password', $hashPassword);
            $this->db->where('id', $row->id);
            $this->db->update('tbl_user');

            $this->session->set_flashdata('message', 'Password berhasil di reset !');
            redirect(site_url('C_user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('C_user'));
        }
    }

    public function change_data_pegawai()
    {
        $option = array(
            'table' => 'jurusan',
        );
        $data['jurusan'] = $this->m_default->fetch_data($option);

        if ($this->session->userdata('tbl_user_level_id') == 5) {
            $option = array(
                'select' => 'tbl_user.*,mahasiswa.nim, mahasiswa.status, mahasiswa.jurusan_id',
                'table' => 'tbl_user',
                'join' => array('mahasiswa' => 'mahasiswa.tbl_user_id = tbl_user.id'),
                'where' => array('tbl_user.id' => $this->uri->segment(3)),
                'single' => true,
            );
        } elseif ($this->session->userdata('tbl_user_level_id') == 4) {
            $option = array(
                'select' => 'tbl_user.*,dosen.nip,dosen.nidn,dosen.jabatan_akademik,dosen.tmt_akademik,dosen.homebase, dosen.pangkat,dosen.pangkat_tmt,dosen.pendidikan_terakhir,dosen.status',
                'table' => 'tbl_user',
                'join' => array('dosen' => 'dosen.tbl_user_id = tbl_user.id'),
                'where' => array('tbl_user.id' => $this->uri->segment(3)),
                'single' => true,
            );
        } else {
            $option = array(
                'select' => 'tbl_user.*',
                'table' => 'tbl_user',
                'where' => array('tbl_user.id' => $this->uri->segment(3)),
                'single' => true,
            );
        }
        $data['user'] = $this->m_default->fetch_data($option);

        // $data['user']    = $this->User_model->get_by_id2($this->uri->segment(3));
        $this->template->load('template', 'user/tbl_pegawai_form', $data);
    }

    public function action_change_data_pegawai()
    {
        if ($this->session->userdata('tbl_user_level_id') == 5) {
            $data['nama_mahasiswa']  = $this->input->post('nama_pengguna');
            $data['nim']  = $this->input->post('nim');
            $data['status']  = $this->input->post('status');
            $data['jurusan_id']  = $this->input->post('jurusan_id');
            $this->m_default->edit('mahasiswa', $data, array('tbl_user_id' => $this->input->post('id', TRUE)));
        } elseif ($this->session->userdata('tbl_user_level_id') == 4) {
            $data['nama_dosen']  = $this->input->post('nama_dosen');
            $data['nidn']  = $this->input->post('nidn');
            $data['status']  = $this->input->post('status');
            $data['homebase']  = $this->input->post('homebase');
            $data['jabatan_akademik']  = $this->input->post('jabatan_akademik');
            $data['tmt_akademik']  = $this->input->post('tmt_akademik');
            $data['pangkat_tmt']  = $this->input->post('pangkat_tmt');
            $data['pangkat']  = $this->input->post('pangkat');
            $data['pendidikan_terakhir']  = $this->input->post('pendidikan_terakhir');
            $this->m_default->edit('dosen', $data, array('tbl_user_id' => $this->input->post('id', TRUE)));
        }

        $foto = $this->upload_foto();
        if ($foto['file_name'] != '') {
            $datab['picture_profile']         = $foto['file_name'];
            $this->session->set_userdata('picture_profile', $foto['file_name']);
        }

        if ($this->input->post('password', TRUE) != '')
            $datab['password']         = $this->input->post('password', TRUE);

        $datab = array(
            'id'    => $this->input->post('id', TRUE),
            'nama_pengguna'    => $this->input->post('nama_pengguna', TRUE),
            'username'           => $this->input->post('username', TRUE),
            'email'          => $this->input->post('email', TRUE),
            'jurusan_id'         => $this->input->post('jurusan_id', TRUE),
            'no_hp'             => $this->input->post('no_hp', TRUE),
        );
        $this->session->set_userdata('username', $this->input->post('username', TRUE));
        $this->session->set_userdata('jurusan_id', $this->input->post('jurusan_id', TRUE));
        $this->session->set_userdata('nama_pengguna', $this->input->post('nama_pengguna', TRUE));

        $this->User_model->update($this->input->post('id', TRUE), $datab);
        $this->session->set_flashdata('edit', 'Berhasil Update Data Profil ' . $this->input->post('nama_pengguna', TRUE));
        redirect('c_home');
    }
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */