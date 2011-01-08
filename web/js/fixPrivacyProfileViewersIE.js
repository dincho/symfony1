// JavaScript Document
Event.observe(window, 'load', function(event) {
  if(/MSIE/.test( navigator.userAgent ))
  {
    $$('#winks  .privacy_profile_viewers .x').each( function(e) {
            e.style.setAttribute('top', '17px');
            });
  }
});    
