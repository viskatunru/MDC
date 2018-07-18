@extends('master')

@section('content')
<h3>DAFTAR SUPPLIER</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="nama">Nama Supplier</th>
					<th data-sortable="true" data-field="nomor_rekening">Nomor Rekening</th>
					<th data-sortable="true" data-field="nomor_telepon">Nomor Telepon</th>
					<th data-sortable="true" data-field="email">Email</th>
					<th data-sortable="true" data-field="alamat">Alamat</th>
					<th>Tampilkan Semua Pembelian</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				@foreach($suppliers as $supplier)
					<tr>
						<td>{{$supplier->nama}}</td>
						<td>{{$supplier->nomor_rekening}}</td>
						<td>{{$supplier->nomor_telepon}}</td>
						<td>{{$supplier->email}}</td>
						<td>{{$supplier->alamat}}</td>
						<td><a href="/supplier/show/{{$supplier->id}}" class="btn btn-blue">Tampilkan</a></td>
						<td>
							<a href="/supplier/edit/{{$supplier->id}}" class="btn btn-primary">Edit</a>
							<a href="/supplier/delete/{{$supplier->id}}" class="btn btn-delete" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection