<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use App\Pemakaian, App\Dokter, App\Barang, App\Expire, App\Category;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pemakaians = Pemakaian::all();
        return view('pemakaian.index', compact('pemakaians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dokters = Dokter::all();
        $categories = Category::all();
        $barangs = Barang::all();
        return view('pemakaian.create', compact('dokters', 'categories', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaian = new Pemakaian;
        $pemakaian->tanggal = $request->tanggal;
        $pemakaian->dokter_id = $request->id_dokter;
        $pemakaian->barang_id = $request->id_barang;
        $pemakaian->jumlah = $request->jumlah_barang;
        $pemakaian->save();

        $barang = Barang::find($request->id_barang);
        $barang->stok -= $request->jumlah_barang;
        $barang->save();

        $expires = Expire::where('barang_id', '=', $barang->id)
                ->where('sisa', '>', 0)->where('tanggal', '>=', date_format(Carbon::now() , 'Y-m-01'))
                ->orderBy('tanggal', 'asc')->get();

        if ($expires != null)
        {
            $jumlahBarang = $request->jumlah_barang;
            foreach($expires as $expire)
            {
                $expire->sisa -= $jumlahBarang;

                if ($expire->sisa >= 0)
                {
                    $expire->save();
                    $pemakaian->expires()->attach($expire->id, ['jumlah' => $jumlahBarang]);
                    break;
                }
                else
                {
                    $pemakaian->expires()->attach($expire->id, ['jumlah' => $jumlahBarang + $expire->sisa]);

                    $jumlahBarang = $expire->sisa * -1;
                    $expire->sisa = 0;
                    $expire->save();
                }
            }
        }
        return redirect()->action('PemakaianController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pemakaian = Pemakaian::find($id);
        $dokters = Dokter::all();
        $barangs = Barang::all();
        $categories = Category::all();
        return view('pemakaian.edit', compact('pemakaian', 'dokters', 'barangs', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $pemakaian = Pemakaian::find($id);
        $pemakaian->tanggal = $request->tanggal;
        $pemakaian->dokter_id = $request->id_dokter;
        $pemakaian->barang_id = $request->id_barang;

        $barang = Barang::find($request->id_barang);
        $barang->stok += $pemakaian->jumlah - $request->jumlah_barang;
        $barang->save();

        $pemakaian->jumlah = $request->jumlah_barang;
        $pemakaian->save();

        $expire = Expire::find($pemakaian->expire_id);

        if ($expire != null)
        {
            $expire->jumlah += $pemakaian->jumlah - $request->jumlah_barang;
            $expire->save();
        }

        return redirect()->route('pemakaian_all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $pemakaian = Pemakaian::find($id);
        $barang = $pemakaian->barang()->first();
        $barang->stok += $pemakaian->jumlah;
        $barang->save();

        $pemakaian->delete();
        return redirect()->action('PemakaianController@index');
    }

    public function showMonthly()
    {
        $tahun = Input::get('tahun', date('Y'));
        $bulan = Input::get('bulan', date('m'));
        $idBarang = Input::get('id_barang', 0);

        $pemakaians = Pemakaian::select('*')
            ->whereYear('tanggal', '=', $tahun)
            ->whereMonth('tanggal', '=', $bulan)
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->tanggal)->format('d');
            });
    }

    public function showYearly()
    {
        $tahun = Input::get('tahun', date('Y'));
        $bulan = Input::get('bulan', date('m'));
        $idBarang = Input::get('id_barang', 0);
/*
        $pemakaians = Pemakaian::selectRaw('tanggal, sum(jumlah) as sum')->whereYear('tanggal', '=', $tahun)
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->tanggal)->format('m');
            });
*/      
        $barang = Barang::find($idBarang);
        $months = array();

        for($i = 1; $i <= 12; $i++)
        {
            $months[$i] = $barang->pemakaians()->whereYear('tanggal', '=', $tahun)->whereMonth('tanggal', '=', $i)->sum('jumlah');
        }
        return view('template.pemakaianbarang', compact('months'));
    }
}
