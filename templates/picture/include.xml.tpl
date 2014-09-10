{* purpose of this template: pictures xml inclusion template *}
<picture id="{$item.id}" createdon="{$item.createdDate|dateformat}" updatedon="{$item.updatedDate|dateformat}">
    <id>{$item.id}</id>
    <title><![CDATA[{$item.title}]]></title>
    <description><![CDATA[{$item.description}]]></description>
    <showTitle>{if !$item.showTitle}0{else}1{/if}</showTitle>
    <showDescription>{if !$item.showDescription}0{else}1{/if}</showDescription>
    <imageUpload{if $item.imageUpload ne ''} extension="{$item.imageUploadMeta.extension}" size="{$item.imageUploadMeta.size}" isImage="{if $item.imageUploadMeta.isImage}true{else}false{/if}"{if $item.imageUploadMeta.isImage} width="{$item.imageUploadMeta.width}" height="{$item.imageUploadMeta.height}" format="{$item.imageUploadMeta.format}"{/if}{/if}>{$item.imageUpload}</imageUpload>
    <imageView>{$item.imageView}</imageView>
    <albumImage>{if !$item.albumImage}0{else}1{/if}</albumImage>
    <pos>{$item.pos}</pos>
    <workflowState>{$item.workflowState|muimageObjectState:false|lower}</workflowState>
    <album>{if isset($item.Album) && $item.Album ne null}{$item.Album->getTitleFromDisplayPattern()|default:''}{/if}</album>
</picture>
