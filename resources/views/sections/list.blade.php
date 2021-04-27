@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('sections.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Sections', 'icon' => 'fa fa-ban', 'path' => 'sections.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Document</th>
						<th>Date</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php
							//dd($sections);
					foreach($sections as $row)
					{
						?>
						<tr>
							<td>{{ $row->title }}</td>
							<td>{{ $row->document['title'] }}</td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>
							<td>@include('layouts.option_buttons', ['path' => route('sections.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection