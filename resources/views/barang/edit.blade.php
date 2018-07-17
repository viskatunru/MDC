@extends('master')

@section('content')
<h3>EDIT BARANG</h3>

<div class="tab-content">
    <div class="tab-pane active" id="horizontal-form">
        <form class="form-horizontal" method="post" action="#">
            {{csrf_field()}}

            <select id="seed_penyimpanan" hidden>
                @foreach($penyimpanans as $p)
                    <option value="{{$p->id}}" @if($p->id == $barang->penyimpanan_id) selected @endif>{{$p->nama}}</option>
                @endforeach
            </select>

            <input type="hidden" name="id_barang" value="{{$barang->id}}">
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
                    <select name="id_kategori" id="id_kategori">
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
                    <select name="id_penyimpanan" id="id_penyimpanan">
                        @foreach($penyimpanans as $p)
                            <option value="{{$p->id}}" @if($p->id == $barang->penyimpanan_id) selected @endif>{{$p->nama}}</option>
                        @endforeach
                    </select>
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

            <div class="form-group">
                <label for="harga_satuan" class="col-sm-2 control-label">Harga Satuan</label>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control1" id="harga_satuan" placeholder="" name="harga_satuan" value="{{$barang->harga_beli}}">
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
                <div class="panel panel-warning col-sm-10 col-sm-offset-1" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                    <div class="panel-body no-padding">
                        <table class="table table-striped" data-toggle="table" data-pagination="true" data-search="true" data-show-toggle="true" data-show-columns="true">
                            <thead>
                                <tr class="warning">
                                    <th data-sortable="true">Tanggal Expired</th>
                                    <th data-sortable="true">Stok Barang</th>
                                    <th data-sortable="true">Penyimpanan</th>
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
    var expires = {!! $barang->expires()->orderBy('tanggal')->get() !!};

    $('#id_kategori').selectize({
        sortField: 'text'
    });

    $('#id_penyimpanan').selectize({
        sortField: 'text'
    });

    function tambahExpire()
    {
        if($('#expire').val() != "")
        {
            var e = new Array();
            e['tanggal'] = $('#expire').val();
            e['jumlah'] = 1;

            expires.push(e);
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
            if (expires[i]['id'] != null)
                tr += "<input type='hidden' class='form-control1' name='id_" + i + "' value='" + expires[i]['id'] + "'></input>";

            tr += 
            "<tr>" +
                "<td><input type='date' class='form-control1' value='" + expires[i]['tanggal'] + "' required name='expire_" + i+ "'</td>" + 
                "<td><input type='number' class='form-control1' value='"+ expires[i]['jumlah'] + "' required name='jumlah_" + i + "'></td>" +
                "<td><select class='form-control1 cb_penyimpanan' id='penyimpanan_" + i + "' name='penyimpanan_"+ i + "'></select></td>";
            if (expires[i]['id'] == null)
                tr += "<td><a onclick='deleteExpire(" + i + ")' class='btn btn-delete'>Hapus</a></td>";
            else
                tr += "<td><a href='/barang/expire/delete/" + expires[i]['id'] + "' class='btn btn-delete'" +
                "onclick='return confirm(" + '"Apakah anda yakin?"' + ");'>Hapus Database</a></td>";
            "</tr>";
        }
        $('#tExpire').html(tr);
        $('.cb_penyimpanan').html($('#seed_penyimpanan').html());
        
        for (var i = 0; i < expires.length; i++)
        {
            $("#penyimpanan_" + i + " option").each(function()
            {
                if ($(this).val() == expires[i]['penyimpanan_id'])
                {
                    $(this).attr('selected', true);
                }
            });
        }
    }

    $(document).ready(function(){
        updateTable();
    });
</script>
@endsection