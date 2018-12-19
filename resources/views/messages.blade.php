<html>

<head>
    <title>Demo chat</title>
</head>
<body>
    <div id="data">
        @foreach($messages as $message)
        <p id="{{$message->id}}"><strong>{{$message->user_id}}</strong>: {{$message->chat}}</p>
        @endforeach
    </div>
    <div>
        <form action="api/chattingroom" method="POST">
        {{csrf_field()}}
        Group: <input type="text" name="group_id">
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <br>
        <br>
        Content: <textarea name="chat" rows="5" style="width:100%"></textarea>
        <button type="submit" name="send">Send</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.js"></script>
        <script>
            
        var socket = io('http://localhost:6001')
        socket.on('groups',function(data){
            //console.log(data)
            if($('#'+data.id).length == 0){
                $('#data').append('<p><strong>'+data.user_id+'</strong>: '+data.chat+'</p>')
            }
            else{
                console.log('Đã có tin nhắn')
            }
        })

        </script>
    </div>
</body>

</html>