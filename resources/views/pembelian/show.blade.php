@extends('master')

@section('content')
<h3>PEMBELIAN DARI: Fondaco ({{date("d M Y", strtotime($pembelian->tanggal))}})</h3>
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped">
			<thead>
				<tr class="warning">
					<th>Kode Barang</th>
					<th>Nama Barang</th>
					<th>Jumlah Pembelian</th>
					<th>Expiry Date</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach($barangs as $barang)
				<tr>
					<td>{{$barang->kode}}</td>
					<td>{{$barang->nama}}</td>
					<td>{{$barang->pivot->jumlah}}</td>
					<td>{{ date("d M Y", strtotime($barang->expires()->where('pembelian_id', '=', $pembelian->id)->first()->tanggal)) }}</td>
					<td>
						<a class="btn btn-primary" href="/pembelian/barang/edit/{{$pembelian->id}}/{{$barang->id}}">Edit</a>
						<a class="btn btn-delete" href="" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection