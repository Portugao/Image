{* purpose of this template: inclusion template for display of related Pictures in user area *}

<h4>
    <a href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id}">
        {$item.title}
    </a>
    <a id="pictureItem{$item.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
        {icon type='view' size='extrasmall' __alt='Quick view'}
    </a>
</h4>
    <script type="text/javascript" charset="utf-8">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            muimageInitInlineWindow($('pictureItem{{$item.id}}Display'), '{{$item.title|replace:"'":""}}');
        });
    /* ]]> */
    </script>
    <br />
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPathURL:50:40}" width="50" height="40" alt="{$item.title|replace:"\"":""}" />
{/if}

