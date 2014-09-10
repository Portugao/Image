{* purpose of this template: build the Form to edit an instance of picture *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit picture' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='edit'}
    {/if}
{elseif $mode eq 'create'}
    {gt text='Create picture' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='new'}
    {/if}
{else}
    {gt text='Edit picture' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='edit'}
    {/if}
{/if}
<div class="muimage-picture muimage-edit">
    {pagesetvar name='title' value=$templateTitle}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type=$adminPageIcon size='small' alt=$templateTitle}
            <h3>{$templateTitle}</h3>
        </div>
    {else}
        <h2>{$templateTitle}</h2>
    {/if}
{form enctype='multipart/form-data' cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}
    {formsetinitialfocus inputId='title'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        
        <div class="z-formrow">
            {formlabel for='title' __text='Title' cssClass=''}
            {formtextinput group='picture' id='title' mandatory=false readOnly=false __title='Enter the title of the picture' textMode='singleline' maxLength=255 cssClass='' }
        </div>
        
        <div class="z-formrow">
            {formlabel for='description' __text='Description' cssClass=''}
            {formtextinput group='picture' id='description' mandatory=false __title='Enter the description of the picture' textMode='multiline' rows='6' cols='50' cssClass='' }
        </div>
        
        <div class="z-formrow">
            {formlabel for='showTitle' __text='Show title' cssClass=''}
            {formcheckbox group='picture' id='showTitle' readOnly=false __title='show title ?' cssClass='' }
        </div>
        
        <div class="z-formrow">
            {formlabel for='showDescription' __text='Show description' cssClass=''}
            {formcheckbox group='picture' id='showDescription' readOnly=false __title='show description ?' cssClass='' }
        </div>
        
        <div class="z-formrow">
            {assign var='mandatorySym' value='1'}
            {if $mode ne 'create'}
                {assign var='mandatorySym' value='0'}
            {/if}
            {formlabel for='imageUpload' __text='Image upload' mandatorysym=$mandatorySym cssClass=''}<br />{* break required for Google Chrome *}
            {if $mode eq 'create'}
                {formuploadinput group='picture' id='imageUpload' mandatory=true readOnly=false cssClass='required validate-upload' }
            {else}
                {formuploadinput group='picture' id='imageUpload' mandatory=false readOnly=false cssClass=' validate-upload' }
                <span class="z-formnote"><a id="resetImageUploadVal" href="javascript:void(0);" class="z-hide">{gt text='Reset to empty value'}</a></span>
            {/if}
            
                <span class="z-formnote">{gt text='Allowed file extensions:'} <span id="imageUploadFileExtensions">gif, jpeg, jpg, png</span></span>
            {if $mode ne 'create'}
                {if $picture.imageUpload ne ''}
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
            {/if}
            {muimageValidationError id='imageUpload' class='required'}
            {muimageValidationError id='imageUpload' class='validate-upload'}
        </div>
        
        <div class="z-formrow">
            {formlabel for='imageView' __text='Image view' cssClass=''}
            {formintinput group='picture' id='imageView' mandatory=false __title='Enter the image view of the picture' maxLength=11 cssClass=' validate-digits' }
            {muimageValidationError id='imageView' class='validate-digits'}
        </div>
        
        <div class="z-formrow">
            {formlabel for='albumImage' __text='Album image' cssClass=''}
            {formcheckbox group='picture' id='albumImage' readOnly=false __title='album image ?' cssClass='' }
        </div>
        
        <div class="z-formrow">
            {formlabel for='pos' __text='Pos' mandatorysym='1' cssClass=''}
            {formintinput group='picture' id='pos' mandatory=true __title='Enter the pos of the picture' maxLength=11 cssClass='required validate-digits' }
            {muimageValidationError id='pos' class='required'}
            {muimageValidationError id='pos' class='validate-digits'}
        </div>
    </fieldset>
    
    {include file='album/include_selectEditOne.tpl' group='picture' alias='album' aliasReverse='picture' mandatory=false idPrefix='muimagePicture_Album' linkingItem=$picture displayMode='dropdown' allowEditing=true}
    {if $mode ne 'create'}
        {include file='helper/include_standardfields_edit.tpl' obj=$picture}
    {/if}
    
    {* include display hooks *}
    {if $mode ne 'create'}
        {assign var='hookId' value=$picture.id}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=$hookId assign='hooks'}
    {else}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.form_edit' id=null assign='hooks'}
    {/if}
    {if is_array($hooks) && count($hooks)}
        {foreach name='hookLoop' key='providerArea' item='hook' from=$hooks}
            <fieldset>
                {$hook}
            </fieldset>
        {/foreach}
    {/if}
    
    
    {* include return control *}
    {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatCreation' __text='Create another item after save'}
                    {formcheckbox group='picture' id='repeatCreation' readOnly=false}
            </div>
        </fieldset>
    {/if}
    
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
</div>
{include file="`$lct`/footer.tpl"}

{icon type='edit' size='extrasmall' assign='editImageArray'}
{icon type='delete' size='extrasmall' assign='removeImageArray'}


<script type="text/javascript">
/* <![CDATA[ */
    
    var formButtons, formValidator;
    
    function handleFormButton (event) {
        var result = formValidator.validate();
        if (!result) {
            // validation error, abort form submit
            Event.stop(event);
        } else {
            // hide form buttons to prevent double submits by accident
            formButtons.each(function (btn) {
                btn.addClassName('z-hide');
            });
        }
    
        return result;
    }
    
    document.observe('dom:loaded', function() {
    
        muimageAddCommonValidationRules('picture', '{{if $mode ne 'create'}}{{$picture.id}}{{/if}}');
        {{* observe validation on button events instead of form submit to exclude the cancel command *}}
        formValidator = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = formValidator.validate();
        {{/if}}
    
        formButtons = $('{{$__formid}}').select('div.z-formbuttons input');
    
        formButtons.each(function (elem) {
            if (elem.id != 'btnCancel') {
                elem.observe('click', handleFormButton);
            }
        });
    
        Zikula.UI.Tooltips($$('.muimage-form-tooltips'));
        muimageInitUploadField('imageUpload');
    });
/* ]]> */
</script>
