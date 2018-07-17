@extends('master')

@section('content')
<h3>PEMBELIAN ({{$pembelian->no_invoice}}): {{$pembelian->supplier->nama}} ({{date("j F Y", strtotime($pembelian->tanggal))}}) : </h3>
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped">
			<center><h4>Daftar Pembelian Barang</h4></center>
			<thead>
				<tr class="warning">
					<th>Kode</th>
					<th>Nama</th>
					<th>Jumlah</th>
					<th>Tanggal Expired</th>
					<th>Penyimpanan</th>
					<th>Harga Satuan</th>
					<th>Harga Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($barangs as $barang)
				<tr>
					<td><u><a href="/barang/show/{{$barang->id}}">{{$barang->kode}}</a></u></td>
					<td>{{$barang->nama}}</td>
					<td>{{$barang->pivot->jumlah}}</td>
					<td>
						@if($barang->expires()->where('pembelian_id', '=', $pembelian->id)->first() !== null)
						{{ date("j F Y", strtotime($barang->expires()->where('pembelian_id', '=', $pembelian->id)->first()->tanggal)) }}
						@else
						Tidak memiliki tanggal expired.
						@endif
					</td>
					<td>{{$barang->penyimpanan->nama}}</td>
					<td>{{$barang->pivot->harga_satuan}}</td>
					<td>{{$pembelian->harga_total}}</td>
					<td>
						<a class="btn btn-primary" href="/pembelian/barang/edit/{{$pembelian->id}}/{{$barang->id}}">Edit</a>
						<a class="btn btn-delete" href="/pembelian/barang/delete/{{$pembelian->id}}/{{$barang->pivot->id}}" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection