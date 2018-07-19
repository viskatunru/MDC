<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang, App\Dokter, App\Pembelian, App\Category, App\Supplier, App\Penyimpanan;
use App\Expire, App\Bulan, Carbon\Carbon;
class BarangController extends Controller
{
    public function json()
    {
        $barangs = Barang::all();
        foreach ($barangs as $barang)
        {
            $barang->namakategori = $barang->category->nama;
            $barang->namapenyimpanan = $barang->penyimpanan->nama;
            $barang->harga_beli = str_replace(',', '.', number_format($barang->harga_beli));
        }
        return $barangs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $dokters = Dokter::all();
        $suppliers = Supplier::all();
        $penyimpanans = Penyimpanan::all();
        return view('barang.create', compact('categories', 'penyimpanans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $kategori = Category::find($request->id_kategori);
        if ($kategori == null)
        {
            $kategori = new Categori;
            $kategori->nama = $request->id_kategori;
            $kategori->save();
        }
        */
        $barang = new Barang;
        $barang->kode = $request->kode_barang;
        $barang->nama = $request->nama_barang;

        $barang->stok = 0;
        $barang->harga_beli = 0;

        if ($request->stok_barang != null)
            $barang->stok = $request->stok_barang;

        $barang->category_id = $request->id_kategori;
        $barang->penyimpanan_id = $request->id_penyimpanan;

        if ($request->harga_satuan != null)
            $barang->harga_beli = $request->harga_satuan;
        
        $barang->save();
        $bulan = Bulan::where('bulan', '=', date_format(Carbon::now() , 'Y-m-01'))->first();
        if ($bulan != "")
        {
            $bulan->barangs()->attach($barang->id, ['stok_awal' => $barang->stok]);
        }

        $counter = 0;
        while (isset($request["expire_$counter"]))
        {
            $tanggal = $request["expire_$counter"];
            $jumlah = $request["jumlah_$counter"];
            $penyimpananExpire = $request["penyimpanan_$counter"];
            if (isset($request["id_$counter"]))
                $expire = Expire::find($request["id_$counter"]);
            else
            {
                $expire = new Expire;
                $expire->sisa = $jumlah;
            }

            $expire->tanggal = $tanggal;
            $expire->jumlah = $jumlah;
            $expire->penyimpanan_id = $penyimpananExpire;
            $expire->barang_id = $barang->id;
            $expire->pembelian_id = null;
            $expire->save();
            $counter++;
        }

/*
        $pembelian = new Pembelian;
        $pembelian->supplier_id = $request->id_supplier;
        $pembelian->save();

        $barang->pembelians()->save($pembelian, ['jumlah' => $request->jumlah]);
*/
        return redirect()->route('barang_all');
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
        $barang = Barang::find($id);
        $expires = $barang->expires()->orderBy('tanggal')->get();

        return view('barang.show', compact('barang' , 'expires'));
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
        $barang = Barang::find($id);
        $categories = Category::all();
        $penyimpanans = Penyimpanan::all();        

        return view('barang.edit', compact('barang', 'categories', 'penyimpanans'));
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
        $barang = Barang::find($id);
        $barang->kode = $request->kode_barang;
        $barang->nama = $request->nama_barang;
        $barang->stok = $request->stok_barang;
        $barang->category_id = $request->id_kategori;
        $barang->penyimpanan_id = $request->id_penyimpanan;
        $barang->harga_beli = $request->harga_satuan;
        $barang->save();

        $counter = 0;
        while (isset($request["expire_$counter"]))
        {
            $tanggal = $request["expire_$counter"];
            $jumlah = $request["jumlah_$counter"];
            $penyimpananExpire = $request["penyimpanan_$counter"];
            if (isset($request["id_$counter"]))
                $expire = Expire::find($request["id_$counter"]);
            else
            {
                $expire = new Expire;
                $expire->sisa = $jumlah;
            }

            $expire->tanggal = $tanggal;
            $expire->jumlah = $jumlah;
            $expire->penyimpanan_id = $penyimpananExpire;
            $expire->barang_id = $barang->id;
            $expire->save();
            $counter++;
        }
        return redirect()->action('BarangController@edit', [$id]);
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
        $barang = Barang::find($id);
        $barang->delete();
        return redirect()->action('BarangController@index');
    }
}
