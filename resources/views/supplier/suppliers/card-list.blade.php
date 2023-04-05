<input type="hidden" id="card_count" name="card_count" value="{{count($cards)}}">
<ul class="list-group" id="cardListContent">
	@if(!empty($cards))
		@foreach($cards as $card)
			@php 
			$card_id = $card['id'];
			$exp_month = sprintf('%02d', $card['exp_month']);
			$exp_year = substr($card['exp_year'], 2);
			@endphp
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div>
					<div class="mb-2">
						<span class="font-weight-bold">{{$card['brand']}} &#8226;&#8226;&#8226;&#8226; {{$card['last4']}}</span>
						@if($card['default'] == 1)
							<span class="card-badge-default">Default</span>
						@elseif($card['exp_month'] < date('m') && $card['exp_year'] < date('Y'))
							<span class="card-badge-expired">Expired</span>
						@endif
					</div>
					<small>
						@if($card['exp_month'] < date('m') && $card['exp_year'] < date('Y'))
							Expired
						@else
							Expires
						@endif
						{{date("M", mktime(0, 0, 0, $card['exp_month'], 10))}} {{$card['exp_year']}}
					</small>
					<div class="card-action">
						<ul class="action-list">
							<li class="action-item">
								<a href="javascript:void(0);" onclick="editCard('{{$card_id}}','{{$exp_month}}','{{$exp_year}}');"><i class="icon-note icons"></i></a>
							</li>
							<li class="action-item">
								<a href="javascript:void(0);" onclick="deleteCard('{{$card_id}}');"><i class="icon-trash icons"></i></a>
							</li>
							<li class="action-item-last">
								<div class="dropdown show" >
									<a class="dropdown-toggle more-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options icons"></i></a>

									<div class="dropdown-menu more-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item text-muted">Action</a>
										<a class="dropdown-item text-primary" href="javascript:void(0);" onclick="setDefaultCard('{{$card_id}}');">Set as Default</a>
										<a class="dropdown-item text-success" href="javascript:void(0);" onclick="editCard('{{$card_id}}','{{$exp_month}}','{{$exp_year}}');">Edit</a>
										<a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteCard('{{$card_id}}');">Delete</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</li>
		@endforeach
	@else
		<li class="list-group-item">No Cards Found.</li>
	@endif
</ul>