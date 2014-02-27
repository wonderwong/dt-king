/*
* Common
*/

$LAB
    .script(themeUrl+'/js/jquery.prettyPhoto.min.js')
    .wait(function(){
        //图片灯箱效果
        $("a.img,.img a").prettyPhoto();

        //鼠标移入图片效果
        $(".img-title-wrap,.item-blog,#relate-post-list li").each(function(){

            var $imgWrap=$(this).find(".img-wrap");
            var imgWrapWidth=$imgWrap.width();
            var iconPosition=(imgWrapWidth/2)-10-40;
            var imgSrc=$(this).find(".img>a").attr("href");
            if (!!$(this).find(".img>a").attr("data-src")){
                imgSrc=$(this).find(".img>a").attr("data-src");
            }
            var pageLink=null;
            if ($(this).find("a.title").length){
                pageLink=$(this).find("a.title").attr("href");
            }else{
                pageLink=$(this).find(".title>a").attr("href");

            }

            var img=$('<a class="to-img" title="查看大图" href="'+imgSrc+'"></a>');
            var page=$('<a class="to-page" title="查看详情" href="'+pageLink+'"></a>');
            var mask=$('<i class="mask"></i>');

            $imgWrap.children("a:eq(0)").append(mask);
            $imgWrap.append(img).append(page);

            var $mask=$imgWrap.find("i.mask");
            var $img=$imgWrap.children("a.to-img");
            var $page=$imgWrap.children("a.to-page");

            $img.prettyPhoto();

            $imgWrap.hover(function(){
                $mask.stop().animate({"opacity":"0.5"});
                $img.stop().animate({"left":iconPosition+"px"});
                $page.stop().animate({"right":iconPosition+"px"});
            },function(){
                $mask.stop().animate({"opacity":"0"});
                $img.stop().animate({"left":"-45px"});
                $page.stop().animate({"right":"-45px"});
            });
        });

        //右侧我的相册效果
        (function(){

            var $myPic=$("#mypic");
            var $a1=$myPic.children("a.a-1");
            var $a2=$myPic.children("a.a-2");
            var $a3=$myPic.children("a.a-3");
            var $mask=$myPic.children("i.mask");

            $myPic.hover(function(){
                $a1.stop().animate({"left":"0"});
                $a2.stop().delay(200).animate({"left":"0"});
                $a3.stop().delay(400).animate({"left":"0"});
                $mask.stop().animate({"opacity":"0.5"});
            },function(){
                $a1.stop().animate({"left":"-100px"});
                $a2.stop().delay(200).animate({"left":"-140px"});
                $a3.stop().delay(400).animate({"left":"-180px"});
                $mask.stop().animate({"opacity":"0"});
            });
        })();

        //侧边栏小图群效果
        $("#sidebar .flickr").hover(function(event){},function(event){
            if (event.target == this){

                $(this).children("a").stop().delay(200).animate({"opacity":"1"});

            }
        });
        $("#sidebar .flickr>a").hover(function(){
            $(this).stop().animate({"opacity":"1"});
            $(this).siblings("a").stop().animate({"opacity":"0.4"});
        },function(){}).prettyPhoto();

        //侧边栏图片列表
        $("#sidebar .img-list a").hover(function(){
            $(this).children("p").stop().animate({"bottom":"0"});
        },function(){
            $(this).children("p").stop().animate({"bottom":"-20px"});
        });

        //侧边栏图书移入效果
        $('#sidebar .carouFredSel_1 .widget-info').hover(function(){
            $(this).children("a.head").stop().animate({"top":"0"});
            $(this).children("p").stop().show(300);
        },function(){
            $(this).children("a.head").stop().animate({"top":"-32px"});
            $(this).children("p").stop().hide(300);
        });

        //相册分类列表效果
        if (document.getElementById('gallery-list')){
            $LAB
                .script(themeUrl+'/js/jquery.hoverdir.min.js')
                .wait(function(){
                    $("#gallery-list>li").hoverdir();
                })
        }

});