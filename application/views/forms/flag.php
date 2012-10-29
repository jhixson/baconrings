<h1>Flag This Rating</h1>

		<p>
			If you believe this rating is inconsistent with our <a href="/pages/site-guidelines">Site Guidelines</a>,
			please use the form below to alert the Moderation Team.
		</p>

		<p>
			Please provide an explanation as to why you are reporting this rating, such as:

			<ul>
				<li>It contains profanity, name-calling, vulgarity, and/or derogatory comments.</li>
				<li>It appears to be spam.</li>
				<li>It is a duplicate rating.</li>
				<li>It is in a language other than English. Comments must be written in English only.</li>
			</ul>

		</p>

		<p><strong>The rating's comment:</strong>
		<br /><em><?php echo $comment->rating_comments ?></em>



		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/forms/flag-comment-thanks">

				<p><label class="labelpadding">Description: </label>
				<textarea name="comments" id="comments" class="textareainput <?php if (!empty($comments)) echo 'textinputerror' ?>"><?php if (!empty($description)) echo $description['value'];?></textarea>
				</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>