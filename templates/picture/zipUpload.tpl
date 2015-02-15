{* purpose of this template: show output of multi upload action in user area *}

{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{include file='user/header.tpl'}
<div class="muimage-zipupload muimage-multiupload">
{gt text='Zip upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>   
    {form enctype='multipart/form-data' cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
        {formlabel for="zipUpload" __text='Zip upload' mandatorysym=0}<br />{* break required for Google Chrome *}
        {formuploadinput group='picture' id="zipUpload`$smarty.section.fields.index`" mandatory=false readOnly=false cssClass=''}
        <div class="z-formnote">{gt text='Allowed file extensions:'} zip</div>
        <div class="z-formnote">{gt text='Allowed file size:'} {$fileSize} </div>
        <div class="z-formnote">{gt text='Required width:'} {$minWidth} </div>
        <div class="z-formnote">{gt text='Maximum width:'} {$maxWidth} </div>
        <div class="z-formnote">{gt text='Maximum height:'} {$maxHeight} </div>
        </div>  
      </fieldset>
          {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
        {formbutton id='btnSubmit' commandName='submit' __text='Upload zip files' class='z-bt-ok'}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
    </div>
    
    {/muimageFormFrame}
    {/form}

</div>
</div>
{include file='user/footer.tpl'}
