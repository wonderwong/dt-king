<div class="search-f">
<form method="get" class="c_search" action="<?php echo home_url('/'); ?>">
    <div class="i-s">
<?php
$stext = __('Search...', LANGUAGE_ZONE);
?>
    <input name="s" type="Search" class="i-search" value="<?php echo $stext; ?>" onblur="if(this.value==''){this.value='<?php echo $stext; ?>';}" onfocus="if(this.value=='<?php echo $stext; ?>'){this.value='';}"/>
    <div class="i-l">
        <span>
            <a class="search" href="#" onClick="jQuery('.c_search').submit(); return false;"></a>
        </span>
    </div>
    </div>
</form>
</div>
