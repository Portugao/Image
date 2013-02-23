{* purpose of this template: show output of multi upload action in user area *}

{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{include file='user/header.tpl'}
<div class="muimage-multiupload muimage-multiupload">
{gt text='Multi upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>
    
    {form enctype='multipart/form-data' cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}

    <fieldset>
        <legend>{gt text='Content'}</legend> 
        
        <div class="z-formrow">
       {* {assign var='mandatorySym' value='1'}
        {if $mode ne 'create'}
            {assign var='mandatorySym' value='0'}
        {/if} *}
        {formlabel for='imageUpload' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
            {if $mode eq 'create'}
                {formuploadinput group='picture' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {else}
                {formuploadinput group='picture' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {/if}
                <div class="z-formnote">{gt text='Allowed file extensions:'} zip</div>
            {muimageValidationError id='imageUpload' class=''}
          </div>        
        
    </fieldset> 
    
    {/muimageFormFrame}
    {/form}       
</div>
{include file='user/footer.tpl'}
