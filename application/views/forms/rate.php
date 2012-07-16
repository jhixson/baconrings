<div id="icon"><img src="<?php echo base_url(); ?>images/icon_large_Dorms.gif" border="0" height="67" width="67" /></div>

		<div id="breadcrumbs" style="margin-top:1px;">
    <span class="breadcrumbs"><a href="/<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></a> > <a href="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>"><?php echo $category->category_name ?></a> > ADD A RATING</span><br />
		</div>

    <h1>Rate <?php echo $item->item_name ?></h1>

		<br /><br />

		<div id="iteminfocontainer2">

			<p>(Responses to all questions are required)</p>

			<div id="infoMessage"><ul><?php echo $message;?></ul></div>

			<div id="rateform" class="rateform">

      <form action="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/<?php echo $item->item_slug ?>/rate-thanks" method="post">

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

				<br /><p class="spacing">Please keep comments clean. Comments that are inconsistent with <a href="">Site Guidelines</a> will be removed.</p>

				<p><label class="labelpadding">Comments:</label>
				<textarea name="comments" id="comments" class="textareainput <?php if (!empty($comments)) echo 'textinputerror' ?>"><?php if (!empty($comments)) echo $comments['value'];?></textarea>
				</p>


				<p class="spacing">By clicking the Submit button, I acknowledge that I have read and agreed to the RateMyCampus <a href="">Site Guidelines</a>, <a href="">Terms of Use</a>, and <a href="">Privacy Policy</a>.</p>

				<button type="submit" class="bluebutton" style="margin-left:153px;">Submit</button>

				<br /><br /><p class="spacing">Submitted data become the property of RateMyCampus.com. IP addresses are logged (<a href="">Privacy Policy</a>).

				</form>

			</div>

		</div>
