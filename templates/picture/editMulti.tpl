{* purpose of this template: show output of edit multi action in user area *}
{include file='user/header.tpl'}
<div class="muimage-editmulti muimage-editmulti">
    {gt text='Edit multi' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <h2>{$templateTitle}</h2>

    <p>Please override this template by moving it from <em>/modules/MUImage/templates/user/editMulti.tpl</em> to either your <em>/themes/YourTheme/templates/modules/MUImage/user/editMulti.tpl</em> or <em>/config/templates/MUImage/user/editMulti.tpl</em>.</p>
</div>
{include file='user/footer.tpl'}
