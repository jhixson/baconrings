<h1>Sign Up</h1>

    <div id="infoMessage"><?php echo $message;?></div>
		<p>Don't worry, we never show your email address for any rating you submit.</p>

		<div id="signup" class="signup">
			
    <?php echo form_open(base_url()."auth/create_user");?>

				<label style="height:50px;">I am a:
				<span class="small">Who are you?</span>
				</label>
				<input type="radio" name="who" value="1" /> Student<br />
				<input type="radio" name="who" value="2" /> Parent<br />
				<input type="radio" name="who" value="3" /> Professor<br />
				<input type="radio" name="who" value="4" /> Alumni<br />
				<input type="radio" name="who" value="5" /> Other<br />
				<br />
				

				<label>School:
				<span class="small">Primary school to rate</span>
				</label>
				<select name="school" id="school">
  				<option value="">Choose a School</option>
  				<?php foreach($campuses as $campus): ?>
    				<option value="<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></option>
    			<?php endforeach ?>
  			</select>
	
	    <label>Email:
			<span class="small">Valid email please</span>
			</label>
			<?php $email = array('name' => 'email', 'id' => 'email', 'class' => 'textinput'); ?>
			<?php echo form_input($email);?>

			<label>Email Again:
			<span class="small">Confirm email</span>
			</label>			
			<?php $email2 = array('name' => 'email2', 'id' => 'email2', 'class' => 'textinput'); ?>
			<?php echo form_input($email2);?>

      <label>Password:
			<span class="small">Min. size 6 chars</span>
			</label>			
			<?php $password = array('name' => 'password', 'id' => 'password', 'class' => 'textinput'); ?>
      <?php echo form_password($password);?>
      
      <label>Password Again:
			<span class="small">Confirm password</span>
			</label>      
      <?php $password_confirm = array('name' => 'password_confirm', 'id' => 'password_confirm', 'class' => 'textinput'); ?>
      <?php echo form_password($password_confirm);?>
      
      <?php $submit = array('name' => 'submit', 'type' => 'submit', 'class' => 'bluebutton', 'content' => 'Sign Up', 'style' => 'margin-left: 153px'); ?>
      <?php echo form_button($submit); ?>
      
    <?php echo form_close();?>

</div>

  <br /><br />

	<p></p>
