<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_sk_dekan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
        $this->load->library('upload');
    }

    public function ujian()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();

        $option = array(
            'select' => 'sk_dekan_ujian.*,ujian.jenis_ujian',
            'table' => 'sk_dekan_ujian',
            'join' => array('sk_dekan_ujian_has_ujian' => 'sk_dekan_ujian_has_ujian.sk_dekan_ujian_id = sk_dekan_ujian.id', 'ujian' => 'ujian.id = sk_dekan_ujian_has_ujian.ujian_id'),
            'group' => 'sk_dekan_ujian.id',
            'order' => array('sk_dekan_ujian.id' => 'desc')
        );

        $data['sk_dekan'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'sk_dekan/ujian', $data);
    }

    public function create_ujian()
    {
        if (!empty($this->input->post('no_sk'))) {

            $option = array(
                'table' => 'sk_dekan_ujian',
                'where' => array('no_sk' => $this->input->post('no_sk')),
            );
            $check_double = $this->m_default->fetch_data($option);
            if ($check_double) {
                $this->session->set_flashdata('delete', 'Gagal Menambahkan Data, SK Dekan Nomor ' . ucwords($this->input->post('no_sk')) . ' Sudah Pernah Ditambahkan');
                redirect('C_sk_dekan/ujian');
            }

            $data['no_sk']  = $this->input->post('no_sk');
            $data['plh_plt']  = $this->input->post('plh_plt');
            // $data['sk_ujian_ttd']  = $this->input->post('sk_ujian_ttd');
            $data['tgl_sk']  = $this->input->post('tgl_sk');
            $data['created']  = date('Y-m-d H:i:s');
            $id = $this->m_default->input('sk_dekan_ujian', $data);

            for ($i = 0; $i < count($this->input->post('ujian_id')); $i++) {
                $datab['sk_dekan_ujian_id']  = $id;
                $datab['ujian_id']  = $this->input->post('ujian_id')[$i];
                $this->m_default->input('sk_dekan_ujian_has_ujian', $datab);
            }

            $this->session->set_flashdata('input', 'Berhasil Tambah SK Dekan Dengan Nomor ' . $data['no_sk']);
            redirect('C_sk_dekan/ujian');
        } else {
            $data = array(
                'action'           => site_url('C_sk_dekan/create_ujian'),
                'id'           => set_value('id'),
                'no_sk'  => set_value('no_sk'),
                'tgl_sk'  => set_value('tgl_sk'),
                'ujian_id'  => set_value('ujian_id'),
                // 'sk_ujian_ttd'  => set_value('sk_ujian_ttd'),
                'plh_plt'  => set_value('plh_plt'),
            );

            $option = array(
                'table' => 'dosen',
                'where' => "status='aktif' and (jabatan_akademik='Wakil Dekan I' or jabatan_akademik='Wakil Dekan II' or jabatan_akademik='Wakil Dekan III')"
            );
            $data['dosen'] = $this->m_default->fetch_data($option);

            $option = array(
                'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                'table' => 'ujian',
                'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                'where' => array('ujian.jenis_ujian' => $this->input->get('jenis_ujian')),
                'where' => array('ujian.status_putusan' => 'verifikasi'),
                'where' => array('ujian.akhiri_ujian' => 1),
                'where' => array('ujian.jenis_ujian' => zget('jenis_ujian')),
                'order' => array('ujian.id' => 'desc'),
            );
            $ujian = $this->m_default->fetch_data($option);
            $data['ujian'] = [];
            foreach ($ujian as $key) {
                $option = array(
                    'table' => 'sk_dekan_ujian_has_ujian',
                    'where' => array('ujian_id' => $key->id),
                );
                $check_double = $this->m_default->fetch_data($option);
                if (!$check_double)
                    $data['ujian'][] = $key;
            }

            $this->template->load('template', 'sk_dekan/form_ujian', $data);
        }
    }

    public function update_ujian($id = null)
    {
        if (!empty($this->input->post('no_sk'))) {
            $data['id']  = $this->input->post('id');
            $data['no_sk']  = $this->input->post('no_sk');
            $data['tgl_sk']  = $this->input->post('tgl_sk');
            // $data['sk_ujian_ttd']  = $this->input->post('sk_ujian_ttd');
            $data['created']  = date('Y-m-d H:i:s');
            $data['status_putusan']  = null;
            $data['plh_plt']  = $this->input->post('plh_plt');
            $this->m_default->edit('sk_dekan_ujian', $data, array('id' => $data['id']));

            $this->m_default->delete('sk_dekan_ujian_has_ujian', array('sk_dekan_ujian_id' => $this->input->post('id')));
            for ($i = 0; $i < count($this->input->post('ujian_id')); $i++) {
                $datab['sk_dekan_ujian_id']  = $data['id'];
                $datab['ujian_id']  = $this->input->post('ujian_id')[$i];
                $this->m_default->input('sk_dekan_ujian_has_ujian', $datab);
            }

            $this->session->set_flashdata('edit', 'Berhasil Edit SK Dekan Dengan Nomor ' . $data['no_sk']);
            redirect('C_sk_dekan/ujian');
        } else {
            $option = array(
                'table' => 'sk_dekan_ujian',
                'where' => array('id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('C_sk_dekan/update_ujian'),
                'id'           => set_value('id', $get->id),
                'no_sk'  => set_value('no_sk', $get->no_sk),
                'tgl_sk'  => set_value('tgl_sk', $get->tgl_sk),
                // 'sk_ujian_ttd'  => set_value('sk_ujian_ttd', $get->sk_ujian_ttd),
                'plh_plt'  => set_value('plh_plt', $get->plh_plt),
            );


            $option = array(
                'select' => 'ujian_id',
                'table' => 'sk_dekan_ujian_has_ujian',
                'where' => array('sk_dekan_ujian_id' => $id)
            );
            $data['ujian_id'] = (array) $this->m_default->fetch_data($option);

            $option = array(
                'table' => 'dosen',
                'where' => "status='aktif' and (jabatan_akademik='Wakil Dekan I' or jabatan_akademik='Wakil Dekan II' or jabatan_akademik='Wakil Dekan III')"
            );
            $data['dosen'] = $this->m_default->fetch_data($option);
            // printr($data['ujian_id']);
            // die;

            $option = array(
                'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                'table' => 'ujian',
                'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                'where' => array('ujian.jenis_ujian' => $this->input->get('jenis_ujian')),
                'where' => array('ujian.status_putusan' => 'verifikasi'),
                'where' => array('ujian.akhiri_ujian' => 1),
                'where' => array('ujian.jenis_ujian' => zget('jenis_ujian')),
                'order' => array('ujian.id' => 'desc'),
            );
            // $data['ujian'] = $this->m_default->fetch_data($option);

            $ujian = $this->m_default->fetch_data($option);
            $data['ujian'] = [];
            foreach ($ujian as $key) {
                if (in_array($key->id, array_column($data['ujian_id'], 'ujian_id'))) {
                    $data['ujian'][] = $key;
                } else {
                    $option = array(
                        'table' => 'sk_dekan_ujian_has_ujian',
                        'where' => array('ujian_id' => $key->id),
                    );
                    $check_double = $this->m_default->fetch_data($option);
                    if (!$check_double)
                        $data['ujian'][] = $key;
                }
            }

            $this->template->load('template', 'sk_dekan/form_ujian', $data);
        }
    }

    public function delete_ujian()
    {
        $this->m_default->delete('sk_dekan_ujian_has_ujian', array('sk_dekan_ujian_id' => $this->input->post('id')));
        $this->m_default->delete('sk_dekan_ujian', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'SK Dekan dengan nomor : ' . $this->input->post('no_sk') . " telah dihapus !");

        redirect('C_sk_dekan/ujian');
    }

    public function upload_file_ujian()
    {
        // $upload_var = '';
        // if (!empty($_FILES['upload_konsideran']['name'])) {
        //     $upload_var = 'upload_konsideran';
        // }
        // if (!empty($_FILES['upload_lampiran']['name'])) {
        //     $upload_var = 'upload_lampiran';
        // }

        // if (!empty($_FILES[$upload_var]['name'])) {
        //     $config['upload_path']   = '/upload/sk/';
        //     $config['allowed_types'] = 'pdf';
        //     $config['file_name']     = $this->input->post($upload_var) . '-' . date('YmdHis') . "-" . rand(1000, 9999);
        //     $this->upload->initialize($config);
        //     $this->upload->do_upload($upload_var);

        //     $data[$upload_var]  = $this->upload->data('file_name');
        // }
        $data = ['status_putusan' => "v1"];

        $this->m_default->edit('sk_dekan_ujian', $data, array('id' => $this->input->post('id')));
        $this->session->set_flashdata('input', 'Berhasil Update Berkas');
        redirect('C_sk_dekan/ujian');
    }

    // Dosen
    public function dosen()
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();

        $option = array(
            'select' => 'sk_dekan_b.*,ujian.jenis_ujian',
            'table' => 'sk_dekan_b',
            'join' => array('ujian_has_sk_dekan_b' => 'ujian_has_sk_dekan_b.sk_dekan_b_id = sk_dekan_b.id', 'ujian' => 'ujian.id = ujian_has_sk_dekan_b.ujian_id'),
            'group' => 'sk_dekan_b.id',
            'order' => array('sk_dekan_b.id' => 'desc')
        );

        if (auth('tbl_user_level_id') == "8") {
            $option['where'] = ['sk_dekan_b.status_putusan' => 'v2'];
        } elseif (auth('tbl_user_level_id') == "4") {
            $option['where'] = ['sk_dekan_b.status_putusan' => 'v1'];
        }

        $data['sk_dekan'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'sk_dekan/dosen', $data);
    }

    public function create_dosen()
    {
        if (!empty($this->input->post('no_sk'))) {

            $option = array(
                'table' => 'sk_dekan_b',
                'where' => array('no_sk' => $this->input->post('no_sk')),
            );
            $check_double = $this->m_default->fetch_data($option);
            if ($check_double) {
                $this->session->set_flashdata('delete', 'Gagal Menambahkan Data, SK Dekan Nomor ' . ucwords($this->input->post('no_sk')) . ' Sudah Pernah Ditambahkan');
                redirect('C_sk_dekan/ujian');
            }

            $data['plh_plt']  = $this->input->post('plh_plt');
            $data['no_sk']  = $this->input->post('no_sk');
            // $data['sk_ujian_ttd']  = $this->input->post('sk_ujian_ttd');
            $data['tgl_sk']  = $this->input->post('tgl_sk');
            $data['created']  = date('Y-m-d H:i:s');
            $id = $this->m_default->input('sk_dekan_b', $data);

            for ($i = 0; $i < count($this->input->post('ujian_id')); $i++) {
                $datab['sk_dekan_b_id']  = $id;
                $datab['ujian_id']  = $this->input->post('ujian_id')[$i];
                $this->m_default->input('ujian_has_sk_dekan_b', $datab);
            }

            $this->session->set_flashdata('input', 'Berhasil Tambah SK Dekan Dengan Nomor ' . $data['no_sk']);
            redirect('C_sk_dekan/dosen');
        } else {
            $data = array(
                'action'           => site_url('C_sk_dekan/create_dosen'),
                'id'           => set_value('id'),
                'no_sk'  => set_value('no_sk'),
                'tgl_sk'  => set_value('tgl_sk'),
                'ujian_id'  => set_value('ujian_id'),
                // 'sk_ujian_ttd'  => set_value('sk_ujian_ttd'),
                'plh_plt'  => set_value('plh_plt'),
            );

            $option = array(
                'table' => 'dosen',
                'where' => "status='aktif' and (jabatan_akademik='Wakil Dekan I' or jabatan_akademik='Wakil Dekan II' or jabatan_akademik='Wakil Dekan III')"
            );
            $data['dosen'] = $this->m_default->fetch_data($option);

            $option = array(
                'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                'table' => 'ujian',
                'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                'where' => array('ujian.jenis_ujian' => $this->input->get('jenis_ujian')),
                'where' => array('ujian.status_putusan' => 'verifikasi'),
                'where' => array('ujian.akhiri_ujian' => 1),
                'where' => array('ujian.jenis_ujian' => zget('jenis_ujian')),
                'order' => array('ujian.id' => 'desc'),
            );
            // $data['ujian'] = $this->m_default->fetch_data($option);

            $ujian = $this->m_default->fetch_data($option);
            $data['ujian'] = [];
            foreach ($ujian as $key) {
                $option = array(
                    'table' => 'ujian_has_sk_dekan_b',
                    'where' => array('ujian_id' => $key->id),
                );
                $check_double = $this->m_default->fetch_data($option);
                if (!$check_double)
                    $data['ujian'][] = $key;
            }

            $this->template->load('template', 'sk_dekan/form_dosen', $data);
        }
    }

    public function update_dosen($id = null)
    {
        if (!empty($this->input->post('no_sk'))) {
            $data['id']  = $this->input->post('id');
            $data['no_sk']  = $this->input->post('no_sk');
            $data['tgl_sk']  = $this->input->post('tgl_sk');
            // $data['sk_ujian_ttd']  = $this->input->post('sk_ujian_ttd');
            $data['plh_plt']  = $this->input->post('plh_plt');
            $data['created']  = date('Y-m-d H:i:s');
            $this->m_default->edit('sk_dekan_b', $data, array('id' => $data['id']));

            $this->m_default->delete('ujian_has_sk_dekan_b', array('sk_dekan_b_id' => $this->input->post('id')));
            for ($i = 0; $i < count($this->input->post('ujian_id')); $i++) {
                $datab['sk_dekan_b_id']  = $data['id'];
                $datab['ujian_id']  = $this->input->post('ujian_id')[$i];
                $this->m_default->input('ujian_has_sk_dekan_b', $datab);
            }

            $this->session->set_flashdata('edit', 'Berhasil Edit SK Dekan Dengan Nomor ' . $data['no_sk']);
            redirect('C_sk_dekan/dosen');
        } else {
            $option = array(
                'table' => 'sk_dekan_b',
                'where' => array('id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);

            $data = array(
                'action'           => site_url('C_sk_dekan/update_dosen'),
                'id'           => set_value('id', $get->id),
                'no_sk'  => set_value('no_sk', $get->no_sk),
                'tgl_sk'  => set_value('tgl_sk', $get->tgl_sk),
                // 'sk_ujian_ttd'  => set_value('sk_ujian_ttd', $get->sk_ujian_ttd),
                'plh_plt'  => set_value('plh_plt', $get->plh_plt),
            );


            $option = array(
                'select' => 'ujian_id',
                'table' => 'ujian_has_sk_dekan_b',
                'where' => array('sk_dekan_b_id' => $id)
            );
            $data['ujian_id'] = (array) $this->m_default->fetch_data($option);

            $option = array(
                'table' => 'dosen',
                'where' => "status='aktif' and (jabatan_akademik='Wakil Dekan I' or jabatan_akademik='Wakil Dekan II' or jabatan_akademik='Wakil Dekan III')"
            );
            $data['dosen'] = $this->m_default->fetch_data($option);
            // printr($data['ujian_id']);
            // die;

            $option = array(
                'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, jurusan.nama_jurusan',
                'table' => 'ujian',
                'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
                'where' => array('ujian.jenis_ujian' => $this->input->get('jenis_ujian')),
                'where' => array('ujian.status_putusan' => 'verifikasi'),
                'where' => array('ujian.akhiri_ujian' => 1),
                'where' => array('ujian.jenis_ujian' => zget('jenis_ujian')),
                'order' => array('ujian.id' => 'desc'),
            );
            // $data['ujian'] = $this->m_default->fetch_data($option);

            $ujian = $this->m_default->fetch_data($option);
            $data['ujian'] = [];
            foreach ($ujian as $key) {
                if (in_array($key->id, array_column($data['ujian_id'], 'ujian_id'))) {
                    $data['ujian'][] = $key;
                } else {
                    $option = array(
                        'table' => 'ujian_has_sk_dekan_b',
                        'where' => array('ujian_id' => $key->id),
                    );
                    $check_double = $this->m_default->fetch_data($option);
                    if (!$check_double)
                        $data['ujian'][] = $key;
                }
            }
            $this->template->load('template', 'sk_dekan/form_dosen', $data);
        }
    }

    public function delete_dosen()
    {
        $this->m_default->delete('ujian_has_sk_dekan_b', array('sk_dekan_b_id' => $this->input->post('id')));
        $this->m_default->delete('sk_dekan_b', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'SK Dekan dengan nomor : ' . $this->input->post('no_sk') . " telah dihapus !");

        redirect('C_sk_dekan/dosen');
    }

    public function upload_file_dosen()
    {
        // $upload_var = '';
        // if (!empty($_FILES['upload_konsideran']['name'])) {
        //     $upload_var = 'upload_konsideran';
        // }
        // if (!empty($_FILES['upload_lampiran']['name'])) {
        //     $upload_var = 'upload_lampiran';
        // }

        // if (!empty($_FILES[$upload_var]['name'])) {
        //     $config['upload_path']   = '/upload/sk/';
        //     $config['allowed_types'] = 'pdf';
        //     $config['file_name']     = $this->input->post($upload_var) . '-' . date('YmdHis') . "-" . rand(1000, 9999);
        //     $this->upload->initialize($config);
        //     $this->upload->do_upload($upload_var);

        //     $data[$upload_var]  = $this->upload->data('file_name');
        // }
        $dosen = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();
        if (auth('tbl_user_level_id') == '8' || auth('tbl_user_level_id') == '4') {
            $data = [
                'status_putusan' => zpost('status_putusan'),
                'catatan'        => zpost('catatan') ?? null,
            ];
            if (auth('tbl_user_level_id') == '8') {
                $data['ttd_dekan'] = (int) $dosen->id;
            } else {
                $data['ttd_wd1']   = (int) $dosen->id;
            }
        } else {
            $data = [
                'status_putusan' => 'v1',
            ];
        }

        $this->m_default->edit('sk_dekan_b', $data, array('id' => $this->input->post('id')));
        $this->session->set_flashdata('input', 'Berhasil Update Berkas');
        redirect('C_sk_dekan/dosen');
    }
}

/* End of file C_ujian.php */
/* Location: ./application/controllers/C_ujian.php */
