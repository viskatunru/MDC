@extends('master')

@section('content')
<h3>DAFTAR SUPPLIER</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true" data-url="/supplier/json">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="nama">Nama Supplier</th>
					<th data-sortable="true" data-field="alamat">Nama Supplier</th>
					<th data-sortable="true" data-field="nomor_telepon">Nama Supplier</th>
					<th data-sortable="true" data-field="email">Nama Supplier</th>
					<th data-sortable="true" data-field="nomor_rekening">Nama Supplier</th>
					<th>Tampilkan Semua Pembelian</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
@endsection