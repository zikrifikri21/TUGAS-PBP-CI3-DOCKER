<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ujian extends ZModel
{
    protected $_table = 'ujian';
    protected $_primary_key = 'id';
    public function __construct()
    {
        parent::__construct();
    }

    public function mahasiswa($res = null)
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id', $res);
    }

    public function jurusan($res = null)
    {
        return $this->hasOneThrough(
            Jurusan::class,
            Mahasiswa::class,
            'id',
            'id',
            'mahasiswa_id',
            'jurusan_id',
            $res
        );
    }
    public function penilaian($res = null)
    {
        return $this->hasMany(PenilaianUjian::class, 'ujian_id', 'id', $res);
    }

    public function sk_dekan($res = null)
    {
        return $this->hasOneThrough(
            SkDekan::class,          // Model Akhir
            SkDekanHasUjian::class,  // Model Perantara
            'ujian_id',              // FK di Perantara (menunjuk ke Ujian)
            'id',                    // FK di Akhir (biasanya Primary Key SkDekan)
            'id',                    // PK di Ujian
            'sk_dekan_ujian_id',     // Key di Perantara yang menunjuk ke Akhir
            $res
        );
    }


    public function ujian_has_sk_dekan_b($res = null)
    {
        return $this->hasOneThrough(
            SkDekanB::class,
            SkDekanBHasUjian::class,
            'ujian_id',
            'id',
            'id',
            'sk_dekan_b_id',
            $res
        );
    }

    public function kajur($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'kajur_id', 'id', $res);
    }

    public function ketua($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'ketua', 'id', $res);
    }
    public function sekretaris($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'sekretaris', 'id', $res);
    }
    public function anggota_1($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'anggota_1', 'id', $res);
    }
    public function anggota_2($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'anggota_2', 'id', $res);
    }
    public function anggota_3($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'anggota_3', 'id', $res);
    }
    public function pembimbing_1($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'pembimbing_1', 'id', $res);
    }
    public function pembimbing_2($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'pembimbing_2', 'id', $res);
    }
    public function uji1($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'uji1', 'id', $res);
    }
    public function uji2($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'uji2', 'id', $res);
    }
    public function uji3($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'uji3', 'id', $res);
    }

    public function sekretaris_sp($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'ttd_sp', 'id', $res);
    }

    public function sekretaris_st($res = null)
    {
        return $this->belongsTo(DosenFhil::class, 'ttd_st', 'id', $res);
    }
}
