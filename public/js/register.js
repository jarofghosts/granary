$(document).ready( function() {
   $("#color_picker").miniColors( {
       change: function(hex) {
           $("#about_me_textarea").css('background-color', hex);
       }
   });
});