'use strict';

function muimageToggleShrinkSettings(fieldName) {
    var idSuffix = fieldName.replace('muimagemodule_appsettings_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#muimagemodule_appsettings_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function() {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            muimageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        muimageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
