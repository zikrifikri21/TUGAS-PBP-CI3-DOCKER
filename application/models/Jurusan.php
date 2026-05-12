<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Jurusan extends ZModel
{
    protected $_table = 'jurusan';
    public function __construct()
    {
        parent::__construct();
    }

    public function sekretaris_jurusan($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'sekretaris_jurusan', 'id', $res);
    }

    public function ketua_jurusan($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'ketua_jurusan', 'id', $res);
    }
}
