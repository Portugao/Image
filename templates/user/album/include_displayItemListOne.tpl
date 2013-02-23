{* purpose of this template: inclusion template for display of related Albums in user area *}

<h4>
    <a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$item.id}">
        {$item.title}
    </a>
    <a id="albumItem{$item.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$item.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
        {icon type='view' size='extrasmall' __alt='Quick view'}
    </a> 
</h4>
   {* <script type="text/javascript" charset="utf-8">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            muimageInitInlineWindow($('albumItem{{$item.id}}Display'), '{{$item.title|replace:"'":""}}');
        });
    /* ]]> */
    </script> *}

