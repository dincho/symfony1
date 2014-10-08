var cropper = null;
window.activeCropButton = null;

function show_crop_area(photo_id, img_src, btn) {
    // manually clean previously unsuccessful loading of #crop_image src
    if ($('imgCrop_crop_image')) {
        $('imgCrop_crop_image').remove();
    }

    $$('div.imgCrop_wrap').forEach(function (el) {
        if (!el.down('img')) el.remove();
    });

    // enable previously pressed "Crop" button if any
    if (window.activeCropButton) {
        window.activeCropButton.disabled = false;
    }

    // disable currently pressed "Crop" button till img loads
    window.activeCropButton = btn;
    window.activeCropButton.disabled = true;

    var photo_el = "photo_" + photo_id;
    var x = 100;
    var y = 100;

    //remove old cropper if any
    if (cropper) {
        cropper.previewWrap.removeClassName('imgCrop_previewWrap');
        cropper.previewWrap.removeAttribute('style');
        cropper.remove();
        cropper = null;
        if ($('crop_image')) {
            $('crop_image').remove();
        }
    }

    //set the image and show the crop_area
    if (!$('crop_area').down('#crop_image')) {
        var elem = $('crop_img_wrap');
        elem.innerHTML += '<img id="crop_image" />';
    }
    $('crop_area').down('#crop_image').src = img_src;
    $('crop_area').down('#crop_image').observe('load', function () {
        window.activeCropButton.disabled = false;
        window.activeCropButton = null;
        $('crop_area').show();

        //this should be done after the image is loaded
        cropper = new Cropper.ImgWithPreview(
            'crop_image',
            {
                minWidth: x,
                minHeight: y,
                ratioDim: {x: x, y: y},
                displayOnInit: true,
                previewWrap: 'crop_preview',
                pd_photo_id: photo_id
            }
        );
    });
}

function remove_crop_area() {
    cropper.previewWrap.removeClassName('imgCrop_previewWrap');
    cropper.previewWrap.removeAttribute('style');
    cropper.remove();
    cropper = null;

    if ($('imgCrop_crop_image')) {
        $('imgCrop_crop_image').remove();
    }
    if ($('crop_image')) {
        $('crop_image').remove();
    }
    $('crop_area').hide();
}

function crop(photo_crop_url) {
    var params = 'photo_id=' + cropper.options.pd_photo_id + '&crop[x1]='
        + cropper.areaCoords.x1 + '&crop[y1]=' + cropper.areaCoords.y1
        + '&crop[x2]=' + cropper.areaCoords.x2 + '&crop[y2]=' + cropper.areaCoords.y2;
    params += '&crop[width]=' + cropper.calcW() + '&crop[height]=' + cropper.calcH();

    var photo_container = $('photo_' + cropper.options.pd_photo_id).parentNode;
    photo_container.update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
    new Ajax.Updater(photo_container, photo_crop_url, {
        asynchronous: true,
        evalScripts: true,
        parameters: params
    });
    remove_crop_area();
}

function rotate(photo_rotate_url, photo_id, deg) {
    var params = 'deg=' + deg + '&photo_id=' + photo_id;
    var photo_container = $('photo_' + photo_id).parentNode;
    photo_container.update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
    new Ajax.Updater(photo_container, photo_rotate_url, {
        asynchronous: true,
        evalScripts: true,
        parameters: params
    });
}

Event.observe(window, 'load', function () {
    new Draggable('crop_area', {});
});
