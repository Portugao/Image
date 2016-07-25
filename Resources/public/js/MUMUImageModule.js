'use strict';

function mUMUImageCapitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.substring(1);
}

/**
 * Submits a quick navigation form.
 */
function mUMUImageSubmitQuickNavForm(objectType)
{
    jQuery('#mumuimagemodule' + mUMUImageCapitaliseFirstLetter(objectType) + 'QuickNavForm').submit();
}

/**
 * Initialise the quick navigation panel in list views.
 */
function mUMUImageInitQuickNavigation(objectType)
{
    if (jQuery('#mumuimagemodule' + mUMUImageCapitaliseFirstLetter(objectType) + 'QuickNavForm').length < 1) {
        return;
    }

    if (jQuery('#catid').length > 0) {
        jQuery('#catid').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
    }
    if (jQuery('#sortBy').length > 0) {
        jQuery('#sortBy').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
    }
    if (jQuery('#sortDir').length > 0) {
        jQuery('#sortDir').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
    }
    if (jQuery('#num').length > 0) {
        jQuery('#num').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
    }

    switch (objectType) {
    case 'album':
        if (jQuery('#parent').length > 0) {
            jQuery('#parent').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#workflowState').length > 0) {
            jQuery('#workflowState').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#albumAccess').length > 0) {
            jQuery('#albumAccess').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#notInFrontend').length > 0) {
            jQuery('#notInFrontend').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        break;
    case 'picture':
        if (jQuery('#album').length > 0) {
            jQuery('#album').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#workflowState').length > 0) {
            jQuery('#workflowState').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#showTitle').length > 0) {
            jQuery('#showTitle').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#showDescription').length > 0) {
            jQuery('#showDescription').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        if (jQuery('#albumImage').length > 0) {
            jQuery('#albumImage').change(function () { mUMUImageSubmitQuickNavForm(objectType); });
        }
        break;
    default:
        break;
    }
}

/**
 * Helper function to create new Bootstrap modal window instances.
 */
function mUMUImageInitInlineWindow(containerElem, title)
{
    var newWindowId;

    // show the container (hidden for users without JavaScript)
    containerElem.removeClass('hidden');

    // define name of window
    newWindowId = containerElem.attr('id') + 'Dialog';

    containerElem.unbind('click').click(function(e) {
        e.preventDefault();

        // check if window exists already
        if (jQuery('#' + newWindowId).length < 1) {
            // create new window instance
            jQuery('<div id="' + newWindowId + '"></div>')
                .append(
                    jQuery('<iframe width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto" />')
                        .attr('src', containerElem.attr('href'))
                )
                .dialog({
                    autoOpen: false,
                    show: {
                        effect: 'blind',
                        duration: 1000
                    },
                    hide: {
                        effect: 'explode',
                        duration: 1000
                    },
                    title: title,
                    width: 600,
                    height: 400,
                    modal: false
                });
        }

        // open the window
        jQuery('#' + newWindowId).dialog('open');
    });

    // return the dialog selector id;
    return newWindowId;
}


/**
 * Initialise ajax-based toggle for boolean fields.
 */
function mUMUImageInitToggle(objectType, fieldName, itemId)
{
    var idSuffix = mUMUImageCapitaliseFirstLetter(fieldName) + itemId;
    if (jQuery('#toggle' + idSuffix).length < 1) {
        return;
    }
    jQuery('#toggle' + idSuffix).click( function() {
        mUMUImageToggleFlag(objectType, fieldName, itemId);
    }).removeClass('hidden');
}


/**
 * Toggles a certain flag for a given item.
 */
function mUMUImageToggleFlag(objectType, fieldName, itemId)
{
    var fieldNameCapitalised = mUMUImageCapitaliseFirstLetter(fieldName);
    var params = 'ot=' + objectType + '&field=' + fieldName + '&id=' + itemId;

    jQuery.ajax({
        type: 'POST',
        url: Routing.generate('mumuimagemodule_ajax_toggleflag'),
        data: params
    }).done(function(res) {
        // get data returned by the ajax response
        var idSuffix, data;

        idSuffix = fieldName + '_' + itemId;
        data = res.data;

        /*if (data.message) {
            mUMUImageSimpleAlert(jQuery('#toggle' + idSuffix), Zikula.__('Success', 'mumuimagemodule_js'), data.message, 'toggle' + idSuffix + 'DoneAlert', 'success');
        }*/

        idSuffix = idSuffix.toLowerCase();
        var state = data.state;
        if (state === true) {
            jQuery('#no' + idSuffix).addClass('hidden');
            jQuery('#yes' + idSuffix).removeClass('hidden');
        } else {
            jQuery('#yes' + idSuffix).addClass('hidden');
            jQuery('#no' + idSuffix).removeClass('hidden');
        }
    });
}


/**
 * Simulates a simple alert using bootstrap.
 */
function mUMUImageSimpleAlert(beforeElem, title, content, alertId, cssClass)
{
    var alertBox;

    alertBox = ' \
        <div id="' + alertId + '" class="alert alert-' + cssClass + ' fade"> \
          <button type="button" class="close" data-dismiss="alert">&times;</button> \
          <h4>' + title + '</h4> \
          <p>' + content + '</p> \
        </div>';

    // insert alert before the given element
    beforeElem.before(alertBox);

    jQuery('#' + alertId).delay(200).addClass('in').fadeOut(4000, function () {
        jQuery(this).remove();
    });
}
