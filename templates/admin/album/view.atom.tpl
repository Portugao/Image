{* purpose of this template: albums atom feed in admin area *}
{muimageTemplateHeaders contentType='application/atom+xml'}<?xml version="1.0" encoding="{charset assign='charset'}{if $charset eq 'ISO-8859-15'}ISO-8859-1{else}{$charset}{/if}" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
{gt text='Latest albums' assign='channelTitle'}
{gt text='A direct feed showing the list of albums' assign='channelDesc'}
    <title type="text">{$channelTitle}</title>
    <subtitle type="text">{$channelDesc} - {$modvars.ZConfig.slogan}</subtitle>
    <author>
        <name>{$modvars.ZConfig.sitename}</name>
    </author>
{assign var='numItems' value=$items|@count}
{if $numItems}
{capture assign='uniqueID'}tag:{$baseurl|replace:'http://':''|replace:'/':''},{$items[0].createdDate|dateformat|default:$smarty.now|dateformat:'%Y-%m-%d'}:{modurl modname='MUImage' type='admin' func='display' ot='album' id=$items[0].id}{/capture}
    <id>{$uniqueID}</id>
    <updated>{$items[0].updatedDate|default:$smarty.now|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</updated>
{/if}
    <link rel="alternate" type="text/html" hreflang="{lang}" href="{modurl modname='MUImage' type='admin' func='main' fqurl=1}" />
    <link rel="self" type="application/atom+xml" href="{php}echo substr(\System::getBaseURL(), 0, strlen(\System::getBaseURL())-1);{/php}{getcurrenturi}" />
    <rights>Copyright (c) {php}echo date('Y');{/php}, {$baseurl}</rights>

{foreach item='album' from=$items}
    <entry>
        <title type="html">{$album->getTitleFromDisplayPattern()|notifyfilters:'muimage.filterhook.albums'}</title>
        <link rel="alternate" type="text/html" href="{modurl modname='MUImage' type='admin' func='display' ot='album' id=$album.id fqurl='1'}" />

        {capture assign='uniqueID'}tag:{$baseurl|replace:'http://':''|replace:'/':''},{$album.createdDate|dateformat|default:$smarty.now|dateformat:'%Y-%m-%d'}:{modurl modname='MUImage' type='admin' func='display' ot='album' id=$album.id}{/capture}
        <id>{$uniqueID}</id>
        {if isset($album.updatedDate) && $album.updatedDate ne null}
            <updated>{$album.updatedDate|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</updated>
        {/if}
        {if isset($album.createdDate) && $album.createdDate ne null}
            <published>{$album.createdDate|dateformat:'%Y-%m-%dT%H:%M:%SZ'}</published>
        {/if}
        {if isset($album.createdUserId)}
            {usergetvar name='uname' uid=$album.createdUserId assign='cr_uname'}
            {usergetvar name='name' uid=$album.createdUserId assign='cr_name'}
            <author>
               <name>{$cr_name|default:$cr_uname}</name>
               <uri>{usergetvar name='_UYOURHOMEPAGE' uid=$album.createdUserId assign='homepage'}{$homepage|default:'-'}</uri>
               <email>{usergetvar name='email' uid=$album.createdUserId}</email>
            </author>
        {/if}

        <summary type="html">
            <![CDATA[
            {$album.description|truncate:150:"&hellip;"|default:'-'}
            ]]>
        </summary>
        <content type="html">
            <![CDATA[
            {$album.title|replace:'<br>':'<br />'}
            ]]>
        </content>
    </entry>
{/foreach}
</feed>
