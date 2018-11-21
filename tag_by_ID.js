

javascript:

var currentLocation = window.location.href;
var string_url = currentLocation.split("/");
function fail(){
  alert("Bạn phải ở đúng trang đã");
}
function failMobile(){
  alert("Không hỗ trợ cho điện thoại");
}
function failPhotos(){
  alert("Không tag được trên ảnh");
}
function failUID(){
	alert("Nhập sai số ID");
}
function redirect(id_post) {
  fail();
  window.location.href = "http://fb.com/"+id_post;
}
function getGroup(){
  try{
    var div = document.getElementsByClassName("coverWrap");
    var id = div[0].dataset.referrerid;
    if(id!="null") return 1;
    else return 0;
  }
  catch (e){
    return 0;
  }
}
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
    if(currentLocation.indexOf("m.facebook") !== -1){
      failMobile();
      return 1;
    }
    else if(currentLocation.indexOf("/permalink/") !== -1){
      var id = string_url[6];
      return id;
    }
    else if(currentLocation.indexOf("videos") !== -1){
      var id = string_url[string_url.length-2];
      var check = getGroup();
      if(check!=0){
        redirect(id);
        return 1;
      }
      else{
        return id;
      }
    }
    else if(currentLocation.indexOf("photo") !== -1){
      var check = getGroup();
      if(check!=0){
        var set    = getAllUrlParams().set;
        var string = set.split(".");
        var id     = string[1];
        redirect(id);
        return 1;
      }
      else{
        failPhotos();
        return 1;
      }
    }
    else if(currentLocation.indexOf("posts") !== -1){
      var set    = string_url[string_url.length-1];
      var string = set.split("?");
      var id     = string[0];
      return id;
    }
    return 0;
  }
  catch (e){
    return 0;
  }
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function(obj) {
  return typeof obj;
} : function(obj) {
  return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
};
var id_post = getPost();
if(id_post!=0 && id_post!=1 && isNumber(id_post)==true){
  var uid = prompt('Nhập số ID Facebook người muốn tag');
  if(isNumber(uid)){
    var text = prompt('Nhập nội dung muốn nhắn');
    addCmt();
  }
  else{
    failUID();
  }
}
else if(id_post!=1){
	fail();
}



function addCmt() {
  request('https://www.facebook.com/ufi/add/comment/?dpr=1', {
    ft_ent_identifier: id_post,
    comment_text: '@[' + uid + ':0] '+text,
    av: getUserID(),
    __user: getUserID(),
    __a: 1,
    fb_dtsg: getUserToken(),
    source: 2,
    client_id: '1489983090155:3363757627',
    session_id: '84d81e4'
  });
}

function request(url, data) {
  fetch(url, {
    method: 'POST',
    credentials: 'include',
    body: JSONtoFormData(data)
  }).then(function(response) {
    if(response.ok) {
      window.scrollTo(0,document.body.scrollHeight);
    }
  });
}

function JSONtoFormData(json) {
  if ((typeof json === 'undefined' ? 'undefined' : _typeof(json)) !== 'object') {
    if (typeof json === 'string') {
      try {
        json = JSON.parse(json);
      } catch (e) {
        return false;
      }
    } else {
      return false;
    }
  }

  var formData = new FormData();
  Object.keys(json).map(function(key) {
    formData.append(key, json[key]);
  });

  return formData;
}

function getUserID() {
  if (typeof require !== 'function') return null;
  try {
    return require('CurrentUserInitialData').USER_ID || document.cookie.match(/c_user=([0-9]+)/)[1];
  } catch (e) {
    return null;
  }
}

function getUserToken() {
  if (typeof require !== 'function') return null;
  try {
    return require('DTSGInitialData').token || document.querySelector('[name="fb_dtsg"]').value;
  } catch (e) {
    return null;
  }
}
