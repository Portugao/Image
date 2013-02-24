{* purpose of this template: build the Form to edit an instance of album *}
{include file='user/header.tpl'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/chosen/chosen.jquery.js'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/chosen/chosen.css'}

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
    {if $mode eq 'create'}
    <input type="hidden" id="muimageAlbum_ParentItemList" name="muimageAlbum_ParentItemList" value="{$parent}">
    <input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
    {else}
    {if $inAdminGroup eq true || ($mainAlbumMode ne false && $mainAlbumMode ne 4)}
    {if $inAdminGroup eq true}
        <p class="z-informationmsg">{gt text='Notice! Your are in admin group. So you get all albums to select. Be careful to make main or sub albums in view of logic!'}</p>       
    {/if}
    {if $inAdminGroup eq false}
        <p class="z-informationmsg">{gt text='Notice! You get only albums to select you have created! Also you get only albums that are qualified under aspects of logic and your quotas!'}</p>       
    {/if}
        <fieldset>
            <legend>{gt text='Main album'}</legend>
            <div class="z-formrow">
                {formlabel for='muimageAlbum_ParentItemList' __text='Album'}
                {formdropdownlist selectedValue=$savedParent group='mainalbum' id='muimageAlbum_ParentItemList' cssClass='chzn-select'}
                <input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
            </div>
        </fieldset>
        {if $mainAlbumMode eq D}
            <p class="z-warningmsg">{gt text='Attention! This album is a sub album and you have no quotas to make it to main album! You may select another album as main album.'}</p>
        {/if}
    {else}
        {if $mainAlbumMode eq 4}
            <p class="z-warningmsg">{gt text='Attention! This album is on first level and you have no quotas to change!'}</p>
        {/if}

        <input type="hidden" id="muimageAlbum_ParentItemList" name="muimageAlbum_ParentItemList" value="{$savedParent}">
        <input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
    {/if}
    {* {include file='user/album/include_selectEditOne.tpl' relItem=$album aliasName='parent' idPrefix='muimageAlbum_Parent'} 
   *}  {/if}
    {* include display hooks *}
    {if $mode eq 'create'}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=null}
    {else}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=$album.id}
    {/if}


    {* include return control *}
    {* {if $mode eq 'create'}
        <fieldset>
            <legend>{gt text='Return control'}</legend>
            <div class="z-formrow">
                {formlabel for='repeatcreation' __text='Create another item after save'}
                {formcheckbox group='album' id='repeatcreation' readOnly=false}
            </div>
        </fieldset>
    {/if} *}

    {* include possible submit actions *}
    <div class="z-buttons z-formbuttons">
    {if $mode eq 'edit'}
        {formbutton id='btnUpdate' commandName='update' __text='Update album' class='z-bt-save'}
        {if !$inlineUsage && $inAdmingroup eq true}
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
    {if $mode ne 'create'}
        {include file='user/include_standardfields_edit.tpl' obj=$album}
    {/if}
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
    
    var MU = jQuery.noConflict();
    MU(document).ready( function() { 
        MU(".chzn-select").chosen();
    });

/* ]]> */
</script>
