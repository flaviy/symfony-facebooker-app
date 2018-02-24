$(document).ready(function () {
    $('.search-form').submit(function (e) {
        e.preventDefault();
        var form = $(e.target);
        var inputValue = $(form.children('input')[0]).val();
        if (!inputValue) {
            return false;
        }
        $.ajax({
            method: 'POST',
            url: form.attr('action')
        }).done(function(data) {
            $("#jsGrid").jsGrid({
                width: "100%",
                height: "auto",
                inserting: false,
                editing: false,
                sorting: true,
                paging: true,
                data: data,

                fields: [
                    { name: "post", type: "text", width: 250, 'title' : "Post" },
                    { name: "author", type: "text", width: 100, 'title' : "Author Name" },
                    { name: "date", type: "date", width: 100, 'title' : 'Date'},
                    { name: "count_likes", type: "number", width: 50, 'title' : 'Likes'}
                ]
            });
        })
    })
});