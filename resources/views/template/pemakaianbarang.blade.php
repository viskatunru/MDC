<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Bulan</th>
					<th>Jumlah Pemakaian</th>
				</tr>
			</thead>
			<tbody>
				@for($i = 1; $i <= 12; $i++)
					<tr>
						<td>{{date('F', strtotime("2018-$i-01"))}}</td>
						<td>{{$months[$i]}}</td>
					</tr>
				@endfor
			</tbody>
		</table>
	</div>
</div>