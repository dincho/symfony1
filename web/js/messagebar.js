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

// add message in both containers
function addMessage(message, divClass, toAppend, showBar) {
    toAppend = toAppend === undefined ? true : toAppend;
    showBar = showBar === undefined ? true : showBar;

    if (!toAppend) {
        clearMessages();
    }

    messageLine(message, divClass, toAppend);

    if (showBar) {
        messageBar(message, toAppend);
    }
}

// add message in static container
function messageLine(message, divClass, toAppend) {
    divClass = divClass === undefined ? 'msg' : divClass;
    toAppend = toAppend === undefined ? true : toAppend;

    var $msgContainer = $('msg_container');
    var $msgs = $('msgs');

    if (!$msgContainer) {
        return;
    }

    if (!$msgs) {
        $msgs = $(document.createElement('div'));
        $msgs.setAttribute('id', 'msgs');
        $msgContainer.appendChild($msgs);
    }

    message = '<div class="' + divClass + '">' + message + '</div>';

    if (toAppend) {
        message = $msgs.innerHTML + message;
    }

    $msgs.innerHTML = message;
}

// add message in fixed container
function messageBar(message, toAppend) {
    toAppend = toAppend === undefined ? true : toAppend;

    var $msgContainer = $('msg_container');
    var $messageBar = $('messageBar');

    if (!$messageBar) {
        var appendTo = $msgContainer ? $msgContainer : document.body;

        $messageBar = $(document.createElement('div'));
        $messageBar.setAttribute('id', 'messageBar');
        appendTo.appendChild($messageBar);
    }

    if (toAppend && $messageBar.innerHTML) {
        message = $messageBar.innerHTML + '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;' + message;
    }

    $messageBar.innerHTML = message;
    $messageBar.show();
}

// clear both containers
function clearMessages() {
    if ($('messageBar')) {
        $('messageBar').innerHTML = '';
    }

    if ($('msg_container')) {
        $('msg_container').innerHTML = '';
    }
}