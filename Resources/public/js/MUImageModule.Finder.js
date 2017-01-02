'use strict';

var currentMUImageModuleEditor = null;
var currentMUImageModuleInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getMUImageModulePopupAttributes()
{
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',scrollbars,resizable';
}

/**
 * Open a popup window with the finder triggered by a CKEditor button.
 */
function MUImageModuleFinderCKEditor(editor, muimageUrl)
{
    // Save editor for access in selector window
    currentMUImageModuleEditor = editor;

    editor.popup(
        Routing.generate('muimagemodule_external_finder', { objectType: 'album', editor: 'ckeditor' }),
        /*width*/ '80%', /*height*/ '70%',
        'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'
    );
}


var mUImageModule = {};

mUImageModule.finder = {};

mUImageModule.finder.onLoad = function (baseId, selectedId)
{
    jQuery('select').not("[id$='pasteas']").change(mUImageModule.finder.onParamChanged);
    
    jQuery('.btn-default').click(mUImageModule.finder.handleCancel);

    var selectedItems = jQuery('#muimagemoduleItemContainer li a');
    selectedItems.bind('click keypress', function (e) {
        e.preventDefault();
        mUImageModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

mUImageModule.finder.onParamChanged = function ()
{
    jQuery('#mUImageModuleSelectorForm').submit();
};

mUImageModule.finder.handleCancel = function ()
{
    var editor;

    editor = jQuery("[id$='editor']").first().val();
    if ('tinymce' === editor) {
        mUImageClosePopup();
    } else if ('ckeditor' === editor) {
        mUImageClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function mUImageGetPasteSnippet(mode, itemId)
{
    var quoteFinder, itemUrl, itemTitle, itemDescription, pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '').trim();
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '').trim();
    pasteMode = jQuery("[id$='pasteas']").first().val();

    if (pasteMode === '2' || pasteMode !== '1') {
        return '' + itemId;
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
mUImageModule.finder.selectItem = function (itemId)
{
    var editor, html;

    editor = jQuery("[id$='editor']").first().val();
    if ('tinymce' === editor) {
        html = mUImageGetPasteSnippet('html', itemId);
        tinyMCE.activeEditor.execCommand('mceInsertContent', false, html);
        // other tinymce commands: mceImage, mceInsertLink, mceReplaceContent, see http://www.tinymce.com/wiki.php/Command_identifiers
    } else if ('ckeditor' === editor) {
        if (null !== window.opener.currentMUImageModuleEditor) {
            html = mUImageGetPasteSnippet('html', itemId);

            window.opener.currentMUImageModuleEditor.insertHtml(html);
        }
    } else {
        alert('Insert into Editor: ' + editor);
    }
    mUImageClosePopup();
};

function mUImageClosePopup()
{
    window.opener.focus();
    window.close();
}




//=============================================================================
// MUImageModule item selector for Forms
//=============================================================================

mUImageModule.itemSelector = {};
mUImageModule.itemSelector.items = {};
mUImageModule.itemSelector.baseId = 0;
mUImageModule.itemSelector.selectedId = 0;

mUImageModule.itemSelector.onLoad = function (baseId, selectedId)
{
    mUImageModule.itemSelector.baseId = baseId;
    mUImageModule.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    jQuery('#mUImageModuleObjectType').change(mUImageModule.itemSelector.onParamChanged);

    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        jQuery('#' + baseId + '_catidMain').change(mUImageModule.itemSelector.onParamChanged);
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        jQuery('#' + baseId + '_catidsMain').change(mUImageModule.itemSelector.onParamChanged);
    }
    jQuery('#' + baseId + 'Id').change(mUImageModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#mUImageModuleSearchGo').click(mUImageModule.itemSelector.onParamChanged);
    jQuery('#mUImageModuleSearchGo').keypress(mUImageModule.itemSelector.onParamChanged);

    mUImageModule.itemSelector.getItemList();
};

mUImageModule.itemSelector.onParamChanged = function ()
{
    jQuery('#ajax_indicator').removeClass('hidden');

    mUImageModule.itemSelector.getItemList();
};

mUImageModule.itemSelector.getItemList = function ()
{
    var baseId, params;

    baseId = image.itemSelector.baseId;
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
        url: Routing.generate('muimagemodule_ajax_getitemlistfinder'),
        data: params
    }).done(function(res) {
        // get data returned by the ajax response
        var baseId;
        baseId = mUImageModule.itemSelector.baseId;
        mUImageModule.itemSelector.items[baseId] = res.data;
        jQuery('#ajax_indicator').addClass('hidden');
        mUImageModule.itemSelector.updateItemDropdownEntries();
        mUImageModule.itemSelector.updatePreview();
    });
};

mUImageModule.itemSelector.updateItemDropdownEntries = function ()
{
    var baseId, itemSelector, items, i, item;

    baseId = mUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    itemSelector.length = 0;

    items = mUImageModule.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.options[i] = new Option(item.title, item.id, false);
    }

    if (mUImageModule.itemSelector.selectedId > 0) {
        jQuery('#' + baseId + 'Id').val(mUImageModule.itemSelector.selectedId);
    }
};

mUImageModule.itemSelector.updatePreview = function ()
{
    var baseId, items, selectedElement, i;

    baseId = mUImageModule.itemSelector.baseId;
    items = mUImageModule.itemSelector.items[baseId];

    jQuery('#' + baseId + 'PreviewContainer').addClass('hidden');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (mUImageModule.itemSelector.selectedId > 0) {
        for (var i = 0; i < items.length; ++i) {
            if (items[i].id === mUImageModule.itemSelector.selectedId) {
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

mUImageModule.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = mUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    preview = window.atob(mUImageModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    mUImageModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
};
