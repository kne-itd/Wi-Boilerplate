$(document).ready(function(){
   var msg_div = $('.user-feedback');
   if (msg_div.html() == '') {
       msg_div.hide();
   }
   
   setTimeout(function(){
      msg_div.hide(1000); 
   }, 2000)
});