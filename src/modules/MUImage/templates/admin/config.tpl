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
            <fieldset>
                <legend>{gt text='Here you can manage all basic settings for this application.'}</legend>

                <div class="z-formrow">
                    {formlabel for='pagesize' __text='Pagesize' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='pagesize' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
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
                </div>
                <div class="z-formrow">
                    {formlabel for='numberSubAlbums' __text='Number sub albums' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='numberSubAlbums' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
                </div>
                <div class="z-formrow">
                    {formlabel for='numberPictures' __text='Number pictures' class='muimageFormTooltips' title=$toolTip}
                    {formintinput id='numberPictures' group='config' maxLength=255 width=20em __title='Enter this setting. Only digits are allowed.'}
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
                    {formlabel for='userDeletePictures' __text='May users delete their pictures?' class='muimageFormTooltips' title=$toolTip}
                    {formcheckbox id='userDeletePictures' group='config'}
                </div>
                 <div class="z-formrow">
                    {formlabel for='ending' __text='Do you wish an ending for display of albums and pictures?' class='muimageFormTooltips' title=$toolTip}
                    {formtextinput id='ending' group='config' maxLength=255 width=20em __title='Enter this setting.'}
                    <div class="z-informationmsg z-formnote">{gt text="You can select between html and htm."}</div>
                </div>
            </fieldset>

            <div class="z-buttons z-formbuttons">
                {formbutton commandName='save' __text='Update configuration' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/form}
</div>
{include file='admin/footer.tpl'}
