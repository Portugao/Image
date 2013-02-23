
/**
 * Initialise a relation field section with autocompletion and optional edit capabilities
 */
function muimageInitRelationItemsForm(objectType, idPrefix, includeEditing)
{
    // add handling for the toggle link if existing
    if ($(idPrefix + 'AddLink') != undefined) {
        $(idPrefix + 'AddLink').observe('click', function(e) { muimageToggleRelatedItemForm(idPrefix); });
    }
    // add handling for the cancel button
    if ($(idPrefix + 'SelectorDoCancel') != undefined) {
        $(idPrefix + 'SelectorDoCancel').observe('click', function(e) { muimageResetRelatedItemForm(idPrefix); });
    }
    // clear values and ensure starting state
    muimageResetRelatedItemForm(idPrefix);

    var acOptions = {
            paramName: 'fragment',
            minChars: 2,
            indicator: idPrefix + 'Indicator',
            callback: function(inputField, defaultQueryString) {
                    // modify the query string before the request
                    defaultQueryString += '&ot=' + objectType;
                    if ($(idPrefix + 'ItemList') != undefined) {
                        defaultQueryString += '&exclude=' + $F(idPrefix + 'ItemList');
                    }
                    return defaultQueryString;
            },
            afterUpdateElement: function(inputField, selectedListItem) {
                    // Called after the input element has been updated (i.e. when the user has selected an entry).
                    // This function is called after the built-in function that adds the list item text to the input field.
                    muimageSelectRelatedItem(objectType, idPrefix, inputField, selectedListItem);
            }
    };
    relationHandler.each(function(relationHandler) {
        if (relationHandler['prefix'] == (idPrefix + 'SelectorDoNew') && relationHandler['acInstance'] == null) {
            relationHandler['acInstance'] = new Ajax.Autocompleter(
                idPrefix + 'Selector',
                idPrefix + 'SelectorChoices',
                Zikula.Config['baseURL'] + 'ajax.php?module=MUImage&func=getItemList',
                acOptions
            );
        }
    });

    if (!includeEditing || $(idPrefix + 'SelectorDoNew') == undefined) {
        return;
    }

    // from here inline editing will be handled
    $(idPrefix + 'SelectorDoNew').href += '&theme=Printer&idp=' + idPrefix + 'SelectorDoNew';
    $(idPrefix + 'SelectorDoNew').observe('click', function(e) {
        muimageInitInlineWindow(objectType, idPrefix + 'SelectorDoNew')
        e.stop();
    });

    var itemIds = $F(idPrefix + 'ItemList');
    var itemIdsArr = itemIds.split(',');
    itemIdsArr.each(function(existingId) {
        if (existingId) {
            var elemPrefix = idPrefix + 'Reference_' + existingId + 'Edit';
            $(elemPrefix).href += '&theme=Printer&idp=' + elemPrefix;
            $(elemPrefix).observe('click', function(e) {
                muimageInitInlineWindow(objectType, elemPrefix);
                e.stop();
            });
        }
    });
}

/**
 * Add a related item to selection which has been chosen by auto completion
 */
function muimageSelectRelatedItem(objectType, idPrefix, inputField, selectedListItem)
{
    var newItemId = selectedListItem.id;
    var newTitle = $F(idPrefix + 'Selector');
    var includeEditing = ($F(idPrefix + 'Mode') == '1') ? true : false;
    var editLink;
    var removeLink;
    var elemPrefix = idPrefix + 'Reference_' + newItemId;
    var itemPreview = '';
    if ($('itempreview' + selectedListItem.id) != undefined) {
        itemPreview = $('itempreview' + selectedListItem.id).innerHTML;
    }

    var li = Builder.node('li', {id: elemPrefix}, newTitle);
    if (includeEditing == true) {
        var editHref = $(idPrefix + 'SelectorDoNew').href + '&id=' + newItemId;
        editLink = Builder.node('a', {id: elemPrefix + 'Edit', href: editHref}, 'edit');
        li.appendChild(editLink);
    }
    removeLink = Builder.node('a', {id: elemPrefix + 'Remove', href: 'javascript:muimageRemoveRelatedItem(\'' + idPrefix + '\', ' + newItemId + ');'}, 'remove');
    li.appendChild(removeLink);
    if (itemPreview != '') {
        var fldPreview = Builder.node('div', {id: elemPrefix + 'preview', name: idPrefix + 'preview'}, '');
        fldPreview.update(itemPreview);
        li.appendChild(fldPreview);
        itemPreview = '';
    }
    $(idPrefix + 'ReferenceList').appendChild(li);

    if (includeEditing == true) {
        editLink.update(' ' + editImage);

        $(elemPrefix + 'Edit').observe('click', function(e) {
            muimageInitInlineWindow(objectType, idPrefix + 'Reference_' + newItemId + 'Edit');
            e.stop();
        });
    }
    removeLink.update(' ' + removeImage);

    var itemIds = $F(idPrefix + 'ItemList');
    if (itemIds != '') {
        if ($F(idPrefix + 'Scope') == '0') {
            var itemIdsArr = itemIds.split(',');
            itemIdsArr.each(function(existingId) {
                if (existingId) {
                    muimageRemoveRelatedItem(idPrefix, existingId);
                }
            });
            itemIds = '';
        }
        else {
            itemIds += ',';
        }
    }
    itemIds += newItemId;
    $(idPrefix + 'ItemList').value = itemIds;

    muimageResetRelatedItemForm(idPrefix);
}
/**
 * Observe a link for opening an inline window
 */
function muimageInitInlineWindow(objectType, containerID)
{
    // whether the handler has been found
    var found = false;

    // search for the handler
    relationHandler.each(function(relationHandler) {
        // is this the right one
        if (relationHandler['prefix'] == containerID) {
            // yes, it is
            found = true;
            // look whether there is already a window instance
            if (relationHandler['windowInstance'] != null) {
                // unset it
                relationHandler['windowInstance'].destroy();
            }
            // create and assign the new window instance
            relationHandler['windowInstance'] = muimageCreateWindowInstance($(containerID), true);
        }
    });

    // if no handler was found
    if (found === false) {
        // create a new one
        var newItem = new Object();
        newItem['ot'] = objectType;
        newItem['alias'] = '';
        newItem['prefix'] = containerID;
        newItem['acInstance'] = null;
        newItem['windowInstance'] = muimageCreateWindowInstance($(containerID), true);
        // add it to the list of handlers
        relationHandler.push(newItem);
    }
}

/**
 * Helper function to create new Zikula.UI.Window instances.
 * For edit forms we use "iframe: true" to ensure file uploads work without problems.
 * For all other windows we use "iframe: false" because we want the escape key working.
 */
function muimageCreateWindowInstance(containerElem, useIframe)
{
    // define the new window instance
    var newWindow = new Zikula.UI.Window(
        containerElem,
        {
            minmax: true,
            resizable: true,
            //title: containerElem.title,
            width: 600,
            initMaxHeight: 500,
            modal: false,
            iframe: useIframe
        }
    );

    // open it
    newWindow.openHandler();

    // return the instance
    return newWindow;
}

/**
 * Removes a related item from the list of selected ones.
 */
function muimageRemoveRelatedItem(idPrefix, removeId)
{
    var itemIds = $F(idPrefix + 'ItemList');
    var itemIdsArr = itemIds.split(',');
    itemIdsArr = itemIdsArr.without(removeId);
    itemIds = itemIdsArr.join(',');
    $(idPrefix + 'ItemList').value = itemIds;
    $(idPrefix + 'Reference_' + removeId).remove();
}

/**
 * Resets an auto completion field.
 */
function muimageResetRelatedItemForm(idPrefix)
{
    // hide the sub form
    muimageToggleRelatedItemForm(idPrefix);

    // reset value of the auto completion field
    $(idPrefix + 'Selector').value = '';
}

/**
 * Toggles the fields of an auto completion field.
 */
function muimageToggleRelatedItemForm(idPrefix)
{
    // if we don't have a toggle link do nothing
    if ($(idPrefix + 'AddLink') == undefined) {
        return;
    }

    // show/hide the toggle link
    $(idPrefix + 'AddLink').toggle();

    // hide/show the fields
    $(idPrefix + 'AddFields').toggle();
}

/**
 * Closes an iframe from the document displayed in it
 */
function muimageCloseWindowFromInside(idPrefix, itemID)
{
    // if there is no parent window do nothing
    if (window.parent == '') {
        return;
    }

    // search for the handler of the current window
    window.parent.relationHandler.each(function(relationHandler) {
        // look if this handler is the right one
        if (relationHandler['prefix'] == idPrefix) {
            // do we have an item created
            if (itemID > 0) {
                // look whether there is an auto completion instance
                if (relationHandler['acInstance'] != null) {
                    // activate it
                    relationHandler['acInstance'].activate();
                    // show a message 
                    Zikula.UI.Alert('Action has been completed.', 'Information');
                }
            }
            // look whether there is a windows instance
            if (relationHandler['windowInstance'] != null) {
                // close it
                relationHandler['windowInstance'].closeHandler();
            }
        }
    });
}


// TODO: support auto-hiding notification windows (see https://github.com/zikula/core/issues/121 for more information)

