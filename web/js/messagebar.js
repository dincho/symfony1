function messagebar_message(message, to_append) {
    if (typeof to_append === "undefined") {
        to_append = false;
    }

    var id = 'messageBar';
    var obj = document.getElementById(id);
    var msg = '&nbsp;&nbsp;&nbsp;' + message + '&nbsp;&nbsp;&nbsp;';
    if (!obj) {
        obj = document.createElement('div');
        obj.setAttribute('id', id);

        document.getElementById('msg_container').appendChild(obj);
    }
    if (to_append && obj.innerHTML) {
        obj.innerHTML = obj.innerHTML + '|' + msg;
    } else {
        obj.innerHTML = msg;
    }
    $(id).show();

}

Event.observe(window, 'unload', function () {
    var obj = $('messageBar');
    if (obj) {
        obj.hide();
    }
});
