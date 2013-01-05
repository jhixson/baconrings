    <h1>Rate <?php echo $campus->university_name ?></h1>

		<br /><br />

		<div id="iteminfocontainer2">

			<p class="required">(Responses to all questions are required)</p>

			<div id="infoMessage"><ul><?php echo $message;?></ul></div>

			<div id="rateform" class="rateform">

      <form action="/<?php echo $campus->university_slug ?>/rate-thanks" method="post">

        <?php foreach($attributes as $attribute): ?>
          <p>
            <label class="labelpadding"><?php echo $attribute->attribute_name ?></label>
            <?php $span_visible = ($attribute == $attributes[0]) ? '' : ' style="visibility: hidden"' ?>
            <span class="awful"<?php echo $span_visible ?>>AWFUL</span>
              <?php for($i = 1; $i <=5; $i++): ?>
                <input type="radio" name="att[<?php echo $attribute->attribute_id ?>]" id="att_<?php echo $attribute->attribute_id ?>" value="<?php echo $i ?>" class="radiorating" /> <?php echo $i ?>
              <?php endfor ?>
              &nbsp;&nbsp;&nbsp;&nbsp;<span class="amazing"<?php echo $span_visible ?>>AMAZING</span>
          </p>
        <?php endforeach ?>

				<br /><p class="spacing">Please keep comments clean. Comments that are inconsistent with <a href="/pages/site-guidelines" class="ratelink">Site Guidelines</a> will be removed.</p>

				<p><label class="labelpadding">Comments:</label>
				<textarea name="comments" id="comments" class="textareainput <?php if (!empty($comments)) echo 'textinputerror' ?>"><?php if (!empty($comments)) echo $comments['value'];?></textarea>
				<span id="char_count">0/150</span>
				</p>


				<p class="spacing">By clicking the Submit button, I acknowledge that I have read and agreed to the RateMyCampus <a href="/pages/site-guidelines" class="ratelink">Site Guidelines</a>, <a href="/pages/terms-of-use" class="ratelink">Terms of Use</a>, and <a href="/pages/privacy-policy" class="ratelink">Privacy Policy</a>.</p>

				<div style="margin-left:153px;">
					<?php
          			require_once('recaptchalib.php');
          			$publickey = "6Lc27NgSAAAAAMfxyzUa1X6zMS2Qx9bk6zwRKQcB";
          			echo recaptcha_get_html($publickey);
        			?>
        		</div>
				
				<p><button type="submit" class="bluebutton" style="margin-left:153px;">Submit</button></p>

				<br /><br /><p class="spacing">Submitted data become the property of RateMyCampus.com.<br />IP addresses are logged (<a href="/pages/privacy-policy" class="ratelink">Privacy Policy</a>).

				</form>

			</div>

		</div>
