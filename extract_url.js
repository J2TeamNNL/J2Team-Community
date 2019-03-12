javascript:
function extract(url){
	var new_url = url ? url.split('?')[0] : window.location.search.slice(0);
	prompt('Đã lọc',new_url);
};
navigator.clipboard.readText()
.then(text => {
	extract(text);
});
