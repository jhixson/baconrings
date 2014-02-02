<h1>Forgot Password</h1>
<p>No worries, it happens to the best of us. Give us your email and we'll send it to you:</p>

<div id="infoMessage"><ul><?php echo $message;?></ul></div>

<div id="contact" class="contact">

<?php echo form_open(base_url()."forms/forgot-password-thanks");?>

      <label class="labelpadding">Email:</label>
			<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" />

			<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

			<input type="hidden" name="sender" value="yes" />
      
<?php echo form_close();?>

</div>