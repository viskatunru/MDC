@extends('master')

@section('content')
<h3>EDIT BARANG</h3>

<div class="tab-content">
    <div class="tab-pane active" id="horizontal-form">
        <form class="form-horizontal" method="post" action="#">
            {{csrf_field()}}

            <select id="seed_penyimpanan" hidden>
                @foreach($penyimpanans as $p)
                    <option value="{{$p->id}}">{{$p->nama}}</option>
                @endforeach
            </select>

            <input type="hidden" name="id_pembelian" value="{{$pembelian->id}}">
            <input type="hidden" name="id_barang" value="{{$barang->id}}">
            <div class="form-group">
                <label for="kode_barang" class="col-sm-2 control-label">Kode Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="kode_barang" placeholder="" name="kode_barang" value="{{$barang->kode}}" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="nama_barang" placeholder="" name="nama_barang"
                    value="{{$barang->nama}}" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="jumlah" class="col-sm-2 control-label">Jumlah Pembelian</label>
                
                <div class="col-sm-8">
                    <input type="number" class="form-control1" id="jumlah" placeholder="" name="jumlah"
                    value="{{$barang->pivot->jumlah}}">
                </div>
            </div>

            <div class="form-group">
                <label for="harga_satuan" class="col-sm-2 control-label">Harga Satuan</label>
                
                <div class="col-sm-8">
                    <input type="number" class="form-control1" id="harga_satuan" placeholder="" name="harga_satuan"
                    value="{{$barang->pivot->harga_satuan}}" min="0">
                </div>
            </div>

            <div class="form-group">
                <label for="expire" class="col-sm-2 control-label">Tanggal Expired</label>
                
                <div class="col-sm-8">
                    <input type="date" class="form-control1" id="expire" placeholder="" name="expire"
                    value="{{explode(' ', $barang->pivot->expire)[0]}}">
                </div>
            </div>

            <div class="form-group">
                <label for="penyimpanan" class="col-sm-2 control-label">Penyimpanan</label>
                
                <div class="col-sm-8">
                    <!-- disini -->
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <input type="submit" class="btn btn-primary col-sm-12" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('.cb_penyimpanan').html($('#seed_penyimpanan').html());
</script>
@endsection