var muimagemodule = function(quill, options) {
    setTimeout(function() {
        var button;

        button = jQuery('button[value=muimagemodule]');

        button
            .css('background', 'url(' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/muimage/images/admin.png) no-repeat center center transparent')
            .css('background-size', '16px 16px')
            .attr('title', 'Image')
        ;

        button.click(function() {
            MUImageModuleFinderOpenPopup(quill, 'quill');
        });
    }, 1000);
};
