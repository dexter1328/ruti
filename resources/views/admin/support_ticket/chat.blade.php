@extends('admin.layout.main')
@section('content')
<style type="text/css">
	.chat_page .box{
		height: 82vh;
		margin-bottom: 0;
	}
	.chat_page .box-body{
		height: 65vh;
	}
	.chat_page .direct-chat-messages{
		height: 65vh;
	}
	.chat_page .box-footer{
		position: absolute;
		bottom: 0;
		width: 100%;
	}

	.chat_page label {
		cursor: pointer;
	}

	.chat_page #attachment {
		opacity: 0;
		position: absolute;
		z-index: -1;
	}

	.chat_page .fa.fa-paperclip {
		position: relative;
		font-size: 24px;
		top: 3px;
	}

	.messages-menu .dropdown-menu li .menu li p {
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.ticket-msg {
		position: relative;
	}
	.ticket-msg .label.label-warning {
		position: absolute;
		right: -10px;
		top: -14px;
	}
	.direct-chat-text {
		border-radius: 5px;
		position: relative;
		padding: 5px 10px;
		background: #d2d6de;
		border: 1px solid #d2d6de;
		margin: 5px 0 0 50px;
		color: #444;
	}
	.direct-chat-info {
		display: block;
		margin-bottom: 2px;
		font-size: 12px;
	}
	.direct-chat-name {
		font-weight: 600;
	}
	.direct-chat-timestamp {
		color: #999;
	}
	.card-body {
		height: 65vh;
	}
	.chat_page .card-footer {
		position: absolute;
		bottom: 0;
		width: 100%;
	}
	.input-group-addon {
		padding: 6px 12px;
		font-size: 14px;
		font-weight: 400;
		line-height: 1;
		color: #555;
		text-align: center;
		background-color: #ffffff;
		border: 1px solid #ccc;
		border-radius: 4px;
	}
	.chat_page .fa.fa-paperclip {
		position: relative;
		font-size: 24px;
		top: 11px;
	}
	button#chatBtn{
		position: relative;
		top: 11px;
	}
	.direct-chat-text:after, .direct-chat-text:before {
		position: absolute;
		right: 100%;
		top: 15px;
		border: solid transparent;
		border-right-color: #d2d6de;
		content: ' ';
		height: 0;
		width: 0;
		pointer-events: none;
	}
	.direct-chat-text:before {
		border-width: 6px;
		margin-top: -6px;
	}
	.direct-chat-text:after {
		border-width: 5px;
		margin-top: -5px;
	}
</style>
<section class="content chat_page">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="left">
						@if($support_ticket->user_type == 'vendor')
							<span>{{$user->name}} (Vendor)</span>
						@else
							<span>{{$user->name}} - {{$user->membership_name}} (Customer)</span>
						@endif
					</div>
				</div>
				<div class="card-body">
					<div class="direct-chat-messages" id="chat_box">
					</div>
				</div>
				<div class="card-footer">
					<form method="post" id="chat_form">
						<div class="input-group">
							<textarea name="message" placeholder="Type Message ..." class="form-control" required="required"></textarea>
							<input type="hidden" name="ticket_no" value="{{$support_ticket->ticket_no}}">
							<input type="hidden" name="admin_id" value="<?php echo Auth::user()->id;?>">
							<input type="hidden" name="admin_name" value="<?php echo Auth::user()->name;?>">
							<input type="hidden" name="email" value="<?php echo Auth::user()->email;?>">
							<input type="hidden" name="user_name" value="{{$user->name}}">
							<input type="hidden" name="time_stamp" value="<?php echo gmdate("Y/m/d H:i:s"); ?>">
							<!-- <span class="input-group-addon">
								<label for="attachment"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
								<input type="file" name="attachment[]" id="attachment" multiple>
							</span> -->
							<span class="input-group-addon">
								<button id="chatBtn" class="btn btn-success btn-flat">Send</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-firestore.js"></script> 

<script src="https://www.gstatic.com/firebasejs/5.0.3/firebase.js"></script>
<script type="text/javascript">
// Your web app's Firebase configuration
var firebaseConfig = {
	apiKey: "AIzaSyCZZueeqw2Ki_GLpMz0IXZicHMDzKEHaqw",
    authDomain: "ezsiop-950d4.firebaseapp.com",
    projectId: "ezsiop-950d4",
    storageBucket: "ezsiop-950d4.appspot.com",
    messagingSenderId: "871506384741",
    appId: "1:871506384741:web:9a4d7043b01731ef10b38c",
    databaseURL: "https://ezsiop-950d4.firebaseio.com"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const db = firebase.firestore();
db.settings({ timestampsInSnapshots : true });

var adminUrl = '{{url("/admin")}}'; 
</script>
<script src="{{ asset('public/js/firebase_chat.js') }}"></script>
@endsection
