$(document).ready(function () {
    $('.search-form').submit(function (e) {
        e.preventDefault();
        var form = $(e.target);
        var inputValue = $(form.children('input')[0]).val();
        if (!inputValue) {
            return false;
        }
        $('#error').text('');
        $('#search-button-i').removeClass('invisible');
        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: {inputValue: inputValue}
        })
            .done(function (data) {
                if (typeof(data.error) !== 'undefined') {
                    $('#error').text(data.error);
                    return;
                }
                $("#jsGrid").jsGrid({
                    width: "100%",
                    height: "auto",
                    inserting: false,
                    editing: false,
                    sorting: true,
                    paging: true,
                    data: data,

                    fields: [
                        {name: "text", type: "text", width: 250, 'title': "Post"},
                        {name: "author", type: "text", width: 100, 'title': "Author Name"},
                        {name: "created_time", type: "date", width: 100, 'title': 'Date'},
                        {name: "count_likes", type: "number", width: 50, 'title': 'Likes'},
                        {name: "count_comments", type: "number", width: 50, 'title': 'Comments'}
                    ]
                });

            }).always(
            function () {
                $('#search-button-i').addClass('invisible');
            })
    })
});