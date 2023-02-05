@php
	if(old('description')){
		$description = (object)old('description');
	}else if($membership->description!=''){
		$description = $membership->description;
	}
@endphp
@foreach($features as $key => $feature)
	@if($feature['type'] == 'array')
		<div class="form-group row">
			<label for="input-11" class="col-sm-12 col-form-label">{{$feature['label']}}</label>
		</div>
		@foreach($feature['values'] as $key2 => $license)
			<div class="form-group row">
				<label for="input-11" class="col-sm-2 col-form-label">{{$license['label']}}</label>
				<div class="col-sm-10">
					@if($license['type'] == 'select')
						<select class="form-control" name="features[{{$key}}][{{$key2}}]">
							<option value="">-- Select --</option>
							@foreach($license['values'] as $value)
								@php $slctd = (array_key_exists($key2,(array)$description->$key) && $description->$key->$key2 == $value ? 'selected="selected"' : ''); @endphp
								<option value="{{$value}}" {{$slctd}}>{{$value}}</option>
							@endforeach
						</select>
					@elseif($license['type'] == 'checkbox')
						@foreach($license['values'] as $value)
							@php $chkd = (array_key_exists($key2,(array)$description->$key) && $description->$key->$key2 == $value ? 'checked="checked"' : ''); @endphp
							<input type="checkbox" name="features[{{$key}}][{{$key2}}]" value="{{$value}}" {{$chkd}}> {{$value}}
						@endforeach
					@endif
				</div>
			</div>
		@endforeach
	@else
		<div class="form-group row">
			<label for="input-11" class="col-sm-2 col-form-label">{{$feature['label']}}</label>
			<div class="col-sm-10">
				@if($feature['type'] == 'select')
					<select class="form-control" name="features[{{$key}}]">
						<option value="">-- Select --</option>
						@foreach($feature['values'] as $value)
							@php $slctd = (array_key_exists($key,(array)$description) && $description->$key == $value ? 'selected="selected"' : ''); @endphp
							<option value="{{$value}}" {{$slctd}}>{{$value}}</option>
						@endforeach
					</select>
				@elseif($feature['type'] == 'checkbox')
					@foreach($feature['values'] as $value)
						@php $chkd = (array_key_exists($key,(array)$description) && $description->$key == $value ? 'checked="checked"' : ''); @endphp
						<input type="checkbox" name="features[{{$key}}]" value="{{$value}}" {{$chkd}}> {{$value}}
					@endforeach
				@endif
			</div>
		</div>	
	@endif
@endforeach