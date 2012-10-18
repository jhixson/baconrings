<h1>Add a Category</h1>

		<p>What can we add for you?</p>

		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/<?php echo $campus->university_slug ?>/add-category-thanks">

				<label class="labelpadding">Name: </label>
				<input type="text" name="name" id="name" class="textinput" value="<?php if (!empty($name)) echo $name['value'];?>" />

				<label class="labelpadding">Email:<span class="required">*</span></label>
				<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" value="<?php if (!empty($email)) echo $email['value'];?>" />

				<label>College/School:
				<span class="small">If applicable</span>
				</label>
				<input type="text" name="school" id="school" class="textinput" value="<?php if (!empty($school)) echo $school['value'];?>" />

				<p><label class="labelpadding">Category to add:<span class="required">*</span></label>
				<input type="text" name="category" id="category" class="textinput <?php if (!empty($category)) echo 'textinputerror' ?>" value="<?php if (!empty($category)) echo $category['value'];?>" />
				</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>