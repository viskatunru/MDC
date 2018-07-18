@extends('master')

@section('content')
<h3>DAFTAR PEMAKAIAN</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true" data-url="/pemakaian/json">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="id">ID</th>
					<th data-sortable="true" data-field="tanggal">Tanggal</th>
					<th data-sortable="true" data-field="nama_dokter">Nama Dokter</th>
					<th data-sortable="true" data-field="kode_barang">Kode Barang</th>
					<th data-sortable="true" data-field="nama_barang">Nama Barang</th>
					<th data-sortable="true" data-field="jumlah">Jumlah Pemakaian</th>
					<th data-field="id" data-formatter="LinkFormatter">Aksi</th>
				</tr>
			</thead>
			
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function LinkFormatter(value, row, index) {
		return "<a href='/pemakaian/edit/" + row['id'] + "' class='btn btn-primary'>Edit</a><br><a href='/pemakaian/delete/" + row['id'] + "' class='btn btn-delete' onclick='return confirm(\"Apakah anda yakin?\");'>Hapus</a>";
	}
</script>
@endsection