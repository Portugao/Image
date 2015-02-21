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
        {formlabel for="zipUpload" __text='Zip upload' mandatorysym=1}<br />{* break required for Google Chrome *}
        {formuploadinput group='picture' id="zipUpload" mandatory=true readOnly=false cssClass='required'}
        <div class="z-formnote">{gt text='Allowed file extensions'}: zip</div>
        <div class="z-formnote">{gt text='Allowed file size:'} {$zipSize} </div>
        </div> 
        {muimageValidationError id='zipUpload' class='required'}
        <p class="z-informationmsg z-formnote">{gt text='Here you can upload a zip file. Please have attention the archive does only contain image files.'}</p> 
      </fieldset>
          {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
        {formbutton id='btnSubmit' commandName='submit' __text='Upload zip file' class='z-bt-ok'}
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

    document.observe('dom:loaded', function() {

        muimageAddCommonValidationRules('picture', '{{if $mode eq 'create'}}{{else}}{{$picture.id}}{{/if}}');

        // observe button events instead of form submit
        var valid = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = valid.validate();
        {{/if}}

        $('{{if $mode eq 'create'}}btnSubmit{{else}}btnUpdate{{/if}}').observe('click', function(event) {
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
