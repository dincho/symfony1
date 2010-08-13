function show_error(message)
{
    $("msg_container").update('<div id="msgs"><p class="msg_error">'+ message +'</p></div>');
}

function fileQueueError(file, errorCode, message) {
    
    try {
        var imageName = "error.gif";

        if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
            show_error("You have attempted to queue too many files.");
        }
        if (errorCode === SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT) {
            show_error("File is too big.");
        }

    } catch (ex) {
        this.debug(ex);
    }

}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
    try {
        if (numFilesQueued > 0) {
           
           $("msg_container").update(); //clear messages
           
           var containers = this.customSettings.block.getElementsBySelector('.photo_container');
           var cnt = containers.length;
   
            for(var i=0; i<numFilesQueued; i++)
            {
               for(j=0; j<cnt; j++)
               {
                   var img = containers[j].down('img');
                   if( img === undefined ) 
                   {
                       containers[j].update('<img src="/images/ajax-loader-bg-3D3D3D.gif" />');
                       break;
                   }
               }
                           
            }
            
            this.startUpload();
        }
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadProgress(file, bytesLoaded) {
    try {
        var percent = Math.ceil((bytesLoaded / file.size) * 100);

    } catch (ex) {
        this.debug(ex);
    }
}

function uploadSuccess(file, serverData) {
    
    var response = eval('(' + serverData + ')');
    
    try {
        var container = get_empty_photo_container(this.customSettings.block);
        
        if (response.status === "success") {
            
            
            container.update(response.data);
            
            var photo = container.down(".photo");
            photo.hide();
            Effect.Appear(photo, { duration: 2.0 });

        } else {
            $("msg_container").update(response.messages);
            container.update(); //clear the container ( loader image )
        }

    } catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
    try {
        /*  I want the next upload to continue automatically so I'll call startUpload here */
        if (this.getStats().files_queued > 0) {
            this.startUpload();
        } else {

        }
    } catch (ex) {
        this.debug(ex);
    }
}

function uploadError(file, errorCode, message) {
    var progress;
    try {
        switch (errorCode) {
        case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
            try {

            }
            catch (ex1) {
                this.debug(ex1);
            }
            break;
        case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
            try {

            }
            catch (ex2) {
                this.debug(ex2);
            }
        case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
            break;
        default:
            $("msg_container").update(message);
            break;
        }

    } catch (ex3) {
        this.debug(ex3);
    }

}
