<!-- The Modal -->
<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">로그인</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>아이디</label>
                    <input type="id" class="form-control" id="account_login_id" placeholder="아이디 입력">
                </div>
                <div class="form-group">
                    <label>비밀번호</label>
                    <input type="password" class="form-control" id="account_login_password" placeholder="비밀번호 입력">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="button_account_login">로그인</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="signupModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">회원가입</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>아이디</label>
                    <input type="text" class="form-control" id="account_signup_id" placeholder="아이디 입력">
                </div>
                <div class="form-group">
                    <label>이메일</label>
                    <input type="email" class="form-control" id="account_signup_email" placeholder="이메일 입력">
                </div>
                <div id="account_signup_email_div">
                    <button type="button" class="btn btn-primary" id="button_account_signup_email">이메일인증번호 받기</button>
                </div>
                <div class="form-group">
                    <label>닉네임</label>
                    <input type="text" class="form-control" id="account_signup_nick" placeholder="닉네임 입력">
                </div>
                <div class="form-group">
                    <label>비밀번호</label>
                    <input type="password" class="form-control" id="account_signup_password" placeholder="비밀번호 입력">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="button_account_signup">회원가입</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addBroadcastModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">방송 시작하기</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>방송 제목</label>
                    <input type="text" class="form-control" id="broadcast_add_title" placeholder="방송 제목 입력">
                </div>
                <div class="form-group">
                    <label>방송 설명</label>
                    <input type="text" class="form-control" id="broadcast_add_detail" placeholder="방송 설명 입력">
                </div>
                <div class="form-group">
                    <label>방송 키워드 (#과 콤마 이용가능)</label>
                    <input type="text" class="form-control" id="broadcast_add_keyword" placeholder="방송 키워드 입력">
                </div>
                <hr>
                <div>
                    <h5>[안내] OBS, Xsplit 등에서 방송 가능합니다.</h5>
                    RTMP URL: rtmp://49.247.36.133:1935/live<br>
                    RTMP ID: test01<br>
                    RTMP PW: test1234<br>
                    스트림키: 방송시작하기를 누르면 팝업창에서 한번만 보여줍니다.<br>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="button_broadcast_start">방송 시작하기</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="delBroadcastModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">방송 종료하기</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="button_broadcast_delete">방송 종료하기</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>