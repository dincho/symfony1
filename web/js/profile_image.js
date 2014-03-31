var current_thumb_id = null;

function show_profile_image(img_src, thumb_id, new_link, rel, error)
{
    if (error.length > 0) {
        addMessage(error, "msg_error", false, true);
        return;
    }

    if( current_thumb_id) $("thumb_" + current_thumb_id).className = 'thumb';
    $("member_image").src = img_src;
    $("member_image_link").setAttribute('rel', rel);
    $("member_image_link").href = new_link;
    $("thumb_" + thumb_id).className = 'current_thumb';
    current_thumb_id = thumb_id;
}