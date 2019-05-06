function run_like(){var run = casper_like("THAY TOKEN VAO CHO NAY EAAAAA");} // set triger per menit

function casper_like(token){
	var fql = "select type,app_id,comments,post_id,actor_id,target_id,message,created_time from stream";
	var randnumber = Math.random()*85000;

	fql = fql+" where source_id in ";

	fql = fql+"(select uid2 from friend where uid1=me())";

	fql = encodeURIComponent(fql);
	fql = "https://api.facebook.com/method/fql.query?query="+fql+"&limit=10&format=json&temp="+Math.floor(Math.random()*1000000)+"&access_token=";
	if(token&&token!=""){
		var me = get_cr_url("https://graph.facebook.com/v2.3/me?access_token="+token+"&temp="+Math.floor(Math.random()*1000000));
		var randnumber = Math.random()*85000;
		if(me&&me.id){
			fql = get_cr_url(fql+token);
			Utilities.sleep(randnumber);
			if(fql&&fql.length!=0){
				var hit = 0;
				var randnumber = Math.random()*85000;
				for(x in fql){
//if(fql[x].type==46 || fql[x].type==247){
					Utilities.sleep(randnumber);
					var cek_daftar = "https://graph.facebook.com/v2.4/"+fql[x].post_id+"/likes?summary=true&limit=1&access_token=";
					cek_daftar = get_cr_url(cek_daftar+token+"&temp="+Math.floor(Math.random()*1000000));
					var can_cr = 1;
					if(cek_daftar&&cek_daftar.summary&&cek_daftar.summary.has_liked == true){
						can_cr = 0;
					}
					if(can_cr==1){
						hit = hit+1;
						Utilities.sleep(randnumber);
						var jempol = "https://graph.facebook.com/v2.6/"+fql[x].post_id+"/reactions?type=LIKE&method=post&access_token=";
						jempol = get_cr_url(jempol+token);
					}
//}
				}
			}
		}
	}
}
function get_cr_url(almt){
	var mute={muteHttpExceptions:true}
	var url_cr = UrlFetchApp.fetch(almt,mute);
	var json_cr = Utilities.jsonParse(url_cr.getContentText());
	return json_cr;
}