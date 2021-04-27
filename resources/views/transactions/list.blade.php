@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('transactions.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'USER TRANSACTIONS', 'icon' => 'fa fa-ban', 'path' => 'transactions.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Surname</th>
						<th>Expiry date</th>
						<th>Upgraded</th>
						<th>Pay Pal</th>
						<th>Created at</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($transactions as $row)
					{
						?>
						<tr>
							<td>{{ $row['user']['name'] }}</td>
							<td>{{ $row['user']['surname'] }}</td>
							<td>{{ $row['expiry_time'] }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row['expired']])</td>
							<td>@include('layouts.bool_badge', ['value' => $row['paypal']])</td>
							<td>{{ $row['created_at'] }}</td>
							<td>@include('layouts.option_buttons', ['path' => route('transactions.list', $row['id']), 'value' => $row['id']])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection