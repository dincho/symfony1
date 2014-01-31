/**
 * Filter options of 'select_id' having 'val' in attribute data-tags (comma separated list of tags)
 */
function filter_select(val, select_id) {
    var el = document.getElementById(select_id);
    var options = el.childNodes;
    var r = new RegExp('(^|,\s*)' + val + '\s*(,|$)');
    Array.prototype.forEach.call(options, function (elem) {
        elem.style.display = null;
        var tags = elem.getAttribute('data-tags');
        if (val) {
            if (tags && tags.search(r) == -1 || !tags) {
                elem.style.display = 'none';
            }
        }
    });
}
