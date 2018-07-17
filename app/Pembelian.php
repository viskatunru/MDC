<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    public function barangs()
    {
    	return $this->belongsToMany('App\Barang')->withPivot('jumlah', 'id', 'harga_satuan');
    }

    public function supplier()
    {
    	return $this->belongsTo('App\Supplier');
    }
}
