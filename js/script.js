jQuery(document).ready(function(){

	jQuery(".dtype").each(function(){
		jQuery(this).click(function(){
			var types = jQuery("#dtype").val();
			var ctype = jQuery(this).val();
			types = types.replace(ctype+",","");
			types = types.replace(ctype,"");
			if(this.checked){
			types = ctype+","+types;
			}
			jQuery("#dtype").val(types);
		});
	});
	jQuery(".ftype").each(function(){
			jQuery(this).click(function(){
				var ctype = jQuery(this).val();
				var iconpath = jQuery("#iconpath").html();
				jQuery("input.search-plug").css({ background: "url("+iconpath+"icon-"+ctype+".png) no-repeat scroll 5px center #FFFFFF" });
			});
		});
	jQuery("#rpg_search_box").focus(function(){
		if(this.value=='Search...')
		this.value = "";
	});
	jQuery("#rpg_search_box").blur(function(){
		if(this.value=='')
		this.value = "Search...";
	});
	jQuery(".ytbv").hover(function(){
		jQuery(this).next().show();
	},
	function(){
		jQuery(this).next().hide();
	});
});
var jdata = new Object();
function dopost(obj){
	var iconpath = jQuery("#iconpath").html();
	jQuery(obj).parent().css({ background: "url("+iconpath+"loading.gif) no-repeat scroll left center transparent " });
	var item = new Object();
	item.ajax = 1;
	div = jQuery(obj).parent().parent().parent();
	item.size = div.find(".size").html();
	item.auth = div.find(".auth").html();
	item.search = div.find(".search").html();
	item.title = div.parent().find(".ta").html();
	item.url = div.parent().find(".ta").attr("href");
	item.abstract = div.parent().find(".description").html();
	item.cat = div.find(".cat").html();
	item.tags = div.parent().find(".term").html();
	jQuery.post(document.location.href,item,function(data){
		jdata = eval(data);
		if(jdata[0].status=='ok'){
			if(confirm(jdata[0].message+"Read Post?")){
				window.open(jdata[0].url);
			}
		}
		else{
			alert(jdata[0].message);
		}
	jQuery(obj).parent().css({ background: "url("+iconpath+"downloads.jpg) no-repeat scroll left center transparent " });
	});
}

function postasswf(obj){
	var iconpath = jQuery("#iconpath").html();
	jQuery(obj).parent().css({ background: "url("+iconpath+"loading.gif) no-repeat scroll left center transparent " });
	var item = new Object();
	item.ajax = 2;
	div = jQuery(obj).parent().parent().parent();
	item.size = div.find(".size").html();
	item.auth = div.find(".auth").html();
	item.search = div.find(".search").html();
	item.title = div.parent().find(".ta").html();
	item.url = div.parent().find(".ta").attr("href");
	item.abstract = div.parent().find(".description").html();
	item.cat = div.find(".cat").html();
	item.tags = div.parent().find(".term").html();
	jQuery.post(document.location.href,item,function(data){
	jdata = eval(data);
	if(jdata[0].status=='ok'){
	jQuery.post(rpg_path+"pdf-to-swf.php?pdfurl="+item.url+"&postid="+jdata[0].postid,function(data2){
		jQuery(obj).parent().css({ background: "url("+iconpath+"downloads.jpg) no-repeat scroll left center transparent " });
		if(confirm(jdata[0].message+"\r\nRead Post?")){
			window.open(jdata[0].url);
		}
	});
	}
	else{
		jQuery(obj).parent().css({ background: "url("+iconpath+"downloads.jpg) no-repeat scroll left center transparent " });
		alert(jdata[0].message);
	}
	});


	
	
}

function postvideo(obj){

	var item = new Object();
	item.ajax = 3;
	div = jQuery(obj).parent();
	authcat = div.parent().attr('id').split(',');
	item.auth = authcat[0];
	item.cat = authcat[1];
	item.search = jQuery('#rpg_search_box').val();
	item.url = div.find(".ytbv").attr('href');
	jQuery(div.find('.desc a')[0]).parent().html("[youtube]"+jQuery(obj).attr("id")+"[/youtube]")
	item.abstract = div.find(".desc").html();
	item.title = div.find(".videotitle").text();
	jQuery.post(document.location.href,item,function(data){
		jdata = eval(data);
		if(jdata[0].status=='ok'){
			if(confirm(jdata[0].message+"Read Post?")){
				window.open(jdata[0].url);
			}
		}
		else{
			alert(jdata[0].message);
		}
	});
	
}
