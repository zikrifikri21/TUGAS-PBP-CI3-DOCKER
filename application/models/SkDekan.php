<?php

defined('BASEPATH') or exit('No direct script access allowed');
class SkDekan extends ZModel
{
    protected $_table = 'sk_dekan_ujian';
    public function __construct()
    {
        parent::__construct();
    }

    public function ujian($res = null)
    {
        return $this->hasOneThrough(
            Ujian::class,
            SkDekanHasUjian::class,
            'sk_dekan_ujian_id',
            'id',
            'id',
            'ujian_id',
            $res
        );
    }
}
