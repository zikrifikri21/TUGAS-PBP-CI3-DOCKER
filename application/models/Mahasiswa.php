<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Mahasiswa extends ZModel
{
    protected $_table = 'mahasiswa';
    public function __construct()
    {
        parent::__construct();
    }

    public function ujian($res = null)
    {
        return $this->hasMany(Ujian::class, 'mahasiswa_id', 'id', $res);
    }

    public function jurusan($res = null)
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id', $res);
    }
}
