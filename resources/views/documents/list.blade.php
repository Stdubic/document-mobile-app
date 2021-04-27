@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('documents.remove-multi')
	],
    [
        'type' => 'activate',
        'action' => route('documents.activate')
    ],
    [
        'type' => 'deactivate',
        'action' => route('documents.deactivate')
    ]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Documents', 'icon' => 'fa fa-ban', 'path' => 'documents.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Date</th>
						<th>Protected</th>
						<th>Active</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($documents as $row)
					{
						?>
						<tr>
							<td>{{ $row->title }}</td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>
							<td>@include('layouts.bool_badge', ['value' => $row->protected])</td>
							<td>@include('layouts.bool_badge', ['value' => $row->active])</td>
							<td>@include('layouts.option_buttons', ['path' => route('documents.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection