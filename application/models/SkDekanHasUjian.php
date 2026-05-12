<?php

defined('BASEPATH') or exit('No direct script access allowed');
class SkDekanHasUjian extends ZModel
{
    protected $_table = 'sk_dekan_ujian_has_ujian';
    protected $_primary_key = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function skdekan($res = null)
    {
        return $this->hasMany(SkDekan::class, 'id', 'sk_dekan_ujian_id', $res);
    }

    public function sk_dekan($res = null)
    {
        return $this->belongsTo(SkDekan::class, 'sk_dekan_ujian_id', 'id', $res);
    }

    public function ujian($res = null)
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id', $res);
    }
}
