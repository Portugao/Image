{* purpose of this template: pictures view xml view *}
{muimageTemplateHeaders contentType='text/xml'}<?xml version="1.0" encoding="{charset}" ?>
<pictures>
{foreach item='item' from=$items}
    {include file='picture/include.xml.tpl'}
{foreachelse}
    <noPicture />
{/foreach}
</pictures>
