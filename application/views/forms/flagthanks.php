<h1>Thank You</h1>

	<p>This rating has been flagged and your comments have been sent to our site Moderation Team.</p>

	<p>Thank you for helping us improve the quality of the ratings.</p>

	<p>
	  <?php if(isset($item)): ?>
		<form action="/<?php echo $campus->university_slug."/".$category->category_slug."/".$item->item_slug ?>">
  		<button type="submit" class="bluebutton">Back to <?php echo $item->item_name ?></button>
		</form>
		<?php else: ?>
      <form action="/<?php echo $campus->university_slug ?>">
    		<button type="submit" class="bluebutton">Back to <?php echo $campus->university_name ?></button>
  		</form>
  	<?php endif ?>
	</p>


	<br /><br /><br /><br />