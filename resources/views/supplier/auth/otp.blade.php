@extends('supplier.layout.auth')
@section('content')
<div class="card-body">
    <div class="card-content p-2">
        <div class="text-center">
            <img src="{{ asset('public/images/logo-icon-xx.png') }}" alt="logo icon">
        </div>
        <div class="card-title text-uppercase text-center py-3">Otp</div>

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/supplier/submit-otp/'.$vendor_otp->token) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="otp" class="sr-only">OTP</label>
                <div class="position-relative has-icon-right">
                    <input type="text" id="otp" class="form-control input-shadow {{ $errors->has('otp') ? 'error' : '' }}" name="otp" value="{{ old('otp') }}" placeholder="OTP" autofocus>
                    <div class="form-control-position">
                        <i class="icon-user"></i>
                    </div>
                    <label class="mt-2">Note: Email was sent to you. Check your Inbox or Spam for the OTP code.</label>
                    <!-- <label id="resend_success" style="color:green;"></label> -->
                    <label class="error">
                        @if ($errors->has('otp'))
                            {{ $errors->first('otp') }}
                        @endif
                        @if ($errors->has('errors'))
                            {{ $errors->first('errors') }}
                        @endif
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            <button type="button" id="resend_otp" class="btn btn-primary btn-block">Resend Otp</button>
            <center style="margin-top: 10px;"><span style="font-weight: 500">Time Left: <span class="countdown" style="font-weight: 500"></span></span></center>
        </form>
    </div>
</div>
<script type="text/javascript">

    let valuestart = moment.duration("{{$time_diff}}", "HH:mm");
    let valuestop = moment.duration("15:00", "HH:mm");
    let difference = valuestop.subtract(valuestart);

    var timer2 = difference.hours() + ":" + difference.minutes();
    //var timer2 = "15:00";
    var interval = setInterval(function() {

        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0){
            clearInterval(interval);
            $('.error').html('OTP has been expired.');
            $('.countdown').html('0:00');
            return false;
        }
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.countdown').html(minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
    }, 1000);

    $( document ).ready(function() {
        $("#resend_otp").click(function(){
            $.ajax({
                type: "post",
                data: {email: '{{$vendor_otp->email}}', token: '{{$vendor_otp->token}}'},
                url: "{{ url('/supplier/resend_otp_mail') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (data) {
                    //$("#resend_success").html(data);
                    //$(".error").html('');
                    window.location.replace("{{ url('supplier/submit-otp/'.$vendor_otp->token) }}");
                }
            });
        });
    });
</script>
@endsection
