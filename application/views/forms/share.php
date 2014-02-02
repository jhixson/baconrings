<h1>Share Ratings</h1>

		<p></p>

		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $item->item_slug ?>/share-thanks">

				<label class="labelpadding">Your Name:<span class="required">*</span></label>
				<input type="text" name="name" id="name" class="textinput" <?php if (!empty($name)) echo 'textinputerror' ?>" value="<?php if (!empty($name)) echo $name['value'];?>" />

				<label class="labelpadding">Your Email:<span class="required">*</span></label>
				<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" value="<?php if (!empty($email)) echo $email['value'];?>" />


				<label class="labelpadding">Friend's Name:<span class="required">*</span></label>
				<input type="text" name="name2" id="name2" class="textinput" value="<?php if (!empty($name2)) echo $name2['value'];?>" />

				<label class="labelpadding">Friend's Email:<span class="required">*</span></label>
				<input type="text" name="email2" id="email2" class="textinput <?php if (!empty($email2)) echo 'textinputerror' ?>" value="<?php if (!empty($email2)) echo $email2['value'];?>" />


				<p><label class="labelpadding">Personal Message:</label>
				<textarea name="comments" id="comments" class="textareainput"><?php if (!empty($comments)) echo $comments['value'];?></textarea>
				</p>

				<p>
					<div style="margin-left:153px;">
					<?php
          			require_once('recaptchalib.php');
          			$publickey = "6Lc27NgSAAAAAMfxyzUa1X6zMS2Qx9bk6zwRKQcB";
          			echo recaptcha_get_html($publickey);
        			?>
        			</div>
        		</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>