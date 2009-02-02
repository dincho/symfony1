var current_thumb_id = null;

function show_profile_image(img_src, thumb_id, new_link)
{
    if( current_thumb_id) document.getElementById("thumb_" + current_thumb_id).className = 'thumb';
    document.getElementById("member_image").src = img_src;
    document.getElementById("member_image_link").href = new_link;
    document.getElementById("thumb_" + thumb_id).className = 'current_thumb';
    current_thumb_id = thumb_id;
}