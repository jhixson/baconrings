<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?> - RateMyCampus</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/general.css" />

  	</head>

  <body>
  
    <div id="fb-root"></div>

  <div id="container">

  	<div id="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.gif" border="0" height="98" width="318" /></a></div>

  	<div id="header">

  		<div id="sitetools">

        <div style="float:right;margin:10px 12px 0 0;"><ul>
          <?php if($logged_in): ?>
            <li><a href="<?php echo base_url()."logout" ?>">logout</a></li>
          <?php else: ?>
            <li><a href="<?php echo base_url()."signup" ?>">create account</a></li>
            <li><a href="<?php echo base_url()."login" ?>">login</a></li>
          <?php endif ?>
  			</ul></div>

  		</div>

  		<div id="navigation">
  			<a href="<?php echo base_url(); ?>" onmouseover="document.nav1.src='<?php echo base_url(); ?>images/nav1b.gif'" onmouseout="document.nav1.src='<?php echo base_url(); ?>images/nav1.gif'"><img src="<?php echo base_url(); ?>images/nav1.gif" id="nav1" name="nav1" border="0" height="61" width="138" alt="home" /></a><a
  			href="<?php echo base_url(); ?>favorites" onmouseover="document.nav2.src='<?php echo base_url(); ?>images/nav2b.gif'" onmouseout="document.nav2.src='<?php echo base_url(); ?>images/nav2.gif'"><img src="<?php echo base_url(); ?>images/nav2.gif" id="nav2" name="nav2" border="0" height="61" width="178" alt="my schools" /></a><a
  			href="<?php echo base_url(); ?>" onmouseover="document.nav3.src='<?php echo base_url(); ?>images/nav3b.gif';document.getElementById('searchbox').style.visibility='visible';" onmouseout="document.nav3.src='<?php echo base_url(); ?>images/nav3.gif';document.getElementById('searchbox').style.visibility='hidden';"><img src="<?php echo base_url(); ?>images/nav3.gif" id="nav3" name="nav3" border="0" height="61" width="185" alt="find schools" /></a><a
  			href="<?php echo base_url(); ?>best-of" onmouseover="document.nav4.src='<?php echo base_url(); ?>images/nav4b.gif'" onmouseout="document.nav4.src='<?php echo base_url(); ?>images/nav4.gif'"><img src="<?php echo base_url(); ?>images/nav4.gif" id="nav4" name="nav4" border="0" height="61" width="151" alt="best of" /></a>
  		</div>

  		<div id="searchbox" name="searchbox" style="visibility:hidden;" onmouseover="document.getElementById('searchbox').style.visibility='visible';document.getElementById('nav3').src='<?php echo base_url(); ?>images/nav3b.gif';" onmouseout="document.getElementById('searchbox').style.visibility='hidden';document.getElementById('nav3').src='<?php echo base_url(); ?>images/nav3.gif';">

        <form action="/campus/view" method="post">

  					<select name="school">
      				<option value="">Choose a School</option>
      				<?php foreach($campuses as $campus): ?>
        				<option value="<?php echo $campus->university_slug ?>"><?php echo $campus->university_name ?></option>
        			<?php endforeach ?>
      			</select>

  					<input type="submit" value="GO" class="bluebutton" />

            <div id="alphalink"><a href="/directory" style="font-size:10pt;">Alphabetical Directory</a></div>

  			</form>

  		</div>

  	</div>


  	<div id="clear" style="clear:both;"></div>


  	<div id="main">
