@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('filteroptions.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'FILTER OPTIONS', 'icon' => 'fa fa-ban', 'path' => 'filteroptions.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Filter</th>
						<th>Order</th>
						<th>Created at</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($filter_options as $row)
					{
						?>
						<tr>
							<td>{{ $row->title }}</td>
							<td>{{$filters[$row->filter_id]->title}}</td>
							<td>{{ $row->order }}</td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>

							<td>@include('layouts.option_buttons', ['path' => route('filteroptions.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection