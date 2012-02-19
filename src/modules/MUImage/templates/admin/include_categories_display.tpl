{* purpose of this template: reusable display of entity categories *}
{if isset($obj.categories)}
<h3 class="categories">{gt text='Categories'}</h3>
{*
<dl class="propertylist">
{foreach key='propName' item='catMapping' from=$obj.categories}
    <dt>{$propName}</dt>
    <dd>{$catMapping.category.name|safetext}</dd>
{/foreach}
</dl>
*}
{assignedcategorieslist categories=$obj.categories doctrine2=true}
{/if}
