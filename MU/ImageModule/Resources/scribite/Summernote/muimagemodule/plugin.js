( function ($) {
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'muimagemodule': function (context) {
            var self = this;

            // ui provides methods to build ui elements.
            var ui = $.summernote.ui;

            // add button
            context.memo('button.muimagemodule', function () {
                // create button
                var button = ui.button({
                    contents: '<img src="' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/muimage/images/admin.png' + '" alt="Image" width="16" height="16" />',
                    tooltip: 'Image',
                    click: function () {
                        MUImageModuleFinderOpenPopup(context, 'summernote');
                    }
                });

                // create jQuery object from button instance.
                var $button = button.render();

                return $button;
            });
        }
    });
})(jQuery);
