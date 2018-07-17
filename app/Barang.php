<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
 	protected $fillable = [
        'nama', 'stok'
    ];

    public function pemakaians()
    {
    	return $this->hasMany('App\Pemakaian');
    }

    public function pembelians()
    {
    	return $this->belongsToMany('App\Pembelian')->withPivot('jumlah', 'id', 'harga_satuan');
    }

    public function expires()
    {
    	return $this->hasMany('App\Expire');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function penyimpanan()
    {
        return $this->belongsTo('App\Penyimpanan');
    }

    public function bulans()
    {
        return $this->belongsToMany('App\Bulan', 'bulan_barang')->withPivot('stok_awal');
    }
}
