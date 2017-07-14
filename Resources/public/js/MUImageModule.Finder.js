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
    var imageModeEnabled;

    imageModeEnabled = jQuery("[id$='onlyImages']").prop('checked');
    if (!imageModeEnabled) {
        jQuery('#imageFieldRow').addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=6]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=7]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=8]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=9]").addClass('hidden');
    } else {
        jQuery('#searchTermRow').addClass('hidden');
    }

    jQuery('input[type="checkbox"]').click(mUImageModule.finder.onParamChanged);
    jQuery('select').not("[id$='pasteAs']").change(mUImageModule.finder.onParamChanged);
    
    jQuery('.btn-default').click(mUImageModule.finder.handleCancel);

    var selectedItems = jQuery('#muimagemoduleItemContainer a');
    selectedItems.bind('click keypress', function (event) {
        event.preventDefault();
        mUImageModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

mUImageModule.finder.onParamChanged = function ()
{
    jQuery('#mUImageModuleSelectorForm').submit();
};

mUImageModule.finder.handleCancel = function (event)
{
    var editor;

    event.preventDefault();
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
    var quoteFinder;
    var itemPath;
    var itemUrl;
    var itemTitle;
    var itemDescription;
    var imagePath;
    var pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemPath = jQuery('#path' + itemId).val().replace(quoteFinder, '');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '').trim();
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '').trim();
    imagePath = jQuery('#imagePath' + itemId).length > 0 ? jQuery('#imagePath' + itemId).val().replace(quoteFinder, '') : '';
    pasteMode = jQuery("[id$='pasteAs']").first().val();

    // item ID
    if (pasteMode === '3') {
        return '' + itemId;
    }

    // relative link to detail page
    if (pasteMode === '1') {
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    // absolute url to detail page
    if (pasteMode === '2') {
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }

    if (pasteMode === '6') {
        // relative link to image file
        return mode === 'url' ? imagePath : '<a href="' + imagePath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    if (pasteMode === '7') {
        // image tag
        return '<img src="' + imagePath + '" alt="' + itemTitle + '" width="300" />';
    }
    if (pasteMode === '8') {
        // image tag with relative link to detail page
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }
    if (pasteMode === '9') {
        // image tag with absolute url to detail page
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }


    return '';
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

    jQuery('#' + baseId + '_catidMain').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + '_catidsMain').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'Id').change(mUImageModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(mUImageModule.itemSelector.onParamChanged);
    jQuery('#mUImageModuleSearchGo').click(mUImageModule.itemSelector.onParamChanged);
    jQuery('#mUImageModuleSearchGo').keypress(mUImageModule.itemSelector.onParamChanged);

    mUImageModule.itemSelector.getItemList();
};

mUImageModule.itemSelector.onParamChanged = function ()
{
    jQuery('#ajaxIndicator').removeClass('hidden');

    mUImageModule.itemSelector.getItemList();
};

mUImageModule.itemSelector.getItemList = function ()
{
    var baseId;
    var params;

    baseId = mUImageModule.itemSelector.baseId;
    params = {
        ot: baseId,
        sort: jQuery('#' + baseId + 'Sort').val(),
        sortdir: jQuery('#' + baseId + 'SortDir').val(),
        q: jQuery('#' + baseId + 'SearchTerm').val()
    }
    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        params[catidMain] = jQuery('#' + baseId + '_catidMain').val();
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        params[catidsMain] = jQuery('#' + baseId + '_catidsMain').val();
    }

    jQuery.getJSON(Routing.generate('muimagemodule_ajax_getitemlistfinder'), params, function( data ) {
        var baseId;

        baseId = mUImageModule.itemSelector.baseId;
        mUImageModule.itemSelector.items[baseId] = data;
        jQuery('#ajaxIndicator').addClass('hidden');
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
        itemSelector.get(0).options[i] = new Option(item.title, item.id, false);
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
            if (items[i].id == mUImageModule.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (null !== selectedElement) {
        jQuery('#' + baseId + 'PreviewContainer')
            .html(window.atob(selectedElement.previewInfo))
            .removeClass('hidden');
        mUImageInitImageViewer();
    }
};

mUImageModule.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = mUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id').get(0);
    preview = window.atob(mUImageModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    mUImageModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
    mUImageInitImageViewer();
};
