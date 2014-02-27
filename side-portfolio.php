<div id="side" class="fl">

<!--侧边菜单-->
	<div class="widget widget-nav">
		<div class="h vht">company</div>
		<ul class="b">

<?php

	wp_list_cats('taxonomy=dt_portfolio_category');
	
?>

		</ul>
	</div>
	<!--/侧边菜单-->
	
	<!--侧边产品-->
		<?php get_template_part("side-por")?>
	<!--/侧边产品-->
	
</div>