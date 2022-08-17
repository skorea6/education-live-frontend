const api_url = "http://0.0.0.0:8080";
const root_path = "/educationlive"
var user_data = null;
var headers = null;

function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; path=/; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}

function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}

function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}

var getParameters = function (paramName) {
    // 리턴값을 위한 변수 선언
    var returnValue;

    // 현재 URL 가져오기
    var url = location.href;

    // get 파라미터 값을 가져올 수 있는 ? 를 기점으로 slice 한 후 split 으로 나눔
    var parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');

    // 나누어진 값의 비교를 통해 paramName 으로 요청된 데이터의 값만 return
    for (var i = 0; i < parameters.length; i++) {
        var varName = parameters[i].split('=')[0];
        if (varName.toUpperCase() == paramName.toUpperCase()) {
            returnValue = parameters[i].split('=')[1];
            return decodeURIComponent(returnValue);
        }
    }
};

function setNavAccount(){
    var html = '';
    if(user_data != null){
        html = '<li class="nav-item">' +
            '      <a class="nav-link" href="#">' + user_data.nick + ' (' + user_data.member_id + ') 님</a>' +
            '            </li>' +
            '            <li class="nav-item">' +
            '                <a class="nav-link" href="#" role="button" onclick="logout()">' +
            '                    <i class="fas fa-th-large"></i> 로그아웃' +
            '                </a>' +
            '            </li>';
    }else {
        html = '<li class="nav-item">' +
            '                <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal" role="button">' +
            '                    <i class="fas fa-th-large"></i> 로그인' +
            '                </a>' +
            '            </li>' +
            '            <li class="nav-item">' +
            '                <a class="nav-link" href="#" data-toggle="modal" data-target="#signupModal" role="button">' +
            '                    <i class="fas fa-th-large"></i> 회원가입' +
            '                </a>' +
            '            </li>';
    }
    $('#nav_account').html(html);
}


function logout(){
    $.ajax({
        url: api_url + '/api/member/logout',
        headers: headers,
        method: 'GET',
        success: function(data){
            deleteCookie('site_jwt_token');
            //alert(data.data.msg);
            location.href = root_path + '/';
        }
    });
}


if(getCookie('site_jwt_token')){
    headers = {
        'Authorization': getCookie('site_jwt_token'),
        'Content-Type': 'application/json'
    }
}

$.ajax({
    url: api_url + '/api/member/me',
    headers: headers,
    method: 'GET',
    success: function(data){
        user_data = data.data;
    },
    complete: function (){
        setNavAccount();
    }
});


