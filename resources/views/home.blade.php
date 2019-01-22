@extends('master')

@section('content')
<h3>BERANDA</h3>

<!-- WIDGET -->
<div class="col_1">
	
	<!-- Kalender -->
	<!-- <div class="col-md-4 span_7">	
		<div class="cal1 cal_2"><div class="clndr"><div class="clndr-controls"><div class="clndr-control-button"><p class="clndr-previous-button">previous</p></div><div class="month">July 2015</div><div class="clndr-control-button rightalign"><p class="clndr-next-button">next</p></div></div><table class="clndr-table" border="0" cellspacing="0" cellpadding="0"><thead><tr class="header-days"><td class="header-day">S</td><td class="header-day">M</td><td class="header-day">T</td><td class="header-day">W</td><td class="header-day">T</td><td class="header-day">F</td><td class="header-day">S</td></tr></thead><tbody><tr><td class="day adjacent-month last-month calendar-day-2015-06-28"><div class="day-contents">28</div></td><td class="day adjacent-month last-month calendar-day-2015-06-29"><div class="day-contents">29</div></td><td class="day adjacent-month last-month calendar-day-2015-06-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-01"><div class="day-contents">1</div></td><td class="day calendar-day-2015-07-02"><div class="day-contents">2</div></td><td class="day calendar-day-2015-07-03"><div class="day-contents">3</div></td><td class="day calendar-day-2015-07-04"><div class="day-contents">4</div></td></tr><tr><td class="day calendar-day-2015-07-05"><div class="day-contents">5</div></td><td class="day calendar-day-2015-07-06"><div class="day-contents">6</div></td><td class="day calendar-day-2015-07-07"><div class="day-contents">7</div></td><td class="day calendar-day-2015-07-08"><div class="day-contents">8</div></td><td class="day calendar-day-2015-07-09"><div class="day-contents">9</div></td><td class="day calendar-day-2015-07-10"><div class="day-contents">10</div></td><td class="day calendar-day-2015-07-11"><div class="day-contents">11</div></td></tr><tr><td class="day calendar-day-2015-07-12"><div class="day-contents">12</div></td><td class="day calendar-day-2015-07-13"><div class="day-contents">13</div></td><td class="day calendar-day-2015-07-14"><div class="day-contents">14</div></td><td class="day calendar-day-2015-07-15"><div class="day-contents">15</div></td><td class="day calendar-day-2015-07-16"><div class="day-contents">16</div></td><td class="day calendar-day-2015-07-17"><div class="day-contents">17</div></td><td class="day calendar-day-2015-07-18"><div class="day-contents">18</div></td></tr><tr><td class="day calendar-day-2015-07-19"><div class="day-contents">19</div></td><td class="day calendar-day-2015-07-20"><div class="day-contents">20</div></td><td class="day calendar-day-2015-07-21"><div class="day-contents">21</div></td><td class="day calendar-day-2015-07-22"><div class="day-contents">22</div></td><td class="day calendar-day-2015-07-23"><div class="day-contents">23</div></td><td class="day calendar-day-2015-07-24"><div class="day-contents">24</div></td><td class="day calendar-day-2015-07-25"><div class="day-contents">25</div></td></tr><tr><td class="day calendar-day-2015-07-26"><div class="day-contents">26</div></td><td class="day calendar-day-2015-07-27"><div class="day-contents">27</div></td><td class="day calendar-day-2015-07-28"><div class="day-contents">28</div></td><td class="day calendar-day-2015-07-29"><div class="day-contents">29</div></td><td class="day calendar-day-2015-07-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-31"><div class="day-contents">31</div></td><td class="day adjacent-month next-month calendar-day-2015-08-01"><div class="day-contents">1</div></td></tr></tbody></table></div></div>
	</div> -->
	
	<!-- Expire Hari Ini -->
	<div class="col-md-4 span_8">
		<div class="activity_box">
			
			<!-- Judul -->
			<div class="panel-heading" id="panel-heading-red">
				<h4 class="panel-title panel-title-home">EXPIRED DALAM 1 BULAN</h4>
			</div>

			<div class="divActivityBox" id="divExpireBulanIni">
			</div>		
		</div>
	</div>
	
	<!-- Expire 3 Bulan -->
	<div class="col-md-4 span_8">
		<div class="activity_box">
		
			<!-- Judul -->
			<div class="panel-heading" id="panel-heading-blue">
				<h4 class="panel-title panel-title-home">EXPIRED DALAM 3 BULAN</h4>
			</div>
		
			<div class="divActivityBox" id="divExpireTigaBulan">
			</div>
		</div>
	</div>

	<!-- Expire 6 Bulan -->
	<div class="col-md-4 span_8">
		<div class="activity_box">
		
			<!-- Judul -->
			<div class="panel-heading" id="panel-heading-green">
				<h4 class="panel-title panel-title-home">EXPIRED DALAM 6 BULAN</h4>
			</div>
		
			<div id="divExpireEnamBulan">
			</div>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
</div>

<!-- TABEL BARANG -->
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	
	<!-- Judul -->
	<div class="panel-heading">
		<h2>Daftar Pemakaian Barang {{date('j F Y')}}</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true" data-url="/ajax/pemakaian/harian">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="kode">Kode</th>
					<th data-sortable="true" data-field="nama">Nama</th>
					<th data-sortable="true" data-field="kategori">Kategori</th>
					
					@foreach($dokters as $dokter)
						<th data-sortable="true" data-field="dokter_{{$dokter->id}}">{{$dokter->nama}}</th>
					@endforeach
					
					<th data-sortable="true" data-field="stok">Stok Saat Ini</th>
				</tr>
			</thead>
			
			<tbody>

			</tbody>
		</table>
	</div>
</div>

<!-- CEK EXPIRE -->
<div class="panel panel-red" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	
	<!-- Judul -->
	<div class="panel-heading">
		<h2>CEK EXPIRED</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding" style="display: block;">
		<form method="get" id="formHariExpire">
			<h4 id="hariExpire">Expired dalam berapa hari?</h4>
			<input type="number" name="hari" id="inputHari" min="0" value="0">
			<button type="submit" class="btn btn-primary">Kirim</button>
		</form>

		<br>

		<div id="barangByExpireDiv">
			
		</div>
	</div>
</div>

<!-- CEK STOK AWAL -->
<div class="panel panel-blue col-md-4" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	
	<!-- Judul -->
	<div class="panel-heading">
		<h2>CEK STOK AWAL</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding" style="display: block;">
		<form method="post" action="/bulan/generate" target="_blank">
			{{csrf_field()}}
			<input type="month" name="bulan" value="<?=date('Y-m')?>">
			<button type="submit" class="btn btn-primary">Kirim</button>
		</form>
	</div>
</div>

<!-- LAPORAN PEMAKAIAN BULANAN -->
<div class="panel panel-green col-md-4" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	
	<!-- Judul -->
	<div class="panel-heading">
		<h2>LAPORAN BULANAN</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding" style="display: block;">
		<form method="get" action="/laporan/stok" target="_blank">
			<input type="month" name="bulan" value="<?=date('Y-m')?>">
			<button type="submit" class="btn btn-primary">Kirim</button>
		</form>
	</div>
</div>

<!-- LAPORAN PEMAKAIAN TAHUNAN -->
<div class="panel panel-yellow col-md-4" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	
	<!-- Judul -->
	<div class="panel-heading">
		<h2>LAPORAN TAHUNAN</h2>
		<div class="panel-ctrls" data-actions-container="" data-action-collapse="{&quot;target&quot;: &quot;.panel-body&quot;}"><span class="button-icon has-bg"><i class="ti ti-angle-down"></i></span></div>
	</div>
	
	<!-- Isi -->
	<div class="panel-body no-padding" style="display: block;">
		<form method="get" action="/laporan/stok/tahunan" target="_blank">
			<input type="number" name="tahun" value="<?=date('Y')?>">
			<button type="submit" class="btn btn-primary">Kirim</button>
		</form>
	</div>
</div>

<!-- STYLESHEET / SCRIPT -->
<link rel="stylesheet" type="text/css" href="css/clndr.css">
<script type="text/javascript" src="js/underscore-min.js"></script>
<script type="text/javascript" src= "js/moment-2.2.1.js"></script>
<script type="text/javascript" src="js/clndr.js"></script>
<script type="text/javascript" src="js/site.js"></script>
<script type="text/javascript">
	$('#formHariExpire').submit(function(e){
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: "/ajax/barangByExpiryDate",
			data: { 
			tanggal: $('#inputHari').val()
			}, 
			success: function( msg ) 
			{
				$('#barangByExpireDiv').html(msg);
			}
		});
	});
	$(document).ready(function(){
		$.ajax({
			type: "GET",
			url: "/ajax/expire/tigabulan",
			success: function( msg ) {
				$('#divExpireTigaBulan').html(msg);
			}
		});
		$.ajax({
			type: "GET",
			url: "/ajax/expire/enambulan",
			success: function( msg ) {
				$('#divExpireEnamBulan').html(msg);
			}
		});
		$.ajax({
			type: "GET",
			url: "/ajax/expire/bulanini",
			success: function( msg ) 
			{
				$('#divExpireBulanIni').html(msg);
			}
		});
	});
</script>
@endsection