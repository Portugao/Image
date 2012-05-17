{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
<div class="muimage-config">
{gt text='Import' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='config' size='small' __alt='Import'}
    <h3>{$templateTitle}</h3>
</div>

    {muimageform cssClass='z-form'}


        {* add validation summary and a <div> element for styling the form *}
        {muimageFormFrame}
        {formsetinitialfocus inputId='pagesize'}
            <fieldset>
                <legend>{gt text='Here you can import albums and pictures from other modules.'}</legend>

                <div class="z-formrow">
                    {formlabel for='module' __text='module' class='muimageFormTooltips' title=$toolTip}
                    {formdropdownlist id='module' group='import'}
                </div>
            </fieldset>
            <input type="hidden" id="kind" name="kind" value="albums">
            <div class="z-buttons z-formbuttons">
                {formbutton commandName='start' __text='Start import' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/muimageform}
</div>
{include file='admin/footer.tpl'}
