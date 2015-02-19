{* purpose of this template: show output of external action in user area *}
{include file='user/header.tpl'}
<div class="muimage-external muimage-external">
    {gt text='External' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>

    <p>Please override this template by moving it from <em>/modules/MUImage/templates/user/external.tpl</em> to either your <em>/themes/YourTheme/templates/modules/MUImage/user/external.tpl</em> or <em>/config/templates/MUImage/user/external.tpl</em>.</p>
</div>
{include file='user/footer.tpl'}
