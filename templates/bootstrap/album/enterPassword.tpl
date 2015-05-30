{* purpose of this template: albums list view *}
<form method="post" action="{modurl modname='MUImage' type='album' func='enterPassword' id="`$id`"}">
<div class="form-group">
    <label for="albumPassword">{gt text='Enter password'}</label>
    <input class="form-control input-sm" type="password" name="albumPassword" />
</div>
<div class="form-group">
	<input class="btn btn-default btn-sm" name="enterPassword" type="submit" value="{gt text='Submit'}" />
</div>
</form>