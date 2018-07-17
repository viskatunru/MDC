<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB, Carbon\Carbon;
use App\Barang, App\Dokter, App\Pemakaian, App\Penyimpanan, App\Expire;
use App\Bulan;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokters = Dokter::all();
        return view('home', compact('dokters', 'date'));
    }

    public function pemakaianHarianJSON()
    {
        $date = date_format(Carbon::now() , 'Y-m-d');
        $barangs = Barang::whereHas('pemakaians', function ($query) {
            $query->where('tanggal', '=', date_format(Carbon::now() , 'Y-m-d'));
        })->get();
        $dokters = Dokter::all();

        foreach($barangs as $barang)
        {
            $barang->kategori = $barang->category->nama;
            
            foreach ($dokters as $dokter)
            {
                $pemakaians = $barang->pemakaians->where('dokter_id', '=', $dokter->id)->where('tanggal', '=', $date);
                $jumlah = 0;
                foreach ($pemakaians as $pemakaian)
                {
                    $jumlah += $pemakaian->jumlah;
                }
                if($jumlah > 0)
                    $barang["dokter_$dokter->id"] = $jumlah;
                else
                    $barang["dokter_$dokter->id"] = "-";
            }
        }
        return $barangs;
    }

    public function cetakLaporanStok()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulanInput = (int)$input[1];

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();

        $bulan = Bulan::whereYear('bulan', '=', $tahunInput)->whereMonth('bulan', '=', $bulanInput)->first();
        
        $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
            $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        })->get();
        return view('report.pemakaian', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
    }

    public function test()
    {
        $pemakaians = Pemakaian::select('jumlah', 'tanggal')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->tanggal)->format('m');
            });
        echo $pemakaians;
    }
}
