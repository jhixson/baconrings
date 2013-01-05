var comment_min = 150;
$(document).ready(function() {
  $('a.heart').click(function(e) {
    e.preventDefault();
    var c = true;
    var heart = $(this);
    if(!heart.is('.item'))
      c = confirm('Are you sure you want to remove this?');
    if(c) {
      $.get(heart.attr('href'), function (data) {
        //console.log(data);
        if(data.status == 'ok') {
          if(data.message == 'deleted') {
            if(heart.is('.item'))
              heart.removeClass('active');
            else {
              heart.closest('tr').remove();
              $('tr.header').each(function() {
                if($(this).next('tr').is('.header') || $(this).next('tr').length == 0)
                  $(this).remove();
              });
            }
          }
          else if(data.message == 'added') {
            heart.addClass('active');
          }
        }
        else if(data.status == 'err')
          if(confirm('You must be logged in to add favorites. Click OK to log in or Cancel to stay on this page.'))
            window.location.href = '/login';
      }, 'json');
    }
  });
  
  $('#rateform #comments').keyup(function(e) {
    var len = $(this).val().length;
    var cc = $('#char_count');
    cc.text(len+'/'+comment_min);
    if(len >= comment_min)
      cc.addClass('ok');
    else
      cc.removeClass('ok');
  });
  
  $('#rateform form').submit(function(e) {
    if($('#char_count').length > 0) {
      var len = $('#rateform #comments').val().length;
      if(len < comment_min) {
        alert('In order to increase the quality of ratings, we ask that your comment be at least 150 characters.');
        return false;
      }
    }
  });
});
