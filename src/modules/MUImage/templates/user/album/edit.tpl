{* purpose of this template: build the Form to edit an instance of album *}
{include file='user/header.tpl'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit album' assign='templateTitle'}
{elseif $mode eq 'create'}
    {gt text='Create album' assign='templateTitle'}
{else}
    {gt text='Edit album' assign='templateTitle'}
{/if}
<div class="muimage-album muimage-edit">
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>
{form cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}
    {formsetinitialfocus inputId='title'}

    <fieldset>
        <legend>{gt text='Content'}</legend>
        <div class="z-formrow">
            {formlabel for='title' __text='Title' mandatorysym='1'}
            {formtextinput group='album' id='title' mandatory=true readOnly=false __title='Enter the title of the album' textMode='singleline' maxLength=255 cssClass='required validate-unique'}
            {muimageValidationError id='title' class='required'}
            {muimageValidationError id='title' class='validate-unique'}
        </div>
        <div class="z-formrow">
            {formlabel for='description' __text='Description'}
            {formtextinput group='album' id='description' mandatory=false __title='Enter the description of the album' textMode='multiline' rows='6' cols='50' cssClass=''}
        </div>
    </fieldset>

    {include file='user/include_categories_edit.tpl' obj=$album groupName='albumObj'}
    {if $mode ne 'create'}
        {include file='user/include_standardfields_edit.tpl' obj=$album}
    {/if}
    {if $mode eq 'create'}
    <input type="hidden" id="muimageAlbum_ParentItemList" name="muimageAlbum_ParentItemList" value="{$parent}">
    <input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
    {else}
    {include file='user/album/include_selectEditOne.tpl' relItem=$album aliasName='parent' idPrefix='muimageAlbum_Parent'}
    {/if}
    {* include display hooks *}
    {if $mode eq 'create'}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=null assign='hooks'}
    {else}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=$album.id assign='hooks'}
    {/if}
   {* {if is_array($hooks) && isset($hooks[0])} *}
        <fieldset>
            <legend>{gt text='Hooks'}</legend>
            {foreach key='hookName' item='hook' from=$hooks}
            <div class="z-formrow">
                {$hook}
            </div>
            {/foreach}
        </fieldset>
   {* {/if} *}

    {* include return control *}
    {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatcreation' __text='Create another item after save'}
                {formcheckbox group='album' id='repeatcreation' readOnly=false}
            </div>
        </fieldset>
    {/if}

    {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {formbutton id='btnUpdate' commandName='update' __text='Update album' class='z-bt-save'}
      {if !$inlineUsage}
        {gt text='Really delete this album? Notice: If you delete this album you will delete also its sub albums and pictures of these albums too!' assign='deleteConfirmMsg'}
        {formbutton id='btnDelete' commandName='delete' __text='Delete album' class='z-bt-delete z-btred' confirmMessage=$deleteConfirmMsg}
      {/if}
    {elseif $mode eq 'create'}
        {formbutton id='btnCreate' commandName='create' __text='Create album' class='z-bt-ok'}
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

{icon type='edit' size='extrasmall' assign='editImageArray'}
{icon type='delete' size='extrasmall' assign='deleteImageArray'}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    var editImage = '<img src="{{$editImageArray.src}}" width="16" height="16" alt="" />';
    var removeImage = '<img src="{{$deleteImageArray.src}}" width="16" height="16" alt="" />';
    var relationHandler = new Array();
    var newItem = new Object();
    newItem['ot'] = 'album';
    newItem['alias'] = 'Parent';
    newItem['prefix'] = 'muimageAlbum_ParentSelectorDoNew';
    newItem['acInstance'] = null;
    newItem['windowInstance'] = null;
    relationHandler.push(newItem);

    document.observe('dom:loaded', function() {
        muimageInitRelationItemsForm('album', 'muimageAlbum_Parent', true);

        muimageAddCommonValidationRules('album', '{{if $mode eq 'create'}}{{else}}{{$album.id}}{{/if}}');

        // observe button events instead of form submit
        var valid = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = valid.validate();
        {{/if}}

        $('{{if $mode eq 'create'}}btnCreate{{else}}btnUpdate{{/if}}').observe('click', function(event) {
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
