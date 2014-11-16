{* purpose of this template: header for user area *}
{pageaddvar name='javascript' value='prototype'}
{pageaddvar name='javascript' value='validation'}
{pageaddvar name='javascript' value='zikula'}
{pageaddvar name='javascript' value='livepipe'}
{pageaddvar name='javascript' value='zikula.ui'}
{pageaddvar name='javascript' value='zikula.imageviewer'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage.js'}

{* initialise additional gettext domain for translations within javascript *}
{pageaddvar name='jsgettext' value='module_muimage_js:MUImage'}

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
    <div class="z-frontendbox">
        <h2>{modgetinfo info='displayname'}{if $templateTitle}: {$templateTitle}{/if}</h2>
        {modulelinks modname='MUImage' type='user'}
    </div>
{/if}
{insert name='getstatusmsg'}
