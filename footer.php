<footer id="footer">
	<div class="top"></div>
	<div class="wp">
		
		<div class="r clearfix">
			<div class="c c1 fl">
				<div class="h">站点札记</div>
				<div class="b list">
					<div class="technology icon clearfix">
						<a class="a-1" href="http://www.adobe.com/cn/products/photoshopfamily.html" title="photoshop" target="_blank">photoshop</a>
						<a class="a-2" href="http://www.adobe.com/cn/products/illustrator.html
" title="illustrator" target="_blank">illustrator</a>
						<a class="a-3" href="http://www.adobe.com/cn/products/dreamweaver.html" title="Dreamweaver" target="_blank">Dreamweaver</a>
						<a class="a-4" href="http://www.w3school.com.cn/html5/" title="HTML5" target="_blank">HTML5</a>
						<a class="a-5" href="http://wordpress.org/" title="Wordperss" target="_blank">Wordperss</a>
					</div>
					<p>原型图---Mockups</p>
					<p>设计稿---Photoshop</p>
					<p>代码神器---WebStorm & Sublime Text</p>
					<p>写作神器---Markdown</p>
					<p>代码维护---Github</p>
				</div>
			</div>
			<div class="c c2 fl">
				<div class="h">常用标签</div>
				<div class="b tag-cloud clearfix">
					<?php  
						wp_tag_cloud(array(
							'smallest' => 12,
							'largest' => 12, 
							'unit' => 'px', 
							'number' => 40
						));
						//wp_tag_cloud();
					?>
				</div>
			</div>
			<div class="c c3 fl">
				<div class="h">相关链接</div>
				<div class="b list">
					<div class="shine icon clearfix">
						<a class="a-1" href="http://wpa.qq.com/msgrd?V=1&Menu=yes&Uin=471897134" title="QQ对话窗" target="_blank">QQ</a>
						<a class="a-2" href="http://user.qzone.qq.com/471897134" title="QQ空间" target="_blank">QQ空间"</a>
						<a class="a-3" href="http://weibo.com/u/1676413634
" title="新浪微博" target="_blank">新浪微博</a>
						<a class="a-4" href="http://t.qq.com/cpjjunmj" title="腾讯微博" target="_blank">腾讯微博</a>
						<a class="a-5" href="http://weixin.qq.com" title="微信" target="_blank">微信</a>
					</div>
					<p>
						<span>设计 - </span>
						<a title="设计师互动平台" target="_blank" href="http://www.zcool.com.cn/">站酷</a>
						<a title="中国人机界面设计门户网站" target="_blank" href="http://www.chinaui.com/">优艾网</a>
						<a title="站长素材是一家大型综合设计类素材网站" target="_blank" href="http://sc.chinaz.com/">chinaZ</a>
						<a title="Popular" target="_blank" href="http://dribbble.com/">Dribbble</a><a href="http://huaban.com/" title="采集你喜欢的美好事物" target="_blank">花瓣</a>
					</p>
					
					<p>
						<span>团队 - </span>
						<a title="做地球上最好的UED" target="_blank" href="http://ued.taobao.com/blog/">淘宝UED</a>
                        <a title="做世界一流的互联网设计团队" target="_blank" href="http://cdc.tencent.com/">腾讯CDC</a>
                        <a title="携程旅行前端开发团队" target="_blank" href="http://ued.ctrip.com/blog/">携程UED</a>
                        <a title="奇舞图|奇虎360前端团队" target="_blank" href="http://www.75team.com/">奇舞团</a>
                    </p>
					<p class="p-3">
						<span>前端 - </span>
                        <a title="前端乱炖, 最专业的前端技术内容社区" target="_blank" href="http://www.html-js.com/">前端乱炖</a>
                        <a title="HTML5 App Development for Desktop and Mobile" target="_blank" href="http://www.sencha.com/">ExtJs</a>
						<a title="AngularJs中文社区" target="_blank" href="http://angularjs.cn/">AngularJs</a>
						<a title="Bootstrap中文网" target="_blank" href="http://www.bootcss.com/">Bootstrap</a>
					</p>
					<p>
						<span>程序 - </span>
						<a title="找到您想要的开源软件，分享和交流" target="_blank" href="http://www.oschina.net/">OSChina</a>
						<a title="技术成就梦想 - 中国领先的IT技术网站" target="_blank" href="http://www.51cto.com/">51CTO</a>
						<a title="全球最大中文IT社区，为IT专业技术人员提供最全面的信息传播和服务平台" target="_blank" href="http://www.csdn.net/">CSDN</a>
						<a title="博客园 - 程序员的网上家园" target="_blank" href="http://www.cnblogs.com/">Cnblog</a>
					</p>
					<p class="p-4">
						<span>开源 - </span>
						<a title="king's github" target="_blank" href="https://github.com/webfing">Github</a>
						<a title="WordPress" target="_blank" href="http://cn.wordpress.org/">WordPress</a>
						<a title="Joomla! is the mobile-ready and user-friendly way to build your website" target="_blank" href="http://www.joomla.org/">Joomla</a>
						<a title="Open Source Shopping Cart Solution" target="_blank" href="http://www.opencart.com/">Opencart</a>
					</p>
				</div>
			</div>
		</div>
		
		<div class="copyright">
			Copyright © 2012-2013 King-悟道前端  保留所有权利.   Theme by King 百度统计
		</div>
		
	</div>	
	
</footer>

<?php wp_footer(); ?>
<script>
	var themeUrl = "<?php the_tl_url(); ?>";
</script>
<script src="<?php the_tl_url();?>/js/common.js"></script>

</body>
</html>
