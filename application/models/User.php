<?php

defined('BASEPATH') or exit('No direct script access allowed');
class User extends ZModel
{
    protected $_table = 'tbl_user';
    public function __construct()
    {
        parent::__construct();
    }

    public function jurusan($res = null)
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id', $res);
    }

    public function dosen($res = null)
    {
        return $this->hasOne(DosenFhil::class, 'tbl_user_id', 'id', $res);
    }
}
