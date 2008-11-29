function add_form_field(container, the_name)
{
    new_f = document.createElement('input');
    new_f.type = 'text';
    new_f.name = the_name;
    
    br = document.createElement('br');
    label = document.createElement('label');
    
    container.appendChild(label);
    container.appendChild(new_f);
    container.appendChild(br);
}