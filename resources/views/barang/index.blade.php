@extends('master')

@section('content')
<h3>DAFTAR BARANG</h3>

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true" data-url="/barang/json">
			<thead>
				<tr class="warning">
					<th data-sortable="true" data-field="kode">Kode</th>
					<th data-sortable="true" data-field="nama">Nama</th>
					<th data-sortable="true" data-field="namakategori">Kategori</th>
					<th data-sortable="true" data-field="namapenyimpanan">Penyimpanan</th>
					<th data-sortable="true" data-field="stok">Stok Saat Ini</th>
					<th data-field="harga_beli">Harga Satuan</th>
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
		return "<a href='/barang/show/" + row['id'] + "' class='btn btn-blue'>Tampilkan</a><br><a href='/barang/edit/" + row['id'] + "' class='btn btn-primary'>Edit</a><br><a href='/barang/delete/" + row['id'] + "' class='btn btn-delete' onclick='return confirm(\"Apakah anda yakin?\");'>Hapus</a>";
	}
</script>
@endsection