{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
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
                        <legend>{$tabTitle}</legend>
                    
                        <p class="z-confirmationmsg">{gt text='Here you can manage all basic settings for this application.'}</p>
                    
                        <div class="z-formrow">
                            {gt text='Pagesize in frontend' assign='toolTip'}
                            {formlabel for='pagesize' __text='Pagesize' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='pagesize' group='config' maxLength=255 __title='Enter the pagesize. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='pageSizeAdminAlbums' __text='Page size admin albums' cssClass=''}
                                {formintinput id='pageSizeAdminAlbums' group='config' maxLength=255 __title='Enter the page size admin albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='pageSizeAdminPictures' __text='Page size admin pictures' cssClass=''}
                                {formintinput id='pageSizeAdminPictures' group='config' maxLength=255 __title='Enter the page size admin pictures. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='Standard setting for showing a title of an image' assign='toolTip'}
                            {formlabel for='showTitle' __text='Show title' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='showTitle' group='config'}
                        </div>
                        <div class="z-formrow">
                            {gt text='Standard setting for showing a description of an image' assign='toolTip'}
                            {formlabel for='showDescription' __text='Show description' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='showDescription' group='config'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='countImageView' __text='Count image view' cssClass=''}
                                {formcheckbox id='countImageView' group='config'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many main albums may a user create' assign='toolTip'}
                            {formlabel for='numberParentAlbums' __text='Number parent albums' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberParentAlbums' group='config' maxLength=255 __title='Enter the number parent albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many sub albums may a user create' assign='toolTip'}
                            {formlabel for='numberSubAlbums' __text='Number sub albums' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberSubAlbums' group='config' maxLength=255 __title='Enter the number sub albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many pictures may a user create' assign='toolTip'}
                            {formlabel for='numberPictures' __text='Number pictures' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberPictures' group='config' maxLength=255 __title='Enter the number pictures. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='fileSize' __text='File size' cssClass=''}
                                {formintinput id='fileSize' group='config' maxLength=255 __title='Enter the file size. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='zipSize' __text='Zip size' cssClass=''}
                                {formintinput id='zipSize' group='config' maxLength=255 __title='Enter the file size. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='minWidth' __text='Min width' cssClass=''}
                                {formintinput id='minWidth' group='config' maxLength=255 __title='Enter the min width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='maxWidth' __text='Max width' cssClass=''}
                                {formintinput id='maxWidth' group='config' maxLength=255 __title='Enter the max width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='maxHeight' __text='Max height' cssClass=''}
                                {formintinput id='maxHeight' group='config' maxLength=255 __title='Enter the max height. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='layout' __text='Layout' cssClass=''}
                                {formdropdownlist id='layout' group='config' __title='Choose the layout'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='groupForCommonAlbums' __text='Group for common albums' cssClass=''}
                                {formdropdownlist id='groupForCommonAlbums' group='config' __title='Choose the group for common albums'}
                        </div>
                        <div class="z-formrow">
                            {gt text='If set to true, pictures get modified to maximum width and height for pictures set in the settings.' assign='toolTip'}   
                            {formlabel for='shrinkPictures' __text='Shrink pictures' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='shrinkPictures' group='config'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='ending' __text='Ending' cssClass=''}
                                {formtextinput id='ending' group='config' maxLength=255 __title='Enter the ending.'}
                                <div class="z-informationmsg z-formnote">{gt text="You can select between html and htm or no ending (empty field)."}</div>
                        </div>
                        <div class="z-formrow">
                            {gt text='If this option is set to true, standard users are able to delete pictures in their albums.' assign='toolTip'}      
                            {formlabel for='userDeletePictures' __text='User delete pictures' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='userDeletePictures' group='config'}
                        </div>
                        <div class="z-formrow">
                            {gt text='If this option is set to true, for multi upload and zip upload we get the file name for a title. It is not possible to edit the title directly after upload.' assign='toolTip'}
                            {formlabel for='fileNameForTitle' __text='File name for title' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='fileNameForTitle' group='config'}
                        </div>
                    </fieldset>
                {/formtabbedpanel}
                {gt text='Slideshows' assign='tabTitle'}
                {formtabbedpanel title=$tabTitle}
                    <fieldset>
                        <legend>{$tabTitle}</legend>
                    
                    
                        <div class="z-formrow">
                            {formlabel for='slideshow1' __text='1. slideshow' cssClass=''}
                                {formcheckbox id='slideshow1' group='config'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='slide1Interval' __text='Interval for 1. slideshow' cssClass=''}
                                {formintinput id='slide1Interval' group='config' maxLength=255 __title='Enter the slide1 interval. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {formlabel for='slide1Speed' __text='Speed for 1. slideshow' cssClass=''}
                                {formintinput id='slide1Speed' group='config' maxLength=255 __title='Enter the slide1 speed. Only digits are allowed.'}
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
{include file='admin/footer.tpl'}
<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        Zikula.UI.Tooltips($$('.muimage-form-tooltips'));
    });
/* ]]> */
</script>
