function clearMessages() {
    if ($('msg_container')) {
        $('msg_container').innerHTML = '';
    }
}

// add message in static container
function addMessage(message, divClass) {
    divClass = divClass === undefined ? 'msg' : divClass;

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
    message = $msgs.innerHTML + message;

    $msgs.innerHTML = message;
}
