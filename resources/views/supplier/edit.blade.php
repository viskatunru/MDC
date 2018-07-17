@extends('master')

@section('content')
<h3>EDIT SUPPLIER ({{$supplier->nama}})</h3>

<div class="tab-content">
	<div class="tab-pane active" id="horizontal-form">
		<form class="form-horizontal" method="post" action="#">
		    {{csrf_field()}}
		    
			<div class="form-group">
				<label for="nama_supplier" class="col-sm-2 control-label">Nama Supplier</label>
				<div class="col-sm-8">
					<input type="text" class="form-control1" id="nama_supplier" placeholder="" name="nama_supplier" value="{{$supplier->nama}}">
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