/**
 * Helper function to create new Zikula.UI.Window instances.
 * For edit forms we use "iframe: true" to ensure file uploads work without problems.
 * For all other windows we use "iframe: false" because we want the escape key working.
 */
function muimageInitInlineWindow(containerElem, title)
{
    // show the container (hidden for users without JavaScript)
    containerElem.show();

    // define the new window instance
    var newWindow = new Zikula.UI.Window(
        containerElem,
        {
            minmax: true,
            resizable: true,
            title: title,
            width: 600,
            initMaxHeight: 400,
            modal: false,
            iframe: false
        }
    );

    // return the instance
    return newWindow;
}

/**
 * Initialise ajax-based toggle for boolean fields.
 */
function muimageInitToggle(objectType, fieldName, itemId)
{
    var idSuffix = fieldName.toLowerCase() + itemId;
    if ($('toggle' + idSuffix) == undefined) {
        return;
    }
    $('toggle' + idSuffix).observe('click', function() {
        muimageToggleFlag(objectType, fieldName, itemId);
    }).show();
}

/**
 * Toggle a certain flag for a given item.
 */
function muimageToggleFlag(objectType, fieldName, itemId)
{
    var pars = 'ot=' + objectType + '&field=' + fieldName + '&id=' + itemId;

    new Zikula.Ajax.Request(
        Zikula.Config.baseURL + 'ajax.php?module=MUImage&func=toggleFlag',
        {
            method: 'post',
            parameters: pars,
            onComplete: function(req) {
                if (!req.isSuccess()) {
                    Zikula.UI.Alert(req.getMessage(), Zikula.__('Error', 'module_MUImage'));
                    return;
                }
                var data = req.getData();
                /*if (data.message) {
                    Zikula.UI.Alert(data.message, Zikula.__('Success', 'module_MUImage'));
                }*/

                var idSuffix = fieldName.toLowerCase() + '_' + itemId;
                var state = data.state;
                if (state === true) {
                    $('no' + idSuffix).hide();
                    $('yes' + idSuffix).show();
                } else {
                    $('yes' + idSuffix).hide();
                    $('no' + idSuffix).show();
                }
            }
        }
    );
}

