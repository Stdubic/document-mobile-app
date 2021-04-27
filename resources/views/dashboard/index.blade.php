@extends('layouts.master')

@section('content')
	@include('layouts.list_header', ['title' => 'Dashboard', 'icon' => 'fa fa-chart-line'])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
			</li>
			<li class="nav-item m-tabs__item" onclick="updateGraphs();">
				<a href="#btabs-graphs" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-chart-line"></i> Charts</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="btabs-basic" role="tabpanel">
			</div>
			<div class="tab-pane" id="btabs-graphs" role="tabpanel">
			</div>
		</div>
	</div>
@endsection
