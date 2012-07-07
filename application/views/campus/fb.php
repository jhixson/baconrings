<h1>FB</h1>

  <?php if (@$user_profile): ?>
          <pre>
              <?php echo print_r($user_profile, TRUE) ?>
          </pre>
          <a href="<?php echo $logout_url ?>">Logout of this thing</a>
      <?php else: ?>
          <h2>Welcome to this facebook thing, please login below</h2>
          <a href="<?php echo $login_url ?>">Login to this thing</a>
      <?php endif; ?>