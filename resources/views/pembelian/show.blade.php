@extends('master')

@section('content')
<h3>PEMBELIAN DARI: {{$pembelian->supplier->nama}} ({{$pembelian->no_invoice}} - {{date("j F Y", strtotime($pembelian->tanggal))}})</h3>
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr class="warning">
					<th data-sortable="true">Kode</th>
					<th data-sortable="true">Nama</th>
					<th data-sortable="true">Jumlah</th>
					<th data-sortable="true">Harga Satuan</th>
					<th data-sortable="true">Harga Total</th>
					<th data-sortable="true">Tanggal Expired</th>
					<th data-sortable="true">Penyimpanan</th>
					<!-- <th>Aksi</th> -->
				</tr>
			</thead>
			<tbody>
				@foreach($barangs as $barang)
				<tr>
					<td><u><a href="/barang/show/{{$barang->id}}">{{$barang->kode}}</a></u></td>
					<td>{{$barang->nama}}</td>
					<td class="right">{{$barang->pivot->jumlah}}</td>
					<td class="right">{{str_replace(',', '.', number_format($barang->pivot->harga_satuan))}}</td>
					<td class="right">{{str_replace(',', '.', number_format($pembelian->harga_total))}}</td>
					<td>
						@if($barang->expires()->where('pembelian_id', '=', $pembelian->id)->first() !== null)
						{{ date("j F Y", strtotime($barang->expires()->where('pembelian_id', '=', $pembelian->id)->first()->tanggal)) }}
						@else
						Tidak memiliki tanggal expired.
						@endif
					</td>
					<td>{{$barang->penyimpanan->nama}}</td>
					<!-- <td>
						<a class="btn btn-primary" href="/pembelian/barang/edit/{{$pembelian->id}}/{{$barang->id}}">Edit</a>
						<a class="btn btn-delete" href="/pembelian/barang/delete/{{$pembelian->id}}/{{$barang->pivot->id}}" onclick="return confirm('Apakah anda yakin?');">Hapus</a>

						<a class="btn btn-primary" href="/pembelian/edit/{{$pembelian->id}}">Edit</a>
					</td> -->
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection