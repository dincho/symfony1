function add_tags(val, el_id) {
    var value = document.getElementById(el_id).value;
    var list = value ? value.split(/\s*,\s*/) : [];
    list.push(val);
    list = list.filter(function (elem, pos, self) {
        return (self.indexOf(elem) == pos) && (elem); //remove duplicate and empty
    });
    document.getElementById(el_id).value = list.join(',');
}