<?php
class C_auth extends CI_Controller
{
    function index()
    {
        if ($this->session->userdata('cek_login')) {
            redirect('C_home');
        } else {
            $this->load->view('auth-login');
        }
    }

    public function cheklogin()
    {
        $username      = $this->input->post('username', TRUE);
        //$password   = $this->input->post('password');
        $password = $this->input->post('password', TRUE);
        $hashPass = password_hash($password, PASSWORD_BCRYPT);
        // query chek users
        $this->db->select('a.*,c.nama');
        $this->db->where('a.username', $username);
        //$this->db->where('password',  $test);
        $this->db->join('tbl_user_level c', 'c.id = a.tbl_user_level_id');
        $users       = $this->db->get('tbl_user a');

        if ($users->num_rows() > 0) {
            $user = $users->row_array();
            // print_r($user);
            // die;
            if (password_verify($password, $user['password'])) {

                $user['logged_in']      = 'Sudah Loggin';
                $user['cek_login']      = 'oke';
                $user['tbl_user_level_id']     = $user['tbl_user_level_id'];
                $user['nama_level']     = $user['nama'];
                // $user['tbl_unit_kerja_id_unit_kerja']     = $user['tbl_unit_kerja_id_unit_kerja'];
                $user['email']     = $user['email'];
                $user['id']        = $user['id'];
                $user['picture_profile']    = $user['picture_profile'];
                $user['jurusan_id']    = $user['jurusan_id'];
                $user['nama_pengguna']    = $user['nama_pengguna'];
                $user['IsAuthorized']    = true;
                // retrive user data to session
                $this->session->set_userdata($user);

                if ($user['tbl_user_level_id'] == 1) {
                    # code...
                    $this->session->set_flashdata('message', 'Selamat Datang <strong>SUPER ADMIN</strong> ' . $user['nama_pengguna']);
                    redirect('C_user');
                } else if ($user['tbl_user_level_id'] == 2) {
                    # code...
                    $this->session->set_flashdata('message', 'Selamat Datang <strong>Staf Jurusan</strong> ' . $user['nama_pengguna']);
                    redirect('C_home');
                } else if ($user['tbl_user_level_id'] == 3) {
                    # code...
                    $this->session->set_flashdata('message', 'Selamat Datang <strong>Staf Akademik</strong> ' . $user['nama_pengguna']);
                    redirect('C_home');
                } else if ($user['tbl_user_level_id'] == 5) {
                    # code...
                    $this->session->set_flashdata('message', 'Selamat Datang <strong>Mahasiswa</strong> ' . $user['nama_pengguna']);
                    redirect('C_home');
                }
                $this->session->set_flashdata('message', 'Selamat Datang ' . $user['nama_pengguna']);
                redirect('C_home');
            } else {
                $this->session->set_flashdata('status_login', 'username atau password yang anda input salah');
                redirect('C_auth');
            }
        } else {
            $this->session->set_flashdata('status_login', 'username atau password yang anda input salah');
            redirect('C_auth');
        }
    }

    // Tambahan AUTH 15/10/2020
    public function forgotpass()
    {
        // 1. Load Library Mailer yang tadi dibuat
        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $this->load->library('mailer');

        //     // 2. Siapkan data yang dibutuhkan oleh fungsi send($data)
        //     $email_data = array(
        //         'email_penerima' => 'iniakunku329@gmail.com', // Ganti dengan email tujuan
        //         'subjek'         => 'Test Kirim Email dari CodeIgniter',
        //         'content'        => '<h1>Halo!</h1><p>Ini adalah isi pesan email testing.</p>'
        //     );

        //     // 3. Panggil fungsi send
        //     $hasil = $this->mailer->send($email_data);
        //     if ($hasil['status'] == 'Sukses') {
        //         $this->session->set_flashdata('notif', 'Berhasil: ' . $hasil['message']);
        //         redirect('C_auth/forgotpass');
        //     } else {
        //         $this->session->set_flashdata('notif', 'Gagal: ' . $hasil['error']);
        //         redirect('C_auth/forgotpass');
        //     }
        // } else {
        // }
        $this->load->view('auth-login');

        // 4. Cek hasilnya
        // $this->load->model('User_model');
        // $post = $this->input->post();

        // if (!isset($post['email'])) {
        //     $this->load->view('forgotpass');
        // } else {
        //     $this->db->where('email', $post['email']);
        //     $result = $this->db->get('tbl_user');

        //     if ($result->num_rows()) {
        //         $id = $result->row()->id;
        //         $randnum = rand(1111111111, 9999999999);
        //         $hashPassword   = password_hash($randnum, PASSWORD_BCRYPT, array('cost' => 4));

        //         $this->User_model->update($id, array('password' => $hashPassword));
        //         $message = 'Password Baru ' . $randnum . ' Silahkan login ulang pada aplikasi Kehadiran TVRI';
        //         $this->sendEmail($post['email'], 'Reset Password APPS Kehadiran TVRI', $message);
        //     } else {
        //         $this->session->set_flashdata('notif', 'Email Yang anda masukkan tidak terdaftar');
        //         redirect('C_auth/forgotpass');
        //     }
        // }
    }


    //SEND EMAIL
    public function sendEmail($email, $subject, $message)
    {
        $this->load->library('mailer');

        $email_penerima = $email;
        $subjek         = $subject;
        $pesan             = $message;
        $content         = $this->load->view('template_email', array('pesan' => $pesan), true);
        $sendmail         = array(
            'email_penerima'    => $email_penerima,
            'subjek'            => $subjek,
            'content'            => $content
        );

        if (empty($attachment['name'])) {
            $send = $this->mailer->send($sendmail);
        }

        redirect('C_auth');
    }

    // public function send($email, $randomnumber)
    // {
    //     // $config = [
    //     //     'mailtype'  => 'html',
    //     //     'charset'   => 'utf-8',
    //     //     'protocol'  => 'smtp',
    //     //     'smtp_host' => 'smtp.gmail.com',
    //     //     'smtp_user' => 'sidasipuhokendari@gmail.com',  // Email gmail
    //     //     'smtp_pass'   => '0811404489TA',  // Password gmail
    //     //     'smtp_crypto' => 'ssl',
    //     //     'smtp_port'   => 465,
    //     //     'crlf'    => "\r\n",
    //     //     'newline' => "\r\n"
    //     // ];

    //     $config = array(
    //         'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    //         'smtp_host' => 'smtp.gmail.com',
    //         'smtp_port' => 587,
    //         'smtp_user' => 'tvri2022@gmail.com',
    //         'smtp_pass' => 'jouohcqddycvxmxl',
    //         // 'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    //         'mailtype' => 'html', //plaintext 'text' mails or 'html'
    //         'smtp_timeout' => '4', //in seconds
    //         'charset' => 'iso-8859-1',
    //         'wordwrap' => TRUE
    //     );

    //     $this->load->library('email', $config);

    //     $this->email->from('tvri2022@gmail.com', 'Kehadiran TVRI Password Reset');
    //     $this->email->to($email);
    //     $this->email->subject('Reset Password');
    //     $this->email->message('Password Anda : ' . $randomnumber);

    //     // if ($this->email->send()){
    //     //     return true;
    //     // } else {
    //     //     echo $this->email->print_debugger();
    //     //     die;
    //     // }

    //     if ($this->email->send()) {
    //         redirect('C_auth');
    //     } else {
    //         $this->session->set_flashdata('notif', 'Gagal Mengirim Pesan');
    //         redirect('C_auth/forgotpass');
    //     }
    // }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login', 'Anda sudah berhasil keluar dari aplikasi');
        redirect('C_auth');
    }
}
