// dùng trên trình duyệt máy tính
// truy cập vào đường link bài đăng. VD: https://www.facebook.com/groups/j2team.community/posts/793663744299081
// thay thế www thành m. VD: https://m.facebook.com/groups/j2team.community/posts/793663744299081
// ấn chuột phải, chọn Inspect
// chọn tab Console => dán code vào đó mà xài thôi

const second = 2; // số giây để load thêm bình luận, có thể chỉnh lại tuỳ thuộc tốc độ mạng của bạn

const authorIdPost = getAuthorId(document.querySelector('div._67lm._77kc'));
let arrPeople = [];

function loadAllComments() {
  const loop = setInterval(function(){ 
    let btnClickMore = document.querySelector('a._108_.hoverZoomFetched'); 
    if(btnClickMore){
      btnClickMore.click();
    }
    else{
      clearInterval(loop);
      loadAllReplyComments();
    }
  }, 1000 * second);
}

function loadAllReplyComments() {
  const loop = setInterval(function(){ 
    let btnClickMore = document.querySelectorAll('div[id^=comment_replies_more]');
    if(btnClickMore.length){
      btnClickMore.forEach(el => el.querySelector('a').click());
    }
    else{
      clearInterval(loop);
      getComments();
    }
  }, 1000 * second);
}

function getComments() {
  const comments = document.querySelectorAll('div._2a_i');
  const lengthComments = comments.length;
  comments.forEach(function(el, index){
    let authorIdComment = getAuthorId(el.querySelector('div._2a_j'));
    if(authorIdComment != authorIdPost){
      let authorNameComment = el.querySelector('div._2b05 > a.hoverZoomFetched')?.textContent ?? '';
      if(authorNameComment === ''){
        return; // đang khoá nick, bay màu hoặc chặn bạn r
      }

      let comment = el.querySelector('div:not([class])');
      if(!comment){
        return; // bình luận nhãn dán không có chữ
      }
      let commentId = comment.getAttribute("data-commentid");
      let commentContent = comment.textContent;

      // lọc trùng người bình luận, mỗi người chỉ được tính 1 lần
      let object = arrPeople.find(element => element.authorIdComment === authorIdComment);
      if(object) {
        object.commentContent += ' | ' + commentContent;
      } else {
        arrPeople.push({
          authorIdComment,
          authorNameComment,
          commentId,
          commentContent
        });
      }
    }
    if(index == lengthComments-1){
      displayPeople();
    }
  })
}

function getAuthorId(el) {
  let attr = el.getAttribute("data-sigil");
  let stringLength = 'feed_story_ring'.length;

  return attr.substr(stringLength); 
}

function displayPeople() {
  string = `Id người bình luận,Tên người bình luận,Id bình luận,Nội dung bình luận\r\n`;
  string += arrayToCsv(arrPeople);
  downloadBlob(string, 'export.csv', 'text/csv;charset=utf-8');
}

loadAllComments();

function arrayToCsv(data){
  return data.map(row =>
    Object.values(row)
    .map(String)  // convert every value to String
    .map(v => v.replaceAll('"', '""'))  // escape double colons
    .map(v => `"${v}"`)  // quote it
    .join(',')  // comma-separated
  ).join('\r\n');  // rows starting on new lines
}

function downloadBlob(content, filename, contentType) {
  // Create a blob
  var blob = new Blob([content], { type: contentType });
  var url = URL.createObjectURL(blob);

  // Create a link to download it
  var pom = document.createElement('a');
  pom.href = url;
  pom.setAttribute('download', filename);
  pom.click();
}
