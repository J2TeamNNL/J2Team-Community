javascript:!function(){ 
  var body = document.body, html = document.documentElement; 
  var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight ); 
  var second = prompt("Hãy nhập số giây bạn muốn cuộn"); 
  var scroll_down = setInterval(function(){ window.scrollBy(0,height); }, 500); 
  setTimeout(function(){ clearInterval(scroll_down);}, second*1000); 
}();
