/**
 * Created by Alexandre on 2015-05-28.
 */

// This is a handler for form submit
function postData(e){
    e.preventDefault();

    var post = {};
    var form = $(this).closest('form');
    var items = form.find('input:not(input:submit), select');

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

// Advanced handler for form submit
function formHelper(){
    this.setCallback(function(data){
        $('#feedback').html(data.feedback);
    });
}

HANDLER_CALLBACK = undefined;
formHelper.prototype.setCallback = function(cb){
    this.callback = cb;
    HANDLER_CALLBACK = cb;
}

formHelper.prototype.handler = function(e){
    e.preventDefault();

    var post = {};
    var form = $(this).closest('form');
    var items = form.find('input:not(input:submit), select');
    var callback = this.callback;

    for (var i = 0; i < items.length; i++)
    {
        post[$(items[i]).attr('name')] = $(items[i]).val();
    }

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: post
    }).done(HANDLER_CALLBACK);
}
