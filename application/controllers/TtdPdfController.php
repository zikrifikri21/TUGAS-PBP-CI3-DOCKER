<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TtdPdfController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function create_qr()
    {
        $data = TtdPdf::last();
        $data = $data->file ?? null;
        if ($data) {
            $data = base_url($data);
        } else {
            $data = "https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg";
        }
        return view('ttd_pdf.index', compact('data'));
    }

    public function store()
    {
        // dd(mime_content_type($_FILES['ttd_pdf_file']['tmp_name']));
        $resupload = zupload('ttd_pdf_file', 'assets/upload/ttd_pdf/', 'jpg|jpeg|png', 500, true);

        if (isset($resupload['error'])) {
            return redirect('ttd-pdf');
        }

        $filedata = $resupload['zupload'];
        $qr = new TtdPdf();
        $qr->insert([
            'file' => 'assets/upload/ttd_pdf/' . $filedata['file_name'],
        ]);

        flash_session('success', 'Berhasil diupload');
        return redirect('ttd-pdf');
    }

    public function verifikasi()
    {
        if (zsession('id')) {
            return view('ttd_pdf.verifikasi');
        } else {
            return $this->load->view('ttd_pdf/verifikasi');
        }
    }
}
