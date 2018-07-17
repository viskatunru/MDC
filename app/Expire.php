<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expire extends Model
{
    //
    protected $fillable = [
        'tanggal'
    ];

    public function barang()
    {
    	return $this->belongsTo('App\Barang');
    }

    public function penyimpanan()
    {
    	return $this->belongsTo('App\Penyimpanan');
    }

    public function pemakaians()
    {
        return $this->belongsToMany('App\Pemakaian')->withPivot('jumlah');
    }

    public function pembelian()
    {
        return $this->belongsTo('App\Pembelian');
    }
}
