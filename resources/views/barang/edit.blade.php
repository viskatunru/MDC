@extends('master')

@section('content')
<h3>EDIT BARANG</h3>

<div class="tab-content">
    <div class="tab-pane active" id="horizontal-form">
        <form class="form-horizontal" method="post" action="#">
            {{csrf_field()}}
            
            <div class="form-group">
                <label for="kode_barang" class="col-sm-2 control-label">Kode Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="kode_barang" placeholder="" name="kode_barang" value="{{$barang->kode}}">
                </div>
            </div>

            <div class="form-group">
                <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="nama_barang" placeholder="" name="nama_barang"
                    value="{{$barang->nama}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_kategori" class="col-sm-2 control-label">Kategori Barang</label>
                
                <div class="col-sm-8">
                    <select name="id_kategori" id="id_kategori" class="form-control1">
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" @if($category->id == $barang->category_id) selected @endif>{{$category->nama}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-sm-2">
				    <a class="btn btn-primary" href="/category/add">+</a>
				</div>
			</div>

            <div class="form-group">
                <label for="lokasi_barang" class="col-sm-2 control-label">Penyimpanan Barang</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="lokasi_barang" placeholder="" name="lokasi_barang" value="{{$barang->penyimpanan->nama}}">
                </div>

                <div class="col-sm-2">
                    <a class="btn btn-primary" href="/penyimpanan/add">+</a>
                </div>
            </div>

            <div class="form-group">
                <label for="stok_barang" class="col-sm-2 control-label">Stok Total Barang</label>
                
                <div class="col-sm-8">
                    <input type="number" class="form-control1" id="stok_barang" placeholder="" name="stok_barang" value="{{$barang->stok}}" min="0">
                </div>
            </div>

            <hr>

            <div class="form-group">
                <label for="expire" class="col-sm-2 control-label">Tanggal Expired</label>
                
                <div class="col-sm-8">
                    <input type="date" class="form-control1" id="expire" placeholder="" name="expiry_date" min="0">
                </div>

                <div class="col-sm-2">
                    <a class="btn btn-primary" href="#" onclick="tambahExpire()">+</a>
                </div>

                <div class="panel panel-warning col-sm-8 col-sm-offset-2" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                    <div class="panel-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr class="warning">
                                    <th>Tanggal Expired</th>
                                    <th>Stok Barang</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tExpire">
                                
                            </tbody>
                        </table>
                    </div>
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

<script type="text/javascript">
    var expires = {!! $barang->expires !!};
    function tambahExpire()
    {
        if($('#expire').val() != "")
        {
            expires.push($('#expire').val());
            updateTable();
        }
        else
            alert("Tanggal expired tidak boleh kosong.");
    }

    function deleteExpire($id)
    {
        expires.splice($id, 1);
        updateTable();
    }

    function updateTable()
    {
        var tr = "";
        for (var i = 0; i < expires.length; i++)
        {
            tr += 
            "<tr><input type='hidden' class='form-control1' value='" + expires[i]['id'] + "'></input>" +
                "<td><input type='date' class='form-control1' value='" + expires[i]['tanggal'] + "' required name='expire_" + i+ "'</td>" + 
                "<td><input type='number' class='form-control1' value='"+ expires[i]['jumlah'] + "' required name='jumlah_" + i + "'></td>" +
                "<td><a onclick='deleteExpire(" + i + ")' class='btn btn-delete'>Hapus</a></td>" + 
            "</tr>";
        }
        $('#tExpire').html(tr);
    }

    $(document).ready(function(){
        updateTable();
    });
</script>
@endsection