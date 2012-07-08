<!DOCTYPE html>
<html>
<head>
	<title>404 Page Not Found - RateMyCampus</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/general.css" />

  	</head>

  <body>

  <div id="container">

  	<div id="logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo.gif" border="0" height="98" width="318" /></a></div>

  	<div id="header">

  		<div id="sitetools">

  			<div style="float:right;margin:10px 12px 0 0;"><ul>
  				<li><a href="<?php echo base_url()."signup" ?>">create account</a></li>
  				<li><a href="<?php echo base_url()."login" ?>">login</a></li>
  			</ul></div>

  		</div>

  		<div id="navigation">
  			<a href="<?php echo base_url(); ?>" onmouseover="document.nav1.src='<?php echo base_url(); ?>images/nav1b.gif'" onmouseout="document.nav1.src='<?php echo base_url(); ?>images/nav1.gif'"><img src="<?php echo base_url(); ?>images/nav1.gif" id="nav1" name="nav1" border="0" height="61" width="138" alt="home" /></a><a
  			href="favorites.php" onmouseover="document.nav2.src='<?php echo base_url(); ?>images/nav2b.gif'" onmouseout="document.nav2.src='<?php echo base_url(); ?>images/nav2.gif'"><img src="<?php echo base_url(); ?>images/nav2.gif" id="nav2" name="nav2" border="0" height="61" width="178" alt="my schools" /></a><a
  			href="find.php" onmouseover="document.nav3.src='<?php echo base_url(); ?>images/nav3b.gif';document.getElementById('searchbox').style.visibility='visible';" onmouseout="document.nav3.src='<?php echo base_url(); ?>images/nav3.gif';document.getElementById('searchbox').style.visibility='hidden';"><img src="<?php echo base_url(); ?>images/nav3.gif" id="nav3" name="nav3" border="0" height="61" width="185" alt="find schools" /></a><a
  			href="bestof.php" onmouseover="document.nav4.src='<?php echo base_url(); ?>images/nav4b.gif'" onmouseout="document.nav4.src='<?php echo base_url(); ?>images/nav4.gif'"><img src="<?php echo base_url(); ?>images/nav4.gif" id="nav4" name="nav4" border="0" height="61" width="151" alt="best of" /></a>
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

  			</form>

  		</div>

  	</div>


  	<div id="clear" style="clear:both;"></div>


  	<div id="main">

  		<img src="/images/404.gif" border="0" alt="i heart college" align="right" height="216" width="286" />

		<h1><?php echo $heading; ?></h1>
		
		<p><?php echo $message; ?> What should you do now??</strong></p>

		<ul>
			<p><li>If you entered in the URL by hand, be sure to double check that it's right.</li></p>
			<p><li>You can <a href="javascript:history.back();">go back</a> and try to do whatever you did again.</li></p>
			<p><li>Or, head <a href="/">home</a> and start your journey from scratch.</li></p>
		</ul>
	
	</div>	

	<div id="footerline"></div>

	<div id="footer">

		<div id="footertext">
			<strong>Navigate</strong>
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="favorites.php">My Schools</a></li>
				<li><a href="find.php">Find Schools</a></li>
				<li><a href="bestof.php">Best of</a></li>
			</ul>
		</div>

		<div id="footertext">
			<strong>Need Help?</strong>
			<ul>
				<li><a href="/pages/faqs">FAQ</a></li>
				<li><a href="contact.php">Contact Us</a></li>
				<li><a href="/pages/rss">RSS</a></li>
			</ul>
		</div>

		<div id="footertext">
			<strong>Site Policies</strong>
			<ul>
				<li><a href="/pages/terms-of-use">Terms of Use</a></li>
				<li><a href="/pages/privacy-policy">Privacy Policy</a></li>
				<li><a href="/pages/site-guidelines">Site Guidelines</a></li>
			</ul>
		</div>

		<div id="footertextright">
			<a href=""><img src="<?php echo base_url(); ?>images/footer_facebook.gif" height="31" width="31" border="0" alt="facebook" /></a>
			<a href=""><img src="<?php echo base_url(); ?>images/footer_twitter.gif" hspace="10" height="31" width="31" border="0" alt="twitter" /></a>
			<a href=""><img src="<?php echo base_url(); ?>images/footer_rss.gif" height="31" width="31" border="0" alt="rss" /></a>

			<p />&copy;<?php echo date("Y") ?> RateMyCampus, All Rights Reserved.

		</div>

	</div>

</div>

</body>

</html>