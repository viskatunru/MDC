@extends('master')

@section('content')
<h3>TAMBAH SUPPLIER BARU</h3>

<div class="tab-content">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post" action="#">
		    {{csrf_field()}}
		    
			<div class="form-group">
				<label for="nama_supplier" class="col-sm-2 control-label">Nama Supplier</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="nama_supplier" placeholder="" name="nama_supplier">
				</div>
			</div>
			
			<div class="form-group">
				<label for="alamat" class="col-sm-2 control-label">Alamat</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="alamat" placeholder="" name="alamat">
				</div>
			</div>
			
			<div class="form-group">
				<label for="nomor_telepon" class="col-sm-2 control-label">Nomor Telepon</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="nomor_telepon" placeholder="" name="nomor_telepon">
				</div>
			</div>
			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-8">
					<input type="email" class="form-control1" id="email" placeholder="" name="email">
				</div>
			</div>

			<div class="form-group">
				<label for="nomor_rekening" class="col-sm-2 control-label">Nomor Rekening</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="nomor_rekening" placeholder="" name="nomor_rekening">
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
@endsection