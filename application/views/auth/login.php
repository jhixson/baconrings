<h1>Log In</h1>
	<p></p>
	
  <div id="infoMessage"><ul><?php echo $message;?></ul></div>
  
  <div id="signup" class="signup" style="float:left;">

    <?php echo form_open(base_url()."auth/login");?>
    	
      <label for="identity" class="labelpadding">Email:</label>
      <?php $identity = array('name' => 'identity', 'id' => 'identity', 'class' => 'textinput', 'tabindex' => '1'); ?>
      <?php echo form_input($identity); ?>

      <label for="password">Password:
      <span class="small"><a href="/forgot_password" style="color:#000000;">Forgot password?</a></span>
      </label>
      <?php $password = array('name' => 'password', 'id' => 'password', 'class' => 'textinput', 'tabindex' => '2'); ?>
      <?php echo form_password($password);?>

      <label for="remember">Remember Me:</label>
      <?php $remember = array('name' => 'remember', 'id' => 'remember', 'checked' => FALSE, 'value' => '1', 'style' => 'float: left', 'tabindex' => '3'); ?>
      <?php echo form_checkbox($remember);?>
      <br style="clear: both;" /><br style="clear: both;" />
      <?php $submit = array('name' => 'submit', 'type' => 'submit', 'class' => 'bluebutton', 'content' => 'Log In', 'style' => 'margin-left: 153px', 'tabindex' => '4'); ?>
    <?php if(isset($location)){
  	?>
  	<input type="hidden" name="location" value="<?php echo $location; ?>" />
  	<?php } ?>
      <?php echo form_button($submit); ?>
      
    <?php echo form_close();?>

</div>

<div style="float:left;margin-left:50px;text-align:center">Or:<p><a href="/auth/fb"><img src="<?php echo base_url() ?>images/login_facebook.gif" border="0" height="60" width="251" /></a></p></div>

<div id="clear" style="clear:both;"></div>

