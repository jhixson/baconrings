<h1>Sign Up</h1>

    <div id="infoMessage"><ul><?php echo $message;?></ul></div>
		
		<p>Don't worry, we never show your email address for any rating you submit.</p>

		<div id="signup" class="signup">
			
    <?php echo form_open(base_url()."auth/create_user");?>

				<label style="height:100px;">I am a:<span class="required">*</span>
				<span class="small">Who are you?</span>
				</label>
				<input type="radio" name="who" value="Student" /> Student<br />
				<input type="radio" name="who" value="Parent" /> Parent<br />
				<input type="radio" name="who" value="Professor" /> Professor<br />
				<input type="radio" name="who" value="Alumni" /> Alumni<br />
				<input type="radio" name="who" value="User" /> Other<br />
				<br />
				

				<label>School:<span class="required">*</span>
				<span class="small">Primary school to rate</span>
				</label>
				<select name="school" id="school">
  				<option value="">Choose a School</option>
  				<?php foreach($campuses as $campus): ?>
    				<option value="<?php echo $campus->university_id ?>"><?php echo $campus->university_name ?></option>
    			<?php endforeach ?>
  			</select>
	
	    <label>Email:<span class="required">*</span>
			<span class="small">Valid email please</span>
			</label>
			<?php $email = array('name' => 'email', 'id' => 'email', 'class' => 'textinput'); ?>
			<?php echo form_input($email);?>

		<label>Email Again:<span class="required">*</span>
			<span class="small">Confirm email</span>
			</label>			
			<?php $email2 = array('name' => 'email2', 'id' => 'email2', 'class' => 'textinput'); ?>
			<?php echo form_input($email2);?>

      <label>Password:<span class="required">*</span>
			<span class="small">Min. size 6 chars</span>
			</label>			
			<?php $password = array('name' => 'password', 'id' => 'password', 'class' => 'textinput'); ?>
      <?php echo form_password($password);?>
      
      <label>Password Again:<span class="required">*</span>
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
