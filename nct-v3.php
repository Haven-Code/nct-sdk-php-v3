<?php

/* Begin With Some Note 
	
	* This SDK is not by NCT Crop
	* This SDK is not for COMMERCIAL
	* The SDK by Phuc Dang (github@phuchptty)
	* You Can Find Me At
		+ Facebook: https://facebook.com/hoangphuchotboy
		+ Twitter : @phuchptty
		+ GitHub  : phuchptty
	* Share free at GitHub, Source Forge
	* DO NOT EDIT UNLESS YOU KNOW ABOUT CODING. JUST LEAVE A NOTE IN ISSUES AND WAIT FOR A NEW UPDATE

This is END */

class NCT_V1 {

	private $nct_v1_token_key = "nct@asdgvhfhyth1391515932000";

	private $index = 1;

	private $size = 30;

	private function getCurl($url){
		
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Mobile Safari/537.36');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}

	private function createToken($type,$id=""){
		return md5($type.$id.$this ->nct_v1_token_key);
	}

	private function createSearchToken($type,$keyword=""){
		return md5($type.$keyword.$this -> index.$this -> size.$this ->nct_v1_token_key);
	}

	private function buildURL($action,$token,$option=""){

		$api = 'http://api.m.nhaccuatui.com/mobile/v5.0/api?secretkey=nct@mobile_service&deviceinfo={"DeviceID":"90c18c4cb3c37d442e8386631d46b46f","OsName":"ANDROID","OsVersion":"10","AppName":"NhacCuaTui","AppVersion":"5.0.1","UserInfo":"","LocationInfo":""}&pageindex='.$this -> index.'&pagesize='.$this -> size.'&time=1391515932000&token='.$token.'&action='.$action.'&'.$option;
		$api = str_replace(" ", "+", $api);
		return $api;
	}

	/* END SUPPORT FUNCTION */

	public function getSongSearch($keyword,$page = 1,$size = 10){

		$this -> index = $page;
		$this -> size = $size;

		$token = $this -> createSearchToken("search-song",$keyword);
		$url = $this -> buildURL("search-song",$token,"keyword=".$keyword);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != "true"){
			return "Error";
		}
		return $b;
	}

	public function getVideoSearch($keyword,$page = 1,$size = 10){

		$this -> index = $page;
		$this -> size = $size;

		$token = $this -> createSearchToken("search-video",$keyword);
		$url = $this -> buildURL("search-video",$token,"keyword=".$keyword);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != "true"){
			return "Error";
		}
		return $b;
	}

	public function getPlaylistSearch($keyword,$page = 1,$size = 10){

		$this -> index = $page;
		$this -> size = $size;

		$token = $this -> createSearchToken("search-playlist",$keyword);
		$url = $this -> buildURL("search-playlist",$token,"keyword=".$keyword);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != "true"){
			return "Error";
		}
		return $b;
	}

	public function getLyric($id){
		if (!isset($id) || $id == NULL){
			return false;
		}
		//$id = $this -> getSongIntID($id);

		$token = $this -> createToken("get-lyric",$id);
		
		$url = $this -> buildURL("get-lyric",$token,"songid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != 1){
			return false;
		}

		$a = $b['Data'];

		$array = array(
			"Lyric" => $a['Lyric'],
			"LyricWithTime" => $a['TimedLyric'],
			"Creator" => $a['UsernameCreated'],
		);

		return $array;
	}

	public function getSongByArtist($id){
		if (!isset($id) || $id == NULL){
			return false;
		}

		$token = $this -> createSearchToken("get-song-by-artist",$id);
		$url = $this -> buildURL("get-song-by-artist",$token,"artistid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	public function getSongInfo($id){
		if (!isset($id) || $id == NULL){
			return false;
		}

		$token = $this -> createToken("get-song-info",$id);
		$url = $this -> buildURL("get-song-info",$token,"songid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	/* Genre Start */
	//song
	public function  getListSongGenre(){
		$token = $this ->  createToken("get-list-genre","song");
		$url = $this -> buildURL("get-list-genre",$token,"type=song");
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	public function getSongByGenre($id){
		if (!isset($id) || $id == NULL){
			return false;
		}

		$token = $this -> createToken("get-song-by-genre",$id);
		$url = $this -> buildURL("get-song-by-genre",$token,"genreid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	//video
	public function getListVideoGenre(){
		$token = $this ->  createToken("get-list-genre","video");
		$url = $this -> buildURL("get-list-genre",$token,"type=video");
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	public function getVideoByGenre($id){
		if (!isset($id) || $id == NULL){
			return false;
		}

		$token = $this -> createToken("get-video-by-genre",$id);
		$url = $this -> buildURL("get-video-by-genre",$token,"genreid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	//playlist
	public function getListPlaylistGenre(){
		$token = $this ->  createToken("get-list-genre","playlist");
		$url = $this -> buildURL("get-list-genre",$token,"type=playlist");
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);

		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}

	public function getPlaylistByGenre($id){
		if (!isset($id) || $id == NULL){
			return false;
		}

		$token = $this -> createToken("get-playlist-by-genre",$id);
		$url = $this -> buildURL("get-playlist-by-genre",$token,"genreid=".$id);

		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}

		return $b['Data'];
	}
	/* END GENRE API */

	/* BEGIN TOPIC API */
	public function getListTopic(){
		$token = $this -> createSearchToken("get-list-topic");
		$url = $this -> buildURL("get-list-topic",$token);
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}
		return $b['Data'];
	}

	public function getPlaylistByTopic($id){
		$token = $this -> createToken("get-playlist-by-topic",$id);
		$url = $this -> buildURL("get-playlist-by-topic",$token,"topicid=".$id);
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}
		return $b['Data'];
	}

	// RELATED

	public function getPlaylistRelated($id){
		$token = $this -> createToken("get-playlist-related",$id);
		$url = $this -> buildURL("get-playlist-related",$token,"playlistid=".$id);
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}
		return $b['Data'];
	}

	public function getVideotRelated($id){
		$token = $this -> createToken("get-video-related",$id);
		$url = $this -> buildURL("get-video-related",$token,"videoid=".$id);
		$a = $this -> getCurl($url);

		$b = json_decode($a,true);
		
		if ($b['Result'] != 1){
			return false;
		}
		return $b['Data'];
	}
}

/* END API V1 */

class NCT_V3 {

	private function getCurl($linklist){
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $linklist);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

		$page = curl_exec($c);
		curl_close($c);

		return $page;
	}

	public function getToken(){

		$date = date("y-m-d h:i:s");
		$timestamp = strtotime($date);

		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		$headers[] = 'Host: graph.nhaccuatui.com';
		$headers[] = 'Connection: Keep-Alive';
		
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, "https://graph.nhaccuatui.com/v3/commons/token");
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, "deviceinfo=%7B%22DeviceID%22%3A%22dd03852ada21ec149103d02f76eb0a04%22%2C%22DeviceName%22%3A%22TrolyFaceBook.Com%22%2C%22OsName%22%3A%22SmartTV%22%2C%22OsVersion%22%3A%228.0%22%2C%22AppName%22%3A%22NCTTablet%22%2C%22AppVersion%22%3A%221.3.0%22%2C%22UserName%22%3A%220%22%2C%22QualityPlay%22%3A%22128%22%2C%22QualityDownload%22%3A%22128%22%2C%22QualityCloud%22%3A%22128%22%2C%22Network%22%3A%22WIFI%22%2C%22Provider%22%3A%22BeDieuApp%22%7D%0A&md5=488c994e95caa50344d217e9926caf76&timestamp=1497863709521");

		$page = curl_exec($c);
		curl_close($c);
		
		$a = json_decode($page,true);
		
		
		if ($a['code'] == "0"){
			
			$a = $a['data'];
			return $a['2'];
		
		}else{
			return "Get Token Error";
		}
	}

	public function getSongDetail($id){
	
		$linklist = 'https://graph.nhaccuatui.com/v3/songs/'.$id.'?access_token='.$this -> getToken();
		
		$page = $this -> getCurl($linklist);
		$data = json_decode($page,true);

		if ($data['code'] != 0){
			return $data['msg'];
		}else{

			$a = $data['data'];

			$array = array(

				"SongID" => $a[1],
				"SongName" => $a[2],
				"SongSinger" => $a[3],
				"SongLike" => $a[4],
				"SongListen" => $a[5],
				"SongLink" => $a[6],
				"SongStreamLink" => $a[7],
				"SongThumbnail" => $a[8],
				"SongDuration" => $a[10],
				"SongDownload128" => $a[11],
				"SongDownload320" => $a[12],
				"SongDownloadLosLess" => $a[19]				

			);
			
			return $array;
		}
	
	}

	function getVideoDetail($id){
	
		$linklist = 'https://graph.nhaccuatui.com/v3/videos/'.$id.'?access_token='.$this -> getToken();
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $linklist);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

		$page = curl_exec($c);
		curl_close($c);
		
		$data = json_decode($page,true);
		
		if ($data['code'] != 0){
			return $data['msg'];
		}else{

			$a = $data['data'];

			$array360 = array(

				"VideoQuality" => $a[12][0][1],
				"VideoStreamLink" => $a[12][0][2],
				"VideoDownloadLink" => $a[12][0][4],

			);

			$array480 = array(

				"VideoQuality" => $a[12][1][1],
				"VideoStreamLink" => $a[12][1][2],
				"VideoDownloadLink" => $a[12][1][4],

			);

			$array720 = array(

				"VideoQuality" => $a[12][2][1],
				"VideoStreamLink" => $a[12][2][2],
				"VideoDownloadLink" => $a[12][2][4],

			);

			$array1080 = array(

				"VideoQuality" => $a[12][3][1],
				"VideoStreamLink" => $a[12][3][2],
				"VideoDownloadLink" => $a[12][3][4],

			);

			$array = array(

				"VideoID" => $a[1],
				"VideoName" => $a[2],
				"VideoThumbnail" => $a[3],
				"VideoArtis" => $a[4],
				"VideoDuration" => $a[5],
				"VideoLike" => $a[6],
				"VideoView" => $a[7],
				"VideoLink" => $a[8],
				"VideoStreamURL" => $a[9],
				"Video360" => $array360,
				"Video480" => $array480,
				"Video720" => $array720,
				"Video1080" => $array1080,

			);
			
			return $array;
		}
	}

	public function getPlaylistDetail($id){
	
		$linklist = 'https://graph.nhaccuatui.com/v3/playlists/'.$id.'?access_token='.$this -> getToken();
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $linklist);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

		$page = curl_exec($c);
		curl_close($c);
		
		$data = json_decode($page,true);
		
		if ($data['code'] != 0){
			return $data['msg'];
		
		}else{

			$a = $data['data'];

			$array = array(

				"PlaylistID" => $a[1],
				"PlaylistName" => $a[2],
				"PlaylistThumbnail" => $a[4],
				"PlaylistArtis" => $a[5],
				"PlaylistLink" => $a[6],
				"PlaylistView" => $a[7],
				"PlaylistLink" => $a[8],
				"PlaylistSongDetail" => $a[9],
				"PlaylistDescription" => $a[11],

			);

			return $array;

		}
		
	}
}

class NCT_Support {
	private function getWeekOfYear($date =""){
		if ($date == ""){
			$date = date('Y-m-d');
		}else{
			$date = $date;
		}
  		while (date('w', strtotime($date)) != 1) {
    		$tmp = strtotime('-1 day', strtotime($date));
    		$date = date('Y-m-d', $tmp);
  		}
  		$week = date('W', strtotime($date));
  		return $week;
	}

	public function getVnSongChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/bai-hat/top-20.nhac-viet.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-bai-hat-viet-nam-tuan-)(.*)(-va.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}

	public function getUSUKSongChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/bai-hat/top-20.au-my.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-bai-hat-au-my-tuan-)(.*)(-va.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}

	public function getKoSongChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/bai-hat/top-20.nhac-han.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-bai-hat-han-quoc-tuan-)(.*)(-va.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}

	//Video
	public function getVnVideoChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/video/top-20.nhac-viet.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-mv-viet-nam-nhaccuatui-tuan-)(.*)(-.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}

	public function getUSUKVideoChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/video/top-20.au-my.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-mv-au-my-nhaccuatui-tuan-)(.*)(-.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}

	public function getKoVideoChartPlaylistKey($date=""){
		$date = date("Y-m-d", strtotime($date));
		$week = $this -> getWeekOfYear($date);
		$year = $date = date("Y", strtotime($date));
		$base = "https://www.nhaccuatui.com/video/top-20.nhac-han.tuan-".($week-1).".".$year.".html";
		$a = file_get_contents($base);
		preg_match('/(https)(.+)(nhaccuatui.com\/playlist\/top-20-mv-han-quoc-nhaccuatui-tuan-)(.*)(-.)(.*)(.html)/',$a,$b);
		$url = $b[0];
		$c = explode(".", $url);
		$playlistkey = $c[3];
		return $playlistkey;
	}
}

class NCT {
	private $v1;
	private $v3;
	private $sp;

	public function __construct(){
		$this -> v1 = new NCT_V1;
		$this -> v3 = new NCT_V3;
		$this -> sp = new NCT_Support;
	}

	private function getSongIntID($songid){
		$detail = $this -> getSongDetail($songid);
		$streamurl = $detail['SongStreamLink'];

		$a = explode('/', $streamurl);
		$a = $a[count($a)-1];

		$b = explode('-', $a);
		$c = explode('.', $b[count($b) -1]);

		return $c[count($c)-2];
	}
	//Begin
	public function getSongDetail($key){
		$data = $this -> v3 -> getSongDetail($key);
		return $data;
	}

	public function getVideoDetail($key){
		$data = $this -> v3 -> getVideoDetail($key);
		return $data;
	}

	public function getPlaylistDetail($key){
		$data = $this -> v3 -> getPlaylistDetail($key);
		return $data;
	}

	// Search
	public function getSongSearch($keyword,$page = 1,$size = 10){
		$data = $this -> v1 -> getSongSearch($keyword,$page,$size);
		return $data;
	}

	public function getVideoSearch($keyword,$page = 1,$size = 10){
		$data = $this -> v3 -> getVideoSearch($keyword,$page,$size);
		return $data;
	}

	public function getPlaylistSearch($keyword,$page = 1,$size = 10){
		$data = $this -> v3 -> getPlaylistSearch($keyword,$page,$size);
		return $data;
	}

	//Get Lyric
	public function getLyric($key){
		$id = $this -> getSongIntID($key);
		$data = $this -> v1 -> getLyric($id);
		return $data;
	}

	//Get genre
	public function getListSongGenre(){
		$data = $this -> v1 -> getListSongGenre();
		return $data;
	}
	public function getListVideoGenre(){
		$data = $this -> v1 -> getListVideoGenre();
		return $data;
	}
	public function getListPlaylistGenre(){
		$data = $this -> v1 -> getListPlaylistGenre();
		return $data;
	}

	//get data by genre
	public function getSongByGenre($id){
		$data = $this -> v1 -> getSongByGenre($id);
		return $data;
	}
	public function getVideoByGenre($id){
		$data = $this -> v1 -> getVideoByGenre($id);
		return $data;
	}
	public function getPlaylistByGenre($id){
		$data = $this -> v1 -> getPlaylistByGenre($id);
		return $data;
	}

	//Topic
	public function getListTopic(){
		$data = $this -> v1 -> getListTopic();
		return $data;
	}
	public function getPlaylistByTopic($id){
		$data = $this -> v1 -> getPlaylistByTopic($id);
		return $data;
	}

	//related

	//get song chart
	public function getVnSongChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getVnSongChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}
	public function getUSUKSongChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getUSUKSongChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}
	public function getKoSongChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getKoSongChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}

	//video chart [ERROR]
	public function getVnVideoChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getVnVideoChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}
	public function getUSUKVideoChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getUSUKVideoChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}
	public function getKoVideoChart(){
		$date = date('Y-m-d');
		$data = $this -> sp -> getKoVideoChartPlaylistKey($date);
		$a = $this -> getPlaylistDetail($data);
		return $a;
	}
}
