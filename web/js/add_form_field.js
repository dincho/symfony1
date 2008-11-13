function add_form_field(container)
{
    new_f = document.createElement('input');
    new_f.type = 'text';
    new_f.name = 'states[]';
    
    br = document.createElement('br');
    label = document.createElement('label');
    
    container.appendChild(label);
    container.appendChild(new_f);
    container.appendChild(br);
}