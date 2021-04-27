@extends('layouts.master')

<?php

$actions = [
	[
		'type' => 'remove',
		'action' => route('terms.remove-multi')
	]
];

?>

@section('content')
	@include('layouts.list_header', ['title' => 'TERMS OF USE', 'icon' => 'fa fa-ban', 'path' => 'terms.add', 'actions' => $actions])
	<div class="m-portlet__body">
		<div class="table-responsive">
			<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
				<thead>
					<tr>
						<th>Title</th>
						<th>Created at</th>
						<th>@include('layouts.options_column_header')</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php

					foreach($terms as $row)
					{
						?>
						<tr>
							<td>{{ $row->title }}</td>
							<td>{{ $row->created_at->format(setting('date_format')) }}</td>
							<td>@include('layouts.option_buttons', ['path' => route('terms.edit', $row->id), 'value' => $row->id])</td>
						</tr>
						<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
@endsection