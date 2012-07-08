<div id="icon"><img src="<?php echo base_url(); ?>images/icon_large_Dorms.gif" border="0" height="67" width="67" /></div>

		<div id="breadcrumbs" style="margin-top:1px;">
			<span class="breadcrumbs"><a href="<?php echo base_url(); ?>">SYRACUSE UNIVERSITY</a> > <a href="">ADD A RATING</a></span><br />
		</div>

		<h1>Rate Dellplain Hall</h1>

		<br /><br />

		<div id="iteminfocontainer2">

			<p>(Responses to all questions are required)</p>

			<div id="infoMessage"><ul><?php echo $message;?></ul></div>

			<div id="rateform" class="rateform">

				<form action="/forms/rate-thanks" method="post">

				<label class="labelpadding">Location:</label>
				<span class="awful">AWFUL</span>
				<input type="radio" name="att1" id="att1" value="1" class="radiorating" /> 1
				<input type="radio" name="att1" id="att1" value="2" class="radiorating" /> 2
				<input type="radio" name="att1" id="att1" value="3" class="radiorating" /> 3
				<input type="radio" name="att1" id="att1" value="4" class="radiorating" /> 4
				<input type="radio" name="att1" id="att1" value="5" class="radiorating" /> 5
				&nbsp;&nbsp;&nbsp;&nbsp;<span class="amazing">AMAZING</span>
				</p>

				<p>
				<label class="labelpadding">Something:</label>
				<span class="awful" style="color:#b2e6f4;">AWFUL</span>
				<input type="radio" name="att2" id="att2" value="1" class="radiorating" /> 1
				<input type="radio" name="att2" id="att2" value="2" class="radiorating" /> 2
				<input type="radio" name="att2" id="att2" value="3" class="radiorating" /> 3
				<input type="radio" name="att2" id="att2" value="4" class="radiorating" /> 4
				<input type="radio" name="att2" id="att2" value="5" class="radiorating" /> 5
				&nbsp;&nbsp;&nbsp;&nbsp;<span class="amazing" style="color:#b2e6f4;">AMAZING</span>
				</p>


				<p>
				<label class="labelpadding">Something:</label>
				<span class="awful" style="color:#b2e6f4;">AWFUL</span>
				<input type="radio" name="att3" id="att3" value="1" class="radiorating" /> 1
				<input type="radio" name="att3" id="att3" value="2" class="radiorating" /> 2
				<input type="radio" name="att3" id="att3" value="3" class="radiorating" /> 3
				<input type="radio" name="att3" id="att3" value="4" class="radiorating" /> 4
				<input type="radio" name="att3" id="att3" value="5" class="radiorating" /> 5
				&nbsp;&nbsp;&nbsp;&nbsp;<span class="amazing" style="color:#b2e6f4;">AMAZING</span>
				</p>

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