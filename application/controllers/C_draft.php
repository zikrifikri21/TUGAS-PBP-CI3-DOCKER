<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_draft extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Cek login
        cek_session();
        $this->load->model("m_default");
    }

    // public function index()
    // {
    // 	$this->template->load('template', 'front/dashboard');
    // }
    public function ba($id)
    {
        $option = array(
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id'),
            'where' => array('ujian.id' => $id),
            'single' => true
        );
        // $data['ujian'] = $this->m_default->fetch_data($option);
        $data['ujian'] = Ujian::table()
            ->where(['id' => $id])
            ->with('mahasiswa', 'penilaian', 'jurusan.ketua_jurusan', 'kajur', 'ketua', 'sekretaris', 'anggota_1', 'anggota_2', 'anggota_3', 'pembimbing_1', 'pembimbing_2', 'uji1', 'uji2', 'uji3')
            ->first();
        $data['title'] = 'Berita Acara';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));

        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $data = $this->load->view('draft/pdf_draft_ba', $data, true);

        $filename = "Berita Acara.pdf";

        $mpdf->WriteHTML($data);
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function st($id)
    {
        $option = array(
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id'),
            'where' => array('ujian.id' => $id),
            'single' => true
        );
        // $data['ujian'] = $this->m_default->fetch_data($option);
        $data['ujian'] = Ujian::table()
            ->where(['id' => $id])
            ->with('mahasiswa', 'penilaian', 'jurusan.ketua_jurusan', 'kajur', 'ketua', 'sekretaris', 'anggota_1', 'anggota_2', 'anggota_3', 'pembimbing_1', 'pembimbing_2', 'uji1', 'uji2', 'uji3')
            ->first();
        $data['title'] = 'Surat Tugas';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));

        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $data = $this->load->view('draft/pdf_draft_st', $data, true);

        $filename = "Surat Tugas.pdf";

        $mpdf->WriteHTML($data);
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function sp($id)
    {
        $option = array(
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id'),
            'where' => array('ujian.id' => $id),
            'single' => true
        );
        // $data['ujian'] = $this->m_default->fetch_data($option);
        $data['ujian'] = Ujian::table()->where(['id' => $id])
            ->with('mahasiswa', 'penilaian', 'jurusan.ketua_jurusan', 'kajur', 'jurusan.sekretaris_jurusan', 'pembimbing_1', 'pembimbing_2', 'uji1', 'uji2', 'uji3')->first();
        $data['title'] = 'Surat Penunjukkan Dosen Pembimbing';
        // $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));
        // dd($data['ujian']);
        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $data = $this->load->view('draft/pdf_draft_sp', $data, true);

        $filename = "Surat Penunjukkan Dosen Pembimbing.pdf";

        $mpdf->WriteHTML($data);
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function sk_dekan_konsideran_ujian($id)
    {
        $option = array(
            'select' => 'sk_dekan_ujian.*,ujian.jenis_ujian',
            'table' => 'sk_dekan_ujian',
            'join' => array('sk_dekan_ujian_has_ujian' => 'sk_dekan_ujian_has_ujian.sk_dekan_ujian_id = sk_dekan_ujian.id', 'ujian' => 'ujian.id = sk_dekan_ujian_has_ujian.ujian_id'),
            'where' => array('sk_dekan_ujian.id' => $id),
            'single' => true
        );
        $data['sk'] = $this->m_default->fetch_data($option);
        $data['title'] = 'Konsideran Ujian';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));

        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        // dd($data['dosen']);
        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $data = $this->load->view('draft/pdf_draft_konsideran_ujian', $data, true);

        $filename = "Konsideran Ujian.pdf";

        $mpdf->WriteHTML($data);
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function sk_dekan_lampiran_ujian($id)
    {
        $option = array(
            'select' => 'sk_dekan_ujian.*,ujian.judul,ujian.jenis_ujian,mahasiswa.nama_mahasiswa,mahasiswa.nim,jurusan.nama_jurusan, ujian.ketua, ujian.sekretaris, ujian.anggota_1, ujian.anggota_2, ujian.anggota_3',
            'table' => 'sk_dekan_ujian',
            'join' => array('sk_dekan_ujian_has_ujian' => 'sk_dekan_ujian_has_ujian.sk_dekan_ujian_id = sk_dekan_ujian.id', 'ujian' => 'ujian.id = sk_dekan_ujian_has_ujian.ujian_id', 'mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
            'where' => array('sk_dekan_ujian.id' => $id),
        );
        $sk = $this->m_default->fetch_data($option);
        $data['title'] = 'Lampiran Ujian';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));
        $skDekanUjian = SkDekanHasUjian::table()->with(
            'sk_dekan',
            'ujian.mahasiswa.jurusan',
            'ujian.kajur',
            'ujian.ketua',
            'ujian.sekretaris',
            'ujian.pembimbing_1',
            'ujian.pembimbing_2',
            'ujian.anggota_1',
            'ujian.anggota_2',
            'ujian.anggota_3'
        )->where(['sk_dekan_ujian_id' => $id])->get();
        // dd([$sk, $skDekanUjian]);


        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        // $mpdf = new \Mpdf\Mpdf(['format' => 'Legal-L']);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'orientation' => 'P']);

        foreach ($skDekanUjian as $i => $key) {
            $data['sk'] = $key;
            if ($i) { //If not the first payroll then add a new page
                $mpdf->AddPage();
            }
            $html = $this->load->view('draft/pdf_draft_lampiran_ujian', $data, true);

            $mpdf->WriteHTML($html);
        }

        $filename = "Lampiran Ujian.pdf";
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function sk_dekan_konsideran_dosen($id)
    {
        $option = array(
            'select' => 'sk_dekan_b.*,ujian.jenis_ujian',
            'table' => 'sk_dekan_b',
            'join' => array('ujian_has_sk_dekan_b' => 'ujian_has_sk_dekan_b.sk_dekan_b_id = sk_dekan_b.id', 'ujian' => 'ujian.id = ujian_has_sk_dekan_b.ujian_id'),
            'where' => array('sk_dekan_b.id' => $id),
            'single' => true
        );
        $data['sk'] = $this->m_default->fetch_data($option);
        $data['title'] = 'Konsideran Dosen';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));

        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
        $data = $this->load->view('draft/pdf_draft_konsideran_dosen', $data, true);

        $filename = "Konsideran Dosen.pdf";

        $mpdf->WriteHTML($data);
        $mpdf->Output(
            $filename,
            "I"
        );
    }

    public function sk_dekan_lampiran_dosen($id)
    {
        $option = array(
            'select' => 'sk_dekan_b.*,
            ujian.judul,ujian.jenis_ujian,ujian.pembimbing_1,ujian.pembimbing_2,ujian.ketua,ujian.sekretaris,ujian.anggota_1,ujian.anggota_2,ujian.anggota_3,
            mahasiswa.nama_mahasiswa,mahasiswa.nim,jurusan.nama_jurusan',
            'table' => 'sk_dekan_b',
            'join' => array('ujian_has_sk_dekan_b' => 'ujian_has_sk_dekan_b.sk_dekan_b_id = sk_dekan_b.id', 'ujian' => 'ujian.id = ujian_has_sk_dekan_b.ujian_id', 'mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
            'where' => array('sk_dekan_b.id' => $id),
        );
        $sk = $this->m_default->fetch_data($option);
        $data['title'] = 'Lampiran Dosen';
        $data['dosen'] = $this->m_default->fetch_data(array('table' => 'dosen'));
        $data['jurusan'] = $this->m_default->fetch_data(array('table' => 'jurusan'));



        // $mpdf = new \Mpdf\Mpdf(
        //   ['tempDir' => '/tmp']
        // );
        // $mpdf = new \Mpdf\Mpdf(['format' => 'Legal-L']);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4', 'orientation' => 'P']);

        foreach ($sk as $i => $key) {
            $data['sk'] = $key;
            if ($i) { //If not the first payroll then add a new page
                $mpdf->AddPage();
            }
            $html = $this->load->view('draft/pdf_draft_lampiran_dosen', $data, true);

            $mpdf->WriteHTML($html);
        }

        $filename = "Lampiran Dosen.pdf";
        $mpdf->Output(
            $filename,
            "I"
        );
    }
}
