<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class ZQrcode
{
    /**
     * @var $logo = 'assets/img/uho.png'
     * @var $data = 'Data QR', $qr_path, 'H', 10, 2, 'qr_' . time() . '.png'
     * @return void
     */
    public static function init()
    {
        static $loaded = false;
        if (!$loaded) {
            require_once APPPATH . 'libraries/qrcode/qrlib.php';
            $loaded = true;
        }
    }

    public static function get($logo, $data_qr, $level = 'H', $size = 10, $margin = 2, $filename = null)
    {
        self::init();

        $folder = FCPATH . 'assets/temp/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if ($filename === null) {
            $filename = 'qr_' . time();
        }
        $qr_path = $folder . $filename . '.png';

        if ($level == 'H') {
            QRcode::png($data_qr, $qr_path, QR_ECLEVEL_H, $size, $margin);
        } else if ($level == 'L') {
            QRcode::png($data_qr, $qr_path, QR_ECLEVEL_L, $size, $margin);
        } else if ($level == 'M') {
            QRcode::png($data_qr, $qr_path, QR_ECLEVEL_M, $size, $margin);
        } else if ($level == 'Q') {
            QRcode::png($data_qr, $qr_path, QR_ECLEVEL_Q, $size, $margin);
        }

        // load QR dan logo
        $qr_image = imagecreatefrompng($qr_path);
        $logo = imagecreatefrompng(FCPATH . $logo);

        // hitung ukuran
        $qr_width  = imagesx($qr_image);
        $qr_height = imagesy($qr_image);
        $logo_width  = imagesx($logo);
        $logo_height = imagesy($logo);

        // resize logo jadi 20% dari QR
        $new_logo_width  = $qr_width / 5;
        $new_logo_height = ($logo_height / $logo_width) * $new_logo_width;

        $logo_resized = imagecreatetruecolor($new_logo_width, $new_logo_height);
        imagealphablending($logo_resized, false);
        imagesavealpha($logo_resized, true);
        imagecopyresampled(
            $logo_resized,
            $logo,
            0,
            0,
            0,
            0,
            $new_logo_width,
            $new_logo_height,
            $logo_width,
            $logo_height
        );

        // posisi tengah
        $x = ($qr_width - $new_logo_width) / 2;
        $y = ($qr_height - $new_logo_height) / 2;

        // gabungkan
        imagecopy($qr_image, $logo_resized, $x, $y, 0, 0, $new_logo_width, $new_logo_height);

        // simpan hasil akhir
        $final_path = $qr_path;
        imagepng($qr_image, $final_path);

        // tampilkan di HTML / mPDF
        $base64 = base64_encode(file_get_contents($final_path));
        return '<img src="data:image/png;base64,' . $base64 . '" />';

        unlink($final_path);
    }
}
