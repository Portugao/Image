'use strict';

var mUImageModule = {};

mUImageModule.itemSelector = {};
mUImageModule.itemSelector.items = {};
mUImageModule.itemSelector.baseId = 0;
mUImageModule.itemSelector.selectedId = 0;

mUImageModule.itemSelector.onLoad = function (baseId, selectedId) {
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

mUImageModule.itemSelector.onParamChanged = function () {
    jQuery('#ajaxIndicator').removeClass('hidden');

    mUImageModule.itemSelector.getItemList();
};

mUImageModule.itemSelector.getItemList = function () {
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

    jQuery.getJSON(Routing.generate('muimagemodule_ajax_getitemlistfinder'), params, function (data) {
        var baseId;

        baseId = mUImageModule.itemSelector.baseId;
        mUImageModule.itemSelector.items[baseId] = data;
        jQuery('#ajaxIndicator').addClass('hidden');
        mUImageModule.itemSelector.updateItemDropdownEntries();
        mUImageModule.itemSelector.updatePreview();
    });
};

mUImageModule.itemSelector.updateItemDropdownEntries = function () {
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

mUImageModule.itemSelector.updatePreview = function () {
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

mUImageModule.itemSelector.onItemChanged = function () {
    var baseId, itemSelector, preview;

    baseId = mUImageModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id').get(0);
    preview = window.atob(mUImageModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    mUImageModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
    mUImageInitImageViewer();
};

jQuery(document).ready(function () {
    var infoElem;

    infoElem = jQuery('#itemSelectorInfo');
    if (infoElem.length == 0) {
        return;
    }

    mUImageModule.itemSelector.onLoad(infoElem.data('base-id'), infoElem.data('selected-id'));
});
