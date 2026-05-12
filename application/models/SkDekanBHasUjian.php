<?php

defined('BASEPATH') or exit('No direct script access allowed');
class SkDekanBHasUjian extends ZModel
{
    protected $_table = 'ujian_has_sk_dekan_b';
    protected $_primary_key = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function skdekanb($res = null)
    {
        return $this->hasMany(SkDekanB::class, 'id', 'sk_dekan_b_id', $res);
    }
}
