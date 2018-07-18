@extends('master')

@section('content')
<h3>{{$barang->kode}} - {{$barang->nama}}</h3>

<div class="panel panel-red" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">

	<!-- Judul -->
	<div class="panel-heading">
		<h2>DAFTAR TANGGAL EXPIRED</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr class="warning">
					<th data-sortable="true">Nomor Invoice</th>
					<th data-sortable="true">Tanggal Expired</th>
					<th data-sortable="true">Jumlah</th>
					<th data-sortable="true">Penyimpanan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				@if (count($expires) > 0)
					@foreach($expires as $expire)
						<tr>
							<td>
								@if(isset($expire->pembelian))
								<u><a href="/pembelian/show/{{$expire->pembelian->id}}">{{$expire->pembelian->no_invoice}}</a></u>
								@else
								-
								@endif
							</td>
							<td>{{date("j F Y", strtotime($expire->tanggal))}}</td>
							<td>{{$expire->jumlah}}</td>
							<td>{{$expire->penyimpanan->nama}}</td>
							<td>
								<a href="/barang/edit/{{$barang->id}}" class="btn btn-primary">Edit</a>
								<!-- <a href="" class="btn btn-delete" onclick="return confirm('Apakah anda yakin?');">Hapus</a> -->
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-blue" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">

	<!-- Judul -->
	<div class="panel-heading">
		<h2>CEK LAPORAN PEMAKAIAN BULANAN</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding">
		<form id="formPemakaian">
			<!-- <select id="tipe">
				<option value="1">Bulan</option>
				<option value="2">Tahun</option>
			</select> -->

			<!-- <select id="tahun" class="form-control1" style="width: 100px">
				<option value="2017">2017</option>
				<option value="2018">2018</option>
			</select> -->

			<input type="number" name="tahun" id="tahun" min="2017" value="2018">

			<!-- <select id="bulan">
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
			</select> -->

			<button type="submit" class="btn btn-primary">Kirim</button>
		</form>

		<div id="divPemakaian">

		</div>
	</div>
</div>

<!-- SCRIPT -->
<script type="text/javascript">
	// $('#tipe').change(function(){
	// 	var tipe = $('#tipe').val();
	// 	if (tipe == 1)
	// 	{
	// 		$('#bulan').removeAttr("hidden");
	// 	}
	// 	else
	// 	{
	// 		$('#bulan').attr("hidden", true);
	// 		$('#tahun').removeAttr("hidden");
	// 	}
	// });

	$('#formPemakaian').submit(function(e){
		// var url = "";
		// var tipe = $('#tipe').val();
		// if (tipe == 1)
		// 	url = '/ajax/barang/showMonthly';
		// else
		// 	url = '/ajax/barang/showYearly';

		e.preventDefault();
	    $.ajax({
	        type: "GET",
	        url: "/ajax/barang/showYearly",
	        data: { 
	        	tahun: $('#tahun').val(),
	        	id_barang: {{$barang->id}}
	        }, 
	        success: function( data ) {
	        	$('#divPemakaian').html(data);
	        }
	    });
    });
</script>
@endsection