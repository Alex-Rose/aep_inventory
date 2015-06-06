/**
 * Created by Alexandre on 2015-05-28.
 */

// This is a handler for form submit
function postData(e){
    e.preventDefault();

    var post = {};
    var form = $(this).closest('form');
    var items = form.find('input:not(input:submit)');

    for (var i = 0; i < items.length; i++)
    {
        post[$(items[i]).attr('name')] = $(items[i]).val();
    }

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: post
    }).done(function(data){
        $('#feedback').html(data.feedback);
    });

}