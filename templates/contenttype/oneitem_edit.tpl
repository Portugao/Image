{* Purpose of this template: edit view of generic item list content type *}

<div class="z-formrow">
    {formlabel for='MUImage_objecttype' __text='Object type'}
    {muimageSelectorObjectTypes assign='allObjectTypes' object='picture'}
    {formdropdownlist id='MUImage_objecttype' dataField='objectType' group='data' mandatory=true items=$allObjectTypes}
</div>
<div class="z-formrow">
    {formlabel for='MUImage_album' __text='Album'}
    {muimageSelectorAlbums assign='Albums'}
    {formdropdownlist id='MUImage_album' dataField='album' group='data' mandatory=true items=$Albums}
</div>
{* <div class="z-formrow">
    {formlabel for='MUImage_picture' __text='Picture'}
    {muimageSelectorPictures assign='Picture'}
    {formdropdownlist id='MUImage_picture' dataField='picture' group='data' mandatory=true items=$Albums}
</div> *}
<div class="z-formrow">
    {formlabel for='MUImage_id' __text='Id'}
    {formtextinput id='MUImage_id' dataField='id' group='data' mandatory=true maxLength=20}
</div>
<div class="z-formrow">
    {formlabel for='MUImage_width' __text='Width'}
    {formtextinput id='MUImage_width' dataField='width' group='data' mandatory=true maxLength=5}
</div>
<div class="z-formrow">
    {formlabel for='MUImage_height' __text='Height'}
    {formtextinput id='MUImage_height' dataField='height' group='data' mandatory=true maxLength=5}
</div>
<div class="z-formrow">
    {formlabel for='MUImage_template' __text='Template File'}
    {muimageSelectorTemplates assign='allTemplates'}
    {formdropdownlist id='MUImage_template' dataField='template' group='data' mandatory=true items=$allTemplates}
</div>
