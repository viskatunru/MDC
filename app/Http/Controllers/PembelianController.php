<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian, App\Supplier, App\Barang, App\Category, App\Penyimpanan, App\Expire;
class PembelianController extends Controller
{
    public function json()
    {
        $pembelians = Pembelian::all();
        foreach($pembelians as $p)
        {
            $p->tanggal = "<span class='hidden'>".date("Y/m/d", strtotime($p->tanggal))."</span>".date("j F Y", strtotime($p->tanggal));
            $p->harga_total = "<span class='hidden'>".$p->harga_total."</span>".str_replace(',', '.', number_format($p->harga_total));
            $p->nama_supplier = $p->supplier->nama;
            if ($p->status_pelunasan == 1)
                $p->status = "Lunas";
            else
                $p->status = "Tidak Lunas";
        }
        return $pembelians;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pembelians = Pembelian::all();
        return view('pembelian.index', compact('pembelians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $categories = Category::all();
        $penyimpanans = Penyimpanan::all();
        return view('pembelian.create', compact('suppliers', 'categories', 'penyimpanans'));
    }

    public function store(Request $request)
    {
        $pembelian = new Pembelian;
        $pembelian->no_invoice = $request->no_invoice;
        $pembelian->tanggal = $request->tanggal;
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->harga_total = 0;
        $pembelian->status_pelunasan = $request->status_pelunasan;
        $pembelian->save();

        $counter = 0;
        $total = 0;
        $hargaTotal = 0;
        while (isset($request["id_$counter"]))
        {
            $idBarang = $request["id_$counter"];
            $jumlah = $request["jumlah_$counter"];
            $tanggal = $request["expire_$counter"];
            $harga = $request["harga_$counter"];
            $penyimpanan = $request["penyimpanan_$counter"];
            $hargaTotal += $harga;
            if($tanggal != "")
            {
                $expire = new Expire;
                $expire->tanggal = $tanggal;
                $expire->jumlah = $jumlah;
                $expire->sisa = $jumlah;
                $expire->penyimpanan_id = $penyimpanan;
                $expire->barang_id = $idBarang;
                $expire->pembelian_id = $pembelian->id;
                $expire->save();
            }

            $pembelian->barangs()->attach($idBarang, 
                ['jumlah' => $jumlah, 'harga_satuan' => $harga / $jumlah]);

            $barang = Barang::find($idBarang);
            $barang->stok += $jumlah;
            $barang->save();
            $counter++;
        }
        $pembelian->harga_total = $hargaTotal;
        $pembelian->save();
        return redirect()->action('PembelianController@index');
    }
    public function storePembelian(Request $request)
    {
        $data = $request->all();
        
        $pembelian = new Pembelian;
        $pembelian->tanggal = $data['tanggal'];
        $pembelian->supplier_id = $request['id_supplier'];
        $pembelian->save();

        $response = [ 'pembelian_id' => $pembelian->id, 'nama_supplier' => $pembelian->supplier->nama, 'tanggal_pembelian' => $pembelian->tanggal];
        return $response;
    }

    public function storeBarang(Request $request)
    {
        $data = $request->all();
        $barang = new Barang;
        $barang->nama = $data['nama_barang'];
        $barang->stok = $data['stok'];
        $expire = $data['tanggal_expire'];        
        return view('pembelian.templatetable', compact('barang', 'expire'));
        /*

        $barang = Barang::find($request->id_barang);        
        $barang->stok += $request->jumlah_barang;
        $barang->save();

        $expire = Expire::where('barang_id', '=', $barang->id)
                ->where('tanggal', '=', $request->tanggal_expire)->first();
        if ($expire == null)
        {
            $expire = new Expire;
            $expire->tanggal = $request->tanggal_expire;
            $expire->jumlah = $request->jumlah_barang;
            $expire->penyimpanan_id = $request->id_penyimpanan;
            $expire->barang_id = $barang->id;
        }
        else
        {
            $expire->jumlah += $request->jumlah_barang;
        }
        $expire->save();
        
        return redirect()->action('PembelianController@index');*/
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
        $pembelian = Pembelian::find($id);
        $barangs = $pembelian->barangs;
        return view('pembelian.show', compact('barangs', 'pembelian'));
    }

    public function editBarang($idPembelian, $idBarang)
    {
        $pembelian = Pembelian::find($idPembelian);
        $barang = $pembelian->barangs()->find($idBarang);
        $penyimpanans = Penyimpanan::all();
        return view('pembelian.editBarang', compact('pembelian', 'barang', 'penyimpanans'));
    }

    public function storeEditBarang(Request $request)
    {
        $jumlahBaru = $request->jumlah;
        $barang = Pembelian::find($request->id_pembelian)->barangs()->find($request->id_barang);
        $jumlahLama = $barang->pivot->jumlah;
        $barang->pivot->jumlah = $jumlahBaru;
        if ($barang->pivot->jumlah < 0)
            $barang->pivot->jumlah = 0;
        
        $barang->pivot->harga_satuan = $request->harga_satuan;
        $barang->pivot->save();

        $pembelian = Pembelian::find($request->id_pembelian);
        $pembelian->harga_total = $barang->pivot->harga_satuan * $barang->pivot->jumlah;
        $pembelian->save();

        $barang->stok -= $jumlahLama - $jumlahBaru;
        if ($barang->stok < 0)
            $barang->stok = 0;
        $barang->save();
        return redirect()->action('PembelianController@show', ['id' => $request->id_pembelian]);
    }

    public function deleteBarang($idPembelian, $id)
    {
        $pembelian = Pembelian::find($idPembelian);
        $barang = $pembelian->barangs()->wherePivot('id', '=', $id)->first();
        $barang->stok -= $barang->pivot->jumlah;
        $barang->save();

        $barang->pivot->delete();
        return redirect()->action('PembelianController@show', ['id' => $idPembelian]);
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
        $pembelian = Pembelian::find($id);
        $suppliers = Supplier::all();
        $categories = Category::all();
        $penyimpanans = Penyimpanan::all();
        $barangs = $pembelian->barangs;
        return view('pembelian.edit', compact('pembelian', 'suppliers', 'categories', 'penyimpanans', 'barangs'));
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
        $pembelian = Pembelian::find($id);
        $pembelian->no_invoice = $request->no_invoice;
        $pembelian->tanggal = $request->tanggal;
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->harga_total = 0;
        $pembelian->status_pelunasan = $request->status_pelunasan;
        $pembelian->save();

        $counter = 0;
        $total = 0;
        $hargaTotal = 0;
        while (isset($request["id_$counter"]))
        {
            $idBarang = $request["id_$counter"];
            $jumlah = $request["jumlah_$counter"];
            $tanggal = $request["expire_$counter"];
            $harga = $request["harga_$counter"];
            $penyimpanan = $request["penyimpanan_$counter"];
            $hargaTotal += $harga;
            if($tanggal != "")
            {
                $expire = Expire::find($id);
                $expire->tanggal = $tanggal;
                $expire->jumlah = $jumlah;
                $expire->sisa = $jumlah;
                $expire->penyimpanan_id = $penyimpanan;
                $expire->barang_id = $idBarang;
                $expire->pembelian_id = $pembelian->id;
                $expire->save();
            }

            $pembelian->barangs()->attach($idBarang, 
                ['jumlah' => $jumlah, 'harga_satuan' => $harga / $jumlah]);

            $barang = Barang::find($idBarang);
            $barang->stok += $jumlah;
            $barang->save();
            $counter++;
        }
        $pembelian->harga_total = $hargaTotal;
        $pembelian->save();
        return redirect()->route('pembelian_all');
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
        $pembelian = Pembelian::find($id);
        $barangs = $pembelian->barangs()->get();
        //return $barangs;
        foreach ($barangs as $barang)
        {
            $b = Barang::find($barang->id);
            $b->stok -= $barang->pivot->jumlah;
            $b->save();
        }
        $pembelian->delete();
        return redirect()->action('PembelianController@index');
    }
}
