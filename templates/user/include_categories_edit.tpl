{* purpose of this template: reusable editing of entity attributes *}
<fieldset>
    <legend>{gt text='Categories'}</legend>
    {formvolatile}
    {foreach key='registryId' item='registryCid' from=$registries}
        <div class="z-formrow">
            {formlabel for="category_`$registryId`" __text='Category'}
            {formcategoryselector id="category_`$registryId`" category=$registryCid
                                  dataField='categories' group=$groupName registryId=$registryId doctrine2=true}
        </div>
    {/foreach}
    {/formvolatile}
</fieldset>
