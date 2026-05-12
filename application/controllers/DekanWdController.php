<?php

defined('BASEPATH') or exit('No direct script access allowed');


class DekanWdController extends CI_Controller
{
    public function index()
    {
        return view('dekan.index');
    }

    public function verifikasi()
    {
        $id = zpost('id');
        $dosen = DosenFhil::table()->where(['tbl_user_id' => auth('id')])->first();

        $aaa = Ujian::table();
        $aaa->update(
            $id,
            ['status_putusan' => 'verifikasi', 'kajur_id' => $dosen->id],
        );

        return redirect($_SERVER['HTTP_REFERER']);
    }
}
