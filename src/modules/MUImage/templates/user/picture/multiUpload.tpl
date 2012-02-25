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
                {formuploadinput group='picture[0]' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {else}
                {formuploadinput group='picture[0]' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {/if}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
            {muimageValidationError id='imageUpload' class=''}
          </div>
    
        <div class="z-formrow">
        {formlabel for='imageUpload' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
            {if $mode eq 'create'}
                {formuploadinput group='picture[1]' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {else}
                {formuploadinput group='picture[1]' id='imageUpload' mandatory=false readOnly=false cssClass=''}
            {/if}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
            {muimageValidationError id='imageUpload' class=''}
          </div>
          
      </fieldset>
          {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {formbutton id='btnUpdate' commandName='update' __text='Update picture' class='z-bt-save'}
      {if !$inlineUsage}
        {gt text='Really delete this picture?' assign='deleteConfirmMsg'}
        {formbutton id='btnDelete' commandName='delete' __text='Delete picture' class='z-bt-delete z-btred' confirmMessage=$deleteConfirmMsg}
      {/if}
    {elseif $mode eq 'create'}
        {formbutton id='btnCreate' commandName='create' __text='Create picture' class='z-bt-ok'}
    {else}
        {formbutton id='btnUpdate' commandName='update' __text='OK' class='z-bt-ok'}
    {/if}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
    </div>
    
    {/muimageFormFrame}
    {/form}

</div>
</div>
{include file='user/footer.tpl'}
