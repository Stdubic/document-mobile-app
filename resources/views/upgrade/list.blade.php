@extends('layouts.master')

<?php

$actions = [
    [
        'type' => 'remove',
        'action' => route('upgrade.remove-multi')
    ],
    [
        'type' => 'activate',
        'action' => route('upgrade.activate')
    ],
    [
        'type' => 'deactivate',
        'action' => route('upgrade.deactivate')
    ]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Upgrade requests', 'icon' => 'fa fa-users', 'path' => 'upgrade.list', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Surname</th>
					<th>Email</th>
					<th>Created at</th>
					<th>Processed</th>
					<th>@include('layouts.options_column_header')</th>
				</tr>
				</thead>
				<tbody align="center">
                <?php

                foreach($users as $row)
                {
                ?>
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ $row->user->name }}</td>
					<td>{{ $row->user->surname }}</td>
					<td>{{ $row->user->email }}</td>
					<td>{{ $row->created_at->format(setting('date_format')) }}</td>
					<td>@include('layouts.bool_badge', ['value' => $row->active])</td>
					<td>@include('layouts.option_buttons', ['path' => route('upgrade.list', $row->id), 'value' => $row->id])</td>
				</tr>
                <?php
                }

                ?>
				</tbody>
			</table>
		</div>
	</div>
@endsection