<h1>Submit Correction</h1>

		<p>Find something wrong with a listing or want to add some info we are missing?</p>

		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $item->item_slug ?>/submit-correction-thanks">

				<label class="labelpadding">Name: </label>
				<input type="text" name="name" id="name" class="textinput" value="<?php if (!empty($name)) echo $name['value'];?>" />

				<label class="labelpadding">Email: <span class="required">*</span></label>
				<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" value="<?php if (!empty($email)) echo $email['value'];?>" />

				<label>College/School:</label>
				<input type="text" name="school" id="school" class="textinput" value="<?php if (!empty($school)) echo $school['value'];else echo $campus->university_name; ?>" />

				<label>Item:
				<span class="small">If applicable</span>
				</label>
				<input type="text" name="itemm" id="itemm" class="textinput" value="<?php if (!empty($itemm)) echo $itemm['value'];else echo $item->item_name; ?>" />

				<p><label class="labelpadding">What would you like to us to change/add?<span class="required">*</span></label>
				<textarea name="comments" id="comments" class="textareainput <?php if (!empty($comments)) echo 'textinputerror' ?>"><?php if (!empty($comments)) echo $comments['value'];?></textarea>
				</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>