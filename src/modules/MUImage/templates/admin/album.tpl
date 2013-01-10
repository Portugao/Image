{zdebug}{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
<div class="muimage-config">
{gt text='Albums of Module' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='config' size='small' __alt='Albums'}
    <h3>{$templateTitle}</h3>
</div>

    {muimageform cssClass='z-form'}


        {* add validation summary and a <div> element for styling the form *}
        {muimageFormFrame}
        {formsetinitialfocus inputId='albums}
            <fieldset>
                <legend>{gt text='Here you can select the albums.'}</legend>
                <div class="z-formrow">
                    {formlabel for='album' __text='album' class='muimageFormTooltips' title=$toolTip}
                    {formdropdownlist id='album' group='albums'}
                </div>
                <div class="z-formrow">
                    {formlabel for='folder' __text='folder' class='muimageFormTooltips' title=$toolTip}
                    {formtextinput group='albums' id='folder' mandatory=true readOnly=false __title='Enter the folder' textMode='singleline' maxLength=255 cssClass='required validate-unique'}         </div>
            </fieldset>
            {* <input type="hidden" value={$module} id="module" name="module"> *}
            <div class="z-buttons z-formbuttons">
                {formbutton commandName='start' __text='Start import' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/muimageform}
</div>
{include file='admin/footer.tpl'}
