{* Purpose of this template: Display a popup selector of pictures for scribite integration *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" lang="{lang}">
<head>
    <title>{gt text='Search and select picture'}</title>
    <link type="text/css" rel="stylesheet" href="{$baseurl}style/core.css" />
    <link type="text/css" rel="stylesheet" href="{$baseurl}modules/MUImage/style/style.css" />
    <link type="text/css" rel="stylesheet" href="{$baseurl}modules/MUImage/style/finder.css" />
    {assign var='ourEntry' value=$modvars.ZConfig.entrypoint}
    <script type="text/javascript">/* <![CDATA[ */
        if (typeof(Zikula) == 'undefined') {var Zikula = {};}
        Zikula.Config = {'entrypoint': '{{$ourEntry|default:'index.php'}}', 'baseURL': '{{$baseurl}}'}; /* ]]> */</script>
        <script type="text/javascript" src="{$baseurl}javascript/jquery/jquery-1.11.2.min.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/jquery-ui/jquery-ui-1.9.1.custom.min.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/ajax/proto_scriptaculous.combined.min.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/helpers/Zikula.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/livepipe/livepipe.combined.min.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/helpers/Zikula.UI.js"></script>
        <script type="text/javascript" src="{$baseurl}javascript/helpers/Zikula.ImageViewer.js"></script>
    	<script type="text/javascript" src="{$baseurl}modules/MUImage/javascript/MUImage_finder.js"></script>
        <!-- Das neueste kompilierte und minimierte CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
{if $editorName eq 'tinymce'}
    <script type="text/javascript" src="{$baseurl}modules/Scribite/includes/tinymce/tiny_mce_popup.js"></script>
{/if}
</head>
<body>
<div class="container-fluid">
    <form action="{$ourEntry|default:'index.php'}" id="mUImageSelectorForm" method="get" class="z-form">
	{*<div class="row">
        <div class="col-md-12"><br />
            {gt text='Switch to'}:
                <a href="{modurl modname='MUImage' type='external' func='finder' objectType='album' editor=$editorName}" title="{gt text='Search and select album'}">{gt text='Albums'}</a>        
        </div>
    </div>*}<br />
    <div class="row">
            <input type="hidden" name="module" value="MUImage" />
            <input type="hidden" name="type" value="external" />
            <input type="hidden" name="func" value="finder" />
            <input type="hidden" name="objectType" id="ObjectType" value="{$objectType}" />
            <input type="hidden" name="editor" id="editorName" value="{$editorName}" />
            {if $albums}
                {section name=singleAlbum loop=$albums}
                    {if $album > 0  && $albums[singleAlbum].id eq $album}
      		            <input type="hidden" name="album" id="albumId" value={$albums[singleAlbum].id} />
            	    {/if}
                 {/section}      
             {/if}        
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>{gt text='Select album and choose embed mode'}</legend>
                <div class="col-md-6">
                    {if $albums}
            	    <div class="form-group">
            	        <label for="mUImageSelect">{gt text='Select album'}:</label>
                        <select id="albums" class="form-control">
            		        {section name=singleAlbum loop=$albums}
            		    	    {if $album == 0}
            		    		    {if $smarty.section.singleAlbum.index == 0}
            		    			<option value="{modurl modname='MUImage' type='external' func='finder' objectType='picture' editor=$editorName album=$albums[singleAlbum].id}" selected=selected>
            		    				{$albums[singleAlbum].title}
            						</option>
            		    		{else}
             		        		<option value="{modurl modname='MUImage' type='external' func='finder' objectType='picture' editor=$editorName album=$albums[singleAlbum].id}">
            			    			{$albums[singleAlbum].title}
            						</option>           		    		
            		    		{/if}
            		    	{else}
             		        	<option value="{modurl modname='MUImage' type='external' func='finder' objectType='picture' editor=$editorName album=$albums[singleAlbum].id}" {if $albums[singleAlbum].id eq $album} selected=selected{/if}>
            			    		{$albums[singleAlbum].title}
            					</option>      		    	
            		    	{/if}
            		    {/section}
            	    </select>
            	    </div>
                    {/if}           
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label for="mUImagePasteAs">{gt text='Paste as'}:</label>
                    <select id="mUImagePasteAs" class="form-control" name="pasteas">
                        {if $modvars.MUImage.createSeveralPictureSizes eq false}
                        	<option value="3">{gt text='Thumbnail of picture'}</option>
                        {else}
                        	<option value="4">{gt text='Thumbnail of picture'}</option>
                        	<option value="5">{gt text='Preview of picture'}</option>
                        	<option value="6">{gt text='Thumbnail of picture with lightbox'}</option>
                        	<option value="7">{gt text='Preview of picture with lightbox'}</option>
                        	<option value="8">{gt text='Original picture'}</option>
                        {/if}
                        <option value="1">{gt text='Link to the picture'}</option>
                    </select>
                    </div>
                </div>
                </fieldset>
        </div>
    </div>
    {if $modvars.MUImage.createSeveralPictureSizes eq 0}
    <div class="row">
    <div class="col-md-12">
        <div class="col-md-6">       
            <div class="form-group">
                <label for="mUImageWidth">{gt text='Width'}:</label>
                    <input class="form-control" type="text" id="mUImageWidth" name="mUImageWidth" style="width: 150px" class="z-floatleft" style="margin-right: 10px" />
            </div>
        
        </div>
        <div class="col-md-6"></div>
    </div>
    </div>
    {else}
        <input id="mUImageWidth" name="mUImageWidth" type="hidden" value="" />
    {/if}
    <div class="row">
        <div class="col-md-12">
        <fieldset>
        <legend>{gt text='Click a picture to embed it into your text!'}</legend>
	    {if $items != null}
            <div class="form-group">
                <label for="mUImageObjectId">{gt text='Picture'}:</label>
                    <div id="muimageItemContainer2">
                        <ul>
                        {foreach item='picture' from=$items}
                            <li>
                                <a title="{$picture.title}" href="#" onclick="muimage.finder.selectItem({$picture.id})" onkeypress="muimage.finder.selectItem({$picture.id})">
                                {* {thumb image=$picture.imageUploadFullPath width=100 height=100 img_alt=$picture->getTitleFromDisplayPattern() tag=true mode='inset' extension='jpg'} *}
                                <div style="border: 3px solid #343434; width: 120px; height: 80px; background: url(userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_tmb.jpg) no-repeat center center; background-size: cover;"></div></a>
                                <input type="hidden" id="url{$picture.id}" value="{modurl modname='MUImage' type='user' func='display' ot='picture'  id=$picture.id fqurl=true}" />
                                <input type="hidden" id="title{$picture.id}" value="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}" />
                                <input type="hidden" id="desc{$picture.id}" value="{capture assign='description'}{if $picture.description ne ''}{$picture.description}{/if}
                                {/capture}{$description|strip_tags|replace:"\"":""}" />
                                <input type="hidden" id="path{$picture.id}" value="{$picture.imageUploadFullPathURL}" />
                                <input type="hidden" id="width{$picture.id}" value="{$picture.imageUploadMeta.width}" />
                                <input type="hidden" id="height{$picture.id}" value="{$picture.imageUploadMeta.height}" />
                                <input type="hidden" id="pathtmb{$picture.id}" value="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_tmb.jpg" />
                                <input type="hidden" id="pathpre{$picture.id}" value="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_pre.jpg" />
                                <input type="hidden" id="pathfull{$picture.id}" value="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_full.jpg" />
                                <input type="hidden" id="pathorig{$picture.id}" value="{$picture.imageUploadFullPathUrl}" />
                                <input type="hidden" id="createPictureSizes" value="{$modvars.MUImage.createSeveralPictureSizes}" />
                            </li>
                        {foreachelse}
                            <li>{gt text='No entries found.'}</li>
                        {/foreach}
                        </ul>
                    </div>
            </div>
            {/if}  
            </fieldset>      
        </div>
        </div>
        <div class="row-">
        	<div class="col-md-12-">
        		<div class="col-md-4">
                    <div class="form-group">
                        <label for="mUImagePageSize">{gt text='Page size'}:</label>
                        <select id="mUImagePageSize" class="form-control" name="num">
                            <option value="5"{if $pager.itemsperpage eq 5} selected="selected"{/if}>5</option>
                            <option value="10"{if $pager.itemsperpage eq 10} selected="selected"{/if}>10</option>
                            <option value="15"{if $pager.itemsperpage eq 15} selected="selected"{/if}>15</option>
                            <option value="20"{if $pager.itemsperpage eq 20} selected="selected"{/if}>20</option>
                            <option value="30"{if $pager.itemsperpage eq 30} selected="selected"{/if}>30</option>
                            <option value="50"{if $pager.itemsperpage eq 50} selected="selected"{/if}>50</option>
                            <option value="100"{if $pager.itemsperpage eq 100} selected="selected"{/if}>100</option>
                        </select><br /><br />
                        <input class="btn btn-warning" type="button" id="mUImageCancel" name="cancelButton" value="{gt text='Cancel'}" /><br /><br />
                        <input class="btn btn-standard" type="submit" id="mUImageSubmit" name="submitButton" value="{gt text='Change selection'}" />                        
                    </div>
                </div>
        		<div class="col-md-4">
                    &nbsp;
                </div>
        		<div class="col-md-4">
                    &nbsp;
                </div>
        	</div>
        </div>

        {if $items ne null}
            <div style="margin-left: 6em">
                {pager display='page' rowcount=$pager.numitems limit=$pager.itemsperpage posvar='pos' template='pagercss.tpl' maxpages='10'}
            </div>
        {/if}<br />
</div>


    <script type="text/javascript">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            muimage.finder.onLoad();
        });
    /* ]]> */
    </script>
        </div>
    </form>
    </div>
</body>
</html>
<script type="text/javascript">
/* <![CDATA[ */
    var MU = jQuery.noConflict();
	MU(document).ready(function(){
  		MU('select#albums').change(function(){
    		location.href = MU('select#albums').val();
    });
  });
/* ]]> */
</script>
