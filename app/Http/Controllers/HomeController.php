<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB, Carbon\Carbon;
use App\Barang, App\Dokter, App\Pemakaian, App\Penyimpanan, App\Expire;
use App\Bulan;
class HomeController extends Controller
{

    // public function dbnorm() {
    //     $pembelian = new \App\Pembelian;
    //     $pembelian->no_invoice = "admin_inputteds";
    //     $pembelian->status_pelunasan = 1;
    //     $pembelian->tanggal = "2014-09-09";
    //     $pembelian->harga_total = 0;
    //     $pembelian->supplier_id = 19;
    //     $pembelian->save();

    //     $expires = Expire::whereNull('pembelian_id')->get();

    //     foreach ($expires as $e) {
    //         $e->pembelian_id = $pembelian->id;
    //         $e->save();

    //         $barang = $e->barang;
    //         $barang->pembelians()->save($pembelian, ['jumlah' => $e->jumlah, 'harga_satuan' => $barang->harga_beli]);
    //     }
    // }
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
        $tahunInput = (int)$input[0];
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
            
            $b->stokAkhir = $b->stokAwal;

            $pbbi = $b->pembelians()->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();
            foreach ($pbbi as $p) {
                $b->stokAkhir += $p->pivot->jumlah;
            }
            
            $pkbi = $b->pemakaians()->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();
            foreach ($pkbi as $p) {
                $b->stokAkhir -= $p->jumlah;
            }
        }

        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        
        return view('report.pemakaian', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
    }

    public function lihatLaporanStokTahunan() {
        $bulan = Input::get('tahun');
        $tahunInput = Input::get('tahun');

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->get();

        $barangs = Barang::all();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereYear("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereYear("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }

            $b->stokAkhir = $b->stokAwal;
            $pbbi = $b->pembelians()->whereYear('tanggal', '=', $bulan)->get();
            foreach ($pbbi as $p) {
                $b->stokAkhir += $p->pivot->jumlah;
            }

            $pkbi = $b->pemakaians()->whereYear('tanggal', '=', $bulan)->get();
            foreach ($pkbi as $p) {
                $b->stokAkhir -= $p->jumlah;
            }        
        }

        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        
        return view('report.pemakaian_tahunan', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput'));
    }

    public function cetakLaporanSemua()
    { 
        $input = explode('-',Input::get('bulan'));
        $tahunInput = $input[0];
        $bulanInput = (int)$input[1];
        $bulan = Input::get('bulan')."-01";

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();

        $barangs = Barang::orderBy("nama", 'asc')->get();

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
            
            $b->stokAkhir = $b->stokAwal;

            $pbbi = $b->pembelians()->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();
            foreach ($pbbi as $p) {
                $b->stokAkhir += $p->pivot->jumlah;
            }
            
            $pkbi = $b->pemakaians()->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput)->get();
            foreach ($pkbi as $p) {
                $b->stokAkhir -= $p->jumlah;
            }
        }

        // $bulan = Bulan::whereYear('bulan', '=', $tahunInput)->whereMonth('bulan', '=', $bulanInput)->first();
        
        // $barangs = $bulan->barangs()->whereHas('pemakaians', function ($query) use ($tahunInput, $bulanInput){
        //     $query->whereYear('tanggal', '=', $tahunInput)->whereMonth('tanggal', '=', $bulanInput);
        // })->get();
        return view('report.print', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput', 'bulanInput'));
    }

    public function cetakLaporanSemuaTahunan()
    { 
        $input = explode('-',Input::get('tahun'));
        $tahunInput = $input[0];
        $bulan = Input::get('tahun')."-01";

        $dokters = Dokter::all();
        
        $pemakaiansBulanIni = Pemakaian::whereYear('tanggal', '=', $tahunInput)->get();

        $barangs = Barang::orderBy("nama", 'asc')->get();

        foreach ($barangs as $b)
        {
            $b->stokAwal = $b->stok;
            $pembelians = $b->pembelians()->whereYear("tanggal", '>=', $bulan)->get();
            foreach ($pembelians as $p) {
                $b->stokAwal -= $p->pivot->jumlah;
            }

            $pemakaians = $b->pemakaians()->whereYear("tanggal", '>=', $bulan)->get();
            foreach ($pemakaians as $p) {
                $b->stokAwal += $p->jumlah;
            }

            $b->stokAkhir = $b->stokAwal;
            $pbbi = $b->pembelians()->whereYear('tanggal', '=', $bulan)->get();
            foreach ($pbbi as $p) {
                $b->stokAkhir += $p->pivot->jumlah;
            }

            $pkbi = $b->pemakaians()->whereYear('tanggal', '=', $bulan)->get();
            foreach ($pkbi as $p) {
                $b->stokAkhir -= $p->jumlah;
            }        
        }
        return view('report.print_tahunan', compact('barangs', 'dokters', 'pemakaiansBulanIni', 'tahunInput'));
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
