<!-- Isi -->
<div class="scrollbar" id="style-2">
	@if(count($expires) > 0)
		@foreach($expires as $e)
			<div class="activity-row">
				<div class="col-xs-12 activity-desc">
				<h5><a href="/barang/show/{{$e->barang->id}}">{{$e->barang->nama}}</a></h5>
					<p>Tanggal: {{date('j F Y', strtotime($e->tanggal))}}</p>
					<p>Stok Expired: {{$e->jumlah}}</p>
				</div>
				<div class="clearfix"></div>
			</div>
		@endforeach
	@else
		Tidak ada barang expired hari ini.
	@endif
</div>