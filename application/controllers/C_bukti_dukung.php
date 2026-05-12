<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_bukti_dukung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
        $this->load->library('upload');
    }

    public function id($id)
    {
        $data['setting'] = $this->db->get_where('tbl_setting', array('id_setting' => 1))->row_array();
        $option = array(
            'table' => 'bukti_dukung',
            'where' => array('ujian_id' => $id)
        );

        $data['bukti_dukung'] = $this->m_default->fetch_data($option);
        $this->template->load('template', 'bukti_dukung/list', $data);
    }

    public function create()
    {
        if (!empty($this->input->post('nama_lampiran'))) {
            $validated = request()->validate([
                'file'          => 'required_if:link_drive,null|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
                'nama_lampiran' => 'required',
                'link_drive'    => 'required_if:file,null',
            ], [
                'file.required_if'       => 'File Bukti Dukung atau Link Drive harus diisi.',
                'link_drive.required_if' => 'Link Drive atau File Bukti Dukung harus diisi.',
                'file.mimes'             => 'Format File Bukti Dukung Harus jpeg,png,jpg,pdf,doc,docx',
                'file.max'               => 'Ukuran File Bukti Dukung Maksimal 2MB',
                'nama_lampiran.required' => 'Nama Bukti Dukung Harus diisi',
            ]);

            if (!$validated->status) {
                zalert('errors', $validated->errors);
                return back();
            }

            if ($validated->file) {
                $parseNama = explode('.', $validated->file->getClientOriginalName());
                $parseNama = preg_replace('/[^a-zA-Z0-9]/', '_', $parseNama[0]);
                $name = $parseNama[0] . '-' . time() . '.' . $validated->file->getClientOriginalExtension();
                $name = $validated->file->storeAs('upload/bukti_dukung', $name);
            } else {
                $name = null;
            }

            $data = [
                'file'          => $name,
                'link_drive'    => $validated->link_drive ? $validated->link_drive : null,
                'nama_lampiran' => $validated->nama_lampiran,
                'ujian_id'      => $validated->ujian_id,
            ];

            $this->m_default->input('bukti_dukung', $data);
            redirect('c_bukti_dukung/id/' . $this->input->post('ujian_id'));
        } else {
            $data = array(
                'action'           => site_url('C_bukti_dukung/create'),
                'id'           => set_value('id'),
                'nama_lampiran'  => set_value('nama_lampiran'),
                'file'  => set_value('file'),
            );
            $this->template->load('template', 'bukti_dukung/form', $data);
        }
    }

    public function update($id = null)
    {
        $id = $this->uri->segment(4);
        $postId = $this->input->post('id');
        if (!empty($this->input->post('nama_lampiran'))) {
            $options = [
                'table' => 'bukti_dukung',
                'where' => ['id' => $postId],
                'single' => true
            ];
            $buktiDukung = $this->m_default->fetch_data($options);
            // dd([$buktiDukung, $buktiDukung->id]);
            if (!$buktiDukung->file && $this->input->post('file')) {
                $validated = request()->validate([
                    'file'          => 'required_if:link_drive,null|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
                    'nama_lampiran' => 'required',
                    'link_drive'    => 'required_if:file,null',
                ], [
                    'file.required_if'       => 'File Bukti Dukung atau Link Drive harus diisi.',
                    'link_drive.required_if' => 'Link Drive atau File Bukti Dukung harus diisi.',
                    'file.mimes'             => 'Format File Bukti Dukung Harus jpeg,png,jpg,pdf,doc,docx',
                    'file.max'               => 'Ukuran File Bukti Dukung Maksimal 2MB',
                    'nama_lampiran.required' => 'Nama Bukti Dukung Harus diisi',
                ]);
                if (!$validated->status) {
                    zalert('errors', $validated->errors);
                    return back();
                }

                if ($validated->file) {
                    $parseNama = explode('.', $validated->file->getClientOriginalName());
                    $parseNama = preg_replace('/[^a-zA-Z0-9]/', '_', $parseNama[0]);
                    $name = $parseNama[0] . '-' . time() . '.' . $validated->file->getClientOriginalExtension();
                    $name = $validated->file->storeAs('upload/bukti_dukung', $name);
                } else {
                    $name = null;
                }

                $data = [
                    'file'          => $name,
                    'link_drive'    => $validated->link_drive ? $validated->link_drive : null,
                    'nama_lampiran' => $validated->nama_lampiran,
                    'ujian_id'      => $validated->ujian_id,
                    'id'            => $validated->id
                ];
            } else {
                if (request()->file) {
                    $parseNama = explode('.', request()->file->getClientOriginalName());
                    $parseNama = preg_replace('/[^a-zA-Z0-9]/', '_', $parseNama[0]);
                    $name = $parseNama[0] . '-' . time() . '.' . request()->file->getClientOriginalExtension();
                    $name = request()->file->storeAs('upload/bukti_dukung', $name);
                } else {
                    $name = $buktiDukung->file;
                }

                $data = [
                    'file'          => $name,
                    'link_drive'    => zpost('link_drive') ? zpost('link_drive') : $buktiDukung->link_drive,
                    'nama_lampiran' => zpost('nama_lampiran') ? zpost('nama_lampiran') : $buktiDukung->nama_lampiran,
                    'ujian_id'      => $buktiDukung->ujian_id,
                    'id'            => $buktiDukung->id
                ];
            }

            $this->m_default->edit('bukti_dukung', $data, array('id' => $data['id']));

            $this->session->set_flashdata('edit', 'Berhasil Update Bukti Dukung ' . $data['nama_lampiran']);
            redirect('c_bukti_dukung/id/' . $this->input->post('ujian_id'));
        } else {
            $option = array(
                'table' => 'bukti_dukung',
                'where' => array('id' => $id),
                'single' => true,
            );
            $get    = $this->m_default->fetch_data($option);
            $data = array(
                'action'           => site_url('C_bukti_dukung/update'),
                'id'               => set_value('id', $get->id),
                'nama_lampiran'    => set_value('nama_lampiran', $get->nama_lampiran),
                'file'             => set_value('file', $get->file),
                'link_drive'       => set_value('link_drive', $get->link_drive),
            );
            $this->template->load('template', 'bukti_dukung/form', $data);
        }
    }

    public function delete()
    {
        $this->m_default->delete('bukti_dukung', array('id' => $this->input->post('id')));
        $this->session->set_flashdata('delete', 'Bukti Dukung ' . $this->input->post('nama_lampiran') . " telah dihapus !");

        redirect('c_bukti_dukung/id/' . $this->input->post('ujian_id'));
    }
}

/* End of file C_bukti_dukung.php */
/* Location: ./application/controllers/C_bukti_dukung.php */
