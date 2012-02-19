{* purpose of this template: show output of zip upload action in user area *}
{include file='user/header.tpl'}
<div class="muimage-zipupload muimage-zipupload">
{gt text='Zip upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>

    <p>Please override this template by moving it from <em>/modules/MUImage/templates/user/zipUpload.tpl</em> to either your <em>/themes/YourTheme/templates/modules/MUImage/user/zipUpload.tpl</em> or <em>/config/templates/MUImage/user/zipUpload.tpl</em>.</p>

</div>
</div>
{include file='user/footer.tpl'}
