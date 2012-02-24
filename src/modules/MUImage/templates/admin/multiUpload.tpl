{* purpose of this template: show output of multi upload action in admin area *}
{include file='admin/header.tpl'}
<div class="muimage-multiupload muimage-multiupload">
{gt text='Multi upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-admin-content-pagetitle">
    {icon type='options' size='small' __alt='Multi upload'}
    <h3>{$templateTitle}</h3>
</div>

    <p>Please override this template by moving it from <em>/modules/MUImage/templates/admin/multiUpload.tpl</em> to either your <em>/themes/YourTheme/templates/modules/MUImage/admin/multiUpload.tpl</em> or <em>/config/templates/MUImage/admin/multiUpload.tpl</em>.</p>

</div>
{include file='admin/footer.tpl'}
