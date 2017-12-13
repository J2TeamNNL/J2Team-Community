
//Id bài đăng
var currentLocation = window.location.href;
var string_url = currentLocation.split("/");
function fail(){
	alert("Bạn phải ở đúng trang đã");
}
function copy(id){
var b=document.createElement("textarea"),c=document.getSelection();
b.textContent=id,document.body.appendChild(b),c.removeAllRanges(),b.select(),document.execCommand("copy"),c.removeAllRanges(),document.body.removeChild(b)
};
function getAllUrlParams() {
  var queryString = currentLocation ? currentLocation.split('?')[1] : window.location.search.slice(1);
  var obj = {};
  if (queryString) {
    queryString = queryString.split('#')[0];
    var arr = queryString.split('&');
    for (var i=0; i<arr.length; i++) {
      var a = arr[i].split('=');
      var paramNum = undefined;
      var paramName = a[0].replace(/\[\d*\]/, function(v) {
        paramNum = v.slice(1,-1);
        return '';
      });
      var paramValue = typeof(a[1])==='undefined' ? true : a[1];
      paramName = paramName.toLowerCase();
      if (obj[paramName]) {
        if (typeof obj[paramName] === 'string') {
          obj[paramName] = [obj[paramName]];
        }
        if (typeof paramNum === 'undefined') {
          obj[paramName].push(paramValue);
        }
        else {
          obj[paramName][paramNum] = paramValue;
        }
      }
      else {
        obj[paramName] = paramValue;
      }
    }
  }
  return obj;
}
function getPost(){
	try{
		if(currentLocation.indexOf("/permalink/") !== -1){
			var id = string_url[6];
			return id;
		}
		else if(currentLocation.indexOf("posts") !== -1){
			var id = string_url[5];
			return id;
		}
		else if(currentLocation.indexOf("videos") !== -1){
			var id = string_url[string_url.length-2];
			return id;
		}
		else if(currentLocation.indexOf("fbid=") !== -1){
			var id = getAllUrlParams().fbid;
			return id;
		}
		else if(currentLocation.indexOf("/photos/a") !== -1){
			var id = string_url[6];
			return id;
		}
		else if(currentLocation.indexOf("m.facebook") !== -1){
			var id = getAllUrlParams().id;
			return id;
		}
		return 0;
	}
	catch (e){
		return 0;
	}
}

var id = getPost();
if(id!="0" && id!="1" && isNaN(id)==false){
	copy(id);
}
else if(id!="1"){
	fail();
}
