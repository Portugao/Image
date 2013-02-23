{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
<div class="muimage-config">
{gt text='Import' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='config' size='small' __alt='Import'}
    <h3>{$templateTitle}</h3>
</div>

    {form cssClass='z-form'}


        {* add validation summary and a <div> element for styling the form *}
        {muimageFormFrame}
        {formsetinitialfocus inputId='module'}
            <fieldset>
                <legend>{gt text='Here you can import albums and pictures from other modules.'}</legend>

                <div class="z-formrow">
                    {formlabel for='importmodule' __text='module' class='muimageFormTooltips' title=$toolTip}
                    {formdropdownlist id='importmodule' group='import'}
                </div>
            </fieldset>

            <div class="z-buttons z-formbuttons">
                {formbutton commandName='start' __text='Start import' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/form}
</div>
{include file='admin/footer.tpl'}
