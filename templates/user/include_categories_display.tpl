{* purpose of this template: reusable display of entity categories *}
{if isset($obj.categories)}
    {gt text='Categories'}: 
    {foreach key='propName' item='catMapping' from=$obj.categories name='Catetgories'}
	{if $smarty.foreach.Categories.index>0}, {/if}
	{$catMapping.category.name|safetext}
    {/foreach}
    &nbsp;|&nbsp;
{/if}
