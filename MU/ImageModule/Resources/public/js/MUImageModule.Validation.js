'use strict';

var lastAlbumTitle = '';

/**
 * Performs a duplicate check for unique fields
 */
function mUImageUniqueCheck(elem, excludeId) {
    var objectType, fieldName, fieldValue, result, params;

    objectType = elem.attr('id').split('_')[1];
    fieldName = elem.attr('id').split('_')[2];
    fieldValue = elem.val();
    if (fieldValue == window['last' + mUImageCapitaliseFirstLetter(objectType) + mUImageCapitaliseFirstLetter(fieldName)]) {
        return true;
    }

    window['last' + mUImageCapitaliseFirstLetter(objectType) + mUImageCapitaliseFirstLetter(fieldName)] = fieldValue;

    result = true;
    params = {
        ot: encodeURIComponent(objectType),
        fn: encodeURIComponent(fieldName),
        v: encodeURIComponent(fieldValue),
        ex: excludeId
    };

    jQuery.ajax({
        url: Routing.generate('muimagemodule_ajax_checkforduplicate'),
        method: 'GET',
        dataType: 'json',
        async: false,
        data: params,
        success: function (data) {
            if (null == data || true === data.isDuplicate) {
                result = false;
            }
        }
    });

    return result;
}

function mUImageValidateNoSpace(val) {
    var valStr;
    valStr = new String(val);

    return (valStr.indexOf(' ') === -1);
}

function mUImageValidateUploadExtension(val, elem) {
    var fileExtension, allowedExtensions;
    if (val === '') {
        return true;
    }

    fileExtension = '.' + val.substr(val.lastIndexOf('.') + 1);
    allowedExtensions = jQuery('#' + elem.attr('id') + 'FileExtensions').text();
    allowedExtensions = '(.' + allowedExtensions.replace(/, /g, '|.').replace(/,/g, '|.') + ')$';
    allowedExtensions = new RegExp(allowedExtensions, 'i');

    return allowedExtensions.test(val);
}

/**
 * Runs special validation rules.
 */
function mUImageExecuteCustomValidationConstraints(objectType, currentEntityId) {
    jQuery('.validate-upload').each(function () {
        if (!mUImageValidateUploadExtension(jQuery(this).val(), jQuery(this))) {
            jQuery(this).get(0).setCustomValidity(Translator.__('Please select a valid file extension.'));
        } else {
            jQuery(this).get(0).setCustomValidity('');
        }
    });
    jQuery('.validate-unique').each(function () {
        if (!mUImageUniqueCheck(jQuery(this), currentEntityId)) {
            jQuery(this).get(0).setCustomValidity(Translator.__('This value is already assigned, but must be unique. Please change it.'));
        } else {
            jQuery(this).get(0).setCustomValidity('');
        }
    });
}
