function select_all_emails(el)
{
    var els = document.getElementsByName("marked[]");
    for (var i=0, im=els.length; im>i; i++) {
        els[i].checked = el.checked;
    }
}