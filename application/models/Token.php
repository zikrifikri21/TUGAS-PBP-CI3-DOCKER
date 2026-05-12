<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Token extends ZModel
{
    protected $_table = 'token';
    public function __construct()
    {
        parent::__construct();
    }
}
