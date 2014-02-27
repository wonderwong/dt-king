//javascript document script.js

window.SetString = function(str,len){
	var strlen = 0; 
	var s = "";
	for(var i = 0;i < str.length;i++){
		if(str.charCodeAt(i) > 128){
			strlen += 2;
		}else{ 
			strlen++;
		}
		s += str.charAt(i);
		if(strlen >= len){ 
			return s ;
		}
	}
	return s;
};

$(function(){
	
	/*king-图文列表插件*/
	$.fn.ImgTextList = function (options){
	
		//整理参数
		var defaults = {        
			thumbState			: 	1, 
			contentState		: 	1,
			headerState	:	0,
			contentHrefState		: 	0,
			thumbAnimate		:	"fade",	//fade：渐显 bt：下到上 rl: 右到左
			contentAnimate	:	"fade",	//fade: 渐显 bt：下到上	rl：右到左
			headerAnimate		:	"rl",	//rl:右到左 rr：右到右
			contentTextLength	:	30,
			headerTextLength	:	20
		}; 
		var opts = $.extend(defaults, options); 
		
		
		var $parent=this;
			$parent.append('<div id="img-text-hook" class="vh"></div>');
		var $imgTextHook=$("#img-text-hook");
		var $children=$parent.find("li");
		
		$children.each(function(){
			//数据准备
			var $thisWrap=$(this); 
			var nAlbumId=$thisWrap.attr("id")||"0";
			var nAlbumNum=parseInt(nAlbumId.split("-")[1]);
			if ($thisWrap.find(".img-wrap").length==0){
				$thisWrap.find("a.img-wrap-a").wrap('<div class="img-wrap"></div>');
			}
			var $this=$thisWrap.find(".img-wrap");
			var $title=$thisWrap.find(".title a");
			var $summary=$thisWrap.find(".summary");
			
			$this.append('<a class="img-mask" href="'+$title.attr("href")+'"></a>');
			var $mask=$this.children(".img-mask");
			$mask.click(function(){
				getAlbumDate(nAlbumNum);
				return false;
			});
			
			//放大镜
			if (opts.thumbState===1){
				$this.append('<a class="img-thumb" href="'+$title.attr("href")+'" title="点击查看大图"><i></i></a>');
				var $thumb=$this.find(".img-thumb");
				
				$thumb.click(function(){
					getAlbumDate(nAlbumNum);
					return false;
				});
			}
			
			//标题
			if (opts.headerState===1){
				var sHeaderHtml='<div class="img-header"><a href="'+$title.attr("href")+'" title="进入详细页">'+SetString($title.text(),opts.headerTextLength)+'</a></div>';
				$this.append(sHeaderHtml);
				var $header=$this.find(".img-header");
				var nHeaderWidth=$header.width();
				var nThisWidth=$this.width();
			}
			
			//简介
			if (opts.contentState===1){
				$thumb.css("top","40%");
				var sContentHtml="";
				if (opts.contentHrefState===1){
					sContentHtml='<a href="'+$title.attr("href")+'" title="进入详细页">'+SetString($summary.text(),opts.contentTextLength)+'</a>';
				}else if(opts.contentHrefState===0){
					sContentHtml=SetString($summary.text(),opts.contentTextLength);
				}
				
				$this.append('<div class="img-content"><p>'+sContentHtml+'</p></div>');
				var $content=$this.find(".img-content");
			}
			
			$this.hover(function(){
			
				$mask.stop().animate({"opacity":"0.2"});
				
				if (opts.thumbState===1){
					switch (opts.thumbAnimate){
						case "fade"	:
							$thumb.children("i").stop().animate({"opacity":"0.7"},300);
							break;
						case "bt"	:
							$thumb.stop().animate({"top":"40%"});
							$thumb.children("i").stop().animate({"opacity":"1"});
					}
				}
				
				if (opts.contentState===1){
					switch (opts.contentAnimate){
						case "fade":
							$content.stop().animate({"opacity":"0.5"},300);
							break;
						case "bt"	:
							$content.css("bottom","-70px");
							$content.stop().animate({"bottom":"0","opacity":"0.5"},300);
							break;
					}
				}
				
				//标题
				if(opts.headerState===1){
					$header.css("right",-nHeaderWidth+"px");
					switch (opts.headerAnimate){
						case "rl"	:
							$header.stop().animate({"right":"0","opacity":"0.5"});
							break;
						case "rr"	:
							$header.stop().animate({"right":"0","opacity":"0.5"});
							break;
					}
					
				}
			
			},function(){
			
				$mask.stop().animate({"opacity":"0"});
				
				//放大镜
				if (opts.thumbState===1){
					switch (opts.thumbAnimate){
						case "fade"	:
							$thumb.children("i").stop().animate({"opacity":"0"},300);
							break;
						case "bt"	:
							$thumb.stop().animate({"top":"50%"});
							$thumb.children("i").stop().animate({"opacity":"0"});
							break;
					}
				}
				//简介内容
				if (opts.contentState===1){
					switch (opts.contentAnimate){
						case "fade"	:
							$content.stop().animate({"opacity":"0"},300);
							break;
						case "bt"	:
							$content.stop().animate({"bottom":"-70px","opacity":"0"},300);
							break;
					}
				}
				//标题
				if(opts.headerState===1){
					switch (opts.headerAnimate){
						case "rl"	:
							$header.stop().animate({"right":nHeaderWidth+nThisWidth,"opacity":"0"});
							break;
						case "rr"	:
							$header.stop().animate({"right":-nHeaderWidth,"opacity":"0"});
					}
				}
			
			});
			
			
		 });
		 
		function getAlbumDate(data){
			$.ajax({
				type: "get",
				url: "ajax.html",
				beforeSend: function(XMLHttpRequest){
					//ShowLoading();
				},
				success: function(data, textStatus){
					$imgTextHook.html(data);
					$imgTextHook.find("a[rel^='prettyPhoto']").prettyPhoto().eq(0).trigger("click");
				},
				complete: function(XMLHttpRequest, textStatus){
					//HideLoading();
				},
				error: function(){
					//请求出错处理
				}
			});
		 }
		 
	};
	
	//king-img-list效果
	$(".img-text-list").ImgTextList({thumbState:0,contentState:0,headerState:1,headerAnimate:"rr"});
})