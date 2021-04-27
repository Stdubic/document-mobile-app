@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('users.remove-multi')
	],
	[
		'type' => 'activate',
		'action' => route('users.activate')
	],
	[
		'type' => 'deactivate',
		'action' => route('users.deactivate')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Users', 'icon' => 'fa fa-users', 'path' => 'users.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>E-mail</th>
						<th>Role</th>
						<th>User since</th>
						<th>Active</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($users as $row)
					{
						?>
						<tr>
							<td>{{ $row->name }}</td>
							<td><a href="mailto:{{ $row->email }}" class="m-link">{{ $row->email }}</a></td>
							<td><a href="{{ route('roles.edit', $row->role_id) }}" class="m-link">{{ $row->role->name }}</a></td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row->active])</td>
							<td>@include('layouts.option_buttons', ['path' => route('users.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection