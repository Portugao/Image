{* purpose of this template: build the Form to edit an instance of picture *}
{include file='user/header.tpl'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit picture' assign='templateTitle'}
{elseif $mode eq 'create'}
    {gt text='Create picture' assign='templateTitle'}
{else}
    {gt text='Edit picture' assign='templateTitle'}
{/if}
<div class="muimage-picture muimage-edit">
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>
{form enctype='multipart/form-data' cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}
    {formsetinitialfocus inputId='title'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
            {formlabel for='title' __text='Title'}
            {formtextinput group='picture' id='title' mandatory=false readOnly=false __title='Enter the title of the picture' textMode='singleline' maxLength=255 cssClass=''}
        </div>
        <div class="z-formrow">
            {formlabel for='description' __text='Description'}
            {formtextinput group='picture' id='description' mandatory=false __title='Enter the description of the picture' textMode='multiline' rows='6' cols='50' cssClass=''}
        </div>
      {*  <div class="z-formrow">
            {formlabel for='showTitle' __text='Show title'}
            {formcheckbox group='picture' id='showTitle' readOnly=false __title='show title ?' cssClass=''}
        </div>
        <div class="z-formrow">
            {formlabel for='showDescription' __text='Show description'}
            {formcheckbox group='picture' id='showDescription' readOnly=false __title='show description ?' cssClass=''}
        </div> *}
        <div class="z-formrow">
            {assign var='mandatorySym' value='1'}
            {if $mode ne 'create'}
                {assign var='mandatorySym' value='0'}
            {/if}
            {formlabel for='imageUpload' __text='Image upload' mandatorysym=$mandatorySym}<br />{* break required for Google Chrome *}
{if $mode eq 'create'}
            {formuploadinput group='picture' id='imageUpload' mandatory=true readOnly=false cssClass='required'}
{else}
            {formuploadinput group='picture' id='imageUpload' mandatory=false readOnly=false cssClass=''}
{/if}

            <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
            <div class="z-formnote">{gt text='Allowed file size:'} {$fileSize} </div>
            <div class="z-formnote">{gt text='Required width:'} {$minWidth} </div>
            <div class="z-formnote">{gt text='Maximum width:'} {$maxWidth} </div>
            <div class="z-formnote">{gt text='Maximum height:'} {$maxHeight} </div>
            {modgetvar module='MUImage' name='shrinkPictures' assign='shrinkPictures'}
            {if $shrinkPictures eq 1 && $mode eq 'create'}
                <div class="z-formnote z-informationmsg">{gt text='Pictures with too big width or height will be shrinked.'}</div>
            {/if}
            {if $mode ne 'create'}
                    <span class="z-formnote">
                        {gt text='Current file'}:
                        <a href="{$picture.imageUploadFullPathUrl}" title="{$formattedEntityTitle|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
                        {if $picture.imageUploadMeta.isImage}
                            {thumb image=$picture.imageUploadFullPath objectid="picture-`$picture.id`" preset=$pictureThumbPresetImageUpload tag=true img_alt=$formattedEntityTitle}
                        {else}
                            {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
                        {/if}
                        </a>
                    </span>
            {/if}
            {muimageValidationError id='imageUpload' class='required'}
        </div>
       {* <div class="z-formrow">
            {formlabel for='imageView' __text='Image view' mandatorysym='1'}
            {formintinput group='picture' id='imageView' mandatory=true __title='Enter the image view of the picture' maxLength=11 cssClass='required validate-digits'}
            {muimageValidationError id='imageView' class='required'}
            {muimageValidationError id='imageView' class='validate-digits'}
        </div> *}
    </fieldset>

    {if $mode ne 'create'}
        {include file='helper/include_standardfields_edit.tpl' obj=$picture}
    {/if}
    {include file='album/include_selectEditOne.tpl' group='picture' alias='album' aliasReverse='picture' mandatory=false idPrefix='muimagePicture_Album' linkingItem=$picture displayMode='dropdown' allowEditing=true}
    {* include display hooks *}
    {if $mode eq 'create'}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=null assign='hooks'}
    {else}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=$picture.id assign='hooks'}
    {/if}
    {if is_array($hooks) && isset($hooks[0])}
        <fieldset>
            <legend>{gt text='Hooks'}</legend>
            {foreach key='hookName' item='hook' from=$hooks}
            <div class="z-formrow">
                {$hook}
            </div>
            {/foreach}
        </fieldset>
    {/if}

    {* include return control *}
   {* {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatcreation' __text='Create another item after save'}
                {formcheckbox group='picture' id='repeatcreation' readOnly=false}
            </div>
        </fieldset>
    {/if} *}
    {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {if $previouspicture eq 1}  
        {formbutton id='btnPrevious' commandName='previous' __text='Previous picture' class='z-bt-previous'}
        {/if}
        {if $nextpicture eq 1}
        {formbutton id='btnNext' commandName='next' __text='Next picture' class='z-bt-next'}
        {/if}
        {formbutton id='btnFinish' commandName='finish' __text='Finish editing' class='z-bt-save'}
     {* {if !$inlineUsage}
        {gt text='Really delete this picture? If you a delete a picture' assign='deleteConfirmMsg'}
        {formbutton id='btnDelete' commandName='delete' __text='Delete picture' class='z-bt-delete z-btred' confirmMessage=$deleteConfirmMsg}
      {/if} *}
    {elseif $mode eq 'create'}
        {if $previouspicture eq 1}        
        {formbutton id='btnPrevious' commandName='previous' __text='Previous picture' class='z-bt-previous'}
        {/if}
        {formbutton id='btnCreate' commandName='create' __text='Create picture' class='z-bt-ok'}
    {else}
        {formbutton id='btnFinish' commandName='finish' __text='OK' class='z-bt-ok'}
    {/if}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}

    </div>
  {/muimageFormFrame}
{/form}

</div>
</div>
{include file='user/footer.tpl'}

{icon type='edit' size='extrasmall' assign='editImageArray'}
{icon type='delete' size='extrasmall' assign='deleteImageArray'}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    var editImage = '<img src="{{$editImageArray.src}}" width="16" height="16" alt="" />';
    var removeImage = '<img src="{{$deleteImageArray.src}}" width="16" height="16" alt="" />';
    var relationHandler = new Array();
    var newItem = new Object();
    newItem['ot'] = 'album';
    newItem['alias'] = 'Album';
    newItem['prefix'] = 'muimageAlbum_AlbumSelectorDoNew';
    newItem['acInstance'] = null;
    newItem['windowInstance'] = null;
    relationHandler.push(newItem);

    document.observe('dom:loaded', function() {
        muimageInitRelationItemsForm('album', 'muimageAlbum_Album', true);

        muimageAddCommonValidationRules('picture', '{{if $mode eq 'create'}}{{else}}{{$picture.id}}{{/if}}');

        // observe button events instead of form submit
        var valid = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = valid.validate();
        {{/if}}

        $('{{if $mode eq 'create'}}btnCreate{{else}}btnUpdate{{/if}}').observe('click', function(event) {
            var result = valid.validate();
            if (!result) {
                // validation error, abort form submit
                Event.stop(event);
            } else {
                // hide form buttons to prevent double submits by accident
                $$('div.z-formbuttons input').each(function(btn) {
                    btn.hide();
                });
            }
            return result;
        });

        Zikula.UI.Tooltips($$('.muimageFormTooltips'));
    });

/* ]]> */
</script>
