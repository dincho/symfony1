/**
 * Filter options of 'select_id' having 'tag' in attribute data-tags (comma separated list of tags)
 */
var originalOptions = [];

function filter_select(tag, select_id) {
    var el = document.getElementById(select_id);

    if (0 === originalOptions.length) {
        Array.prototype.forEach.call(el.childNodes, function (optEl) {
            originalOptions.push(optEl.cloneNode(true));
        });
    }

    el.innerHTML = '';

    if (tag) {
        el.innerHTML = '<option selected></option>';
    }

    Array.prototype.forEach.call(originalOptions, function (elem) {
        var tags = (elem.getAttribute('data-tags') || "").split(',');
        if (-1 !== tags.indexOf(tag) || (!tag)) {
            el.appendChild(elem);
        }
    });
}
