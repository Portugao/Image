'use strict';

var currentMUMUImageModuleEditor = null;
var currentMUMUImageModuleInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getMUMUImageModulePopupAttributes()
{
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',scrollbars,resizable';
}

/**
 * Open a popup window with the finder triggered by a Xinha button.
 */
function MUMUImageModuleFinderXinha(editor, muimageUrl)
{
    var popupAttributes;

    // Save editor for access in selector window
    currentMUMUImageModuleEditor = editor;

    popupAttributes = getMUMUImageModulePopupAttributes();
    window.open(muimageUrl, '', popupAttributes);
}

/**
 * Open a popup window with the finder triggered by a CKEditor button.
 */
function MUMUImageModuleFinderCKEditor(editor, muimageUrl)
{
    // Save editor for access in selector window
    currentMUMUImageModuleEditor = editor;

    editor.popup(
        Routing.generate('mumuimagemodule_external_finder', { editor: 'ckeditor' }),
        /*width*/ '80%', /*height*/ '70%',
        'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'
    );
}


var mUMUImageModule = {};

mUMUImageModule.finder = {};

mUMUImageModule.finder.onLoad = function (baseId, selectedId)
{
    jQuery('div.category-selector select').change(mUMUImageModule.finder.onParamChanged);
    jQuery('#mUMUImageModuleSort').change(mUMUImageModule.finder.onParamChanged);
    jQuery('#mUMUImageModuleSortDir').change(mUMUImageModule.finder.onParamChanged);
    jQuery('#mUMUImageModulePageSize').change(mUMUImageModule.finder.onParamChanged);
    jQuery('#mUMUImageModuleCancel').click(mUMUImageModule.finder.handleCancel);

    var selectedItems = jQuery('#mumuimagemoduleItemContainer li a');
    selectedItems.bind('click keypress', function (e) {
        e.preventDefault();
        mUMUImageModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

mUMUImageModule.finder.onParamChanged = function ()
{
    jQuery('#mUMUImageModuleSelectorForm').submit();
};

mUMUImageModule.finder.handleCancel = function ()
{
    var editor, w;

    editor = jQuery('#editorName').val();
    if ('xinha' === editor) {
        w = parent.window;
        window.close();
        w.focus();
    } else if (editor === 'tinymce') {
        mUMUImageClosePopup();
    } else if (editor === 'ckeditor') {
        mUMUImageClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function mUMUImageGetPasteSnippet(mode, itemId)
{
    var quoteFinder, itemUrl, itemTitle, itemDescription, pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '');
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '');
    pasteMode = jQuery('#mUMUImageModulePasteAs').val();

    if (pasteMode === '2' || pasteMode !== '1') {
        return itemId;
    }

    // return link to item
    if (mode === 'url') {
        // plugin mode
        return itemUrl;
    }

    // editor mode
    return '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
}


// User clicks on "select item" button
mUMUImageModule.finder.selectItem = function (itemId)
{
    var editor, html;

    editor = jQuery('#editorName').val();
    if ('xinha' === editor) {
        if (null !== window.opener.currentMUMUImageModuleEditor) {
            html = mUMUImageGetPasteSnippet('html', itemId);

            window.opener.currentMUMUImageModuleEditor.focusEditor();
            window.opener.currentMUMUImageModuleEditor.insertHTML(html);
        } else {
            html = mUMUImageGetPasteSnippet('url', itemId);
            var currentInput = window.opener.currentMUMUImageModuleInput;

            if ('INPUT' === currentInput.tagName) {
                // Simply overwrite value of input elements
                currentInput.value = html;
            } else if ('TEXTAREA' === currentInput.tagName) {
                // Try to paste into textarea - technique depends on environment
                if (typeof document.selection !== 'undefined') {
                    // IE: Move focus to textarea (which fortunately keeps its current selection) and overwrite selection
                    currentInput.focus();
                    window.opener.document.selection.createRange().text = html;
                } else if (typeof currentInput.selectionStart !== 'undefined') {
                    // Firefox: Get start and end points of selection and create new value based on old value
                    var startPos = currentInput.selectionStart;
                    var endPos = currentInput.selectionEnd;
                    currentInput.value = currentInput.value.substring(0, startPos)
                                        + html
                                        + currentInput.value.substring(endPos, currentInput.value.length);
                } else {
                    // Others: just append to the current value
                    currentInput.value += html;
                }
            }
        }
    } else if ('tinymce' === editor) {
        html = mUMUImageGetPasteSnippet('html', itemId);
        tinyMCE.activeEditor.execCommand('mceInsertContent', false, html);
        // other tinymce commands: mceImage, mceInsertLink, mceReplaceContent, see http://www.tinymce.com/wiki.php/Command_identifiers
    } else if ('ckeditor' === editor) {
        if (null !== window.opener.currentMUMUImageModuleEditor) {
            html = mUMUImageGetPasteSnippet('html', itemId);

            window.opener.currentMUMUImageModuleEditor.insertHtml(html);
        }
    } else {
        alert('Insert into Editor: ' + editor);
    }
    mUMUImageClosePopup();
};

function mUMUImageClosePopup()
{
    window.opener.focus();
    window.close();
}




//=============================================================================
// MUMUImageModule item selector for Forms
//=============================================================================

mUMUImageModule.itemSelector = {};
mUMUImageModule.itemSelector.items = {};
mUMUImageModule.itemSelector.baseId = 0;
mUMUImageModule.itemSelector.selectedId = 0;

mUMUImageModule.itemSelector.onLoad = function (baseId, selectedId)
{
    mUMUImageModule.itemSelector.baseId = baseId;
    mUMUImageModule.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    jQuery('#mUMUImageModuleObjectType').change(mUMUImageModule.itemSelector.onParamChanged);

    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        jQuery('#' + baseId + '_catidMain').change(mUMUImageModule.itemSelector.onParamChanged);
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        jQuery('#' + baseId + '_catidsMain').change(mUMUImageModule.itemSelector.onParamChanged);
    }
    jQuery('#' + baseId + 'Id').change(mUMUImageModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(mUMUImageModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(mUMUImageModule.itemSelector.onParamChanged);
    jQuery('#mUMUImageModuleSearchGo').click(mUMUImageModule.itemSelector.onParamChanged);
    jQuery('#mUMUImageModuleSearchGo').keypress(mUMUImageModule.itemSelector.onParamChanged);

    mUMUImageModule.itemSelector.getItemList();
};

mUMUImageModule.itemSelector.onParamChanged = function ()
{
    jQuery('#ajax_indicator').removeClass('hidden');

    mUMUImageModule.itemSelector.getItemList();
};

mUMUImageModule.itemSelector.getItemList = function ()
{
    var baseId, params;

    baseId = muimage.itemSelector.baseId;
    params = 'ot=' + baseId + '&';
    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        params += 'catidMain=' + jQuery('#' + baseId + '_catidMain').val() + '&';
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        params += 'catidsMain=' + jQuery('#' + baseId + '_catidsMain').val() + '&';
    }
    params += 'sort=' + jQuery('#' + baseId + 'Sort').val() + '&' +
              'sortdir=' + jQuery('#' + baseId + 'SortDir').val() + '&' +
              'q=' + jQuery('#' + baseId + 'SearchTerm').val();

    jQuery.ajax({
        type: 'POST',
        url: Routing.generate('mumuimagemodule_ajax_getitemlistfinder'),
        data: params
    }).done(function(res) {
        // get data returned by the ajax response
        var baseId;
        baseId = mUMUImageModule.itemSelector.baseId;
        mUMUImageModule.itemSelector.items[baseId] = res.data;
        jQuery('#ajax_indicator').addClass('hidden');
        mUMUImageModule.itemSelector.updateItemDropdownEntries();
        mUMUImageModule.itemSelector.updatePreview();
    });
};

mUMUImageModule.itemSelector.updateItemDropdownEntries = function ()
{
    var baseId, itemSelector, items, i, item;

    baseId = mUMUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    itemSelector.length = 0;

    items = mUMUImageModule.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.options[i] = new Option(item.title, item.id, false);
    }

    if (mUMUImageModule.itemSelector.selectedId > 0) {
        jQuery('#' + baseId + 'Id').val(mUMUImageModule.itemSelector.selectedId);
    }
};

mUMUImageModule.itemSelector.updatePreview = function ()
{
    var baseId, items, selectedElement, i;

    baseId = mUMUImageModule.itemSelector.baseId;
    items = mUMUImageModule.itemSelector.items[baseId];

    jQuery('#' + baseId + 'PreviewContainer').addClass('hidden');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (mUMUImageModule.itemSelector.selectedId > 0) {
        for (var i = 0; i < items.length; ++i) {
            if (items[i].id === mUMUImageModule.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (null !== selectedElement) {
        jQuery('#' + baseId + 'PreviewContainer')
            .html(window.atob(selectedElement.previewInfo))
            .removeClass('hidden');
    }
};

mUMUImageModule.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = mUMUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    preview = window.atob(mUMUImageModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    mUMUImageModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
};
