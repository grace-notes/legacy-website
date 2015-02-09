$(document).ready(function() {
  $("body").on('click', 'a[href*=".pdf"], a[href*=".docx"]', function(e) {
    var url;
    e.preventDefault();
    url = $(this).attr('href');
    ga('send', {
      'hitType': 'pageview',
      'page': url.replace(/http:\/\/[^\/]*\//, '/'),
      'title': $(this).text()
    });
    setTimeout(function() {
      return location.href = url;
    }, 300);
    return false;
  });
});

