<?php
require_once 'includes/main.inc.php';
require_once 'includes/header.inc.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $podcast = new podcast($id,$db);
	$category = new category($db,"",$podcast->getCategoryId());
        if ($podcast->getApproved()) {
                $relFile = __PODCAST_WEB_DIR__ . "/" . $podcast->getFile();
        }
        else {
                echo "This podcast does not exist";
                exit;
        }
}

else {

        echo "Podcast does not exist\n";
		exit;
}

?>


    <div class="podcast">
      <div class="category_img"><img src='<?php echo __PICTURE_WEB_DIR__ . "/" . $category->get_picture(); ?>' 
	alt='<?php echo $category->get_name(); ?>'></div>
      <div class="category_content">
        <h2><?php echo $podcast->getShowName(); ?></h2>
       <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $podcast->getShowName(); ?>" data-via="audibleecosci" data-hashtags="AudibleEcoScience">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div class="fb-like" data-href="http://www.audibleecoscience.org/podcast.php?id=<?php echo $_GET['id'] ?>" data-width="50" data-layout="button_count" data-show-faces="false" data-send="true" ></div>
        <p>Media Source: <?php echo $podcast->getSource(); ?><br>
          Program Name: <?php echo $podcast->getProgramName(); ?><br>
	  Show Name: <?php echo $podcast->getShowName(); ?><br>
          Broadcast Year: <?php echo $podcast->getBroadcastYear(); ?><br>
        Original Link: <a href='<?php echo $podcast->getUrl(); ?>' target='_blank'><?php echo $podcast->getUrl(); ?></a></p>
       	<p><?php echo $podcast->getSummary(); ?></p> 
        <hr>
<?php if ($podcast->getFile() != "") {
	echo "<div class='podcast_media'>";
	echo "<div class='podcast_media_links'><a href='#'>Play Podcast</a> | <a href='download.php?id=" . $id . "'>Download Podcast</a>";
	echo "<div class='clear'></div>";
	echo "<audio id='player' type='audio/mp3' controls='controls' src='" . $relFile . "'></audio>";
	//echo "<script>$('audio,video').mediaelementplayer();</script>";
	echo "</div><div class='clear'></div></div></div>";

} ?>
<!-- end: class="container_category_podcastlist -->
</div><div class="clear"></div>

<?php require_once 'includes/footer.inc.php'; ?>
