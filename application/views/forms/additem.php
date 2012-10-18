<h1>Add Something to Rate</h1>

		<p>What can we add for you?</p>

		<div id="infoMessage"><ul><?php echo $message;?></ul></div>

		<div id="contact" class="contact">
			
			<form id="form" name="form" method="post" action="/<?php echo $campus->university_slug ?>/<?php echo $category->category_slug ?>/add-item-thanks">

				<label class="labelpadding">Name: </label>
				<input type="text" name="name" id="name" class="textinput" value="<?php if (!empty($name)) echo $name['value'];?>" />

				<label class="labelpadding">Email:<span class="required">*</span></label>
				<input type="text" name="email" id="email" class="textinput <?php if (!empty($email)) echo 'textinputerror' ?>" value="<?php if (!empty($email)) echo $email['value'];?>" />

				<label class="labelpadding">College:<span class="required">*</span></label>
				<select name="school" id="school" <?php if (!empty($school)) echo 'class="textinputerror"'?>>

					<option value="">Choose...</option>
					<?php foreach($schools as $c): ?>

						<?php if ($c->university_name == $school['value']):?>
							<option selected="selected" value="<?php echo $c->university_name ?>"><?php echo $c->university_name ?></option>
						<?php else:?>	
  							<option value="<?php echo $c->university_name ?>"><?php echo $c->university_name ?></option>
  						<?php endif?>

  					<?php endforeach ?>

				</select>
				
				<br /><br />

				<label class="labelpadding">Item to Add:<span class="required">*</span></label>
				<input type="text" name="item" id="item" class="textinput <?php if (!empty($item)) echo 'textinputerror' ?>" value="<?php if (!empty($item)) echo $item['value'];?>" />
				
				<label class="labelpadding">Category:<span class="required">*</span></label>
				<select name="cat" id="cat" <?php if (!empty($category)) echo 'class="textinputerror"'?>>

					<option value="">Choose...</option>
					<?php foreach($categories as $categoryy): ?>
  						
  						<?php if ($categoryy->category_name == $cat['value']):?>
  							<option selected="selected" value="<?php echo $categoryy->category_name ?>"><?php echo $categoryy->category_name ?></option>
  						<?php else:?>
	  						<option value="<?php echo $categoryy->category_name ?>"><?php echo $categoryy->category_name ?></option>
  						<?php endif?>

  					<?php endforeach ?>

				</select>

				<br /><br /><br /><p><strong>Help us with the detailed information?</strong></p>

				<label class="labelpadding">Address: </label>
				<textarea name="address" id="address" class="textareainput"><?php if (!empty($address)) echo $address['value'];?></textarea>
				
				<label class="labelpadding">Phone: </label>
				<input type="text" name="phone" id="phone" class="textinput" value="<?php if (!empty($phone)) echo $phone['value'];?>" />

				<p><label class="labelpadding">Description: </label>
				<textarea name="description" id="description" class="textareainput"><?php if (!empty($description)) echo $description['value'];?></textarea>
				</p>

				<button type="submit" name="submit" class="bluebutton" style="margin-left:153px;">Send</button>

				<input type="hidden" name="sender" value="yes" />

			</form>
		</div>