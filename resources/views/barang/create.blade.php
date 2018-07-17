@extends('master')

@section('content')
<h3>TAMBAH BARANG BARU</h3>

<div class="tab-content">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post" action="#">
			{{csrf_field()}}
			
			<select id="seed_penyimpanan" hidden>
				@foreach($penyimpanans as $p)
					<option value="{{$p->id}}">{{$p->nama}}</option>
				@endforeach
			</select>

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
					<select name="id_kategori" id="kategori">
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
				<label for="lokasi" class="col-sm-2 control-label">Penyimpanan Barang</label>
				
				<div class="col-sm-8">
					<select id="penyimpanan" name="id_penyimpanan">
						@foreach($penyimpanans as $p)
							<option value="{{$p->id}}">{{$p->nama}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-2">
				    <a class="btn btn-primary" href="/penyimpanan/add">+</a>
				</div>
			</div>
			
			<div class="form-group">
				<label for="stok" class="col-sm-2 control-label">Stok Total Barang</label>
				
				<div class="col-sm-8">
					<input type="number" class="form-control1" id="stok" placeholder="" name="stok_barang" min="0">
				</div>
			</div>

			<div class="form-group">
				<label for="harga_satuan" class="col-sm-2 control-label">Harga Beli Satuan</label>
				
				<div class="col-sm-8">
					<input type="number" class="form-control1" id="harga_satuan" placeholder="" name="harga_satuan" min="0">
				</div>
			</div>
			
			<hr>

			<div class="form-group">
				<label for="expire" class="col-sm-2 control-label">Tanggal Expired</label>
				
				<div class="col-sm-8">
					<input type="date" class="form-control1" id="expire" placeholder="" name="expiry_date" min="0">
				</div>

				<div class="col-sm-2">
				    <a class="btn btn-primary" href="#" onclick="tambahExpire()">+</a>
				</div>

				<div class="panel panel-warning col-sm-10 col-sm-offset-1" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
					<div class="panel-body no-padding">
						<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
							<thead>
								<tr class="warning">
									<th data-sortable="true">Tanggal Expired</th>
									<th data-sortable="true">Stok Barang</th>
									<th data-sortable="true">Penyimpanan</th>
									<th>Hapus</th>
								</tr>
							</thead>
							<tbody id="tExpire">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button type="submit" class="btn btn-primary btn-full">Kirim</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	var expires = new Array();

	$('#kategori').selectize({
	    sortField: 'text'
	});

	$('#penyimpanan').selectize({
	    sortField: 'text'
	});

	$('#a').selectize({
	    sortField: 'text'
	});
	
	function tambahExpire()
	{
		if($('#expire').val() != "")
		{
			expires.push($('#expire').val());
			updateTable();
		}
		else
			alert("Tanggal expired tidak boleh kosong.");
	}

	function deleteExpire($id)
	{
		expires.splice($id, 1);
		updateTable();
	}

	function updateTable()
	{
		var tr = "";
		for (var i = 0; i < expires.length; i++)
		{
			tr += 
			"<tr>" +
				"<td><input type='date' class='form-control1' value='" + expires[i] + "' required name='expire_" + i+ "'</td>" + 
				"<td><input type='number' class='form-control1' value=1 required name='jumlah_" + i + "'></td>" +
				"<td><select class='form-control1 cb_penyimpanan' name='penyimpanan_"+ i + "'></select></td>" +
				"<td><a onclick='deleteExpire(" + i + ")' class='btn btn-delete'>Hapus</a></td>" + 
			"</tr>";
		}
		$('#tExpire').html(tr);
		$('.cb_penyimpanan').html($('#seed_penyimpanan').html());
	}

	$(document).ready(function(){
	});
</script>
@endsection

