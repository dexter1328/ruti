@extends('vendor.layout.main')
@section('content')
@if(session()->get('success'))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<div class="alert-icon">
			<i class="fa fa-check"></i>
		</div>
		<div class="alert-message">
			<span><strong>Success!</strong> {{ session()->get('success') }}</span>
		</div>
	</div>
@endif
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="left"><span>Checklist</span></div>
			</div>
			<div class="card-body">
				<div class="progress" style="height: auto;">
					<div class="progress-bar bg-success" style="width: {{$data['percentage']}}%;">
						<span class="progress-value">{{$data['percentage']}}%</span>
					</div>
				</div>
				<table class="table table-bordered dataTable">
					<tr>
						<th style="height: 50px;">Module</th>
						<th class="text-center" style="height: 50px;">Completed</th>
					</tr>
					@foreach($data['checklist'] as $item)
						<tr>
							<td style="height: 50px;">{{$item['title']}}</td>
							<td class="text-center" style="height: 50px;">
								@if($item['is_completed'] == 'no')
									<a href="{{$item['url']=='' ? 'javascript:void(0)' : $item['url']}}">UPDATE</a>
								@else
									<span style="font-size: 30px; color: green;">&check;</span>
								@endif
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
<!--End Row--> 

@endsection 

