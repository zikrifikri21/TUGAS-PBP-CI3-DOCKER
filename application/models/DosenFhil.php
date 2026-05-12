<?php

defined('BASEPATH') or exit('No direct script access allowed');
class DosenFhil extends ZModel
{
    protected $_table = 'dosen';
    public function __construct()
    {
        parent::__construct();
    }

    public function jurusan($res = null)
    {
        return $this->belongsTo(Jurusan::class, 'homebase', 'id', $res);
    }
}
