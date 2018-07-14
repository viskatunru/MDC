@extends('master')

@section('content')
<h3>EDIT BARANG (ID: {{$barang->id}})</h3>

<div class="tab-content">
    <div class="tab-pane active" id="horizontal-form">
        <form class="form-horizontal" method="post" action="#">
            {{csrf_field()}}
            
            <div class="form-group">
                <label for="kode_barang" class="col-sm-2 control-label">Kode Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="kode_barang" placeholder="" name="kode_barang" value="{{$barang->kode}}">
                </div>
            </div>

            <div class="form-group">
                <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="nama_barang" placeholder="" name="nama_barang"
                    value="{{$barang->nama}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_kategori" class="col-sm-2 control-label">Kategori Barang</label>
                
                <div class="col-sm-8">
                    <select name="id_kategori" id="id_kategori" class="form-control1">
                        <option selected disabled>...</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" @if($category->id == $barang->category_id) selected @endif>{{$category->nama}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-sm-2">
				    <a class="btn btn-primary" href="/category/add">+</a>
				</div>
			</div>

            <div class="form-group">
                <label for="lokasi_barang" class="col-sm-2 control-label">Lokasi Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="lokasi_barang" placeholder="" name="lokasi_barang" value="{{$barang->lokasi}}">
                </div>
            </div>

            <div class="form-group">
                <label for="stok_barang" class="col-sm-2 control-label">Stok Barang</label>
                
                <div class="col-sm-8">
                    <input type="number" class="form-control1" id="stok_barang" placeholder="" name="stok_barang" value="{{$barang->stok}}" min="0">
                </div>
            </div>
			
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button type="submit" class="btn-primary btn">Kirim</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection