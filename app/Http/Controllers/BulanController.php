<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bulan, App\Barang;
class BulanController extends Controller
{
    //
    public function generateStok(Request $request)
    {
    	$bulan = Bulan::where('bulan', '=', $request->bulan."-01")->first();
    	if ($bulan == "")
    	{
    		$bulan = new Bulan;
    		$bulan->bulan = $request->bulan."-01";
    		$bulan->save();

    		$barangs = Barang::all();
    		foreach($barangs as $b)
    		{
	    		$bulan->barangs()->attach($b->id, ['stok_awal' => $b->stok]);
	    	}
    	}
		return view('report.bulan', compact('bulan'));
    }
}
