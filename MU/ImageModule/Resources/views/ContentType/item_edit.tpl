{* Purpose of this template: edit view of specific item detail view content type *}

<div style="margin-left: 80px">
    <div class="form-group">
        {formlabel for='mUImageModuleObjectType' __text='Object type' cssClass='col-sm-3 control-label'}
        <div class="col-sm-9">
            {muimagemoduleObjectTypeSelector assign='allObjectTypes'}
            {formdropdownlist id='mUImageModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
            <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.'}</span>
        </div>
    </div>
    <div{* class="form-group"*}>
        <p>{gt text='Please select your item here. You can resort the dropdown list and reduce it\'s entries by applying filters. On the right side you will see a preview of the selected entry.' domain='muimagemodule'}</p>
        {muimagemoduleItemSelector id='id' group='data' objectType=$objectType}
    </div>

    <div{* class="form-group"*}>
        {gt text='Link to object' assign='displayModeLabel'}
        {formradiobutton id='linkButton' value='link' dataField='displayMode' group='data' mandatory=1}
        {formlabel for='linkButton' text=$displayModeLabel}
        {gt text='Embed object display' assign='displayModeLabel'}
        {formradiobutton id='embedButton' value='embed' dataField='displayMode' group='data' mandatory=1}
        {formlabel for='embedButton' text=$displayModeLabel}
    </div>

    <div{* class="form-group"*}>
        {gt text='Custom template' domain='muimagemodule' assign='customTemplateLabel'}
        {formlabel for='mUImageModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
        <div class="col-sm-9">
            {formtextinput id='mUImageModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
            <span class="help-block">{gt text='Example' domain='muimagemodule'}: <em>displaySpecial.html.twig</em></span>
            <span class="help-block">{gt text='Needs to be located in the "External/YourEntity/" directory.' domain='muimagemodule'}</span>
        </div>
    </div>
</div>
