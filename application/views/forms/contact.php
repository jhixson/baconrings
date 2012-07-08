<h1>Contact Us</h1>

		<p>Have a question? Need help? Want to compliment us? Fill out the form below.</p>

		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/forms/contact-thanks">

				<label class="labelpadding">Name: </label>
				<input type="text" name="name" id="name" class="textinput" value="<?php if (!empty($name)) echo $name['value'];?>" />

				<label class="labelpadding">Email:<span class="required">*</span></label>
				<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" value="<?php if (!empty($email)) echo $email['value'];?>" />

				<label>College:
				<span class="small">If applicable</span>
				</label>
				<input type="text" name="school" id="school" class="textinput" value="<?php if (!empty($school)) echo $school['value'];?>" />

				<p><label class="labelpadding">What can we help you with:<span class="required">*</span></label>
				<textarea name="comments" id="comments" class="textareainput <?php if (!empty($comments)) echo 'textinputerror' ?>"><?php if (!empty($comments)) echo $comments['value'];?></textarea>
				</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>