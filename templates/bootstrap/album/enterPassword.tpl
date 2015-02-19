{* purpose of this template: albums list view *}
<form method="post" action="{modurl modname='MUImage' type='album' func='enterPassword' id="`$id`"}">
    <label for="albumPassword">{gt text='Enter password'}</label>
        <input type="password" name="albumPassword" />
		<input name="enterPassword" type="submit" value="{gt text='Submit'}" />
</form>