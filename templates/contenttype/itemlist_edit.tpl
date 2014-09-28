{* Purpose of this template: edit view of generic item list content type *}

<div class="z-formrow">
    {formlabel for='MUImage_objecttype' __text='Object type'}
    {muimageSelectorObjectTypes assign='allObjectTypes'}
    {formdropdownlist id='MUImage_objecttype' dataField='objectType' group='data' mandatory=true items=$allObjectTypes}
</div>

<div class="z-formrow">
    {formlabel for='MUImage_albums' __text='Album'}
    {muimageSelectorAlbums assign='albums'}
    {formdropdownlist id='MUImage_albums' dataField='albums' group='data' mandatory=true items=$albums}
</div>

<div class="z-formrow">
    {formlabel __text='Sorting'}
    <div>
        {formradiobutton id='MUImage_srandom' value='random' dataField='sorting' group='data' mandatory=true}
        {formlabel for='MUImage_srandom' __text='Random'}
        {formradiobutton id='MUImage_snewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {formlabel for='MUImage_snewest' __text='Newest'}
        {formradiobutton id='MUImage_sdefault' value='default' dataField='sorting' group='data' mandatory=true}
        {formlabel for='MUImage_sdefault' __text='Default'}
    </div>
</div>

<div class="z-formrow">
    {formlabel for='MUImage_amount' __text='Amount'}
    {formtextinput id='MUImage_amount' dataField='amount' group='data' mandatory=true maxLength=2}
</div>

<div class="z-formrow">
    {formlabel for='MUImage_template' __text='Template File'}
    {muimageSelectorTemplates assign='allTemplates'}
    {formdropdownlist id='MUImage_template' dataField='template' group='data' mandatory=true items=$allTemplates}
</div>

<div class="z-formrow">
    {formlabel for='MUImage_filter' __text='Filter (expert option)'}
    {formtextinput id='MUImage_filter' dataField='filter' group='data' mandatory=false maxLength=255}
    <div class="z-formnote">({gt text='Syntax examples'}: <kbd>name:like:foobar</kbd> {gt text='or'} <kbd>status:ne:3</kbd>)</div>
</div>
