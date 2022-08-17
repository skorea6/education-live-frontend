var broadcastService = function() {

    function _init() {

        $("#button_broadcast_start").click(function () {
            $.ajax({
                url: api_url + '/api/broadcast/start',
                method: 'POST',
                headers: headers,
                data: JSON.stringify({
                    'title': $('#broadcast_add_title').val(),
                    'detail': $('#broadcast_add_detail').val(),
                    'keyword': $('#broadcast_add_keyword').val()
                }),
                success: function (data) {
                    if (data.status_code == 200) {
                        alert(data.data.msg);
                        location.href = root_path + '/';
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data){
                    alert(data.responseJSON.msg);
                }
            });
        });

        $("#button_broadcast_delete").click(function () {
            $.ajax({
                url: api_url + '/api/broadcast/stop',
                method: 'POST',
                headers: headers,
                success: function (data) {
                    if (data.status_code == 200) {
                        alert(data.data.msg);
                        location.href = root_path + '/';
                    } else {
                        alert(data.msg);
                    }
                },
                error: function (data){
                    alert(data.responseJSON.msg);
                }
            });
        });

    }


    return {
        init: _init
    }

}();