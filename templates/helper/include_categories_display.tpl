{* purpose of this template: reusable display of entity categories *}
{if isset($obj.categories)}
    {if isset($panel) && $panel eq true}
        <h3 class="categories z-panel-header z-panel-indicator z-pointer">{gt text='Categories'}</h3>
        <div class="categories z-panel-content" style="display: none">
    {else}
        <h3 class="categories">{gt text='Categories'}</h3>
    {/if}
    {*
    <dl class="propertylist">
    {foreach key='propName' item='catMapping' from=$obj.categories}
        <dt>{$propName}</dt>
        <dd>{$catMapping.category.name|safetext}</dd>
    {/foreach}
    </dl>
    *}
    {assignedcategorieslist categories=$obj.categories doctrine2=true}
    {if isset($panel) && $panel eq true}
        </div>
    {/if}
{/if}
