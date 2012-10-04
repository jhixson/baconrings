<h1>Upload</h1>

<?php if (isset($msg)) echo $msg; ?>

<?php echo form_open_multipart('/do_upload'); ?>

<p>Photo: <input type="file" name="userfile" /></p>
<p>Caption: <input type="text" name="caption" size="20" /></p>
<input type="hidden" name="item_id" value="<?php echo $item->item_id ?>" />

<br /><br />

<input type="submit" value="Submit" />

</form>