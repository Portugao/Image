'use strict';

function mUImageToday(format)
{
    var timestamp, todayDate, month, day, hours, minutes, seconds;

    timestamp = new Date();
    todayDate = '';
    if (format !== 'time') {
        month = new String((parseInt(timestamp.getMonth()) + 1));
        if (month.length === 1) {
            month = '0' + month;
        }
        day = new String(timestamp.getDate());
        if (day.length === 1) {
            day = '0' + day;
        }
        todayDate += timestamp.getFullYear() + '-' + month + '-' + day;
    }
    if (format === 'datetime') {
        todayDate += ' ';
    }
    if (format != 'date') {
        hours = new String(timestamp.getHours());
        if (hours.length === 1) {
            hours = '0' + hours;
        }
        minutes = new String(timestamp.getMinutes());
        if (minutes.length === 1) {
            minutes = '0' + minutes;
        }
        seconds = new String(timestamp.getSeconds());
        if (seconds.length === 1) {
            seconds = '0' + seconds;
        }
        todayDate += hours + ':' + minutes;// + ':' + seconds;
    }

    return todayDate;
}

// returns YYYY-MM-DD even if date is in DD.MM.YYYY
function mUImageReadDate(val, includeTime)
{
    // look if we have YYYY-MM-DD
    if (val.substr(4, 1) === '-' && val.substr(7, 1) === '-') {
        return val;
    }

    // look if we have DD.MM.YYYY
    if (val.substr(2, 1) === '.' && val.substr(5, 1) === '.') {
        var newVal = val.substr(6, 4) + '-' + val.substr(3, 2) + '-' + val.substr(0, 2);
        if (true === includeTime) {
            newVal += ' ' + val.substr(11, 5);
        }

        return newVal;
    }
}

var lastAlbumTitle = '';

/**
 * Performs a duplicate check for unique fields
 */
function mUImageUniqueCheck(ucOt, val, elem, ucEx)
{
    var params;

    if (elem.val() == window['last' + mUImageCapitaliseFirstLetter(ucOt) + mUImageCapitaliseFirstLetter(elem.attr('id')) ]) {
        return true;
    }

    window['last' + mUImageCapitaliseFirstLetter(ucOt) + mUImageCapitaliseFirstLetter(elem.attr('id')) ] = elem.val();

    // build parameters object
    params = {
        ot: ucOt,
        fn: encodeURIComponent(elem.attr('id')),
        v: encodeURIComponent(val),
        ex: ucEx
    };

    var result = true;

    jQuery.ajax({
        type: 'POST',
        url: Routing.generate('muimagemodule_ajax_checkforduplicate'),
        data: params,
        async: false
    }).done(function(res) {
        if (null == res.data || true === res.data.isDuplicate) {
            result = false;
        }
    });

    return result;
}

function mUImageValidateNoSpace(val)
{
    var valStr;
    valStr = new String(val);

    return (valStr.indexOf(' ') === -1);
}

function mUImageValidateUploadExtension(val, elem)
{
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
function mUImagePerformCustomValidationRules(objectType, currentEntityId)
{
    jQuery('.validate-nospace').each( function() {
        if (!mUImageValidateNoSpace(jQuery(this).val())) {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity(Translator.__('This value must not contain spaces.'));
        } else {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity('');
        }
    });
    jQuery('.validate-upload').each( function() {
        if (!mUImageValidateUploadExtension(jQuery(this).val(), jQuery(this))) {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity(Translator.__('Please select a valid file extension.'));
        } else {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity('');
        }
    });
    jQuery('.validate-unique').each( function() {
        if (!mUImageUniqueCheck(jQuery(this).attr('id'), jQuery(this).val(), jQuery(this), currentEntityId)) {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity(Translator.__('This value is already assigned, but must be unique. Please change it.'));
        } else {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity('');
        }
    });
}
