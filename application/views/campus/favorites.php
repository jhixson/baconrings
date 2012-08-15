<h1>My Favorites</h1>

		<p></p>

		<table cellpadding="3" cellspacing="0" border="0">

			<?php foreach($favorites as $k => $fave): ?>

			<tr bgcolor="#b2e6f4">
				<td colspan="2"><strong><a style="text-decoration:none;color:#000000;" href="<?php echo base_url(); ?><?php echo $fave[0]->university_slug ?>"><?php echo $fave[0]->university_name ?></a></strong></td>
				<td class="theader">&nbsp;</td>
				<td class="theader">RATING</td>
				<td>&nbsp;</td>
			</tr>

				<?php foreach($fave as $favorite): ?>
				<tr>
					<td width="20">&nbsp;</td>
					<td width="300"><a href="<?php echo base_url(); ?><?php echo $favorite->university_slug ?>/<?php echo $favorite->category_slug ?>/<?php echo $favorite->item_slug ?>" class="favlink"><?php echo $favorite->item_name ?></a></td>
					<td width="200"><a href="<?php echo base_url(); ?><?php echo $favorite->university_slug ?>/<?php echo $favorite->category_slug ?>" class="favlink"><?php echo $favorite->category_name ?></a></td>
					<td width="100">4.5</td>
					<td width="25"><a href=""><img src="<?php echo base_url(); ?>images/icon_favorite_remove.png" border="0" height="18" width="20" alt="remove from favorites" /></a></td>
				</tr>
				<?php endforeach ?>

			<?php endforeach ?>

		</table>

		<br /><br />

		<p></p>
