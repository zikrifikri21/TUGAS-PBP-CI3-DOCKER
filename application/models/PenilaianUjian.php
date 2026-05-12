<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PenilaianUjian extends ZModel
{
    protected $_table = 'nilai_has_ujian';
    protected $_primary_key = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function dosen($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'penilai_id', 'id', $res);
    }
}
