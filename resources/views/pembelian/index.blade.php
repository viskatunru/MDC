@extends('master')

@section('content')
<h3>DAFTAR PEMBELIAN</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr class="warning">
					<th data-sortable="true">ID</th>
					<th data-sortable="true">Tanggal</th>
					<th data-sortable="true">Nama Supplier</th>
					<th data-sortable="true">Harga Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($pembelians as $pembelian)
					<tr>
						<td>{{$pembelian->id}}</td>
						<td>{{date('j F Y', strtotime($pembelian->tanggal))}}</td>
						<td><u><a href="/supplier/show/{{$pembelian->supplier->id}}">{{$pembelian->supplier->nama}}</a></u></td>
						<td>{{$pembelian->harga_total}}</td>
						<td>
							<a href="/pembelian/show/{{$pembelian->id}}" class="btn btn-primary">Tampilkan Detail</a>
							<a href="/pembelian/edit/{{$pembelian->id}}" class="btn btn-primary">Edit</a>
							<a href="/pembelian/delete/{{$pembelian->id}}" class="btn btn-delete" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection