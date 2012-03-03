{* purpose of this template: show output of multi upload action in user area *}

{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_editFunctions.js'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage_validation.js'}
{include file='user/header.tpl'}
<div class="muimage-multiupload muimage-multiupload">
{gt text='Multi upload' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>
<div class="z-frontendcontainer">    
    <form action="/index.php?module=muimage&type=user&func=multi" method="post" enctype='multipart/form-data' class='z-form'>
    <fieldset>
        <legend>{gt text='Content'}</legend>
        <label for="upload[]">Upload</label>
        <div class="z-formrow">
             <input id=upload[] name="upload[]" type="file">
         </div>
        <label for="upload[]">Upload</label>
        <div class="z-formrow">
             <input id=upload[] name="upload[]" type="file">
         </div>   
    </fieldset>
    <button type="submit" value="senden">Senden</button>
    </form>



</div>
</div>
</div>
{include file='user/footer.tpl'}
