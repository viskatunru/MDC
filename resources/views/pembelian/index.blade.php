@extends('master')

@section('content')
<h3>DAFTAR PEMBELIAN</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true" data-url="/pembelian/json">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="id">ID</th>
					<th data-sortable="true" data-field="no_invoice">Nomor Invoice</th>
					<th data-sortable="true" data-field="tanggal">Tanggal</th>
					<th data-sortable="true" data-field="nama_supplier">Nama Supplier</th>
					<th data-sortable="true" data-field="harga_total">Harga Total</th>
					<th data-sortable="true" data-field="status">Status Pelunasan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			
			<tbody>
			</tbody>
		</table>
	</div>
</div>
@endsection