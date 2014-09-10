{* purpose of this template: build the Form to edit an instance of album *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}

{if $mode eq 'edit'}
    {gt text='Edit album' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='edit'}
    {/if}
{elseif $mode eq 'create'}
    {gt text='Create album' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='new'}
    {/if}
{else}
    {gt text='Edit album' assign='templateTitle'}
    {if $lct eq 'admin'}
        {assign var='adminPageIcon' value='edit'}
    {/if}
{/if}
<div class="muimage-album muimage-edit">
    {pagesetvar name='title' value=$templateTitle}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type=$adminPageIcon size='small' alt=$templateTitle}
            <h3>{$templateTitle}</h3>
        </div>
    {else}
        <h2>{$templateTitle}</h2>
    {/if}
{form cssClass='z-form'}
    {* add validation summary and a <div> element for styling the form *}
    {muimageFormFrame}
    {formsetinitialfocus inputId='title'}

    <div id="mUImagePanel" class="z-panels">
        <h3 id="z-panel-header-fields" class="z-panel-header z-panel-indicator z-pointer">{gt text='Fields'}</h3>
        <div class="z-panel-content z-panel-active" style="overflow: visible">
            <fieldset>
                <legend>{gt text='Content'}</legend>
                
                <div class="z-formrow">
                    {formlabel for='title' __text='Title' mandatorysym='1' cssClass=''}
                    {formtextinput group='album' id='title' mandatory=true readOnly=false __title='Enter the title of the album' textMode='singleline' maxLength=255 cssClass='required validate-unique' }
                    {muimageValidationError id='title' class='required'}
                    {muimageValidationError id='title' class='validate-unique'}
                </div>
                
                <div class="z-formrow">
                    {formlabel for='description' __text='Description' cssClass=''}
                    {formtextinput group='album' id='description' mandatory=false __title='Enter the description of the album' textMode='multiline' rows='6' cols='50' cssClass='' }
                </div>
                
                
                <div class="z-formrow">
                    {formlabel for='albumAccess' __text='Album access' mandatorysym='1' cssClass=''}
                    {formdropdownlist group='album' id='albumAccess' mandatory=true __title='Choose the album access' selectionMode='single'}
                </div>
                
                <div class="z-formrow">
                    {formlabel for='passwordAccess' __text='Password access' cssClass=''}
                    {formtextinput group='album' id='passwordAccess' mandatory=false readOnly=false __title='Enter the password access of the album' textMode='password' maxLength=255 cssClass='' }
                </div>
                
                <div class="z-formrow">
                    {formlabel for='notInFrontend' __text='Not in frontend' cssClass=''}
                    {formcheckbox group='album' id='notInFrontend' readOnly=false __title='not in frontend ?' cssClass='' }
                </div>
            </fieldset>
        </div>
        
        {include file='helper/include_categories_edit.tpl' obj=$album groupName='albumObj' panel=true}
        {include file='album/include_selectEditOne.tpl' group='album' alias='parent' aliasReverse='children' mandatory=false idPrefix='muimageAlbum_Parent' linkingItem=$album panel=true displayMode='dropdown' allowEditing=true}
        {if $mode ne 'create'}
            {include file='helper/include_standardfields_edit.tpl' obj=$album panel=true}
        {/if}
        
        {* include display hooks *}
        {if $mode ne 'create'}
            {assign var='hookId' value=$album.id}
            {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=$hookId assign='hooks'}
        {else}
            {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_edit' id=null assign='hooks'}
        {/if}
        {if is_array($hooks) && count($hooks)}
            {foreach name='hookLoop' key='providerArea' item='hook' from=$hooks}
                <h3 class="hook z-panel-header z-panel-indicator z-pointer">{$providerArea}</h3>
                <fieldset class="hook z-panel-content" style="display: none">{$hook}</div>
                    {$hook}
                </fieldset>
            {/foreach}
        {/if}
        
        
        {* include return control *}
        {if $mode eq 'create'}
            <fieldset>
                <legend>{gt text='Return control'}</legend>
                <div class="z-formrow">
                    {formlabel for='repeatCreation' __text='Create another item after save'}
                        {formcheckbox group='album' id='repeatCreation' readOnly=false}
                </div>
            </fieldset>
        {/if}
        
        {* include possible submit actions *}
        <div class="z-buttons z-formbuttons">
        {foreach item='action' from=$actions}
            {assign var='actionIdCapital' value=$action.id|@ucfirst}
            {gt text=$action.title assign='actionTitle'}
            {*gt text=$action.description assign='actionDescription'*}{* TODO: formbutton could support title attributes *}
            {if $action.id eq 'delete'}
                {gt text='Really delete this album?' assign='deleteConfirmMsg'}
                {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass confirmMessage=$deleteConfirmMsg}
            {else}
                {formbutton id="btn`$actionIdCapital`" commandName=$action.id text=$actionTitle class=$action.buttonClass}
            {/if}
        {/foreach}
        {formbutton id='btnCancel' commandName='cancel' __text='Cancel' class='z-bt-cancel'}
        </div>
    </div>
    {/muimageFormFrame}
{/form}
</div>
{include file="`$lct`/footer.tpl"}

{icon type='edit' size='extrasmall' assign='editImageArray'}
{icon type='delete' size='extrasmall' assign='removeImageArray'}


<script type="text/javascript">
/* <![CDATA[ */
    
    var formButtons, formValidator;
    
    function handleFormButton (event) {
        var result = formValidator.validate();
        if (!result) {
            // validation error, abort form submit
            Event.stop(event);
        } else {
            // hide form buttons to prevent double submits by accident
            formButtons.each(function (btn) {
                btn.addClassName('z-hide');
            });
        }
    
        return result;
    }
    
    document.observe('dom:loaded', function() {
    
        muimageAddCommonValidationRules('album', '{{if $mode ne 'create'}}{{$album.id}}{{/if}}');
        {{* observe validation on button events instead of form submit to exclude the cancel command *}}
        formValidator = new Validation('{{$__formid}}', {onSubmit: false, immediate: true, focusOnError: false});
        {{if $mode ne 'create'}}
            var result = formValidator.validate();
        {{/if}}
    
        formButtons = $('{{$__formid}}').select('div.z-formbuttons input');
    
        formButtons.each(function (elem) {
            if (elem.id != 'btnCancel') {
                elem.observe('click', handleFormButton);
            }
        });
    
        var panel = new Zikula.UI.Panels('mUImagePanel', {
            headerSelector: 'h3',
            headerClassName: 'z-panel-header z-panel-indicator',
            contentClassName: 'z-panel-content',
            active: $('z-panel-header-fields')
        });
    
        Zikula.UI.Tooltips($$('.muimage-form-tooltips'));
    });
/* ]]> */
</script>
