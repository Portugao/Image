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
        <p>{gt text='Please select your item here. You can resort the dropdown list and reduce it\'s entries by applying filters. On the right side you will see a preview of the selected entry.'}</p>
        {muimagemoduleItemSelector id='id' group='data' objectType=$objectType}
    </div>

    <div{* class="form-group"*}>
        {formradiobutton id='linkButton' value='link' dataField='displayMode' group='data' mandatory=1}
        {formlabel for='linkButton' __text='Link to object'}
        {formradiobutton id='embedButton' value='embed' dataField='displayMode' group='data' mandatory=1}
        {formlabel for='embedButton' __text='Embed object display'}
    </div>
</div>
