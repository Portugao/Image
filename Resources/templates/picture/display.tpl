{* purpose of this template: pictures display view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
<div class="muimage-picture muimage-display">
    {gt text='Picture' assign='templateTitle'}
    {assign var='templateTitle' value=$picture->getTitleFromDisplayPattern()|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type='display' size='small' __alt='Details'}
            <h3>{$templateTitle|notifyfilters:'muimage.filter_hooks.pictures.filter'}{icon id="itemActions`$picture.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
            </h3>
        </div>
    {else}
        <h2>{$templateTitle|notifyfilters:'muimage.filter_hooks.pictures.filter'}{icon id="itemActions`$picture.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
        </h2>
    {/if}

    <dl>
       {* <dt>{gt text='Title'}</dt>
        <dd>{$picture.title}</dd> *}
        {if $picture.description ne '' && $picture.showDescription}
        <dt>{gt text='Description'}</dt>
        <dd>{$picture.description}</dd>
        {/if}
        {* <dt>{gt text='Show title'}</dt>
        <dd>{assign var='itemid' value=$picture.id}
        <a id="toggleShowTitle{$itemid}" href="javascript:void(0);" class="z-hide">
        {if $picture.showTitle}
            {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title='This setting is enabled. Click here to disable it.'}
            {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title='This setting is disabled. Click here to enable it.' class='z-hide'}
        {else}
            {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title='This setting is enabled. Click here to disable it.' class='z-hide'}
            {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title='This setting is disabled. Click here to enable it.'}
        {/if}
        </a>
        <noscript><div id="noscriptShowTitle{$itemid}">
            {$picture.showTitle|yesno:true}
        </div></noscript>
        </dd> 
        <dt>{gt text='Show description'}</dt>
        <dd>{assign var='itemid' value=$picture.id}
        <a id="toggleShowDescription{$itemid}" href="javascript:void(0);" class="z-hide">
        {if $picture.showDescription}
            {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title='This setting is enabled. Click here to disable it.'}
            {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title='This setting is disabled. Click here to enable it.' class='z-hide'}
        {else}
            {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title='This setting is enabled. Click here to disable it.' class='z-hide'}
            {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title='This setting is disabled. Click here to enable it.'}
        {/if}
        </a>
        <noscript><div id="noscriptShowDescription{$itemid}">
            {$picture.showDescription|yesno:true}
        </div></noscript>
        </dd> 
        <dt>{gt text='Image upload'}</dt> *}
        <dd>  <a href="{$picture.imageUploadFullPathURL}" title="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
          {if $picture.imageUploadMeta.isImage}
              {thumb image=$picture.imageUploadFullPath objectid="picture-`$picture.id`" preset=$pictureThumbPresetImageUpload tag=true img_alt=$picture->getTitleFromDisplayPattern()}
          {else}
              {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
          {/if}
          </a>
        </dd>
        {modgetvar module='MUImage' name='countImageView' assign='imageView'}
        {if $imageView eq 1}
        <dt>{gt text='Invocations'}</dt>
        <dd>{$picture.imageView}</dd>
        {/if}               
       {* <dt>{gt text='Album image'}</dt>
        <dd>{$picture.albumImage|yesno:true}</dd>
        <dt>{gt text='Pos'}</dt>
        <dd>{$picture.pos}</dd> *}
        <dt>{gt text='Album'}</dt>
        <dd>
        {if isset($picture.Album) && $picture.Album ne null}
          {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
          <a href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$picture.Album.id}">
          {strip}
            {$picture.Album->getTitleFromDisplayPattern()|default:""}
          {/strip}</a>
          {*
          <a id="albumItem{$picture.Album.id}Display" href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$picture.Album.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="z-hide">{icon type='view' size='extrasmall' __alt='Quick view'}</a>
          <script type="text/javascript">
          /* <![CDATA[ */
              document.observe('dom:loaded', function() {
                  muimageInitInlineWindow($('albumItem{{$picture.Album.id}}Display'), '{{$picture.Album->getTitleFromDisplayPattern()|replace:"'":""}}');
              });
          /* ]]> */
          </script> *}
          {else}
            {$picture.Album->getTitleFromDisplayPattern()|default:""}
          {/if}
        {else}
            {gt text='Not set.'}
        {/if}
        </dd>
        
    </dl>
    {include file='helper/include_standardfields_display.tpl' obj=$picture}
     <div class="z-panels" id="panel">
    <h2 class="z-panel-header z-panel-indicator z-pointer z-panel-active">{gt text='Meta Datas'}</h2>
    {if $picture.imageUploadMeta.extension eq 'jpg' || $picture.imageUploadMeta.extension eq 'TIFF'}
    <div class="z-panel-content z-panel-active" style="overflow: visible;">
    {$picture.imageUploadFullPath|muimageImageMeta}
    </div>
    {else}
    <div>
    {gt text='Not supported for this picture'}
    </div>
    {/if}
    </div>

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        {* include display hooks *}
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.display_view' id=$picture.id urlobject=$currentUrlObject assign='hooks'}
        {foreach name='hookLoop' key='providerArea' item='hook' from=$hooks}
            {$hook}
        {/foreach}
        {if count($picture._actions) gt 0}
            <p id="itemActions{$picture.id}">
                {foreach item='option' from=$picture._actions}
                    <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">{$option.linkText|safetext}</a>
                {/foreach}
            </p>
        
            <script type="text/javascript">
            /* <![CDATA[ */
                document.observe('dom:loaded', function() {
                    muimageInitItemActions('picture', 'display', 'itemActions{{$picture.id}}');
                });
            /* ]]> */
            </script>
        {/if}
    {/if}
</div>
{include file="`$lct`/footer.tpl"}

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
    <script type="text/javascript">
    /* <![CDATA[ */
        var panel = new Zikula.UI.Panels('panel', {
        headerSelector: 'h2',
        headerClassName: 'z-panel-header z-panel-indicator',
        contentClassName: 'z-panel-content'
        }); 
    
        document.observe('dom:loaded', function() {
            {{assign var='itemid' value=$picture.id}}
            muimageInitToggle('picture', 'showTitle', '{{$itemid}}');
            muimageInitToggle('picture', 'showDescription', '{{$itemid}}');
        });
    /* ]]> */
    </script>
{/if}
