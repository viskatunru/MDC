<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bulan extends Model
{
    //

    public function barangs()
    {
    	return $this->belongsToMany('App\Barang', 'bulan_barang')->withPivot('stok_awal');
    }
}
