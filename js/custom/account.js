var accountService = function() {

    function _init() {
        $("#button_account_login").click(function () {
            $.ajax({
                url: api_url + '/api/auth/login',
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    'member_id': $('#account_login_id').val(),
                    'password': $('#account_login_password').val()
                }),
                success: function (data) {
                    if (data.status_code == 200) {
                        setCookie('site_jwt_token', data.data.Authorization, data.data.expire_hours)
                        alert(data.data.msg);
                        location.href = root_path + '/';
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data){
                    alert(data.responseJSON.msg)
                }
            });
        });

        $("#button_account_signup").click(function () {
            $.ajax({
                url: api_url + '/api/auth/register',
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    'member_id': $('#account_signup_id').val(),
                    'email': $('#account_signup_email').val(),
                    'password': $('#account_signup_password').val(),
                    'nick': $('#account_signup_nick').val(),
                    'email_verify_secret_key': getCookie('email_verify_secret_key')
                }),
                success: function (data) {
                    if (data.status_code == 200) {
                        setCookie('site_jwt_token', data.data.Authorization, data.data.expire_hours)
                        alert(data.data.msg);
                        location.href = root_path + '/';
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data){
                    alert(data.responseJSON.msg)
                }
            });
        });

        $("#button_account_signup_email").click(function () {
            $.ajax({
                url: api_url + '/api/auth/register/verify/email/send',
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                data: JSON.stringify({
                    'email': $('#account_signup_email').val()
                }),
                success: function (data) {
                    if (data.status_code == 200) {
                        setCookie('email_verify_secret_key', data.data.email_verify_secret_key, 1)
                        alert('해당 이메일로 인증번호가 담긴 이메일을 전송했습니다!');

                        var html = '';
                        html += '<div class="form-group">' +
                            '       <label>인증번호 (이메일)</label>' +
                            '       <input type="email" class="form-control" id="account_signup_email_code" placeholder="인증번호 입력">' +
                            '    </div>'
                        html += '<button type="button" class="btn btn-warning" onclick="accountService.email_check()">인증번호 확인</button>'
                        $('#account_signup_email').prop("disabled", true);
                        $('#account_signup_email_div').html(html);
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data){
                    alert(data.responseJSON.msg)
                }
            });
        });

    }

    function _email_check(){
        $.ajax({
            url: api_url + '/api/auth/register/verify/email/check',
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            data: JSON.stringify({
                'email_verify_secret_key': getCookie('email_verify_secret_key'),
                'code': $('#account_signup_email_code').val()
            }),
            success: function (data) {
                if (data.status_code == 200) {
                    $('#account_signup_email_div').html('');
                    alert(data.data.msg);
                } else {
                    alert(data.msg);
                }
            },
            error: function (data){
                alert(data.responseJSON.msg)
            }
        });
    }

    return {
        init: _init,
        email_check: _email_check
    }

}();