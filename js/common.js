// JavaScript Document

/*--------------------------------------
* 	author:	King
* 	website:	www.webfing.com
--------------------------------------*/


/*--------------------------------------
*	Base
--------------------------------------*/


//定义全局变量
var King = {};

//定义全局静态变量
(function(){
	var isIE = !(- [ 1, ]);
	var isIE6 = !window.XMLHttpRequest;
	var isIE7 = isIE && !isIE6 && !isIE8;
	var isIE8 = isIE && !!document.documentMode;
	function HasPC () {
		var userAgentInfo = navigator.userAgent;
		var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
		var flag = true;
		for (var v = 0; v < Agents.length; v++) {
		   if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }
		}
		return flag;
	}

	King.static= {
		isIE: isIE,
		isIE6: isIE6,
		isIE7: isIE7,
		isIE8: isIE8,
		domain: document.location.href,
		hostName: document.location.hostname,
		isPc: HasPC(),
		winWidth: $(window).width(),
		winHeight: $(window).height()
	}

})();

//dom加载完才初始化的静态变量
King.DomLoadStatic = function(){
	King.static.domHeight = $(document).height();
	King.static.scrollTop = $(document).scrollTop();
};

//图片预加载
King.imgReady = function(src, callback){
    var img = new Image();
	img.src = src;
    console.log(img.onload);
    img.onload = function(){
        callback && callback();
		img = null;
	}
}

//滚动执行类	
King.lazyLoad = function(obj, callback){
	this.ele = $(obj);
	var top = this.ele.offset().top;
	var height = this.ele.height();
	this.hasInit = false;
	this.getTop = function(){
		return top;
	}
	this.getHeight = function(){
		return height;
	}
	this.init = function(){
		var winHeight = King.static.winHeight;
		var scrollTop = King.static.scrollTop;
		King.lazyLoad.count++;
		var eleTop = top+height;
		var winTop = scrollTop+winHeight;
		King.lazyLoad.arr.push(this);

		if (  !((eleTop<scrollTop) || (winTop<top)) ){
			this.load(callback);
		}else{
			this.attactScroll(top,eleTop,height,winHeight,callback);
		}
	}
	this.init();
}
King.lazyLoad.prototype = {
	load: function(callback){
		if (this.hasInit) {
			$(window).unbind("scroll.lazyLoas"+King.lazyLoad.count);
			return false;
		}
        if (callback) callback();
		this.hasInit = true;
	},
	attactScroll: function(top,eleTop,height,winHeight,callback){
		var self = this;
		$(window).bind("scroll.lazyLoad"+King.lazyLoad.count, function(){
			var scrollTop = $(document).scrollTop();
			var winTop = scrollTop+winHeight;
			if (  !((eleTop<scrollTop) || (winTop<top)) ){
                self.load(callback);
			}
		})
	}
}
King.lazyLoad.arr = [];
King.lazyLoad.count = 0;

//画片自适应类
King.rspImg = function (obj, options) {
	var imgEle = $(obj);
	var options = options || {};
	var imgWrap = imgEle.parents(".img-wrap");
	var imgWidth = imgWrap.width();
	var imgHeight = imgWrap.height();
	var imgSrc = imgEle.attr("src");
	var imgDataSrc = imgEle.attr("data-src");
	this.init = function(){
		var isBlackImg = imgSrc.indexOf("blank.gif");
		if (!imgEle || isBlackImg==-1) return false;
		var tempSrc = imgDataSrc.replace(/(&w=\d{2,4})(&h=\d{2,})/,function(w, h){
			return "&w="+imgWidth+"&h="+imgHeight;
		})
		if (options.imgReady){
			King.imgReady(tempSrc,changeSrc);
		}else{
			changeSrc();
		}
		function changeSrc (){
			if (options.imgReady && options.fadeIn){
				imgEle.fadeTo(0,0);
				imgEle.attr("src", tempSrc);
				imgEle.fadeTo(1000, 1);
			}else{
				imgEle.attr("src", tempSrc);
			}
		}
	}
}


/*--------------------------------------
*	Common
--------------------------------------*/

//导航
King.nav = function () {
	var subMenu=null;
	$("#top-nav>li").hover(function(){
		subMenu=this.getElementsByTagName("div");
		if (subMenu){
			$(this).children("a").addClass("on");
			if (King.static.isPc) $(subMenu).stop().show();
		}
	},function(){
		if (subMenu){
			$(this).children("a").removeClass("on");
			if (King.static.isPc) $(subMenu).stop().delay(200).hide();
		}
	});
};

//到顶部
King.toTop = function () {
	if (King.static.domHeight>King.static.winHeight+500){
		var toTop = document.createElement("div"),
			$header=$("#header"),
			pot_t=0,
			pot_b=1;

		toTop.id = "to-top";
		toTop.className = "font-icon";
		toTop.innerHTML = ':';
		var toright=(King.static.winWidth-1000)/2-40-10;
		$header.hover(function(){
			$header.toggleClass("hover");
		},function(){
			$header.toggleClass("hover");
		});

		$(window).bind("scroll.toTop", function(){
			var scrollTop = $(document).scrollTop();
			if (scrollTop>10){
				$header.addClass("hover");
				if(scrollTop>290&&pot_t==0){
					$(toTop).stop().animate({"right":toright,"opacity":"1"},200);
					pot_t=1;
					pot_b=0;
				}else if(scrollTop<290&&pot_b==0){
					$(toTop).stop().animate({"right":"-60px","opacity":"0"},200);
					pot_t=0;
					pot_b=1;
				}
			}else{
				$header.removeClass("hover");
			}
		});

		document.body.appendChild(toTop);
		toTop.onclick = function(){
			$("html"+( ! $.browser.opera ? ",body" : "")).animate({scrollTop: 0}, 500);
		};
	}

};

//侧栏推荐图书
King.sideIMgSlider = function (){
    $('#sidebar .carouFredSel_1').carouFredSel({
        direction: 'left',
        circular: true,
        infinite: false,
        items: 1,
        auto: false,
        prev: '.prev',
        next: '.next',
        'scroll'		: {
            'easing'		: 'swing',
            'duration'		: 1000,
            'pauseOnHover'	: true
        }
    });
};

//瀑布流
King.flowImg = function(){
    var $gallery=$("#gallery");

    $gallery.imagesLoaded(function(){
        $gallery.masonry({
            itemSelector: 'li'
        });
    });

    var nextselector=$("#nav-above").find("li.act").next("li").find("a");

    $gallery.infinitescroll({
        navSelector : '#nav-above', 		// 选择的分页导航
        nextSelector : nextselector, 		// 选择的下一个链接到（第2页）
        itemSelector : '#gallery li', 				// 选择检索所有项目
        loading: {
            finishedMsg: '没有更多的页面加载。',
            img: '/wp-content/themes/dt-king/images/loading.gif'
        }
    },function(newElements){
        // 隐藏新的项目，而他们正在加载
        var $newElems = $( newElements ).css({ opacity: 0 });
        // 确保的图像装载增加砖石布局
        $newElems.imagesLoaded(function(){
            // 元素展示准备
            $newElems.animate({opacity:1});
            $gallery.masonry( 'appended', $newElems, true );
            galleryInit($newElems);
        });
    });

    function galleryInit($parentArea){
        //喜欢功能
        $parentArea.find(".love a").click(function(){
            var post_id=this.id.split("-")[1];
            var $loveShow=$(this).prev("span.num");

            $.ajax({
                type	:	"post",
                url		:	dt_ajax.ajaxurl,
                data	:	{
                    action:         'king_love_pic_do_ajax',
                    post_id:        post_id
                },
                success	:	function (data){
                    $loveShow.hide(function(){
                        $loveShow.html(data);
                        $loveShow.show();
                    });

                }
            });

        });

        //相册移入效果
        $parentArea.find("a.img").each(function(){
            if (!$(this).children("i").length){
                $(this).append('<i class="mask"></i><i class="to-big"></i>');
            }
        });
        //$parentArea.find("a.img").append('<i class="mask"></i><i class="to-big"></i>');

        if($.browser.msie && $.browser.version < 9 && $.browser.version>6){
            $parentArea.find("a.img").hover(function(){
                $(this).children("i.mask").stop().animate({"opacity":0.7});
                $(this).children("i.to-big").css("top","50%").stop().animate({"opacity":1});
            },function(){
                $(this).children("i.mask").stop().animate({"opacity":0});
                $(this).children("i.to-big").stop().animate({"opacity":0});
            })
        }else if($.browser.msie && $.browser.version==6){
            $parentArea.find("a.img").hover(function(){
                $(this).children("i.mask").css("height",$(this).height()+"px");
                $(this).children("i.mask").stop().animate({"opacity":0.7});
                $(this).children("i.to-big").css("top","50%").stop().animate({"opacity":1});
            },function(){
                $(this).children("i.mask").stop().animate({"opacity":0});
                $(this).children("i.to-big").stop().animate({"opacity":0});
            })
        }else{
            $parentArea.find("a.img").hover(function(){
                $(this).children("i.mask").stop().animate({"opacity":0.7});
                $(this).children("i.to-big").stop().animate({"opacity":1,"top":"50%"});
            },function(){
                $(this).children("i.mask").stop().animate({"opacity":0});
                $(this).children("i.to-big").stop().animate({"opacity":0,"top":"60%"});
            })
        };


        $parentArea.find("a.img").prettyPhoto();

    }
    galleryInit($gallery);
}

//tab
King.tab = function(){
    $(".tab").each(function(){
        var _this=$(this);
        var index=null;
        $tabNav=_this.find("ul>li>a");
        $tabBox=_this.next(".wrap").find(".b");
        $tabNav.click(function(){
            if (!$(this).hasClass("act")){
                $tabNav.removeClass("act");
                $tabBox.removeClass("act");
                $(this).addClass("act");
                index=$tabNav.index($(this));
                $tabBox.eq(index).addClass("act");
            }
            return false;
        });
    });
}


jQuery(document).ready(function($) {
	King.DomLoadStatic();
	King.nav();
    King.toTop();
    King.tab();

    //小屏时菜单
    (function(){
        var menuBtn = $("#menu-btn");
        var menuWrap = $("#nav-wrap");

        menuBtn.click(function(){
            menuWrap.slideToggle();
        });

    })();
	//自适应图片懒加载实例化
	$(".lazy-rwd-img").each(function(){
		var self = $(this);
		new King.lazyLoad($(this), function(){
			new King.rspImg(self, {
				imgReady: true,
				fadeIn: true
			}).init();
		});
	});

	//图片懒加载实例化
	$(".lazy-img").each(function(){
		var self = $(this);
		var orgSrc = self.attr("data-src");
        new King.lazyLoad(self,function(){
			King.imgReady(orgSrc, function(){
				self.attr("src",orgSrc);
			})
		}).init();
	});

    //侧栏推荐图书
    $LAB
        .script(themeUrl+'/js/jquery.easing.min.1.3.js').wait()
        .script(themeUrl+'/js/jquery.carouFredSel-5.2.3-packed.js')
        .wait(function(){
            King.sideIMgSlider();
        });

    //瀑布流
    if (document.getElementById('gallery')){
        $LAB
            .script(themeUrl+'/js/jquery.masonry.min.js')
            .script(themeUrl+'/js/jquery.infinitescroll.min.js')
            .wait(function(){
                King.flowImg();
            });
    }

	//若为pc，则增加效果
	if (King.static.isPc){
		(function(){
			var script = document.createElement("script");
			script.src = themeUrl+"/js/pc_enhance.js";
            document.body.appendChild(script);
		})();
	}

    //图书热度
    (function(){
        var $star=$("#pro-hot>.reco-star");
        data_star=$star.attr("data");
        $star.html('<i class="mask"></i><i class="star"></i>');
        $star.find("i.star").animate({"width":data_star/10*125+"px"},600);
    })();


});

//最迟加载项
window.onload = function (){
    if ($(".bdshare-t").length>0) {
        $LAB.script('http://bdimg.share.baidu.com/static/api/js/share.js');
    }
}