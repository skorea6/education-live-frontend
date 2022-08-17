<?php
$template = "../template/";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>교육 생방송 - 생방송 시청</title>

    <!-- Google Font: Source Sans Pro -->
    <?php include($template."css.php") ?>
    <?php include($template."javascript.php") ?>
    <script src="//ssl.p.jwpcdn.com/player/v/8.21.2/jwplayer.js"></script>
    <script src="../js/custom/socket.js"></script>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <?php include($template."nav.php") ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 id="live_play_title" class="m-0"> 로딩하고 있습니다</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">호스팅: <a id="live_play_who" href="#">로딩중</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div style="width:100%;height: 100%;justify-content: center;align-items: center;">
                            <div id="player" style="height:100%;"></div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                            <div class="card card-danger direct-chat direct-chat-danger">
                                <div class="card-header">
                                    <h3 class="card-title">채팅방</h3>
                                </div>
                                <div class="card-body">
                                    <div class="direct-chat-messages" id="livechat">
                                        <div style="margin-bottom: 7px;"><center>채팅방에 접속중입니다.</center></div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="input-group">
                                        <input type="text" id="message-input" placeholder="채팅을 입력해주세요." class="form-control">
                                        <span class="input-group-append">
                                          <button id="message-button" type="submit" class="btn btn-success">전송</button>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <!--/.direct-chat -->
                        </div>
                        <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr>
                방송 설명: <span id="live_play_detail"></span><br>
                방송 키워드: <span id="live_play_keyword"></span><br><br>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include($template."footer.php") ?>
    <?php include($template."popup.php") ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script>
    $(document).ready(function (){

        $.ajax({
            url: api_url + '/api/broadcast/detail/' + getParameters('code') + '/' + getParameters('pass'),
            method: 'GET',
            success: function (data) {
                if (data.status_code == 200) {
                    var result = data.data;

                    $('#live_play_who').html(result.nick + ' (' + result.member_id + ')');
                    $('#live_play_title').html(result.title);
                    $('#live_play_detail').html(result.detail);
                    $('#live_play_keyword').html(result.keyword);

                    jwConfig = {
                        autostart: "true",
                        sources: [{
                            file: 'http://49.247.36.133:1935/live/' + result.stream_code + '/playlist.m3u8', // http://d61q3nbxlkoh2.cloudfront.net http://49.247.36.133:1935
                            type: "application/vnd.apple.mpegurl"
                        }],
                        width: "100%",
                        stretching: "uniform",
                        aspectratio: "16:9",
                        primary: "html5",
                        cast: {},
                        mute: false,
                        volume: 50
                    };

                    jwplayer.key = "uoW6qHjBL3KNudxKVnwa3rt5LlTakbko9e6aQ6VUyKQ=";
                    var player = jwplayer('player').setup(jwConfig);

                    var room = result.room;
                    var user_secret = null
                    if(user_data != null){
                        user_secret = user_data.secret;
                    }
                    var socket = io.connect('49.247.36.133:3000', {transports: ['websocket']});

                    function writeMessage(type, name, id, message) {
                        var html0 = '<div class="direct-chat-msg"><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-left">{NICK} ({MEMBER_ID})</span></div><div class="direct-chat-text" style="margin: 5px 0 0 3px;">{MESSAGE}</div></div>';
                        var html5 = '<div style="margin-bottom: 7px;"><center>{MESSAGE}</center></div>'

                        if(type == 5){
                            if(message != null){
                                html5 = html5.replace('{MESSAGE}', message);
                                $(html5).appendTo('#livechat');
                            }
                        }else if(type == 1){
                            html0 = html0.replace('{NICK}', name);
                            html0 = html0.replace('{MEMBER_ID}', id);
                            html0 = html0.replace('{MESSAGE}', message);
                            $(html0).appendTo('#livechat');
                        }

                    }

                    socket.on('connection', function(data) {
                        if(data.type === 'connected') {
                            socket.emit('connection', {
                                room: room,
                                user_secret : user_secret
                            });
                        }
                    });

                    socket.on('입퇴장', function(data) {
                        $('#message-input').attr('disabled', false);
                        $('#message-button').attr('disabled', false);
                        $("#livechat").html('');

                        writeMessage(data.type, '', '', data.message);

                        var lastChatData = data.lastchat;
                        for(var i=lastChatData.length-1;i>=0;i--){
                            writeMessage(lastChatData[i]["type"], lastChatData[i]["name"], lastChatData[i]["id"], lastChatData[i]["message"]);
                        }
                    });

                    socket.on('message', function(data) {
                        writeMessage(data.type, data.name, data.id, data.message);
                    });

                    function sendMessageBtn(){
                        if(user_data != null) {
                            var $input = $('#message-input');
                            var msg = $input.val();
                            msg = msg.replace(/(^\s*)|(\s*$)/, '');
                            msg = msg.replace(/[\r|\n]/g, '');
                            if (!msg) {
                                //alert('채팅을 입력해주세요!');
                            } else {
                                socket.emit('user', {
                                    message: msg
                                });
                            }
                            $input.val('');
                            $input.focus();
                        }else{
                            alert('로그인 후 이용 가능합니다!');
                        }
                    }

                    $('#message-button').click(function() {
                        sendMessageBtn();
                    });

                    $('#message-input').keyup(function(e) {
                        if(e.keyCode == 13){
                            sendMessageBtn();
                        }
                    });

                } else {
                    alert('비밀번호가 일치하지 않거나 일치하는 방송이 없습니다!');
                    location.href = root_path + '/';
                }
            },
            error: function (data){
                alert('비밀번호가 일치하지 않거나 일치하는 방송이 없습니다!');
                location.href = root_path + '/';
            }
        });

       accountService.init();
       broadcastService.init();
    });
</script>
</body>
</html>
