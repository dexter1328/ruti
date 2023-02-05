@extends('admin.layout.main')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="left"><!-- <i class="fa fa-trophy"></i> --><span>Edit Reward Point</span></div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="signupForm" method="post" action="{{ route('reward_points.update',$reward_point->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="input-10" class="col-sm-2 col-form-label">Reward Types<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="input-7" name="reward_type" value="{{$reward_point->reward_type}}">
                                    <option value="">Select Type</option>
                                    @php $invite = ''; $transaction = '';
                                        if(old('reward_type')){
                                            if(old('reward_type')=='invite'){
                                                $invite = 'selected="selected"';
                                            }elseif(old('reward_type')=='transaction'){
                                                $transaction = 'selected="selected"';
                                            }
                                        }
                                        else{
                                            if($reward_point->reward_type == 'invite'){
                                                $invite = 'selected="selected"';
                                            }elseif($reward_point->reward_type == 'transaction'){
                                                $transaction = 'selected="selected"';
                                            }
                                        }
                                    @endphp
                                    <option value="invite"{{$invite}}>Invite</option>
                                    <option value="transaction"{{$transaction}}>Transaction</option>
                                </select>
                                @if ($errors->has('reward_type'))
                                <span class="text-danger">{{ $errors->first('reward_type') }}</span>
                                @endif
                            </div>
                            <label for="input-11" class="col-sm-2 col-form-label">Reward Points<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="input-12" name="reward_points" value="{{old('reward_points',$reward_point->reward_points)}}" placeholder="RewardPoints">
                                @if ($errors->has('reward_points'))
                                <span class="text-danger">{{ $errors->first('reward_points') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- <label for="input-12" class="col-sm-2 col-form-label">End Date</label>
                            <div class="col-sm-4">
                                <input type="text" id="autoclose-datepicker" class="form-control" name="end_date" value="{{date('m/d/Y', strtotime($reward_point->end_date))}}" placeholder="End Date">
                                @if ($errors->has('end_date'))
                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div> -->
                            <label for="input-12" class="col-sm-2 col-form-label">Exchange rate per $1<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="input-8" name="exchange_rate" value="{{old('exchange_rate',$reward_point->reward_point_exchange_rate)}}">
                                @if ($errors->has('exchange_rate'))
                                <span class="text-danger">{{ $errors->first('exchange_rate') }}</span>
                                @endif
                            </div>
                            <label for="input-13" class="col-sm-2 col-form-label">Status<span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="input-7" name="status" value="{{old('status')}}">
                                    <option value="">Select Status</option>
                                    @php $ac_status = ''; $de_status = '';
                                        if(old('status')){
                                            if(old('status')=='active'){
                                                $ac_status = 'selected="selected"';
                                            }elseif(old('status')=='deactive'){
                                                $de_status = 'selected="selected"';
                                            }
                                        }
                                        else{
                                            if($reward_point->status == 'active'){
                                                $ac_status = 'selected="selected"';
                                            }elseif($reward_point->status == 'deactive'){
                                                $de_status = 'selected="selected"';
                                            }
                                        }
                                    @endphp
                                    <option value="active"{{$ac_status}}>Active</option>
                                    <option value="deactive"{{$de_status}}>Deactive</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                          
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
<!--End Row-->

<script>
 $('#autoclose-datepicker').datepicker({
    autoclose: true,
    todayHighlight: true
});
</script>
@endsection