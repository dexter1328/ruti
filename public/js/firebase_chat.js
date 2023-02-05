const form = document.querySelector('#chat_form');
var ticket_no = form.ticket_no.value;
var admin_name = form.admin_name.value;
var user_name = form.user_name.value;

function renderCafe(doc){
		var data = '';
		//snapshot.docs.forEach(doc =>{
		var message = doc.data().text;
		console.log(message);
		
		var type = doc.data().sender.type;
		var datetime = new Date(doc.data().date.seconds*1000);
		var date = datetime.toDateString("yyyy-MM-dd");
		var hours = datetime.getHours();
		var minutes = datetime.getMinutes();
		var seconds = datetime.getSeconds();
		var time = date+' '+hours+':'+ minutes +':'+seconds;
		if(type == 'admin'){
			var data = $('<div class="direct-chat-msg align-right"><div class="direct-chat-text"><div class="direct-chat-info clearfix"><div class="direct-chat-info clearfix"><span class="direct-chat-timestamp pull-right">'+time+'</span><span class="direct-chat-name  pull-left ">'+admin_name+'</span></div><div id="chat-message">'+message+'</div></div></div>');
		}else{
			var data = $('<div class="direct-chat-msg"><div class="direct-chat-text"><div class="direct-chat-info clearfix"><div class="direct-chat-info clearfix"><span class="direct-chat-timestamp pull-right ">'+time+'</span><span class="direct-chat-name">'+user_name+'</span></div><div id="chat-message">'+message+'</div></div></div>');
		}
		$('#chat_box').append(data);
		$("#chat_box").stop().animate({ scrollTop: $("#chat_box")[0].scrollHeight}, 1000);
}
	
//save data
form.addEventListener('submit', (e) => {
	e.preventDefault();
	var ticket_no = form.ticket_no.value;
	var newMessageRef = db.collection('Chatrooms').doc(ticket_no).collection('Chat Messages').doc();

	//send user notificatiob
	$.ajax({
		type: "post",
		url: adminUrl+'/support_ticket/support_ticket_notification',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data:{
			'ticket_no':ticket_no,
			'message':form.message.value
		},
		success: function (data) {

		}
	});
	//send user notification
    db.collection('support_threads').doc(ticket_no).collection('messages').add({
		date: firebase.firestore.Timestamp.fromDate(new Date()),
		id:newMessageRef.id,
		sender:{id: parseInt(form.admin_id.value),
		type:'admin'},
		text:form.message.value,
		type:'text'
	})
	form.message.value = '';
});
	
// get data
db.collection('support_threads').doc(ticket_no).collection('messages').orderBy("date").onSnapshot(snapshot =>{
	let changes = snapshot.docChanges();
	changes.forEach(change =>{
		if(change.type == 'added'){
			renderCafe(change.doc);
		}
		
	})
})


