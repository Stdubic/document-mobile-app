@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('category.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'COMMENT CATEGORY', 'icon' => 'fa fa-ban', 'path' => 'category.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Order</th>
						<th>Protected</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($categories as $row)
					{
						?>
						<tr>
							<td>{{ $row->name }}</td>
							<td>{{ $row->order }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row->protected])</td>
							<td>@include('layouts.option_buttons', ['path' => route('category.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection