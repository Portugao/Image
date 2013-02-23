{* purpose of this template: reusable editing of standard fields *}
{if (isset($obj.createdUserId) && $obj.createdUserId) || (isset($obj.updatedUserId) && $obj.updatedUserId)}
<fieldset>
    <legend>{gt text='Creation and update'}</legend>
    <ul>
{if isset($obj.createdUserId) && $obj.createdUserId}
        {usergetvar name='uname' uid=$obj.createdUserId assign='username'}
        <li>{gt text='Created by %s' tag1=$username}</li>
        <li>{gt text='Created on %s' tag1=$obj.createdDate|dateformat}</li>
{/if}
{if isset($obj.updatedUserId) && $obj.updatedUserId}
        {usergetvar name='uname' uid=$obj.updatedUserId assign='username'}
        <li>{gt text='Updated by %s' tag1=$username}</li>
        <li>{gt text='Updated on %s' tag1=$obj.updatedDate|dateformat}</li>
{/if}
    </ul>
</fieldset>
{/if}
