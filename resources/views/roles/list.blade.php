@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('roles.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Roles', 'icon' => 'fa fa-ban', 'path' => 'roles.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>View all records</th>
						<th>Users</th>
						<th>Created at</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($roles as $row)
					{
						?>
						<tr>
							<td>{{ $row->name }}</td>
							<td>{{ $row->view_all ? 'Yes' : 'No' }}</td>
							<td>{{ count($row->users) }}</td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>
							<td>@include('layouts.option_buttons', ['path' => route('roles.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection