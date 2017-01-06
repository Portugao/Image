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

var editedObjectType;
var editedEntityId;
var editForm;
var formButtons;
var triggerValidation = true;

function mUImageTriggerFormValidation()
{
    mUImagePerformCustomValidationConstraints(editedObjectType, editedEntityId);

    if (!editForm.get(0).checkValidity()) {
        // This does not really submit the form,
        // but causes the browser to display the error message
        editForm.find(':submit').first().click();
    }
}

function mUImageHandleFormSubmit (event) {
    if (triggerValidation) {
        mUImageTriggerFormValidation();
        if (!editForm.get(0).checkValidity()) {
            event.preventDefault();
            return false;
        }
    }

    // hide form buttons to prevent double submits by accident
    formButtons.each(function (index) {
        jQuery(this).addClass('hidden');
    });

    return true;
}

/**
 * Initialises an entity edit form.
 */
function mUImageInitEditForm(mode, entityId)
{
    if (jQuery('.muimage-edit-form').length < 1) {
        return;
    }

    editForm = jQuery('.muimage-edit-form').first();
    editedObjectType = editForm.attr('id').replace('EditForm', '');
    editedEntityId = entityId;

    var allFormFields = editForm.find('input, select, textarea');
    allFormFields.change(mUImageExecuteCustomValidationConstraints);

    formButtons = editForm.find('.form-buttons input');
    editForm.find('.btn-danger').first().bind('click keypress', function (event) {
        if (!window.confirm(Translator.__('Do you really want to delete this entry?'))) {
            event.preventDefault();
        }
    });
    editForm.find('button[type=submit]').bind('click keypress', function (event) {
        triggerValidation = !jQuery(this).attr('formnovalidate');
    });
    editForm.submit(mUImageHandleFormSubmit);
    if (mode != 'create') {
        mUImageTriggerFormValidation();
    }
}

