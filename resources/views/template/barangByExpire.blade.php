<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
	<thead>
		<tr>
			<th data-sortable="true">Kode Barang</th>
			<th data-sortable="true">Nama Barang</th>
			<th data-sortable="true">Tanggal Expired</th>
			<th data-sortable="true">Stok Expired</th>
			<th data-sortable="true">Lokasi</th>
		</tr>
	</thead>
	<tbody>
		@foreach($expires as $expire)
		<tr>
			<td>{{$expire->barang->kode}}</td>
			<td>{{$expire->barang->nama}}</td>
			<td>{{$expire->tanggal}}</td>
			<td>{{$expire->jumlah}}</td>
			<td>{{$expire->penyimpanan->nama}}</td>
		</tr>
		@endforeach
	</tbody>
</table>