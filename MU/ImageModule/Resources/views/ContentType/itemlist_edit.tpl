{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='muimagemodule' assign='objectTypeSelectorLabel'}
    {formlabel for='mUImageModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {muimagemoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='mUImageModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='muimagemodule'}</span>
    </div>
</div>

{if $featureActivationHelper->isEnabled(constant('MU\\ImageModule\\Helper\\FeatureActivationHelper::CATEGORIES'), $objectType)}
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
        <div class="form-group">
            {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection($objectType, $propertyName)}
            {gt text='Category' domain='muimagemodule' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='muimagemodule' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="mUImageModuleCatIds`$propertyName`" text=$categorySelectorLabel cssClass='col-sm-3 control-label'}
            <div class="col-sm-9">
                {formdropdownlist id="mUImageModuleCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.' domain='muimagemodule'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}
{/if}

<div class="form-group">
    {gt text='Sorting' domain='muimagemodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formradiobutton id='mUImageModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='muimagemodule' assign='sortingRandomLabel'}
        {formlabel for='mUImageModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='mUImageModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='muimagemodule' assign='sortingNewestLabel'}
        {formlabel for='mUImageModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='mUImageModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='muimagemodule' assign='sortingDefaultLabel'}
        {formlabel for='mUImageModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='muimagemodule' assign='amountLabel'}
    {formlabel for='mUImageModuleAmount' text=$amountLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formintinput id='mUImageModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2 cssClass='form-control'}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='muimagemodule' assign='templateLabel'}
    {formlabel for='mUImageModuleTemplate' text=$templateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {muimagemoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='mUImageModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group"{* data-switch="mUImageModuleTemplate" data-switch-value="custom"*}>
    {gt text='Custom template' domain='muimagemodule' assign='customTemplateLabel'}
    {formlabel for='mUImageModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='mUImageModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='muimagemodule'}: <em>itemlist_[objectType]_display.html.twig</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='muimagemodule' assign='filterLabel'}
    {formlabel for='mUImageModuleFilter' text=$filterLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='mUImageModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='muimagemodule'}: <em>tbl.age >= 18</em></span>
    </div>
</div>

<script type="text/javascript">
    (function($) {
    	$('#mUImageModuleTemplate').change(function() {
    	    $('#customTemplateArea').toggleClass('hidden', $(this).val() != 'custom');
	    }).trigger('change');
    })(jQuery)
</script>
