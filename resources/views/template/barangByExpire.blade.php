<table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
	<thead>
		<tr>
			<th data-sortable="true">Kode</th>
			<th data-sortable="true">Nama</th>
			<th data-sortable="true">Tanggal Expired</th>
			<th data-sortable="true">Stok Expired</th>
			<th data-sortable="true">Penyimpanan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($expires as $expire)
		<tr>
			<td><u><a href="/barang/show/{{$expire->barang->id}}">{{$expire->barang->kode}}</a></u></td>
			<td>{{$expire->barang->nama}}</td>
			<td>{{date('j F Y', strtotime($expire->tanggal))}}</td>
			<td>{{$expire->jumlah}}</td>
			<td>{{$expire->penyimpanan->nama}}</td>
		</tr>
		@endforeach
	</tbody>
</table>