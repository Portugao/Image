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
                            {gt text='Here you can set the number of items per page in frontend' assign='toolTip'}
                            {formlabel for='pagesize' __text='Number of items per page' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='pagesize' group='config' maxLength=255 __title='Enter the pagesize. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        {gt text='Here you can set the number of albums per page in backend.' assign='toolTip'}
                            {formlabel for='pageSizeAdminAlbums' __text='Page size admin albums' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='pageSizeAdminAlbums' group='config' maxLength=255 __title='Enter the page size admin albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        {gt text='Here you can set the number of pictures per page in backend.' assign='toolTip'}
                            {formlabel for='pageSizeAdminPictures' __text='Page size admin pictures' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='pageSizeAdminPictures' group='config' maxLength=255 __title='Enter the page size admin pictures. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='Standard setting for showing a title of a picture.' assign='toolTip'}
                            {formlabel for='showTitle' __text='Show title' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='showTitle' group='config'}
                        </div>
                        <div class="z-formrow">
                            {gt text='Standard setting for showing a description of a picture.' assign='toolTip'}
                            {formlabel for='showDescription' __text='Show description' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='showDescription' group='config'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can activate the count of access to detail pages of pictures.' assign='toolTip'}
                            {formlabel for='countImageView' __text='Count image view' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='countImageView' group='config'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many main albums may a user create? Not relevant for admins.' assign='toolTip'}
                            {formlabel for='numberParentAlbums' __text='Number parent albums' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberParentAlbums' group='config' maxLength=255 __title='Enter the number parent albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many sub albums may a user create? Not relevant for admins.' assign='toolTip'}
                            {formlabel for='numberSubAlbums' __text='Number sub albums' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberSubAlbums' group='config' maxLength=255 __title='Enter the number sub albums. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='How many pictures may a user create? Not relevant for admins' assign='toolTip'}
                            {formlabel for='numberPictures' __text='Number pictures' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='numberPictures' group='config' maxLength=255 __title='Enter the number pictures. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the maximum file size for pictures.' assign='toolTip'}
                            {formlabel for='fileSize' __text='File size' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='fileSize' group='config' maxLength=255 __title='Enter the file size. Only digits are allowed.'}
                                <div class="z-informationmsg z-formnote">{gt text="In kilobytes. 102400 means 100 KB."}</div>
                        </div>
                        <div class="z-formrow">
                            {gt text='Here you can set the maximum file size for zip upload.' assign='toolTip'}
                            {formlabel for='zipSize' __text='Zip size' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='zipSize' group='config' maxLength=255 __title='Enter the file size. Only digits are allowed.'}
                                <div class="z-informationmsg z-formnote">{gt text="In kilobytes. 102400 means 100 KB."}</div>
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the minimum width for pictures.' assign='toolTip'}
                            {formlabel for='minWidth' __text='Minimum width for pictures.' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='minWidth' group='config' maxLength=255 __title='Enter the minimum width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the maximum width for pictures.' assign='toolTip'}
                            {formlabel for='maxWidth' __text='Maximum width for pictures.' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='maxWidth' group='config' maxLength=255 __title='Enter the maximum width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the maximum height for pictures.' assign='toolTip'}
                            {formlabel for='maxHeight' __text='Max height' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='maxHeight' group='config' maxLength=255 __title='Enter the max height. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set different layouts.' assign='toolTip'}
                            {formlabel for='layout' __text='Layout' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formdropdownlist id='layout' group='config' __title='Choose the layout'}
                        </div>
                        <div class="z-formrow">
                            {gt text='Here you can set a group for common access to albums. Admin and user group are not selectable. Create another group like editors to be able to work on albums together. Every member of this group can edit albums created by a group member. If not set, every user that is in the admin group has access to each album.' assign='toolTip'}
                            {formlabel for='groupForCommonAlbums' __text='Group for common albums' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formdropdownlist id='groupForCommonAlbums' group='config' __title='Choose the group for common albums'}
                                <div class="z-informationmsg z-formnote">{gt text="If a group is set, all users of this group have access to the albums, that created a group member. Admins have access to each album if set or not."}</div>
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can enable categories.' assign='toolTip'}
                            {formlabel for='supportCategories' __text='Support categories?' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='supportCategories' group='config' maxLength=255 __title='Enable categories.'}
   						</div>
                        <div class="z-formrow">
                        	{gt text='Here you can enable breadcrumbs in the display template for albums.' assign='toolTip'}
                            {formlabel for='breadcrumbInFrontend' __text='Breadcrumbs in Frontend?' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='breadcrumbInFrontend' group='config' maxLength=255 __title='Enable breadcrumbs.'}
   						</div>
                        <div class="z-formrow">
                            {formlabel for='kindOfShowSubAlbums' __text='Kind of show sub albums' cssClass=''}
                                {formdropdownlist id='kindOfShowSubAlbums' group='config' __title='Choose the kind of show sub albums'}
                                <div class="z-informationmsg z-formnote">{gt text="If set to links, sub albums with password access will not be shown in the display template."}</div>  
                        </div>
                       {* <div class="z-formrow">
                        	{gt text='Here you can enable ordering of albums in the frontend.' assign='toolTip'}
                            {formlabel for='orderAlbums' __text='Order albums?' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='orderAlbums' group='config' maxLength=255 __title='Enable ordering.'}
	                    </div> *}
                        <div class="z-formrow">
                        	{gt text='Here you can set an ending for detail pages.' assign='toolTip'}
                            {formlabel for='ending' __text='Ending' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formtextinput id='ending' group='config' maxLength=255 __title='Enter the ending.'}
                                <div class="z-informationmsg z-formnote">{gt text="You can select between html and htm or no ending (empty field)."}</div>
                        </div>
                        <div class="z-formrow">
                            {gt text='If this option is set to true, standard users are able to delete pictures in their albums.' assign='toolTip'}      
                            {formlabel for='userDeletePictures' __text='User delete pictures' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='userDeletePictures' group='config'}
                        </div>
                    </fieldset>
                {/formtabbedpanel}
                {gt text='Upload Handler' assign='tabTitle'}
                {formtabbedpanel title=$tabTitle}
                	<fieldset>
                        <legend>{$tabTitle}</legend>
                    
                        <p class="z-confirmationmsg">{gt text='Here you can manage all settings for uploads.'}</p>
                    
                        <div class="z-formrow">
                            {gt text='If this option is set to true, 3 sizes of pictures will be created near the original picture.' assign='toolTip'}
                            {formlabel for='createSeveralPictureSizes' __text='Create several picture sizes?' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formcheckbox id='createSeveralPictureSizes' group='config'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the width for the thumbnail.' assign='toolTip'}
                            {formlabel for='widthFirst' __text='Width for the thumbnail' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='widthFirst' group='config' maxLength=255 __title='Enter the width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the height for the thumbnail.' assign='toolTip'}
                            {formlabel for='heightFirst' __text='Height for the thumbnail' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='heightFirst' group='config' maxLength=255 __title='Enter the height. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the width for the preview.' assign='toolTip'}
                            {formlabel for='widthSecond' __text='Width for the preview' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='widthSecond' group='config' maxLength=255 __title='Enter the width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the height for the preview.' assign='toolTip'}
                            {formlabel for='heightSecond' __text='Height for the preview' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='heightSecond' group='config' maxLength=255 __title='Enter the height. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the width for the full image.' assign='toolTip'}
                            {formlabel for='widthThird' __text='Width for the full image' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='widthThird' group='config' maxLength=255 __title='Enter the width. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                        	{gt text='Here you can set the height for the full image.' assign='toolTip'}
                            {formlabel for='heightThird' __text='Height for the full image' cssClass='muimage-form-tooltips ' title=$toolTip}
                                {formintinput id='heightThird' group='config' maxLength=255 __title='Enter the height. Only digits are allowed.'}
                        </div>
                        <div class="z-formrow">
                            {gt text='If set to true, pictures get modified to maximum width and height for pictures set in the settings. The aspect ratio of pictures will get received' assign='toolTip'}   
                            {formlabel for='shrinkPictures' __text='Shrink pictures' cssClass='muimage-form-tooltips' title=$toolTip}
                                {formcheckbox id='shrinkPictures' group='config'}
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
