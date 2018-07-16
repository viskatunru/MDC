@extends('master')

@section('content')
<h3>TAMBAH PEMBELIAN BARU</h3>

<div class="tab-content" id="divpembelian">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post" action="#">
			{{csrf_field()}}
			<select id="seed_penyimpanan" hidden>
				@foreach($penyimpanans as $p)
					<option value="{{$p->id}}">{{$p->nama}}</option>
				@endforeach
			</select>


			<div class="form-group">
				<label for="focusedinput" class="col-sm-2 control-label">Tanggal Pembelian</label>

				<div class="col-sm-8">
					<input required type="date" class="form-control1" id="focusedinput" placeholder="Tanggal" name="tanggal">
				</div>
			</div>
			
			<div class="form-group">
				<label for="focusedinput" class="col-sm-2 control-label">Nama Supplier</label>
				
				<div class="col-sm-8">
					<select name="supplier_id" class="form-control1" id="supplier_id">
						@foreach($suppliers as $supplier)
							<option value="{{$supplier->id}}">{{$supplier->nama}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="focusedinput" class="col-sm-2 control-label">Aksi</label>
					
				<div class="col-sm-3">
					<a href="#" class="btn btn-primary" id="caribarang" style="width:100%;">Cari Barang</a>
				</div>
				<div class="col-sm-3">
					<a href="#" class="btn btn-delete" id="tutupbarang" style="width:100%;">Tutup Pencarian Barang</a>
				</div>
			</div>

			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="" id="tablebarang" hidden>
				<div class="panel-body no-padding">
					<h3>Pencarian Barang</h3>
					<table class="table table-striped" id="tablebarang" data-toggle="table" data-url="/barang/json" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
						<thead>
							<tr class="warning">
								<th data-sortable="true" data-field="kode">Kode</th>
								<th data-sortable="true" data-field="nama">Nama</th>
								<th data-sortable="true" data-field="namakategori">Kategori</th>
								<th data-sortable="true" data-field="stok">Stok Saat Ini</th>
								<th data-field="id" data-formatter="LinkFormatter">Aksi</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>

			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<h3>Daftar Pembelian Barang</h3>
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Kode</th>
								<th>Nama</th>
								<th>Jumlah</th>
								<th>Tanggal Expired</th>
								<th>Penyimpanan</th>
								<th>Hapus</th>
							</tr>
						</thead>
						<tbody id="tBarangs">
							
						</tbody>
					</table>
				</div>
			</div>

			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button type="submit" class="btn btn-primary" style="width:100%;">Kirim</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="divsupplier">
	
</div>
<script type="text/javascript">
	/*
	$('#tambahsupplier').click(function(){
		$.ajax({
	        type: "GET",
	        url: '/ajax/add/supplier',
	        success: function( data ) {
	        	$('#divsupplier').html(data);
	        	$('#divpembelian').attr('hidden', true);
	        }
	    });
	});*/
	$('#caribarang').click(function(){
		$('#tablebarang').removeAttr('hidden');
	});
	$('#tutupbarang').click(function(){
		$('#tablebarang').attr('hidden', true);
	});
	var barangs = new Array();
	
	function LinkFormatter(value, row, index) {
		return "<a class='btn btn-primary' " +
		"onclick='addBarang("+ row['id'] + ',"' + row['kode'] + '","' + row['nama']+ '"' + ")'>Tambah</a>";
	}

	function addBarang(...args)
	{
			barangs.push(args);
			updateTable();
	}

	function updateTable()
	{
		var tr = "";
		var counter = 0;
		for (var i = 0; i < barangs.length; i++)
		{
			tr +=
			"<tr>" +
				"<td>" + barangs[i][1] + "</td>" + 
				"<td>" + barangs[i][2] + "</td>" +
				"<input type='hidden' name='id_" + counter + "' value='" + barangs[i][0] + "'>" +
				"<td><input type='number' class='form-control1' value=1 required name='jumlah_" + counter + "'></td>" +
				"<td><input type='date' class='form-control1' placeholder='Expire' name='expire_" + counter + "'</td>" +
				"<td><select class='form-control1 cb_penyimpanan' name='penyimpanan_"+ counter + "'></select></td>" +
				"<td><a onclick='deleteBarang(" + counter + ")' class='btn btn-delete'>Hapus</a></td>" + 
			"</tr>";
			counter++;
		}
		$('#tBarangs').html(tr);

		$('.cb_penyimpanan').html($('#seed_penyimpanan').html());
	}

	function barangIsAdded(id)
	{

		for (var i = 0; i < barangs.length; i++)
		{
			if (barangs[i][0] === id)
				return true;
		}
		return false;
	}

	function deleteBarang(id)
	{		
		if(confirm('Apakah anda yakin?'))
		{
			barangs.splice(id, 1);
			updateTable();
		}
	}
	$(document).ready(function(){

	});
</script>
@endsection