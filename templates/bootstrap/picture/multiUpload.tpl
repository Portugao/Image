{* purpose of this template: show output of multi upload action in user area *}

{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{include file='bootstrap/user/header.tpl'}
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
        <div class="form-group">
        {formlabel for="imageUpload`$smarty.section.fields.index`" __text='Image upload' mandatorysym=0}<br />{* break required for Google Chrome *}
        {formuploadinput group='picture' id="imageUpload`$smarty.section.fields.index`" mandatory=false readOnly=false cssClass=''}<br />
        <div class="alert alert-info">{gt text='Allowed file extensions:'} gif, jpeg, jpg, png</div>
        <div class="alert alert-info">{gt text='Allowed file size:'} {$fileSize} </div>
        <div class="alert alert-info">{gt text='Required width:'} {$minWidth} </div>
        <div class="alert alert-info">{gt text='Maximum width:'} {$maxWidth} </div>
        <div class="alert alert-info">{gt text='Maximum height:'} {$maxHeight} </div>
        </div>
        {/section}     
      </fieldset>
          {* include possible submit actions *}
    <div class="form-group">
        {formbutton id='btnSubmit' commandName='submit' __text='Create pictures' class='btn btn-primary'}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='btn btn-warning'}
    </div>
    
    {/muimageFormFrame}
    {/form}

</div>
</div>
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
$(document).ready(function() {
  var $num = $('.number'),
        times = 0;

    for(i=0; i<=100; i++) {
        setTimeout(function() { 
            $num.html(times);
            times++;
            if (times === 100) {
                $('.progress-circle-outer').removeClass('animate');
            }
        },i*100)
    };
});
/* ]]> */
</script>
{include file='user/footer.tpl'}
