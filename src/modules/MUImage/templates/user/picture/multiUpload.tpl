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
        {section name='fields' start=1 loop=$allowedFields}
        <div class="z-formrow">
        {formlabel for="imageUpload`$smarty.section.fields.index`" __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
        {formuploadinput group='picture' id="imageUpload`$smarty.section.fields.index`" mandatory=false readOnly=false cssClass=''}
        <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        <div class="z-formnote">{gt text='Allowed file size:'} {$fileSize} </div>
        </div>
        {/section}     
      </fieldset>
          {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
        {formbutton id='btnCreate' commandName='create' __text='Create pictures' class='z-bt-ok'}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
    </div>
    
    {/muimageFormFrame}
    {/form}

</div>
</div>
{include file='user/footer.tpl'}
