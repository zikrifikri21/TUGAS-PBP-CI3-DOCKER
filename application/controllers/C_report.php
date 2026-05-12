<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_default');
        $this->load->library('upload');
        $this->load->library('excel');
        $this->load->library('Ciqrcode');
        cek_session();
    }

    public function index()
    {


        $this->template->load('template', 'report/form_report', '');
    }


    function report_excel()
    {
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal file excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => false), // Set font nya jadi bold
            // 'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF33')
            )
        );

        $style_col_2 = array(
            'font' => array('bold' => false), // Set font nya jadi bold
            // 'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99CCFF')
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER  // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $report = [];

        $mulai = $this->input->post('mulai');
        $selesai = $this->input->post('selesai');
        $jenis_ujian = $this->input->post('jenis_ujian');
        $jurusan_id = $this->session->userdata('jurusan_id');


        $option = array(
            'select' => 'ujian.*,mahasiswa.nama_mahasiswa,mahasiswa.nim, mahasiswa.jurusan_id, jurusan.nama_jurusan',
            'table' => 'ujian',
            'join' => array('mahasiswa' => 'ujian.mahasiswa_id = mahasiswa.id', 'jurusan' => 'mahasiswa.jurusan_id = jurusan.id'),
            'order' => array('ujian.id' => 'desc'),
        );
        if ($this->session->userdata('tbl_user_level_id') == 2) {
            if (!empty($jenis_ujian))
                $option['where'] = "mahasiswa.jurusan_id ='$jurusan_id' AND ujian.akhiri_ujian='1' and ujian.jenis_ujian='$jenis_ujian' and DATE_FORMAT(ujian.hari_ujian, '%Y-%m-%d') BETWEEN '$mulai' AND '$selesai' ";
            else
                $option['where'] = "mahasiswa.jurusan_id ='$jurusan_id' AND ujian.akhiri_ujian='1' and DATE_FORMAT(ujian.hari_ujian, '%Y-%m-%d') BETWEEN '$mulai' AND '$selesai' ";
        } else {
            if (!empty($jenis_ujian))
                $option['where'] = "ujian.jenis_ujian='$jenis_ujian' AND ujian.akhiri_ujian='1' and DATE_FORMAT(ujian.hari_ujian, '%Y-%m-%d') BETWEEN '$mulai' AND '$selesai' ";
            else
                $option['where'] = "DATE_FORMAT(ujian.hari_ujian, '%Y-%m-%d') BETWEEN '$mulai' AND '$selesai' AND ujian.akhiri_ujian='1' ";
        }

        $report = $this->m_default->fetch_data($option);
        dd($report);

        if ($report) {
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT UJIAN " . 'TANGGAL ' . strtoupper(indonesiaDate($mulai)) . ' SAMPAI ' . strtoupper(indonesiaDate($selesai)));
            $excel->getActiveSheet()->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NIM");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Judul Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Pembimbing 1");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Pembimbing 2");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "Penguji 1");
            $excel->setActiveSheetIndex(0)->setCellValue('H3', "Penguji 2");
            $excel->setActiveSheetIndex(0)->setCellValue('I3', "Penguji 3");
            $excel->setActiveSheetIndex(0)->setCellValue('J3', "Jenis Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('K3', "Tanggal Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('L3', "Jurusan");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);


            // Set height baris ke 1, 2 dan 3
            // $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            // $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            // $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
            // $excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
            // $excel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            foreach ($report as $row) {
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $row->nama_mahasiswa);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $row->nim);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $row->judul);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $this->m_default->fetch_data(array('table' => 'dosen', 'where' => "id='$row->pembimbing_1'", 'single' => true))->nama_dosen);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $this->m_default->fetch_data(array('table' => 'dosen', 'where' => "id='$row->pembimbing_2'", 'single' => true))->nama_dosen);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $this->m_default->fetch_data(array('table' => 'dosen', 'where' => "id='$row->uji1'", 'single' => true))->nama_dosen);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $this->m_default->fetch_data(array('table' => 'dosen', 'where' => "id='$row->uji2'", 'single' => true))->nama_dosen);
                $excel->getActiveSheet()->getStyle('H' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $this->m_default->fetch_data(array('table' => 'dosen', 'where' => "id='$row->uji3'", 'single' => true))->nama_dosen);
                $excel->getActiveSheet()->getStyle('I' . $numrow)->getAlignment()->setWrapText(true);

                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, indonesiaDate($row->hari_ujian));
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $row->jenis_ujian);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $row->nama_jurusan);

                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);

                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(40);
                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT UJIAN " . strtoupper($jenis_ujian) . ' TANGGAL ' . indonesiaDate($mulai) . ' SAMPAI ' . indonesiaDate($selesai));
            $excel->getActiveSheet()->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai F1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA Mahasiswa");
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NIM");
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "Judul Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "Pembimbing 1");
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "Pembimbing 2");
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "Penguji 1");
            $excel->setActiveSheetIndex(0)->setCellValue('H3', "Penguji 2");
            $excel->setActiveSheetIndex(0)->setCellValue('I3', "Penguji 3");
            $excel->setActiveSheetIndex(0)->setCellValue('J3', "Jenis Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('K3', "Tanggal Ujian");
            $excel->setActiveSheetIndex(0)->setCellValue('L3', "Jurusan");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(17); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(25); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25); // Set width kolom F

        // Set orientasi kertas jadi LANDSCAPE
        // $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Report Ujian");
        $excel->setActiveSheetIndex(0);

        // ob_end_clean();

        $filename = "Report Ujian.xls";

        $object_writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $object_writer->save('php://output');
    }
}
