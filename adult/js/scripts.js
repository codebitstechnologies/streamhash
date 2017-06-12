$(document).ready(function(){
    $('.show-comments-text').click(function(){
    
       $('.show-comments-content').slideToggle('slow');
       if($(this).text() == 'More Comments')
       {
           $(this).text('Less Comments');
       }
       else
       {
           $(this).text('More Comments');
       }
    });   

});

  $('.video-box').hover(
          function(){
            $(this).addClass( "rotate" );
            }, function() { 
            $(this).removeClass( "rotate" );
  });

