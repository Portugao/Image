{* purpose of this template: module configuration *}
{include file='admin/header.tpl'}
<div class="muimage-config">
    {gt text='Additional Sizes' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    <div class="z-admin-content-pagetitle">
        {icon type='config' size='small' __alt='Additional Sizes'}
        <h3>{$templateTitle}</h3>
    </div>

    {form cssClass='z-form'}
        {* add validation summary and a <div> element for styling the form *}
        {muimageFormFrame}
            <div class="z-buttons z-formbuttons">
                {formbutton commandName='generate' __text='Create several sizes' class='z-bt-save'}
                {formbutton commandName='cancel' __text='Cancel' class='z-bt-cancel'}
            </div>
        {/muimageFormFrame}
    {/form}
</div>
{include file='admin/footer.tpl'}
<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        Zikula.UI.Tooltips($$('.muimage-form-tooltips'));
    });
/* ]]> */
</script>
