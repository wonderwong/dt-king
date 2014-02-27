<div id="side" class="fl">

<!--侧边菜单-->
	<div class="widget widget-nav">
		<div class="h vht">company</div>
		<ul class="b">

<?php
	//判断是否为产品页或礼品页
	if ($post->ID == 9 || $post->ID == 10 ){
	
			wp_list_cats('taxonomy=dt_portfolio_category');
	
	}else{
?>
	
<?php
	if (is_page( )) {    
	  $page = $post->ID;    
	  if ($post->post_parent) {      
		$page = $post->post_parent;    
	  }    
	  $children=wp_list_pages( 'echo=0&child_of=' . $page . '&title_li=' );    
	  if ($children) {      
		$output = wp_list_pages ('echo=0&child_of=' . $page . '&title_li=');    
	  } 
	  echo $output; 
	}  
}
?>

		</ul>
	</div>
	<!--/侧边菜单-->
	
	<!--侧边产品-->
		<?php get_template_part("side-por")?>
	<!--/侧边产品-->
	
</div>