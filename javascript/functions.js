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
      }, 'json');
    }
  });
});
