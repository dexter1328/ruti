@extends('admin.layout.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-trophy"></i> --><span>Add Reward Point</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{ route('reward_points.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="input-10" class="col-sm-2 col-form-label">Reward Types<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="input-7" name="reward_type" value="{{old('reward_type')}}">
                                    <option value="">Select Type</option>
                                    <option value="invite" @if(old('reward_type')=='invite' ) selected="selected" @endif>Invite</option>
                                    <option value="transaction" @if(old('reward_type')=='transaction' ) selected="selected" @endif>Transaction</option>
                                </select>
                                @if ($errors->has('reward_type'))
                                <span class="text-danger">{{ $errors->first('reward_type') }}</span>
                                @endif
                            </div>
                            <label for="input-11" class="col-sm-2 col-form-label">Reward Points<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="input-12" name="reward_points" value="{{old('reward_points')}}" placeholder="RewardPoints">
                                @if ($errors->has('reward_points'))
                                <span class="text-danger">{{ $errors->first('reward_points') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                        	<!-- <label for="input-12" class="col-sm-2 col-form-label">End Date</label>
                            <div class="col-sm-4">
                                <input type="text" id="autoclose-datepicker" class="form-control" name="end_date" value="{{old('end_date')}}" placeholder="End Date">
                                @if ($errors->has('end_date'))
                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div> -->
                            <label for="input-12" class="col-sm-2 col-form-label">Exchange rate per $1<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="input-8" name="exchange_rate" value="{{old('exchange_rate')}}">
                                @if ($errors->has('exchange_rate'))
                                <span class="text-danger">{{ $errors->first('exchange_rate') }}</span>
                                @endif
                            </div>
                            <label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="input-7" name="status" value="{{old('status')}}">
                                    <option value="">Select Status</option>
                                    <option value="active" @if(old('status')=='active' ) selected="selected" @endif>Active</option>
                                    <option value="deactive" @if(old('status')=='deactive' ) selected="selected" @endif>Deactive</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <center>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                <a href="{{url('admin/reward_points')}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</button></a>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#autoclose-datepicker').datepicker({
    autoclose: true,
    todayHighlight: true
});
</script>

@endsection