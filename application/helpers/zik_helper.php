<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('dd')) {
    function dd($var)
    {
        // echo "<pre>";
        // print_r(json_encode($var, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        // echo "</pre>";
        // die;
        // echo "<pre>";
        print_r(json_output($var));
        // echo "</pre>";
        die;
    }
}
if (!function_exists('json_output')) {
    function json_output($data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}
if (!function_exists('back')) {
    function back(?callable $callback = null)
    {
        if ($callback) {
            $callback();
        }
        return redirect($_SERVER['HTTP_REFERER']);
    }
}

if (!function_exists('param_id')) {
    function param_id()
    {
        $ci = &get_instance();
        $segments = $ci->uri->segment_array();
        return end($segments);
    }
}

if (!function_exists('request')) {
    function request()
    {
        $z = &get_instance();
        $z->load->library('request');
        return $z->request;
    }
}

if (!function_exists('panah')) {
    function panah()
    {
        $z = &get_instance();
        return $z->db->get()->result();
    }
}

if (!function_exists('siku')) {
    function siku()
    {
        $z = &get_instance();
        return $z->db->get()->result_array();
    }
}

if (!function_exists('view')) {
    function view($view, $data = array(), $return = false)
    {
        $z = &get_instance();
        $view = str_replace('.', '/', $view);
        return $z->template->load('template', $view, $data, $return);
    }
}

if (!function_exists('zpost')) {
    function zpost($field = null)
    {
        $z = &get_instance();
        return $z->input->post($field);
    }
}

if (!function_exists('zvalidate')) {
    function zvalidate(...$field)
    {
        $z = &get_instance();
        return $z->form_validation->set_rules(...$field);
    }
}
if (!function_exists('zerror_arrray')) {
    function zerror_arrray()
    {
        $z = &get_instance();
        return $z->form_validation->error_array();
    }
}

if (!function_exists('zvalidate_run')) {
    function zvalidate_run()
    {
        $z = &get_instance();
        return $z->form_validation->run();
    }
}

if (!function_exists('zget')) {
    function zget($field)
    {
        $z = &get_instance();
        return $z->input->get($field);
    }
}

if (!function_exists('zurl')) {
    function zurl($url)
    {
        return base_url($url);
    }
}

if (!function_exists('auth')) {
    function auth(...$field)
    {
        $z = &get_instance();
        $userData = $z->session->userdata();
        if (!empty($field)) {
            $key = array_shift($field);
            if (isset($userData[$key])) {
                return $userData[$key];
            }
        }
        return $userData;
    }
}

if (!function_exists('zalert')) {
    /**
     * @see CI_Session::set_flashdata
     * Menyimpan message ke flashdata
     * @param mixed ...$response
     */
    function zalert($key, $value)
    {
        $CI = &get_instance();
        if (!isset($CI->session)) {
            $CI->load->library('session');
        }
        $CI->session->set_flashdata($key, $value);
    }
}

if (!function_exists('zflash')) {
    /**
     * @see CI_Session::flashdata
     * Mendapatkan/Menampilkan message
     * @param mixed ...$response
     */
    function zflash(...$response)
    {
        $z = &get_instance();
        return $z->session->flashdata(...$response);
    }
}

/**
 * Mengambil dan menyimpan error validasi dari session flashdata untuk request saat ini.
 * Ini adalah fungsi inti yang mencegah masalah flashdata yang hanya bisa dibaca sekali.
 * @return array
 */
function _get_validation_errors()
{
    // Variabel statis untuk menyimpan error setelah dibaca dari session
    static $errors = null;

    // Jika error belum diambil untuk request ini
    if ($errors === null) {
        $CI = &get_instance();
        // Pastikan library session sudah dimuat
        if (!isset($CI->session)) {
            $CI->load->library('session');
        }
        // Ambil dari flashdata dan simpan. Jika tidak ada, simpan array kosong.
        $errors = $CI->session->flashdata('errors') ?? [];
    }

    return $errors;
}

if (!function_exists('has_error')) {
    /**
     * Mengecek apakah sebuah field memiliki error validasi.
     * Berguna untuk menambahkan class CSS seperti 'is-invalid'.
     * @param string $field Nama field.
     * @return bool
     */
    function has_error($field)
    {
        $errors = _get_validation_errors();
        return isset($errors[$field]) && !empty($errors[$field]);
    }
}

if (!function_exists('validation_error')) {
    /**
     * Menampilkan pesan error pertama untuk satu field spesifik.
     * @param string $field Nama field.
     * @param string $before HTML pembuka.
     * @param string $after HTML penutup.
     * @return string
     */
    function validation_error($field, $before = '<div class="invalid-feedback d-block">', $after = '</div>')
    {
        $errors = _get_validation_errors();

        // Jika tidak ada error untuk field ini, kembalikan string kosong.
        if (!isset($errors[$field]) || empty($errors[$field])) {
            return '';
        }

        // Ambil pesan error pertama dari array
        $message = $errors[$field][0];

        return $before . $message . $after;
    }
}

if (!function_exists('validation_errors')) {
    /**
     * Menampilkan SEMUA pesan error validasi dalam sebuah daftar.
     * @param string $before HTML pembuka, contoh: <div class="alert alert-danger"><ul>
     * @param string $after HTML penutup, contoh: </ul></div>
     * @return string
     */
    function validation_errors($before = '<div class="alert alert-danger" role="alert"><ul>', $after = '</ul></div>')
    {
        $errors = _get_validation_errors();

        if (empty($errors)) {
            return '';
        }

        $output = '';
        // Ubah array error multidimensi menjadi satu daftar HTML
        foreach ($errors as $field_errors) {
            foreach ($field_errors as $error_message) {
                $output .= '<li>' . $error_message . '</li>';
            }
        }

        if (empty($output)) {
            return '';
        }

        return $before . $output . $after;
    }
}

if (!function_exists('Model')) {
    function Model($name)
    {
        $z = &get_instance();
        $z->load->model($name);
        return $z->$name;
    }
}

if (!function_exists('znow')) {
    function znow($field = 'Y-m-d H:i:s')
    {
        return date($field);
    }
}

if (!function_exists('flash_session')) {
    /**
     * Simpan data sementara ke session (flashdata) agar bisa dipakai sekali saja.
     *
     * @param string $key   Kunci flashdata (misal: 'error', 'success', 'info')
     * @param mixed  ...$data  Data bisa berupa string, array, atau beberapa parameter
     */
    function flash_session($key, ...$data)
    {
        $CI = &get_instance();

        // Kalau user kirim array langsung
        if (count($data) === 1 && is_array($data[0])) {
            $value = $data[0];
        }
        // Kalau user kirim banyak parameter
        elseif (count($data) > 1) {
            $value = $data;
        }
        // Kalau hanya string tunggal
        else {
            $value = $data[0] ?? null;
        }

        return $CI->session->set_flashdata($key, $value);
    }
}

if (!function_exists('zupload')) {
    /**
     * Upload file dengan validasi standar dan pesan error otomatis ke flashdata
     *
     * @param string $field_name  Nama field input (misal: 'ttd_pdf_file')
     * @param string $upload_path Path upload relatif dari FCPATH
     * @param string $allowed_types Tipe file yang diizinkan (default: pdf|jpg|jpeg|png)
     * @param int    $max_size  Maksimal ukuran file (KB)
     * @param bool   $required  Apakah file wajib ada
     *
     * @return array
     */
    function zupload($field_name, $upload_path, $allowed_types = 'pdf|jpg|jpeg|png', $max_size = 500, $required = true)
    {
        $CI = &get_instance();

        $config['upload_path']   = FCPATH . $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['encrypt_name']  = true;
        $config['remove_space']  = true;
        $config['max_size']      = $max_size;

        // Buat folder jika belum ada
        if (!is_dir($config['upload_path'])) {
            if (!mkdir($config['upload_path'], 0777, true)) {
                $msg = 'Gagal membuat folder upload: ' . $upload_path;
                flash_session('error', $msg);
                return ['error' => 'gagal_buat_folder', 'message' => $msg];
            }
        }

        // Cek kalau file wajib tapi kosong
        if ($required && empty($_FILES[$field_name]['name'])) {
            $msg = 'Silakan pilih file untuk diupload';
            flash_session('error', $msg);
            return ['error' => 'file_wajib', 'message' => $msg];
        }

        $CI->load->library('upload', $config);

        if (!$CI->upload->do_upload($field_name)) {
            $error = $CI->upload->display_errors('', '');

            $error_keys = [
                'The filetype you are attempting to upload is not allowed.'         => 'tipe_file_tidak_diizinkan',
                'The file you are attempting to upload is larger than the permitted size.' => 'file_terlalu_besar',
                'The file you are attempting to upload is not of a permitted type.' => 'tipe_file_tidak_diizinkan',
                'You did not select a file to upload.'                              => 'tidak_ada_file',
                'The upload destination folder does not appear to be writable.'     => 'folder_tidak_bisa_ditulis',
                'The file could not be written to disk.'                            => 'gagal_tulis_disk',
                'The file upload was stopped by extension.'                         => 'upload_dihentikan_ekstensi',
                'A PHP extension stopped the file upload.'                          => 'upload_dihentikan_php',
                'The upload path does not appear to be valid.'                      => 'folder_upload_tidak_valid',
            ];

            $error_key = isset($error_keys[$error]) ? $error_keys[$error] : 'error_tidak_diketahui';

            // Kasus khusus: file berekstensi .png tapi MIME sebenarnya image/jpeg
            $mime = mime_content_type($_FILES[$field_name]['tmp_name']);
            $ext  = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);

            if ($error_key === 'tipe_file_tidak_diizinkan' && strtolower($ext) === 'png' && $mime === 'image/jpeg') {
                $msg = 'File yang kamu upload berekstensi PNG, tetapi isinya sebenarnya JPEG. '
                    . 'Silakan simpan ulang file sebagai PNG asli atau gunakan ekstensi JPG/JPEG.';
                flash_session('error', $msg);
                return ['error' => 'file_format_salah', 'message' => $msg];
            }

            // Pesan default
            $msg = $error;
            flash_session('error', $msg);
            return ['error' => $error_key, 'message' => $msg];
        }

        // Jika berhasil
        return ['zupload' => $CI->upload->data()];
    }
}
if (!function_exists('zrupiah')) {
    function zrupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}

if (!function_exists('whereId')) {
    function whereId($table, $key, $val)
    {
        $z = &get_instance();
        return $z->db->get_where($table, [$key => $val])->row();
    }
}


if (!function_exists('zdate')) {
    function zdate($date, $format = 'Y-m-d')
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('zrandstr')) {
    function zrandstr($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

if (!function_exists('zarrfirst')) {
    /**
     * Mendapatkan nilai pertama dari array atau objek secara dinamis, mendukung kedalaman yang ditentukan
     *
     * @param array|object $data Data yang akan diakses
     * @param int $depth Kedalaman untuk mendapatkan nilai pertama
     * @return mixed|null Nilai pertama atau null jika data tidak valid
     */
    function zarrfirst($data, $depth = 1)
    {
        for ($i = 0; $i < $depth; $i++) {
            if (is_array($data)) {
                $data = reset($data);
            } elseif (is_object($data)) {
                $data = (array) $data;
                $data = reset($data);
            } else {
                return null;
            }
        }

        return $data;
    }
}

if (!function_exists('zarrfirst_key')) {
    /**
     * Mendapatkan kunci pertama dari array atau objek secara dinamis, mendukung kedalaman yang ditentukan
     *
     * @param array|object $data Data yang akan diakses
     * @param int $depth Kedalaman untuk mendapatkan kunci pertama
     * @return mixed|null Kunci pertama atau null jika data tidak valid
     */
    function zarrfirst_key($data, $depth = 1)
    {
        for ($i = 0; $i < $depth; $i++) {
            if (is_array($data)) {
                reset($data);
                $key = key($data);
                $data = $data[$key];
            } elseif (is_object($data)) {
                $data = (array) $data;
                reset($data);
                $key = key($data);
                $data = $data[$key];
            } else {
                return null;
            }
        }

        return isset($key) ? $key : null;
    }
}

if (!function_exists('logoUho')) {
    function logoUho()
    {
        return 'https://upload.wikimedia.org/wikipedia/id/thumb/0/04/Logo_Universitas_Halu_Oleo.png/200px-Logo_Universitas_Halu_Oleo.png';
    }
}

if (!function_exists('vpdf')) {
    function vpdf($html, $data = [], $return = false)
    {
        $z = &get_instance();
        return $z->load->view('pdf/' . $html, $data, true);
    }
}
if (!function_exists('zsession')) {
    function zsession($field = 'id')
    {
        $z = &get_instance();
        return $z->session->has_userdata($field);
    }
}
if (!function_exists('terbilang')) {
    function terbilang($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = terbilang($nilai / 10) . " puluh" . terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = terbilang($nilai / 100) . " ratus" . terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = terbilang($nilai / 1000) . " ribu" . terbilang($nilai % 1000);
        }
        return trim($temp);
    }
}


if (!function_exists('get_bulan_indo')) {
    function get_bulan_indo($angka_bulan)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        return $bulan[(int)$angka_bulan];
    }
}
