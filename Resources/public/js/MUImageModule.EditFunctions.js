'use strict';


/**
 * Resets the value of an upload / file input field.
 */
function mUImageResetUploadField(fieldName)
{
    jQuery('#' + fieldName).attr('type', 'input');
    jQuery('#' + fieldName).attr('type', 'file');
}

/**
 * Initialises the reset button for a certain upload input.
 */
function mUImageInitUploadField(fieldName)
{
    jQuery('#' + fieldName + 'ResetVal').click( function (event) {
        event.stopPropagation();
        mUImageResetUploadField(fieldName);
    }).removeClass('hidden');
}

