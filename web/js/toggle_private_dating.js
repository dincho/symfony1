function toggle_private_dating(button) {
    $('private_dating').setValue($('private_dating').getValue() == 1 ? 0 : 1);
    $(button).textContent = $('member_private_dating').textContent;
    $('member_private_dating').textContent = ($('private_dating').getValue() == 1) ? 'ON' : 'off';
}
