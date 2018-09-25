'use strict';

function imageToggleShrinkSettings(fieldName) {
    var idSuffix;

    idSuffix = fieldName.replace('muimagemodule_config_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#muimagemodule_config_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function () {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            imageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        imageToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
