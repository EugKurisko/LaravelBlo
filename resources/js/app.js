const { join } = require('lodash');

require('./bootstrap');

var form = $('#comment-form');

$('#leaveCom').on('click', function (e) {
    e.preventDefault();
    form.removeClass('d-none');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    form.on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/store',
            type: "post",
            async: false,
            data: {
                comment: jQuery('#comment-text').val(),
                postId: jQuery('#postId').val(),
                postAuthor: jQuery('#postAuthor').val(),
                userName: jQuery('#userName').val(),
            },
            success: function (response) {
                form.addClass('d-none');
                $('#comment-text').val('');
                console.log(response);
                let date = new Date(response.created_at);
                $('#comments').append('<div class="card mt-4 bg-info"><div class="card-body"><span class="card-title">Written by ' +
                    response.user.name + ' on '
                    + date.getFullYear() + '-'
                    + ("0" + (date.getMonth() + 1)).slice(-2) + '-'
                    + date.getDate(response.create_at) + ' at '
                    + (date.getHours() < 10 ? '0' : '') + date.getHours() + ':'
                    + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + ':'
                    + (date.getSeconds() < 10 ? '0' : '') + date.getSeconds()
                    + '</span><div class="card-text">'
                    + response.comment + '</div>');
            },
            error: function (response) {
                console.log('no');
            }
        })
    })
});

//timer for flash-messages
jQuery(function () {
    setTimeout(function () {
        $("#message").remove();
    }, 2000);
})