{* purpose of this template: inclusion template for managing related Albums in user area *}
<fieldset>
    <legend>{gt text='Album'}</legend>
    <div class="z-formrow">
    <div class="muimageRelationRightSide">
        <a id="{$idPrefix}AddLink" href="javascript:void(0);" style="display: none">{gt text='Select album'}</a>
        <div id="{$idPrefix}AddFields">
            <label for="{$idPrefix}Selector">{gt text='Find album'}</label>
            <br />
            {icon type='search' size='extrasmall' __alt='Search album'}
            <input type="text" name="{$idPrefix}Selector" id="{$idPrefix}Selector" value="" />
            <input type="hidden" name="{$idPrefix}Scope" id="{$idPrefix}Scope" value="0" />
            {img src='indicator_circle.gif' modname='core' set='ajax' alt='' id="`$idPrefix`Indicator" style='display: none'}
            <div id="{$idPrefix}SelectorChoices" class="muimageAutoComplete"></div>
            <input type="button" id="{$idPrefix}SelectorDoCancel" name="{$idPrefix}SelectorDoCancel" value="{gt text='Cancel'}" class="z-button muimageInlineButton" />
            <a id="{$idPrefix}SelectorDoNew" href="{modurl modname='MUImage' type='user' func='edit' ot='album'}" title="{gt text='Create new album'}" class="z-button muimageInlineButton">{gt text='Create'}</a>
        </div>
        <noscript><p>{gt text='This function requires JavaScript activated!'}</p></noscript>
    </div>
    <div class="muimageRelationLeftSide">
        {if isset($userSelection.$aliasName) && $userSelection.$aliasName ne ''}
            {* the user has submitted something *}
            {include file='user/album/include_selectEditItemListOne.tpl' item=$userSelection.$aliasName}
        {elseif $mode ne 'create' || isset($relItem.$aliasName)}
            {include file='user/album/include_selectEditItemListOne.tpl' item=$relItem.$aliasName}
        {else}
            {include file='user/album/include_selectEditItemListOne.tpl'}
        {/if}
    </div>
    <br style="clear: both" />
    </div>
</fieldset>
