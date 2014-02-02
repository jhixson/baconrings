
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php 
    /*
    if(isset($url)): ?>
    <a href="<?php echo $url; ?>">Click here to login</a>
    <?php else: ?>
    <p>You are logged in: <?php print_r($user) ?></p>
    <?php print_r($_SESSION) ?>
    <?php endif 
    */
    ?>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $this->facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          console.log(response);
          window.location.reload();
        });
      
        FB.getLoginStatus(function(response) {
          console.log(response);
          if(response.status == 'connected') {
            window.location.reload();
          }
          else {
            window.location.href = '/login';
          }
        }, true);
      };
      
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
</html>
