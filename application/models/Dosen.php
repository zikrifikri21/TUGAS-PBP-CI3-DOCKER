<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Dosen extends ZModel
{
    protected $_table = 'tbl_user';
    public function __construct()
    {
        parent::__construct();
    }

    public function jurusan($res)
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id', $res);
    }
}
