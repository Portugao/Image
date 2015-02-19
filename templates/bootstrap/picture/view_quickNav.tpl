{* purpose of this template: pictures view filter form *}
{checkpermissionblock component='MUImage:Picture:' instance='::' level='ACCESS_EDIT'}
{assign var='objectType' value='picture'}
<form action="{$modvars.ZConfig.entrypoint|default:'index.php'}" method="get" id="mUImagePictureQuickNavForm" class="muimage-quicknav">
    <fieldset>
        <h3>{gt text='Quick navigation'}</h3>
        <input type="hidden" name="module" value="{modgetinfo modname='MUImage' info='url'}" />
        <input type="hidden" name="type" value="{$lct}" />
        <input type="hidden" name="ot" value="picture" />
        <input type="hidden" name="func" value="view" />
        <input type="hidden" name="all" value="{$all|default:0}" />
        <input type="hidden" name="own" value="{$own|default:0}" />
        {gt text='All' assign='lblDefault'}
        {if !isset($albumFilter) || $albumFilter eq true}
                <label for="album">{gt text='Albums'}</label>
                {modapifunc modname='MUImage' type='selection' func='getEntities' ot='album' useJoins=false assign='listEntries'}
                <select id="album" name="album">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$listEntries}
                    {assign var='entryId' value=$option.id}
                    <option value="{$entryId}"{if $entryId eq $album} selected="selected"{/if}>{$option->getTitleFromDisplayPattern()}</option>
                {/foreach}
                </select>
        {/if}
        {if !isset($workflowStateFilter) || $workflowStateFilter eq true}
                <label for="workflowState">{gt text='Workflow state'}</label>
                <select id="workflowState" name="workflowState">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$workflowStateItems}
                <option value="{$option.value}"{if $option.title ne ''} title="{$option.title|safetext}"{/if}{if $option.value eq $workflowState} selected="selected"{/if}>{$option.text|safetext}</option>
                {/foreach}
                </select>
        {/if}
        {if !isset($searchFilter) || $searchFilter eq true}
                <label for="searchTerm">{gt text='Search'}</label>
                <input type="text" id="searchTerm" name="searchterm" value="{$searchterm}" />
        {/if}
        {if !isset($sorting) || $sorting eq true}
                <label for="sortBy">{gt text='Sort by'}</label>
                &nbsp;
                <select id="sortBy" name="sort">
                    <option value="id"{if $sort eq 'id'} selected="selected"{/if}>{gt text='Id'}</option>
                    <option value="workflowState"{if $sort eq 'workflowState'} selected="selected"{/if}>{gt text='Workflow state'}</option>
                    <option value="title"{if $sort eq 'title'} selected="selected"{/if}>{gt text='Title'}</option>
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
                    <option value="showTitle"{if $sort eq 'showTitle'} selected="selected"{/if}>{gt text='Show title'}</option>
                    <option value="showDescription"{if $sort eq 'showDescription'} selected="selected"{/if}>{gt text='Show description'}</option>
                    <option value="imageUpload"{if $sort eq 'imageUpload'} selected="selected"{/if}>{gt text='Image upload'}</option>
                    <option value="imageView"{if $sort eq 'imageView'} selected="selected"{/if}>{gt text='Image view'}</option>
                    <option value="albumImage"{if $sort eq 'albumImage'} selected="selected"{/if}>{gt text='Album image'}</option>
                    <option value="pos"{if $sort eq 'pos'} selected="selected"{/if}>{gt text='Pos'}</option>
                    <option value="createdDate"{if $sort eq 'createdDate'} selected="selected"{/if}>{gt text='Creation date'}</option>
                    <option value="createdUserId"{if $sort eq 'createdUserId'} selected="selected"{/if}>{gt text='Creator'}</option>
                    <option value="updatedDate"{if $sort eq 'updatedDate'} selected="selected"{/if}>{gt text='Update date'}</option>
                </select>
                <select id="sortDir" name="sortdir">
                    <option value="asc"{if $sdir eq 'asc'} selected="selected"{/if}>{gt text='ascending'}</option>
                    <option value="desc"{if $sdir eq 'desc'} selected="selected"{/if}>{gt text='descending'}</option>
                </select>
        {else}
            <input type="hidden" name="sort" value="{$sort}" />
            <input type="hidden" name="sdir" value="{if $sdir eq 'desc'}asc{else}desc{/if}" />
        {/if}
        {if !isset($pageSizeSelector) || $pageSizeSelector eq true}
                <label for="num">{gt text='Page size'}</label>
                <select id="num" name="num">
                    <option value="5"{if $pageSize eq 5} selected="selected"{/if}>5</option>
                    <option value="10"{if $pageSize eq 10} selected="selected"{/if}>10</option>
                    <option value="15"{if $pageSize eq 15} selected="selected"{/if}>15</option>
                    <option value="20"{if $pageSize eq 20} selected="selected"{/if}>20</option>
                    <option value="30"{if $pageSize eq 30} selected="selected"{/if}>30</option>
                    <option value="50"{if $pageSize eq 50} selected="selected"{/if}>50</option>
                    <option value="100"{if $pageSize eq 100} selected="selected"{/if}>100</option>
                </select>
        {/if}
        {if !isset($showTitleFilter) || $showTitleFilter eq true}
                <label for="showTitle">{gt text='Show title'}</label>
                <select id="showTitle" name="showTitle">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$showTitleItems}
                    <option value="{$option.value}"{if $option.value eq $showTitle} selected="selected"{/if}>{$option.text|safetext}</option>
                {/foreach}
                </select>
        {/if}
        {if !isset($showDescriptionFilter) || $showDescriptionFilter eq true}
                <label for="showDescription">{gt text='Show description'}</label>
                <select id="showDescription" name="showDescription">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$showDescriptionItems}
                    <option value="{$option.value}"{if $option.value eq $showDescription} selected="selected"{/if}>{$option.text|safetext}</option>
                {/foreach}
                </select>
        {/if}
        {if !isset($albumImageFilter) || $albumImageFilter eq true}
                <label for="albumImage">{gt text='Album image'}</label>
                <select id="albumImage" name="albumImage">
                    <option value="">{$lblDefault}</option>
                {foreach item='option' from=$albumImageItems}
                    <option value="{$option.value}"{if $option.value eq $albumImage} selected="selected"{/if}>{$option.text|safetext}</option>
                {/foreach}
                </select>
        {/if}
        <input type="submit" name="updateview" id="quicknavSubmit" value="{gt text='OK'}" />
    </fieldset>
</form>

<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        muimageInitQuickNavigation('picture');
        {{if isset($searchFilter) && $searchFilter eq false}}
            {{* we can hide the submit button if we have no quick search field *}}
            $('quicknavSubmit').addClassName('z-hide');
        {{/if}}
    });
/* ]]> */
</script>
{/checkpermissionblock}
