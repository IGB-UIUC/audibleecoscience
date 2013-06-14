<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';

$numPages = 0;
$podcastsHtml = "";
if (isset($_GET['terms'])) {


	if (isset($_GET['start']) && is_numeric($_GET['start'])) {
                $start = $_GET['start'];
        }
        else {
                $start = 0;
        }

	$count = 10;
	
	$terms = $_GET['terms'];
	$terms = trim(rtrim($terms));
	$podcasts = search($terms,$db);
	
	$numPodcasts = count($podcasts);
	$numPages = getNumPages($numPodcasts,$count);
        $currentPage = $start / $count +1;
        
	$pagesHtml = "<p>";
        if ($currentPage > 1) {
                $startRecord = $start - $count;
                $pagesHtml .= "<a href='search.php?terms=" . $terms . "&start=" . $startRecord . "'>Back</a> |";
        }
        for ($i=0;$i<$numPages;$i++) {
                $pageNumber = $i +1;
                $startRecord = $i * $count;
                $pagesHtml .= " <a href='search.php?terms=" . $terms . "&start=" . $startRecord . "'>" . $pageNumber . "</a> ";
                if ($pageNumber != $numPages) {
                        $pagesHtml .= " | ";
                }
        }
        if ($currentPage < $numPages) {
                $startRecord = $start + $count;
                $pagesHtml .= " | <a href='search.php?terms=" . $terms . "&start=" . $startRecord . "'>Next</a> ";
        }
        $pagesHtml .= "</p>";


	if ($terms == "") {
		$searchMsg = "<b class='error'>Please enter a search term.</b>";
	}
	elseif (count($podcasts) == '0') {
		$searchMsg = "<b class='error'>No Results.</b>";

	}
	else {

		
		for ($i=0;$i<count($podcasts);$i++) {

			$source = $podcasts[$i]['podcast_source'];
	                $showName = $podcasts[$i]['podcast_showName'];
	                $programName = $podcasts[$i]['podcast_programName'];
        	        $summary = substr($podcasts[$i]['podcast_summary'],0,200);
        	        $year = $podcasts[$i]['podcast_year'];
               		$podcast_id = $podcasts[$i]['podcast_id'];
	                $podcastsHtml .= "<div id='listpodcasts'><ul><a href='podcast.php?id=" . $podcast_id . "'>" . $showName . "</a>";
        	        $podcastsHtml .= "<li>" . $source . "</li>";
               		$podcastsHtml .= "<li>" . $programName . "</li>"; 
	                $podcastsHtml .= "<li>" . $year . "</li>";
        	        $podcastsHtml .= "<li>" . $summary . "...</li>";
                	$podcastsHtml .= "</ul></div>";

		}

	}
}

?>
<h3>Search</h3>
<form method='get' action='<?php echo $_SERVER['PHP_SELF']; ?>' class='form'>
<br><input type='text' name='terms' value='<?php if (isset($terms)) { echo $terms; } ?>'>
<br><input class='btn' type='submit' name='search' value='Search'>
</form>
<?php if (isset($searchMsg)) { echo $searchMsg; }


echo $podcastsHtml;
if ($numPages > 1) {
	echo $pagesHtml; 
}

include 'includes/footer.inc.php';
?>
