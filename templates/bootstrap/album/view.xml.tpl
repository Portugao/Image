{* purpose of this template: albums view xml view *}
{muimageTemplateHeaders contentType='text/xml'}<?xml version="1.0" encoding="{charset}" ?>
<albums>
{foreach item='item' from=$items}
    {include file='album/include.xml.tpl'}
{foreachelse}
    <noAlbum />
{/foreach}
</albums>
