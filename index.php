<?php
$template = "./template/";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>교육 생방송</title>

    <!-- Google Font: Source Sans Pro -->
    <?php include($template."css.php") ?>
    <?php include($template."javascript.php") ?>
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
                        <h1 class="m-0"> 생방송 목록</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div id="live_list" class="row"></div>
                <!-- /.row -->
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
    var mainService = function() {

        var now_stream_code = null;

        function _init() {
            $.ajax({
                url: api_url + '/api/broadcast/list',
                method: 'GET',
                success: function (data) {
                    if (data.status_code == 200) {
                        var result = data.data;
                        var html = '';

                        for (var i = 0; i < result.length; i++) {
                            html += '<div class="col-lg-4">';
                            html += '<div class="card card-primary card-outline">';
                            html += '<div class="card-header">';
                            html += '<h5 class="card-title m-0">' + result[i].title + '</h5>';
                            html += '</div>';
                            html += '<div class="card-body">';
                            html += '    <p class="card-text">호스트: ' + result[i].member_id + ' (' + result[i].nick + ')</p>';
                            html += '    <p class="card-text">방송 키워드: ' + result[i].keyword + '</p>';
                            if(result[i].require_password == true){
                                var onclick_html = "'" + result[i].stream_code + "'"
                                html += '    <p class="card-text">* 비밀번호가 포함된 방송입니다 *</p>';
                                html += '    <a href="#" onclick="mainService.openPasswordModal(' + onclick_html + ')" class="btn btn-primary">생방송 시청하기</a>';
                            }else{
                                html += '    <a href="/educationlive/live/?code=' + result[i].stream_code + '" class="btn btn-primary">생방송 시청하기</a>';
                            }
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }

                        $('#live_list').html(html);
                    }
                }
            });

            $("#button_broadcast_password").click(function () {
                location.href = '/educationlive/live/?code=' + now_stream_code + '&pass=' + $('#broadcast_password_password').val();
            });
        }

        function _openPasswordModal(stream_code){
            now_stream_code = stream_code;
            $('#passwordBroadcastModal').modal('show');
        }

        return {
            init: _init,
            openPasswordModal: _openPasswordModal
        }

    }();

    $(document).ready(function (){
       accountService.init();
       broadcastService.init();
       mainService.init();
    });
</script>
</body>
</html>
