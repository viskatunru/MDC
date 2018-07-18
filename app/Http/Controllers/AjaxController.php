<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Expire, App\Barang, Carbon\Carbon, App\Pembelian;

class AjaxController extends Controller
{
    //

    public function barangByExpiryDate()
    {	
    	$tanggal = Input::get('tanggal', 0);

    	$date = (int)date("d");
    	$month = (int)date('m');
    	$year = (int)date("Y");    	

        $format = date_create("$year-$month-$date");
    	date_add($format, date_interval_create_from_date_string("$tanggal days"));

        $uppBound = date_format($format, 'Y-m-d');
        $expires = Expire::where('tanggal', '>=', "$year-$month-$date 00:00:00")
                ->where('tanggal', '<=', "$uppBound 00:00:00")->get();
        return view('template.barangByExpire', compact('expires'));
    }

    public function expireTigaBulan()
    {
        return $this->getExpires(30, 90);
    }

    public function expireEnamBulan()
    {
        return $this->getExpires(90, 180);
    }

    public function expireBulanIni()
    {
        return $this->getExpires(0, 30);
    }

    public function getExpires($bwh, $atas)
    {
        $format = date_create(Carbon::now());
        date_add($format, date_interval_create_from_date_string("$bwh days"));

        $lowBound = date_format($format, 'Y-m-d');

        $format = date_create(Carbon::now());
        date_add($format, date_interval_create_from_date_string("$atas days"));

        $uppBound = date_format($format, 'Y-m-d');

        $expires = Expire::where('tanggal', '>', $lowBound)->where('tanggal', '<=', $uppBound)->get();
        return view('template.expireBulanIni', compact('expires'));
    }

    public function barangYangExpire($barangs)
    {
        $results;
    }
}
