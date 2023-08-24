<?php
use Carbon\Carbon;

if (!function_exists('replaceRpSeparator')) {
	function replaceRpSeparator($nilai)
	{
		return str_replace('Rp', "", str_replace(',', '', $nilai));
	}
}

if (!function_exists('replaceRp')) {
	function replaceRp($nilai)
	{
		return str_replace('Rp', "", str_replace('.', '', $nilai));
	}
}

if (! function_exists('parseFormat'))
{
	function parseFormat($tgl)
	{
        $tgl = Carbon::createFromFormat('d/m/Y', $tgl)->format('Y-m-d');
		return $tgl;
	}
}

if (! function_exists('toRp'))
{
	function toRp($parm)
	{
		return 'Rp. ' . number_format( floatval($parm), 0 , ',' , '.' ) . '';//,00
	}
}

if (! function_exists('notoRp'))
{
	function notoRp($parm)
	{
		return number_format( floatval($parm), 0 , ',' , '.' ) . '';//,00
	}
}

if (! function_exists('parseFormat'))
{
	function parseFormat($tgl)
	{
        $tgl = Carbon::createFromFormat('d/m/Y', $tgl)->format('Y-m-d');
		return $tgl;
	}
}

function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " Belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " Seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " Seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
	}
	return $temp;
}

if (! function_exists('tglIndo'))
{
	function tglIndo($parm)
	{
        $array_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $dataBulan = date('n',strtotime($parm));
        return date('d',strtotime($parm))." ".$array_bulan[$dataBulan]." ".date('Y',strtotime($parm));
	}
}
