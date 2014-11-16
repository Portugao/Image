{* purpose of this template: reusable display of entity categories *}
{if isset($obj.categories)}
    {gt text='Categories'}: 
   {* {foreach key='propName' item='catMapping' from=$obj.categories name='Categories'}
	{if $smarty.foreach.Categories.index >0 }, {/if}
	{$catMapping.category.name|safetext}
    {/foreach} *}
    {assignedcategorieslist categories=$obj.categories doctrine2=true}
    &nbsp;|&nbsp;
{/if}
