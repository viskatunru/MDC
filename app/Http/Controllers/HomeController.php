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

    public function lihatLaporanStok()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulanInput = (int)$input[1];

        $bulan = Input::get('bulan')."-01";

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }

            $pbi = $b->pemakaians()->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();
            foreach ($pbi as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        
        return view('report.pemakaian', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
    }

    public function lihatLaporanStokTahunan() {
        $bulan = Input::get('tahun')."-01-01";
        $tahunInput = Input::get('tahun');

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        
        return view('report.pemakaian_tahunan', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput'));
    }
    public function cetakLaporanDokter()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulanInput = (int)$input[1];
        $bulan = Input::get('bulan')."-01";

        $dokters = Dokter::where('nama', 'not like', '%op%')->get();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        // $bulan = Bulan::whereYear('bulan', '=', $tahunInput)->whereMonth('bulan', '=', $bulanInput)->first();
        
        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        return view('report.print', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
    }

    public function cetakLaporanDokterTahunan()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulan = Input::get('bulan')."-01";

        $dokters = Dokter::where('nama', 'not like', '%op%')->get();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        // $bulan = Bulan::whereYear('bulan', '=', $tahunInput)->whereMonth('bulan', '=', $bulanInput)->first();
        
        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        return view('report.print_tahunan', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput'));
    }

    public function cetakLaporanRuanganTahunan()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulan = Input::get('bulan')."-01";

        $dokters = Dokter::where('nama', 'like', '%op%')->get();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        // $bulan = Bulan::whereYear('bulan', '=', $tahunInput)->whereMonth('bulan', '=', $bulanInput)->first();
        
        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        return view('report.print_tahunan', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput'));
    }

    public function cetakLaporanRuangan()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulanInput = (int)$input[1];
        $bulan = Input::get('bulan')."-01";


        $dokters = Dokter::where('nama', 'like', '%op%')->get();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();


        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) 
            {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereDate("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }
        }

        return view('report.print', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
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

    public function coba()
    {
        $dokters = Dokter::where('nama', 'not like', '%op%')->get();
        return $dokters;
    }
}
