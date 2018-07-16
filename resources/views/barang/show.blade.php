@extends('master')

@section('content')
<h3 style="margin-bottom:10px;">{{$barang->nama}}</h3>
<h4>({{$barang->kode}}, {{$barang->category->nama}}, {{$barang->lokasi}})</h4>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<h3>Detail Expired</h3>
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr class="warning">
					<th data-sortable="true">Tanggal Expired</th>
					<th data-sortable="true">Jumlah</th>
					<th data-sortable="true">Penyimpanan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($expires as $expire)
					<tr>
						{{$expire->id}}
						<td>{{$expire->tanggal}}</td>
						<td>{{$expire->jumlah}}</td>
						<td>{{$expire->penyimpanan->nama}}</td>
						<td><a href="/pemakaian/add" class="btn btn-delete" onclick="return confirm('Apakah anda yakin?');">Edit</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<form id="formPemakaian">
	<select id="tipe">
		<option value="1">Bulan</option>
		<option value="2">Tahun</option>
	</select>

	<select id="tahun">
		<option value="2017">2017</option>
	</select>

	<select id="bulan">
		<option value="1">Januari</option>
		<option value="2">Februari</option>
		<option value="3">Maret</option>
		<option value="4">April</option>
		<option value="5">Mei</option>
		<option value="6">Juni</option>
		<option value="7">Juli</option>
		<option value="8">Agustus</option>
		<option value="9">September</option>
		<option value="10">Oktober</option>
		<option value="11">November</option>
		<option value="12">Desember</option>
	</select>
	<input type="submit" name="" value="Submit" class="btn btn-primary">
</form>

<div id="divPemakaian">

</div>

<!-- SCRIPT -->
<script type="text/javascript">
	$('#tipe').change(function(){
		var tipe = $('#tipe').val();
		if (tipe == 1)
		{
			$('#bulan').removeAttr("hidden");
		}
		else
		{
			$('#bulan').attr("hidden", true);
			$('#tahun').removeAttr("hidden");
		}
	});

	$('#formPemakaian').submit(function(e){
		var url = "";
		var tipe = $('#tipe').val();
		if (tipe == 1)
			url = '/ajax/barang/showMonthly';
		else
			url = '/ajax/barang/showYearly';
		e.preventDefault();
	    $.ajax({
	        type: "GET",
	        url: url,
	        data: { 
	        	tahun: $('#tahun').val(),
	        	bulan: $('#bulan').val(),
	        	id_barang: {{$barang->id}}
	        }, 
	        success: function( data ) {
	        	$('#divPemakaian').html(data);
	        }
	    });
    });
</script>
@endsection