{* purpose of this template: pictures display view in user area *}
{include file='user/header.tpl'}
<div class="muimage-picture muimage-display">
{gt text='Picture' assign='templateTitle'}
{assign var='templateTitle' value=$picture.title|default:$templateTitle}
{pagesetvar name='title' value=$templateTitle|@html_entity_decode}
<div class="z-frontendcontainer">
    <h2>{$templateTitle|notifyfilters:'muimage.filter_hooks.pictures.filter'}</h2>


<dl id="MUImage_body">
    <dt>{gt text='Description'}</dt>
    <dd>{$picture.description}</dd>
{*    <dt>{gt text='Show title'}</dt>
    <dd>{assign var='itemid' value=$picture.id}
<a id="toggleshowtitle{$itemid}" href="javascript:void(0);" style="display: none">
{if $picture.showTitle}
    {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title="This setting is enabled. Click here to disable it."}
    {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title="This setting is disabled. Click here to enable it." style="display: none;"}
{else}
    {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title="This setting is enabled. Click here to disable it." style="display: none;"}
    {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title="This setting is disabled. Click here to enable it."}
{/if}
</a>
<noscript><div id="noscriptshowtitle{$itemid}">
    {$picture.showTitle|yesno:true}</div></noscript>
</dd>
    <dt>{gt text='Show description'}</dt>
    <dd>{assign var='itemid' value=$picture.id}
<a id="toggleshowdescription{$itemid}" href="javascript:void(0);" style="display: none">
{if $picture.showDescription}
    {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title="This setting is enabled. Click here to disable it."}
    {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title="This setting is disabled. Click here to enable it." style="display: none;"}
{else}
    {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title="This setting is enabled. Click here to disable it." style="display: none;"}
    {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title="This setting is disabled. Click here to enable it."}
{/if}
</a>
<noscript><div id="noscriptshowdescription{$itemid}">
    {$picture.showDescription|yesno:true}</div></noscript>
</dd> *}
    <dt>{gt text='Image upload'}</dt>
    <dd>  <a href="{$picture.imageUploadFullPathURL}" title="{$picture.title|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
  {if $picture.imageUploadMeta.isImage}
      <img src="{$picture.imageUpload|muimageImageThumb:$picture.imageUploadFullPath:250:150}" width="250" height="150" alt="{$picture.title|replace:"\"":""}" />
  {else}
      {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
  {/if}
  </a>
</dd>
    <dt>{gt text='Image view'}</dt>
    <dd>{$picture.imageView}</dd>
    <dt>{gt text='Album'}</dt>
    <dd>
    {if isset($picture.Album) && $picture.Album ne null}
      {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        <a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$picture.Album.id}">
            {$picture.Album.title|default:""}
        </a>
       {* <a id="albumItem{$picture.Album.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$picture.Album.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
            {icon type='view' size='extrasmall' __alt='Quick view'}
        </a>
        <script type="text/javascript" charset="utf-8">
        /* <![CDATA[ */
            document.observe('dom:loaded', function() {
                muimageInitInlineWindow($('albumItem{{$picture.Album.id}}Display'), '{{$picture.Album.title|replace:"'":""}}');
            });
        /* ]]> */
        </script> *}
      {else}
        {$picture.Album.title|default:""}
      {/if}
    {else}
        {gt text='No set.'}
    {/if}
    </dd>
</dl>
    {include file='user/include_standardfields_display.tpl' obj=$picture}
    {$picture.title|muimageImageMeta:$picture.imageUploadFullPathURL}
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
{if count($picture._actions) gt 0}
    <p>{strip}
    {foreach item='option' from=$picture._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
    {/foreach}
    {/strip}</p>
{/if}

{* include display hooks *}
{notifydisplayhooks eventname='muimage.ui_hooks.pictures.display_view' id=$picture.id urlobject=$currentUrlObject assign='hooks'}
{foreach key='hookname' item='hook' from=$hooks}
    {$hook}
{/foreach}

{/if}

</div>
</div>
{include file='user/footer.tpl'}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        {{assign var='itemid' value=$picture.id}}
        muimageInitToggle('picture', 'showTitle', '{{$itemid}}');
        muimageInitToggle('picture', 'showDescription', '{{$itemid}}');
    });
/* ]]> */
</script>
