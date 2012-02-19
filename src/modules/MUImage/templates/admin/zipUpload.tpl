{* purpose of this template: show output of zip upload action in admin area *}
{include file='admin/header.tpl'}
<div class="muimage-zipupload muimage-zipupload">
{gt text='Zip upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='options' size='small' __alt='Zip upload'}
    <h3>{$templateTitle}</h3>
</div>

    <p>Please override this template by moving it from <em>/modules/MUImage/templates/admin/zipUpload.tpl</em> to either your <em>/themes/YourTheme/templates/modules/MUImage/admin/zipUpload.tpl</em> or <em>/config/templates/MUImage/admin/zipUpload.tpl</em>.</p>

</div>
{include file='admin/footer.tpl'}
