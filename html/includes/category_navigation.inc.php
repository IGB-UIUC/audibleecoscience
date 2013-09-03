   <div class="sidenav_categories">
    <ul class="sidenav_ul">
    	<li class="mainnavtag"><a href="index.php">Home</a></li>
	<?php echo $nav_html; ?>
        <div class="clear"></div>
    </ul>
    </div>
<script>
  $(function () {
    $("ul").tinyNav();
  });
</script>
<?php
	$number = 1;
	while($number < 9)
	{
?>

<script> 

  $(".category_<?php echo $number ?>").mouseenter(function(){
	  
	  $(".category_<?php echo $number ?>").stop(true).animate({width:'175px'});
	   $(".cat_title_<?php echo $number ?>").fadeIn();
	
  });


  $(".category_<?php echo $number ?>").mouseleave(function(){
	
    $(".category_<?php echo $number ?>").animate({width:'70px'});
	 $(".cat_title_<?php echo $number ?>").fadeOut();

  });
  
$(".category_<?php echo $number ?>").click(
				function (instance) {
					return function (e) {
						document.location.href=$(".category_<?php echo $number ?>").data('url');
					};
				}(".category_<?php echo $number ?>")
			);
</script> 

<?php
	$number = $number + 1;
	} // while
?>
