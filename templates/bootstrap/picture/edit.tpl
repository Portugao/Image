{* purpose of this template: build the Form to edit an instance of picture *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="bootstrap/`$lct`/header.tpl"}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/chosen/chosen.jquery.js'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/chosen/chosen.css'}

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
        <div class="form-group">
            {formlabel for='title' __text='Title'}
            {formtextinput group='picture' id='title' mandatory=false readOnly=false __title='Enter the title of the picture' textMode='singleline' maxLength=255 cssClass='form-control'}
        </div>
        <div class="form-group">
            {formlabel for='description' __text='Description'}
            {formtextinput group='picture' id='description' mandatory=false __title='Enter the description of the picture' textMode='multiline' rows='6' cols='50' cssClass='form-control'}
        </div>
        <div class="checkbox">
            {formlabel for='showTitle' __text='Show title'}
            {formcheckbox group='picture' id='showTitle' readOnly=false __title='show title ?' cssClass=''}
        </div>
        <div class="checkbox">
            {formlabel for='showDescription' __text='Show description'}
            {formcheckbox group='picture' id='showDescription' readOnly=false __title='show description ?' cssClass=''}
        </div>
        <div class="form-group">
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
            <div class="alert alert-info">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
            <div class="alert alert-info">{gt text='Allowed file size:'} {$fileSize} </div>
            <div class="alert alert-info">{gt text='Required width:'} {$minWidth} </div>
            <div class="alert alert-info">{gt text='Maximum width:'} {$maxWidth} </div>
            <div class="alert alert-info">{gt text='Maximum height:'} {$maxHeight} </div>
            {modgetvar module='MUImage' name='shrinkPictures' assign='shrinkPictures'}
            {if $shrinkPictures eq 1 && $mode eq 'create'}
                <div class="alert alert-info">{gt text='Pictures with too big width or height will be shrinked.'}</div>
            {/if}
            {if $mode ne 'create'}
                {if $picture.imageUpload ne ''}
                    <span class="form-group">
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
            {/if}
            {muimageValidationError id='imageUpload' class='required'}
        </div>
        <div class="form-group" style="display: none;">
            {formlabel for='imageView' __text='Image view' mandatorysym='1'}
            {formintinput group='picture' id='imageView' mandatory=true __title='Enter the image view of the picture' maxLength=11 cssClass='required validate-digits form-group'}
            {muimageValidationError id='imageView' class='required'}
            {muimageValidationError id='imageView' class='validate-digits'}
        </div>
        
        <div class="checkbox">
            {formlabel for='albumImage' __text='Album image' cssClass=''}
            {formcheckbox group='picture' id='albumImage' readOnly=false __title='album image ?' cssClass='' }
        </div>
    </fieldset>

    {if $mode ne 'create'}
        {* {include file='user/album/include_selectEditOne.tpl' relItem=$picture aliasName='album' idPrefix='muimageAlbum_Album'} *}
        <fieldset>
        <legend>{gt text='Album'}</legend>
            <div class="form-group">
                {formlabel for='muimageAlbum_AlbumItemList' __text='Album'}
                {formdropdownlist selectedValue=$savedAlbum group='mainalbum' id='muimageAlbum_AlbumItemList' cssClass='chzn-select form-control'}
                <input type="hidden" id="muimageAlbum_AlbumMode" name="muimageAlbum_AlbumMode" value="{$savedAlbum}">
            </div>
        </fieldset>  
    {else}
        <input id="muimageAlbum_AlbumItemList" type="hidden" value="{$albumid}" name="muimageAlbum_AlbumItemList">
        <input id="muimageAlbum_AlbumMode" type="hidden" value="{$savedAlbum}" name="muimageAlbum_AlbumMode">
    {/if}

    {* include display hooks *}
    {if $mode eq 'create'}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=null}
    {else}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=$picture.id}
    {/if}

    {* include return control 
    {if $mode eq 'create'}
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
    {foreach item='action' from=$actions}
        {assign var='actionIdCapital' value=$action.id|@ucfirst}
        {gt text=$action.title assign='actionTitle'}
        {*gt text=$action.description assign='actionDescription'*}{* TODO: formbutton could support title attributes *}
        {if $action.id eq 'delete'}
            {gt text='Really delete this picture?' assign='deleteConfirmMsg'}
            {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass confirmMessage=$deleteConfirmMsg}
        {else}
            {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass}
        {/if}
    {/foreach}
    {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
    </div>
  {/muimageFormFrame}
{/form}
    {if $mode ne 'create'}
        {include file='helper/include_standardfields_edit.tpl' obj=$picture}
   {/if}
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
    
    var MU = jQuery.noConflict();
    MU(document).ready( function() { 
        MU(".chzn-select").chosen();
    });

/* ]]> */
</script>
