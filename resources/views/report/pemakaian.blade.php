<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE HTML>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="description" content="Makassar Dental Care">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Logistik MDC</title>
		
		<!-- Stylesheet -->
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-table.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<style>
			body,
			html {
				background-color: #fff;
			}

			body {
				padding: 20px;
			}

			h3 {
				text-decoration: underline;
				text-transform: uppercase;
			}
		</style>
		
		<!-- Script -->
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/bootstrap-table.js"></script>
		
		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="/images/favicon/mdc-favicon.ico" />
		<link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
		<link rel="manifest" href="/images/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
	</head>
	
	<body>
		<div class="float-right">
			<a href="/pdf/dokter/stok?bulan={{$tahunInput}}-{{$bulanInput}}" target="_blank" class="btn btn-blue">Print Dokter</a>
			<a href="/pdf/ruangan/stok?bulan={{$tahunInput}}-{{$bulanInput}}" target="_blank" class="btn btn-primary">Print Ruangan</a>
		</div>

		<center><h3><b>Daftar Pemakaian Barang Bulan {{date('F Y', strtotime("$tahunInput-$bulanInput"))}}</h3></b></center>
		<br>

		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr>
					<th data-sortable="true">Kode</th>
					<th data-sortable="true">Nama</th>
					<th data-sortable="true">Stok Awal</th>
					<?php $jumlah = array(); ?>
					@foreach($dokters as $dokter)
						<th data-sortable="true">{{$dokter->nama}}</th>
						<?php $jumlah[$dokter->id] = 0; ?>
					@endforeach
					<th data-sortable="true">Total Pemakaian</th>
					<th data-sortable="true">Stok Akhir</th>
					<th data-sortable="true">Pengeluaran</th>
				</tr>
			</thead>
			<?php $totalPengeluaranBulanIni = 0; ?>
			<tbody>
				@foreach($barangs as $barang)
					<tr>
						<td><u><a href="/barang/show/{{$barang->id}}" target="_blank">{{$barang->kode}}</a></u></td>
						<td>{{$barang->nama}}</td>
						<td class="right">{{$barang->stokAwal}}</td>

						<?php $total = 0; $pengeluaranPerBarang = 0; $jumlahBarangTerhitung = 0;?>
						@foreach($pemakaiansBulanIni->where("barang_id", '=', $barang->id) as $pemakaian)							
							@foreach($pemakaian->expires as $e)
								@if($e->pembelian != "")
									<?php $jumlahBarangTerhitung += $e->pivot->jumlah; ?>
									<?php $pengeluaranPerBarang += $e->pivot->jumlah * $e->pembelian->barangs()->find($pemakaian->barang->id)->pivot->harga_satuan; ?>
								@endif
							@endforeach

							@foreach($dokters as $dokter)
								@if($dokter->id == $pemakaian->dokter_id)
									<?php $jumlah[$dokter->id] += $pemakaian->jumlah; ?>
								@endif
							@endforeach
						@endforeach
						@foreach($dokters as $dokter)
							<td class="right">
								<?php 
								if($jumlah[$dokter->id] > 0) 
									echo $jumlah[$dokter->id]; 
								else
									echo "-";
								$total += $jumlah[$dokter->id];
								$jumlah[$dokter->id] = 0; 
								?>
							</td>
						@endforeach
						<?php 
							$pengeluaranPerBarang = ($total - $jumlahBarangTerhitung) * $barang->harga_beli + $pengeluaranPerBarang; 
							$totalPengeluaranBulanIni += $pengeluaranPerBarang
						?>
						<td class="right">{{$total}}</td>
						<td class="right">{{$barang->stokAwal - $total}}</td>
						<td class="right">{{str_replace(',', '.', number_format($pengeluaranPerBarang))}}</td>
					</tr>
				@endforeach
			<tfoot>
				<tr>
					<td colspan="{{5+count($dokters)}}" style="border-right: 1px solid #ddd;"><b>Total Pengeluaran Bulan {{date('F Y', strtotime("$tahunInput-$bulanInput"))}}</b></td>
					<td class="right">{{str_replace(',', '.', number_format($totalPengeluaranBulanIni))}}</td>
				</tr>
			</tfoot>
			</tbody>
		</table>
	</body>
</html>