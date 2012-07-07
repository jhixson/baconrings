<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?> - RateMyCampus</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/general.css" />

  	</head>

  <body>

  <div id="container">

  	<div id="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.gif" border="0" height="98" width="318" /></a></div>

  	<div id="header">

  		<div id="sitetools">

  			<div style="float:right;margin:10px 12px 0 0;"><ul>
  				<li><a href="signup.php">create account</a></li>
  				<li><a href="login.php">login</a></li>
  			</ul></div>

  		</div>

  		<div id="navigation">
  			<a href="<?php echo base_url(); ?>" onmouseover="document.nav1.src='<?php echo base_url(); ?>images/nav1b.gif'" onmouseout="document.nav1.src='<?php echo base_url(); ?>images/nav1.gif'"><img src="<?php echo base_url(); ?>images/nav1.gif" id="nav1" name="nav1" border="0" height="61" width="138" alt="home" /></a><a
  			href="favorites.php" onmouseover="document.nav2.src='<?php echo base_url(); ?>images/nav2b.gif'" onmouseout="document.nav2.src='<?php echo base_url(); ?>images/nav2.gif'"><img src="<?php echo base_url(); ?>images/nav2.gif" id="nav2" name="nav2" border="0" height="61" width="178" alt="my schools" /></a><a
  			href="find.php" onmouseover="document.nav3.src='<?php echo base_url(); ?>images/nav3b.gif';document.getElementById('searchbox').style.visibility='visible';" onmouseout="document.nav3.src='<?php echo base_url(); ?>images/nav3.gif';document.getElementById('searchbox').style.visibility='hidden';"><img src="<?php echo base_url(); ?>images/nav3.gif" id="nav3" name="nav3" border="0" height="61" width="185" alt="find schools" /></a><a
  			href="bestof.php" onmouseover="document.nav4.src='<?php echo base_url(); ?>images/nav4b.gif'" onmouseout="document.nav4.src='<?php echo base_url(); ?>images/nav4.gif'"><img src="<?php echo base_url(); ?>images/nav4.gif" id="nav4" name="nav4" border="0" height="61" width="151" alt="best of" /></a>
  		</div>

  		<div id="searchbox" name="searchbox" style="visibility:hidden;" onmouseover="document.getElementById('searchbox').style.visibility='visible';document.getElementById('nav3').src='<?php echo base_url(); ?>images/nav3b.gif';" onmouseout="document.getElementById('searchbox').style.visibility='hidden';document.getElementById('nav3').src='<?php echo base_url(); ?>images/nav3.gif';">

  			<form action="" method="post">

  					<select name="">
  						<option value="">Choose a School</option>
  						<option value="">Ohio State</option>
  						<option value="">Syracuse University</option>
  					</select>

  					<input type="submit" value="GO" class="bluebutton" />

  			</form>

  		</div>

  	</div>


  	<div id="clear" style="clear:both;"></div>


  	<div id="main">