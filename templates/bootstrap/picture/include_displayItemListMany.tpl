{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
	<ul id="sortable" class="row">
		{foreach name='relLoop' item='item' from=$items}
			<li class="ui-state-default col-xs-6 col-sm-4 col-md-3 col-lg-2">
				<div class="thumbnail">
					{muimageCheckGroupMember createdUserId=$item.createdUserId assign='groupMember'}
					{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId || $groupMember eq 1}
						{assign var='cursor' value='movecursor'}
					{else}
						{assign var='cursor' value=''}
					{/if}
					<a data-placement="top" data-toggle="tooltip" href="{$item.imageUploadFullPath}" title="{$item.title}{if $item.description ne ''} - {$item.description}{/if}" data-gallery>
        				<img src="{thumb image=$item.imageUploadFullPath width=200 height=125 mode='outset' extension='jpg'}" alt="">
    				</a>
    				<div class="caption {$cursor}">
    					<a title="{gt text='Details'}" href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id}">
    						<i class="fa fa-camera-retro fa-lg"></i>
    					</a>
    					{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_EDIT'}
    						{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId || $groupMember eq 1}
    							<a title="{gt text='Edit'}" href="{modurl modname='MUImage' type='user' func='edit' ot='picture' id=$item.id}">
    						   		<i class="fa fa-pencil-square-o"></i>
    							</a>
    						{/if}
    					{/checkpermissionblock}	
    					<input name="pictures[]" type="hidden" value={$item.id} />
						{modgetvar module='MUImage' name='countImageView' assign='imageView'}
						<p class="muimage-picture-invocations">
							{if $imageView eq 1}
								{gt text='Invocations'}: {$item.imageView}
							{/if}	
						</p>		
    				</div>
    			</div>
    		</li>
		{/foreach}
	</ul>
{/if}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

    var MU = jQuery.noConflict();
	MU(document).ready(function(MU) {	
    {{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId || $groupMember eq 1}}
        MU(function() {
            MU( "#sortable" ).sortable();
        });
    {{/if}}
    
    	MU(function () {
			MU('[data-toggle="tooltip"]').tooltip()
		})
		});
    /* ]]> */
</script>