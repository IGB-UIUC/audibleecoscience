<?php

//////////////////////////////////////////
//					//
//	podcast.class.inc.php		//
//					//
//	Class that represents a 	//
//	podcast.			//
//					//
//	By David Slater			//
//	June 2009			//
//					//
//////////////////////////////////////////


class podcast {


///////////////Private Variables//////////////
	private $db;
	private $id;
	private $year;
	private $ipaddress;
	private $programName;
	private $showName;
	private $url;
	private $summary;
	private $approved;
	private $approvedBy;
	private $createdBy;
	private $file;
	private $category;
	private $category_id;

//////////////Public Functions///////////////

	public function __construct($podcast_id,$db) {
		
		$this->db = $db;
		
		$this->id = $podcast_id;
		$this->getPodcastInfo();		

	}


	public function __destruct() {
        }


	public function getSource() {
		return $this->source;
	}

	public function setSource($source) {
		$source = trim(rtrim($source));
		$safeSource = mysql_real_escape_string($source,$this->db->get_link());
                $sql = "UPDATE podcasts SET podcast_source='" . $safeSource . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
                if ($result) {
                        $this->source = stripslashes($safeSource);

                }
                return $result;

	}

	public function getProgramName() {
		return $this->programName;
	}

	public function setProgramName($programName) {
		$programName = trim(rtrim($programName));
		$safeProgramName = mysql_real_escape_string($programName,$this->db->get_link());
		$sql = "UPDATE podcasts SET podcast_programName='" . $safeProgramName . "' WHERE podcast_id='" . $this->id . "'"; 
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->programName = stripslashes($safeProgramName);
		}
		return $result;
	}

	public function getShowName() {
		return $this->showName;

	}
	public function setShowName($showName) {
		$showName = trim(rtrim($showName));
		$safeShowName = mysql_real_escape_string($showName,$this->db->get_link());
		$sql = "UPDATE podcasts SET podcast_showName='" . $safeShowName . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->showName = stripslashes($safeShowName);
		}
		return $result;
	}

	public function getBroadcastYear() {
		return $this->year;

	}

	public function setBroadcastYear($year) {
		$year = trim(rtrim($year));
		$sql = "UPDATE podcasts SET podcast_year='" . $year . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->year = $year;
		}
		return $result;
	}
	
	public function getSummary() {
		return $this->summary;
	}

	public function setSummary($summary) {
		$summary = trim(rtrim($summary));
		$safeSummary = mysql_real_escape_string($summary,$this->db->get_link());
		$sql = "UPDATE podcasts SET podcast_summary='" . $safeSummary . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->summary = stripslashes($safeSummary);
		}
		return $result;

	}

	public function getUrl() {
		return $this->url;

	}

	public function setUrl($url) {
		$url = trim(rtrim($url));
		$safeUrl = mysql_real_escape_string($url,$this->db->get_link());
		$sql = "UPDATE podcasts SET podcast_url='" . $safeUrl . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->url = stripslashes($safeUrl);
		}
		return $result;

	}

	public function getIPAddress() {
		return $this->ipaddress;

	}
	public function setIPAddress($ipaddress) {
		$sql = "UPDATE podcasts SET podcast_ipaddress='" . $ipaddress . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->ipaddress = $ipaddress;
		}
		return $result;


	}


	public function getCreatedBy() {
		return $this->createdBy;

	}

	public function setCreatedBy($username) {
		$users = new users($this->db);
		$user_id = $users->getUserID($username);
		$users->__destruct();
		$sql = "UPDATE podcasts SET podcast_createBy='" . $user_id . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->createdBy = $user_id;
		}
		return $result;
	}

	public function getFile() {
		return $this->file;

	}

	public function getFileType() {
		return end(explode(".",$this->file));
	}
	public function downloadPodcast($podcastDirectory) {

			
        	//creates the link to the stored file
        	$linkToFile = $podcastDirectory . $this->file;
	        $fileType = end(explode(".",$this->file));
		$filename = $this->getShowName() . "." . $fileType;
		//creates the html header that is used to download the file.
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application-download');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		//opens up the file so it can be downloaded.
		readfile($linkToFile);
	
	}
	
	public function uploadPodcast($filename,$tmpfile,$directory) {
		$fileType = end(explode(".",$filename));
		$tmpPodcastPath = $this->movePodcast($fileType,$tmpfile,$directory);
		$podcastFileName = $this->id . "." . $fileType;		
		$podcastPath = $directory . "/" . $podcastFileName;
		if (file_exists($podcastPath)) {
			unlink($podcastPath);
		}

		$sql = "UPDATE podcasts SET podcast_file='" . $podcastFileName . "' WHERE podcast_id='" . $this->id . "'";
		$this->db->non_select_query($sql);

		rename($tmpPodcastPath,$podcastPath);


	}
	public function getCatagory() {
		return $this->category;

	}
	
	public function getCategoryId() {
		return $this->category_id;
	}

	public function setCategory($category_id) {
		$sql = "UPDATE podcasts SET podcast_categoryId='" . $category_id . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->category_id = $category_id;
		}
		return $result;
	}
	public function getUploadTime() {
		return $this->time;

	}
	public function getApproved() {
		return $this->approved;
	}

	public function getApprovedBy() {
		return $this->approvedBy;

	}
	public function approve($user_id) {
		$sql = "UPDATE podcasts SET podcast_approved=1,podcast_approvedBy='" . $user_id . "' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->approved = true;
			$user_sql = "SELECT * FROM users WHERE user_id='" . $user_id . "'";
			$result = $this->db->query($user_sql);
			$this->approvedBy = $result[0]['user_name'];
		}
		return $result;

	}	

	public function unapprove() {
		$sql = "UPDATE podcasts SET podcast_approved=0,podcast_approvedBy='0' WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		if ($result) {
			$this->approved = false;
			$this->approvedBy = "";
		}
		return $result;
	}
	public function remove() {
		$sql = "UPDATE podcasts SET podcast_enabled=0 WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		return $result;


	}

	public function setAcknowledgement($acknowledgement) {
		$sql = "UPDATE podcasts SET podcast_acknowledgement='" . $acknowledgement . "' ";
		$sql .= "WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->non_select_query($sql);
		return $result;

	}

	public function setReviewPermission($review_permission) {
		$sql = "UPDATE podcasts SET podcast_review_permission='" . $review_permission . "' ";
                $sql .= "WHERE podcast_id='" . $this->id . "'";
                $result = $this->db->non_select_query($sql);
                return $result;

	}

	public function setCreateBy($username) {
		$sql = "SELECT user_id FROM users WHERE user_name='" . $username . "' LIMIT 1";
		$result = $this->db->query($sql);
		$user_id = $result['user_id'];
		$sql = "UPDATE podcast SET podcast_createBy='" . $user_id . "' ";
		$sql .= "WHERE podcast_id='" . $this->id . "'";
		return $this->db->non_select_query($sql);

	}

////////////////////////Private Functions/////////////

	private function getPodcastInfo() {

		$sql = "SELECT podcasts.*,categories.category_id,categories.category_name,";
		$sql .= "users.user_name as createdBy,approved.user_name AS approvedBy FROM podcasts ";
		$sql .= "LEFT JOIN categories ON podcasts.podcast_categoryId=categories.category_id ";
		$sql .= "LEFT JOIN users ON podcasts.podcast_createBy=users.user_id ";
		$sql .= "LEFT JOIN users AS approved ON podcasts.podcast_approvedBy=approved.user_id ";
		$sql .= "WHERE podcast_id='" . $this->id . "'";
		$result = $this->db->query($sql); 
		$this->time = $result[0]['podcast_time'];
		$this->ipaddress = $result[0]['podcast_ipaddress'];
		$this->source = stripslashes($result[0]['podcast_source']);
		$this->programName = stripslashes($result[0]['podcast_programName']);
		$this->showName = stripslashes($result[0]['podcast_showName']);
		$this->year = $result[0]['podcast_year'];
		$this->url = stripslashes($result[0]['podcast_url']);
		$this->approved = $result[0]['podcast_approved'];
		$this->createdBy = $result[0]['createdBy'];
		$this->category = $result[0]['category_name'];
		$this->category_id = $result[0]['category_id'];
		$this->file = $result[0]['podcast_file'];
		$this->summary = stripslashes($result[0]['podcast_summary']);
		$this->approvedBy = $result[0]['approvedBy'];
	}



	private function movePodcast($fileType,$tmpfile,$directory) {

                $tmpFilename = "tmp_" . mt_rand(100000000,999999999) . "." . $fileType;
                $targetPath = $directory . "/" . $tmpFilename;
                move_uploaded_file($tmpfile,$targetPath);
                return $targetPath;



	}


	
	

}

?>
