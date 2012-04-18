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
        {formlabel for='imageUpload1' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload1' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
         </div>
        <div class="z-formrow">
        {formlabel for='imageUpload2' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload2' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
         </div>
        <div class="z-formrow">
        {formlabel for='imageUpload3' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload3' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div> 
        <div class="z-formrow">
        {formlabel for='imageUpload4' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload4' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div> 
        <div class="z-formrow">
        {formlabel for='imageUpload5' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload5' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div> 
        <div class="z-formrow">
        {formlabel for='imageUpload6' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload6' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div>     
        <div class="z-formrow">
        {formlabel for='imageUpload7' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload7' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div>  
        <div class="z-formrow">
        {formlabel for='imageUpload8' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload8' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div>    
        <div class="z-formrow">
        {formlabel for='imageUpload9' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload9' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div>
        <div class="z-formrow">
        {formlabel for='imageUpload10' __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
                {formuploadinput group='picture' id='imageUpload10' mandatory=false readOnly=false cssClass=''}
                <div class="z-formnote">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        </div>       
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
