{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
<div class="muimage-config">
{gt text='Settings' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='config' size='small' __alt='Settings'}
    <h3>{$templateTitle}</h3>
</div>

    {form cssClass='z-form'}

        {* add validation summary and a <div> element for styling the form *}
        {muimageFormFrame}
        {formsetinitialfocus inputId='pagesize'}
        {formtabbedpanelset}
            {gt text='General' assign='tabTitle'}
            {formtabbedpanel title=$tabTitle}
            <fieldset>
                <legend>{gt text='Here you can manage all basic settings for this application.'}</legend>

                <div class="z-formrow">
                    {formlabel for='pagesize' __text='Albums per page in frontend' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='pagesize' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                </div>
                 <div class="z-formrow">
                    {formlabel for='pageSizeAdminAlbums' __text='Albums per page in backend' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='pageSizeAdminAlbums' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='pageSizeAdminPictures' __text='Pictures per page in backend' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='pageSizeAdminPictures' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='showTitle' __text='Show title' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='showTitle' group='config'}
                </div>
                <div class="z-formrow">
                    {formlabel for='showDescription' __text='Show description' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='showDescription' group='config'}
                </div>
                <div class="z-formrow">
                    {formlabel for='countImageView' __text='Count image view'}
                    {formcheckbox id='countImageView' group='config'}
                </div>
                <div class="z-formrow">
                    {formlabel for='numberParentAlbums' __text='Number parent albums' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='numberParentAlbums' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                    <div class="z-informationmsg z-formnote">{gt text="Enter -1 for none. Empty for unlimited."}</div>
                </div>
                <div class="z-formrow">
                    {formlabel for='numberSubAlbums' __text='Number sub albums' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='numberSubAlbums' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                    <div class="z-informationmsg z-formnote">{gt text="Enter -1 for none. Empty for unlimited."}</div>
                </div>
                <div class="z-formrow">
                    {formlabel for='numberPictures' __text='Number pictures' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='numberPictures' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                    <div class="z-informationmsg z-formnote">{gt text="Enter -1 for none. Empty for unlimited."}</div>
                </div>
                <div class="z-formrow">
                    {formlabel for='fileSize' __text='Allowed filesize?'}
                    {formintinput id='fileSize' group='config' maxLength=20 width=20em __title='Input this setting.'}
                    <div class="z-informationmsg z-formnote">{gt text="102400 = 100 KB."}</div>
                </div>
                <div class="z-formrow">
                    {formlabel for='minWidth' __text='Required width of pictures'}
                    {formintinput id='minWidth' group='config' maxLength=20 width=20em __title='Input this setting.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='axmWidth' __text='Maximum width of pictures'}
                    {formintinput id='maxWidth' group='config' maxLength=20 width=20em __title='Input this setting.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='maxHeight' __text='Maximum height of pictures'}
                    {formintinput id='maxHeight' group='config' maxLength=20 width=20em __title='Input this setting.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='userDeletePictures' __text='May users delete their pictures?' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='userDeletePictures' group='config'}
                </div>
                <div class="z-formrow">
                    {formlabel for='ending' __text='Choose an ending for display of albums and pictures!' class='muimageFormTooltips' title=$toolTip}
                    {formtextinput id='ending' group='config' maxLength=255 width=20em __title='Enter this setting.'}
                    <div class="z-informationmsg z-formnote">{gt text="You can select between html and htm or no ending (empty field)."}</div>
                </div>
                </fieldset>
                {/formtabbedpanel}
                {gt text='Slideshows' assign='tabTitle'}
                {formtabbedpanel title=$tabTitle}
                <fielddset>
                <div class="z-formrow">
                    {formlabel for='slideshow1' __text='Allow Slideshow1?' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='slideshow1' group='config'}
                </div>
                <div id="muimage-config-slideshow1" style="display: none;">
                <div class="z-formrow">
                    {formlabel for='slide1Interval' __text='Interval'}
                    {formtextinput id='slide1Interval' group='config' maxLength=10 width=10em __title='Input this setting.'}
                    <div class="z-informationmsg z-formnote">{gt text="Delay in milliseconds between slides for the automatic slideshow"}</div>
                </div>
                <div class="z-formrow">
                    {formlabel for='slide1Speed' __text='Speed'}
                    {formtextinput id='slide1Speed' group='config' maxLength=10 width=10em __title='Input this setting.'}
                    <div class="z-informationmsg z-formnote">{gt text="The transition speed between slide changes in milliseconds"}</div>
                </div>                  
                </div>
              {*  <div class="z-formrow">
                    {formlabel for='slideshow2' __text='Allow Slideshow2?' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='slideshow2' group='config'}
                </div> *}
                <div id="muimage-config-slideshow2" style="display: none;">
                <div class="z-formrow">
                    {formlabel for='slide1auto' __text='Autostart?'}
                    {formcheckbox id='slide1auto' group='config' __title='Input this setting.'}
                </div>              
                </div>
            </fieldset>
            {/formtabbedpanel}
            {/formtabbedpanelset}
            <div class="z-buttons z-formbuttons">
                {formbutton commandName='save' __text='Update configuration' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/form}
</div>
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
             
    var MU = jQuery.noConflict();
    MU(document).ready(function() {
        if(MU(".z-formrow > #slideshow1").is(':checked')) {
            MU("#muimage-config-slideshow1").css({display: 'block'});
        }
        if(MU(".z-formrow > #slideshow2").is(':checked')) {
            MU("#muimage-config-slideshow2").css({display: 'block'});
        }        
    });
    
    MU(".z-formrow > #slideshow1").click( function() {
        if(MU(this).is(':checked')) {
            MU("#muimage-config-slideshow1").slideDown('slow');
            }
            else {
            	MU("#muimage-config-slideshow1").slideUp('slow');
            }

        });

    MU(".z-formrow > #slideshow2").click( function() {
        if(MU(this).is(':checked')) {
            MU("#muimage-config-slideshow2").slideDown('slow');
            }
            else {
            	MU("#muimage-config-slideshow2").slideUp('slow');
            }

        });  


/* ]]> */
</script>
{include file='admin/footer.tpl'}
