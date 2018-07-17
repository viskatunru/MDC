<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    //

    public function dokter()
    {
    	return $this->belongsTo('App\Dokter');
    }

    public function barang()
    {
    	return $this->belongsTo('App\Barang');
    }

    public function expires()
    {
        return $this->belongsToMany('App\Expire')->withPivot('jumlah');
    }   
}
