{* purpose of this template: build the Form to edit an instance of album *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="bootstrap/`$lct`/header.tpl"}
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
               <div class="form-group">
                   {formlabel for='title' __text='Title' mandatorysym='1'}
                   {formtextinput group='album' id='title' mandatory=true readOnly=false __title='Enter the title of the album' textMode='singleline' maxLength=255 cssClass='required validate-unique form-control'}
                   {muimageValidationError id='title' class='required'}
                   {muimageValidationError id='title' class='validate-unique'}
               </div>
               <div class="form-group">
                    {formlabel for='description' __text='Description'}
                    {formtextinput group='album' id='description' mandatory=false __title='Enter the description of the album' textMode='multiline' rows='6' cols='50' cssClass='form-control'}
                </div>

                <div id="MUImage_Albumaccess" class="form-group">
                    {formlabel for='albumAccess' __text='Album access' mandatorysym='1' cssClass='accessSelect'}
                    {formdropdownlist group='album' id='albumAccess' mandatory=true __title='Choose the album access' selectionMode='single' cssClass='form-control'}
                </div>

                <div id="MUImage_Myfriends" class="form-group" style="display: none">
                    {formlabel for='myFriends' __text='My friends' cssClass=''}
                    {formtextinput group='album' id='myFriends' mandatory=false readOnly=false __title='Enter your friends (comma seperated)!' textMode='singleline' maxLength=255 cssClass='form-control' }
                </div>
                                
                <div id="MUImage_Password" class="form-group" style="display: none">
                    {formlabel for='passwordAccess' __text='Password access' cssClass=''}
                    {formtextinput group='album' id='passwordAccess' mandatory=false readOnly=false __title='Enter the password access of the album' textMode='password' maxLength=255 cssClass='form-control' }
                </div>
                {if $inAdminGroup eq true}
                <div class="checkbox">
                	<label>
                    {formcheckbox group='album' id='notInFrontend' readOnly=false __title='not in frontend ?' cssClass='' }
                	{gt text='not in Frontend ?'}
                	</label>
                </div>
                {/if}
                </fieldset>
                {include file='bootstrap/helper/include_categories_edit.tpl' obj=$album groupName='albumObj'}
                {if $mode eq 'create'}
                    <input type="hidden" id="muimageAlbum_ParentItemList" name="muimageAlbum_ParentItemList[]" value="{$savedParent}">
                    <input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="1">
                {else}
                {if $inAdminGroup eq true || ($mainAlbumMode ne false && $mainAlbumMode ne 4)}
                 {if $inAdminGroup eq true}
                <p class="alert alert-info" role="alert">{gt text='Notice! Your are in admin group. So you get all albums to select. Be careful to make main or sub albums in view of logic!'}</p>
                <p class="alert alert-info" role="alert">{gt text='So pleace avoid for example that an album becomes main album of an album, that is children album already. Otherwise you will produce big problems!'}</p>
            {/if}
            {if $inAdminGroup eq false}
                <p class="alert alert-info" role="alert">{gt text='Notice! You get only albums to select you have created! Also you get only albums that are qualified under aspects of logic and your quotas!'}</p>
            {/if}
      	<fieldset>
		<legend>{gt text='Main album'}</legend>
		<div class="form-group>
			{formlabel for='muimageAlbum_ParentItemList' __text='Album'}
			{formdropdownlist selectedValue=$savedParent group='mainalbum' id='muimageAlbum_ParentItemList' cssClass='chzn-select form-control'}
			<input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
		</div>
	</fieldset>
	{if $mainAlbumMode eq D}
		<p class="alert alert-warning">{gt text='Attention! This album is a sub album and you have no quotas to make it to main album! You may select another album as main album.'}</p>
	{/if}
{else}
{if $mainAlbumMode eq 4}
<p class="alert alert-warning">{gt text='Attention! This album is on first level and you have no quotas to change!'}</p>
{/if}
<input type="hidden" id="muimageAlbum_ParentItemList" name="muimageAlbum_ParentItemList[]" value="{$savedParent}">
<input type="hidden" id="muimageAlbum_ParentMode" name="muimageAlbum_ParentMode" value="0">
{/if}
{* {include file='album/include_selectEditOne.tpl' relItem=$album aliasName='parent' idPrefix='muimageAlbum_Parent'}
*} {/if}
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
        <div class="form-group">
        {foreach item='action' from=$actions}
            {assign var='actionIdCapital' value=$action.id|@ucfirst}
            {gt text=$action.title assign='actionTitle'}
            {*gt text=$action.description assign='actionDescription'*}{* TODO: formbutton could support title attributes *}
            {if $action.id eq 'delete'}
                {gt text='Really delete this album?' assign='deleteConfirmMsg'}
                {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class="btn btn-danger" confirmMessage=$deleteConfirmMsg}</i>
            {else}
                {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class="btn btn-primary"}
            {/if}
        {/foreach}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='btn btn-warning'}
        </div>
{/muimageFormFrame}
{/form}
{if $mode ne 'create'}
	{include file='helper/include_standardfields_edit.tpl' obj=$album}
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
    
    MU(document).ready( function() {
    MU("#MUImage_Albumaccess select option:selected").each(
        function(){
            if (MU(this).val() == 'friends') {
                MU("#MUImage_Myfriends").css("display", "block");
            }
            if (MU(this).val() == 'known') {
                MU("#MUImage_Password").css("display", "block");
            } 
    });
    MU("#MUImage_Albumaccess select").change(
        function(){
            MU("#MUImage_Albumaccess select option:selected").each(
                function(){
                    if (MU(this).val() == 'all' || MU(this).val() == 'users') {
                        MU("#MUImage_Myfriends").css("display", "none");
                        MU("#MUImage_Password").css("display", "none");
                    } 
                    if (MU(this).val() == 'friends') {
                        MU("#MUImage_Myfriends").css("display", "block");
                        MU("#MUImage_Password").css("display", "none");
                    }
                    if (MU(this).val() == 'known') {
                        MU("#MUImage_Password").css("display", "block");
                        MU("#MUImage_Myfriends").css("display", "none");
                    } 
            });        
    });
    });

/* ]]> */
</script>
