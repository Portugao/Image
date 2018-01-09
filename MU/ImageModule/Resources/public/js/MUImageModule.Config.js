'use strict';

function imageToggleShrinkSettings(fieldName) {
    var idSuffix = fieldName.replace('muimagemodule_appsettings_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#muimagemodule_appsettings_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function () {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            imageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        imageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
