<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('rupiah'))
	{
		function rupiah($angka)
		{
			if($angka==null)
			{
				return "Kosong";
			}
			else
			{
				$jumlah_desimal="0";
				$pemisah_desimal=",";
				$pemisah_ribuan=".";
				return  $rupiah="Rp. ".number_format($angka,$jumlah_desimal,$pemisah_desimal,$pemisah_ribuan).",-";
			}
		}
	}