javascript:
!function(){ 
var second = prompt("Hãy nhập số giây bạn muốn cuộn"); 
var scroll_down = setInterval(function(){ window.scrollBy(0,2000); }, 500); 
setTimeout(function(){ clearInterval(scroll_down);}, second*1000); }();
