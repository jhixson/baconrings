<h1>Alphabetical Directory</h1>

<div id="directory" style="margin-left:0px;margin-top:20px;">

	<?php
	foreach (range('A', 'Z') as $letter) {
	  echo '<a href="/directory/#'.$letter.'">'.$letter.'</a>&nbsp;&nbsp;';
  }
  ?>
  
</div>

<?php foreach($campus_dir as $letter => $schools): ?>		
  <p id="<?php echo $letter ?>"><strong><?php echo $letter ?></strong></p>
  <?php foreach($schools as $campus): ?>		
    <p><a class="directorylink" href="/<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></a></p>
  <?php endforeach ?>
<?php endforeach ?>


<p></p>
