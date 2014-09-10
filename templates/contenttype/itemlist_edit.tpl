{* Purpose of this template: edit view of generic item list content type *}
<div class="z-formrow">
    {gt text='Object type' domain='module_muimage' assign='objectTypeSelectorLabel'}
    {formlabel for='mUImageObjectType' text=$objectTypeSelectorLabel}
        {muimageObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='mUImageOjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes}
        <span class="z-sub z-formnote">{gt text='If you change this please save the element once to reload the parameters below.' domain='module_muimage'}</span>
</div>

{formvolatile}
{if $properties ne null && is_array($properties)}
    {nocache}
    {foreach key='registryId' item='registryCid' from=$registries}
        {assign var='propName' value=''}
        {foreach key='propertyName' item='propertyId' from=$properties}
            {if $propertyId eq $registryId}
                {assign var='propName' value=$propertyName}
            {/if}
        {/foreach}
        <div class="z-formrow">
            {modapifunc modname='MUImage' type='category' func='hasMultipleSelection' ot=$objectType registry=$propertyName assign='hasMultiSelection'}
            {gt text='Category' domain='module_muimage' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='module_muimage' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="mUImageCatIds`$propertyName`" text=$categorySelectorLabel}
                {formdropdownlist id="mUImageCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode}
                <span class="z-sub z-formnote">{gt text='This is an optional filter.' domain='module_muimage'}</span>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}

<div class="z-formrow">
    {gt text='Sorting' domain='module_muimage' assign='sortingLabel'}
    {formlabel text=$sortingLabel}
    <div>
        {formradiobutton id='mUImageSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='module_muimage' assign='sortingRandomLabel'}
        {formlabel for='mUImageSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='mUImageSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='module_muimage' assign='sortingNewestLabel'}
        {formlabel for='mUImageSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='mUImageSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='module_muimage' assign='sortingDefaultLabel'}
        {formlabel for='mUImageSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="z-formrow">
    {gt text='Amount' domain='module_muimage' assign='amountLabel'}
    {formlabel for='mUImageAmount' text=$amountLabel}
        {formintinput id='mUImageAmount' dataField='amount' group='data' mandatory=true maxLength=2}
</div>

<div class="z-formrow">
    {gt text='Template' domain='module_muimage' assign='templateLabel'}
    {formlabel for='mUImageTemplate' text=$templateLabel}
        {muimageTemplateSelector assign='allTemplates'}
        {formdropdownlist id='mUImageTemplate' dataField='template' group='data' mandatory=true items=$allTemplates}
</div>

<div id="customTemplateArea" class="z-formrow z-hide">
    {gt text='Custom template' domain='module_muimage' assign='customTemplateLabel'}
    {formlabel for='mUImageCustomTemplate' text=$customTemplateLabel}
        {formtextinput id='mUImageCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80}
        <span class="z-sub z-formnote">{gt text='Example' domain='module_muimage'}: <em>itemlist_[objectType]_display.tpl</em></span>
</div>

<div class="z-formrow z-hide">
    {gt text='Filter (expert option)' domain='module_muimage' assign='filterLabel'}
    {formlabel for='mUImageFilter' text=$filterLabel}
        {formtextinput id='mUImageFilter' dataField='filter' group='data' mandatory=false maxLength=255}
        <span class="z-sub z-formnote">
            ({gt text='Syntax examples'}: <kbd>name:like:foobar</kbd> {gt text='or'} <kbd>status:ne:3</kbd>)
        </span>
</div>

{pageaddvar name='javascript' value='prototype'}
<script type="text/javascript">
/* <![CDATA[ */
    function muimageToggleCustomTemplate() {
        if ($F('mUImageTemplate') == 'custom') {
            $('customTemplateArea').removeClassName('z-hide');
        } else {
            $('customTemplateArea').addClassName('z-hide');
        }
    }

    document.observe('dom:loaded', function() {
        muimageToggleCustomTemplate();
        $('mUImageTemplate').observe('change', function(e) {
            muimageToggleCustomTemplate();
        });
    });
/* ]]> */
</script>
