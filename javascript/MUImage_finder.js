'use strict';

var currentMUImageEditor = null;
var currentMUImageInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getPopupAttributes()
{
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',scrollbars,resizable';
}

/**
 * Open a popup window with the finder triggered by a Xinha button.
 */
function MUImageFinderXinha(editor, muimageURL)
{
    var popupAttributes;

    // Save editor for access in selector window
    currentMUImageEditor = editor;

    popupAttributes = getPopupAttributes();
    window.open(muimageURL, '', popupAttributes);
}

/**
 * Open a popup window with the finder triggered by a CKEditor button.
 */
function MUImageFinderCKEditor(editor, muimageURL)
{
    // Save editor for access in selector window
    currentMUImageEditor = editor;

    editor.popup(
        Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUImage&type=external&func=finder&editor=ckeditor',
        /*width*/ '80%', /*height*/ '90%',
        'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'
    );
}



var muimage = {};

muimage.finder = {};

muimage.finder.onLoad = function (baseId, selectedId)
{
    $$('div.categoryselector select').invoke('observe', 'change', muimage.finder.onParamChanged);
    /*$('mUImageSort').observe('change', muimage.finder.onParamChanged);
    $('mUImageSortDir').observe('change', muimage.finder.onParamChanged);*/
    $('mUImagePageSize').observe('change', muimage.finder.onParamChanged);
    /*$('mUImageSearchGo').observe('click', muimage.finder.onParamChanged);
    $('mUImageSearchGo').observe('keypress', muimage.finder.onParamChanged);*/
    $('mUImageSubmit').addClassName('z-hide');
    $('mUImageCancel').observe('click', muimage.finder.handleCancel);
};

muimage.finder.onParamChanged = function ()
{
    $('mUImageSelectorForm').submit();
};

muimage.finder.handleCancel = function ()
{
    var editor, w;

    editor = $F('editorName');
    if (editor === 'xinha') {
        w = parent.window;
        window.close();
        w.focus();
    } else if (editor === 'tinymce') {
        muimageClosePopup();
    } else if (editor === 'ckeditor') {
        muimageClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function getPasteSnippet(mode, itemId)
{
    var objectType, itemUrl, itemTitle, itemDescription, pasteMode;

    objectType = $F('ObjectType');

    if (objectType === 'picture') {
    	var itemPath, tmbPath, prePath, fullPath, origPath, createPictureSizes;
    }

    itemUrl = $F('url' + itemId);
    itemTitle = $F('title' + itemId);
    itemDescription = $F('desc' + itemId);
    if (objectType === 'picture') {
    itemPath = $F('path' + itemId);

    tmbPath = $F('pathtmb' + itemId);
    prePath = $F('pathpre' + itemId);
    fullPath = $F('pathfull' + itemId);
    origPath = $F('pathorig' + itemId);
    createPictureSizes = $F('createPictureSizes');
    if (createPictureSizes === false) {
    	var selectedWidth;
        selectedWidth = $F('mUImageWidth');
    }
    }

    pasteMode = $F('mUImagePasteAs');
    
    
    if (pasteMode === '3') {
    	return '<img alt="' + itemTitle + '" src="' + itemPath + '" width="' + selectedWidth + '" height="auto" />';
    }
    
    if (pasteMode === '4') {
    	return '<img class="img-responsive" alt="' + itemTitle + '" src="' + tmbPath + '" />';
    }
    
    if (pasteMode === '5') {
    	return '<img class="img-responsive" alt="' + itemTitle + '" src="' + prePath + '" />';
    }
    
    if (pasteMode === '6') {
    	return '<a href="' + fullPath + '" rel="imageviewer[picture]"><img class="img-responsive" alt="' + itemTitle + '" src="' + tmbPath + '" /></a>';
    }
    
    if (pasteMode === '7') {
    	return '<a href="' + fullPath + '"rel="imageviewer[picture]"><img class="img-responsive" alt="' + itemTitle + '" src="' + prePath + '" /></a>';
    }
    
    if (pasteMode === '8') {
    	return '<img class="img-responsive" alt="' + itemTitle + '" src="' + origPath + '" />';
    }
    
    if (pasteMode === '2' || pasteMode !== '1') {
        return itemId;
    }

    // return link to item
    if (mode === 'url') {
        // plugin mode
        return itemUrl;
    } else {
        // editor mode
        return '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
}


// User clicks on "select item" button
muimage.finder.selectItem = function (itemId)
{
    var editor, html;

    editor = $F('editorName');
    if (editor === 'xinha') {
        if (window.opener.currentMUImageEditor !== null) {
            html = getPasteSnippet('html', itemId);

            window.opener.currentMUImageEditor.focusEditor();
            window.opener.currentMUImageEditor.insertHTML(html);
        } else {
            html = getPasteSnippet('url', itemId);
            var currentInput = window.opener.currentMUImageInput;

            if (currentInput.tagName === 'INPUT') {
                // Simply overwrite value of input elements
                currentInput.value = html;
            } else if (currentInput.tagName === 'TEXTAREA') {
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
    } else if (editor === 'tinymce') {
        html = getPasteSnippet('html', itemId);
        window.opener.tinyMCE.activeEditor.execCommand('mceInsertContent', false, html);
        // other tinymce commands: mceImage, mceInsertLink, mceReplaceContent, see http://www.tinymce.com/wiki.php/Command_identifiers
    } else if (editor === 'ckeditor') {
        if (window.opener.currentMUImageEditor !== null) {
            html = getPasteSnippet('html', itemId);

            window.opener.currentMUImageEditor.insertHtml(html);
        }
    } else {
        alert('Insert into Editor: ' + editor);
    }
    muimageClosePopup();
};


function muimageClosePopup()
{
    window.opener.focus();
    window.close();
}




//=============================================================================
// MUImage item selector for Forms
//=============================================================================

muimage.itemSelector = {};
muimage.itemSelector.items = {};
muimage.itemSelector.baseId = 0;
muimage.itemSelector.selectedId = 0;

muimage.itemSelector.onLoad = function (baseId, selectedId)
{
    muimage.itemSelector.baseId = baseId;
    muimage.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    $('mUImageObjectType').observe('change', muimage.itemSelector.onParamChanged);

    if ($(baseId + '_catidMain') != undefined) {
        $(baseId + '_catidMain').observe('change', muimage.itemSelector.onParamChanged);
    } else if ($(baseId + '_catidsMain') != undefined) {
        $(baseId + '_catidsMain').observe('change', muimage.itemSelector.onParamChanged);
    }
    $(baseId + 'Id').observe('change', muimage.itemSelector.onItemChanged);
    $(baseId + 'Sort').observe('change', muimage.itemSelector.onParamChanged);
    $(baseId + 'SortDir').observe('change', muimage.itemSelector.onParamChanged);
    $('mUImageSearchGo').observe('click', muimage.itemSelector.onParamChanged);
    $('mUImageSearchGo').observe('keypress', muimage.itemSelector.onParamChanged);

    muimage.itemSelector.getItemList();
};

muimage.itemSelector.onParamChanged = function ()
{
    $('ajax_indicator').removeClassName('z-hide');

    muimage.itemSelector.getItemList();
};

muimage.itemSelector.getItemList = function ()
{
    var baseId, params, request;

    baseId = muimage.itemSelector.baseId;
    params = 'ot=' + baseId + '&';
    if ($(baseId + '_catidMain') != undefined) {
        params += 'catidMain=' + $F(baseId + '_catidMain') + '&';
    } else if ($(baseId + '_catidsMain') != undefined) {
        params += 'catidsMain=' + $F(baseId + '_catidsMain') + '&';
    }
    params += 'sort=' + $F(baseId + 'Sort') + '&' +
              'sortdir=' + $F(baseId + 'SortDir') + '&' +
              'searchterm=' + $F(baseId + 'SearchTerm');

    request = new Zikula.Ajax.Request(
        Zikula.Config.baseURL + 'ajax.php?module=MUImage&func=getItemListFinder',
        {
            method: 'post',
            parameters: params,
            onFailure: function(req) {
                Zikula.showajaxerror(req.getMessage());
            },
            onSuccess: function(req) {
                var baseId;
                baseId = muimage.itemSelector.baseId;
                muimage.itemSelector.items[baseId] = req.getData();
                $('ajax_indicator').addClassName('z-hide');
                muimage.itemSelector.updateItemDropdownEntries();
                muimage.itemSelector.updatePreview();
            }
        }
    );
};

muimage.itemSelector.updateItemDropdownEntries = function ()
{
    var baseId, itemSelector, items, i, item;

    baseId = muimage.itemSelector.baseId;
    itemSelector = $(baseId + 'Id');
    itemSelector.length = 0;

    items = muimage.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.options[i] = new Option(item.title, item.id, false);
    }

    if (muimage.itemSelector.selectedId > 0) {
        $(baseId + 'Id').value = muimage.itemSelector.selectedId;
    }
};

muimage.itemSelector.updatePreview = function ()
{
    var baseId, items, selectedElement, i;

    baseId = muimage.itemSelector.baseId;
    items = muimage.itemSelector.items[baseId];

    $(baseId + 'PreviewContainer').addClassName('z-hide');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (muimage.itemSelector.selectedId > 0) {
        for (i = 0; i < items.length; ++i) {
            if (items[i].id === muimage.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (selectedElement !== null) {
        $(baseId + 'PreviewContainer')
            .update(window.atob(selectedElement.previewInfo))
            .removeClassName('z-hide');
    }
};

muimage.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = muimage.itemSelector.baseId;
    itemSelector = $(baseId + 'Id');
    preview = window.atob(muimage.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    $(baseId + 'PreviewContainer').update(preview);
    muimage.itemSelector.selectedId = $F(baseId + 'Id');
};
