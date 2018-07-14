@extends('master')

@section('content')
<h3>TAMBAH BARANG BARU</h3>

<div class="tab-content">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post" action="#">
			{{csrf_field()}}
			
			<div class="form-group">
				<label for="kode" class="col-sm-2 control-label">Kode Barang</label>
				
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="kode" placeholder="" name="kode_barang">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nama" class="col-sm-2 control-label">Nama Barang</label>
				
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="nama" placeholder="" name="nama_barang">
				</div>
			</div>

			<div class="form-group">
				<label for="kategori" class="col-sm-2 control-label">Kategori Barang</label>
				
				<div class="col-sm-8">
					<select name="id_kategori" id="kategori" class="form-control1">
						<option selected disabled>...</option>
						@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->nama}}</option>
						@endforeach
					</select>
				</div>
				
				<div class="col-sm-2">
				    <a class="btn btn-primary" href="/category/add">+</a>
				</div>
			</div>

			<div class="form-group">
				<label for="lokasi" class="col-sm-2 control-label">Lokasi Barang</label>
				
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="lokasi" placeholder="" name="lokasi_barang">
				</div>
			</div>
			
			<div class="form-group">
				<label for="stok" class="col-sm-2 control-label">Stok Barang</label>
				
				<div class="col-sm-8">
					<input type="number" class="form-control1" id="stok" placeholder="" name="stok_barang" min="0">
				</div>
			</div>

			<div class="form-group">
				<label for="expire" class="col-sm-2 control-label">Expiry Date</label>
				
				<div class="col-sm-8">
					<input type="date" class="form-control1" id="expire" placeholder="" name="stok_barang" min="0">
				</div>
			</div>
			
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Expiry Dates</th>
								<th>Jumlah Barang</th>
								<th>Hapus</th>
							</tr>
						</thead>
						<tbody id="tExpire">
							
						</tbody>
					</table>
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

