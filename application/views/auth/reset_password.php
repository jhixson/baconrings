<h1>Change Password</h1>

<div id="infoMessage"><ul><?php echo $message;?></ul></div>

<div id="contact" class="contact">

<?php echo form_open(base_url().'auth/reset_password/' . $code);?>
      
      <label class="labelpadding">New Password:
        <span class="small">(Min. <?php echo $min_password_length;?> characters)</span>
      </label>
      <?php echo form_input($new_password);?>
      
      <label class="labelpadding">Password Again:
        <span class="small">(Confirm new password)</span>
      </label> 
      <?php echo form_input($new_password_confirm);?>
      
      <?php echo form_input($user_id);?>
      <?php echo form_hidden($csrf); ?>
      <?php
      $data = array(
          'name'        => 'submit',
          'id'          => 'submit',
          'value'       => 'Change',
          'class'     => 'bluebutton',
          'style'       => 'margin-left:153px',
          );
      
      ?>
      <p><?php echo form_submit($data); ?></p>
      
<?php echo form_close();?>

</div>
