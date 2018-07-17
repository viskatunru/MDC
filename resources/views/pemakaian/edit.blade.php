@extends('master')

@section('content')
<h3>EDIT PEMAKAIAN</h3>

<div class="tab-content">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post">
			{{csrf_field()}}
			
			<div class="form-group">
				<label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
				
				<div class="col-sm-8">
					<input type="date" class="form-control1" id="tanggal" placeholder="" name="tanggal" value="{{date('Y-m-d', strtotime($pemakaian->tanggal))}}">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nama_dokter" class="col-sm-2 control-label">Nama Dokter</label>
				
				<div class="col-sm-8">
					<select name="id_dokter" id="nama_dokter">
						@foreach($dokters as $dokter)
							<option value="{{$dokter->id}}" @if($dokter->id == $pemakaian->dokter_id) selected @endif>{{$dokter->nama}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="cBoxBarang" class="col-sm-2 control-label">Nama Barang</label>
				
				<div class="col-sm-5">
					<select name="id_barang" id="cBoxBarang">
						@foreach($categories as $c)
							<optgroup label="{{$c->nama}}">
								@foreach($c->barangs as $barang)
									<option value="{{$barang->id}}">{{$barang->nama}}</option>
								@endforeach
							</optgroup>
						@endforeach
					</select>
				</div>
				
				<label class="col-sm-1 control-label" id="labelStok">Stok</label>
				
				<div class="col-sm-2">
					<select disabled class="form-control1" id=cBoxStok>
						@foreach($barangs as $barang)
							<option value="{{$barang->id}}" @if($barang->id == $pemakaian->barang_id) selected @endif>{{$barang->stok}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="jumlah" class="col-sm-2 control-label">Jumlah Pemakaian</label>
				
				<div class="col-sm-8">
					<input type="number" id="jumlah" class="form-control1" placeholder="" name="jumlah_barang" min="1">
				</div>
			</div>
			
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button type="submit" class="btn btn-primary btn-full">Kirim</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- SCRIPT -->
<script type="text/javascript">
	$('#nama_dokter').selectize({
	    sortField: 'text'
	});

	$('#cBoxBarang').selectize({
	    sortField: 'text'
	});

	$('#cBoxBarang').change(function(){
		$('#cBoxStok').val($('#cBoxBarang').val());
		var cBox = document.getElementById('cBoxStok');
		var stok = parseInt(cBox.options[cBox.selectedIndex].text); 
		if (stok < 1)
		{
			alert("Stok Habis.");
			$('#buttonSubmit').attr("disabled", true);
		}
		else
			$('#buttonSubmit').removeAttr("disabled");
	});
</script>
@endsection