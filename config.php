<?php
function connect(){
	return $link = $link = new PDO('mysql:host=localhost;dbname=upwork;charset=utf8mb4', 'root', '');
}
function check_table($link,$source,$new){
	$stmt = $link->prepare('Select * from '.$source.' where '.$source.' = :new');
	$stmt->BindValue(":new", $new, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt;
}
function adding_new($link,$source,$id,$insert){
	$stmt = $link->prepare('INSERT INTO '.$source.'('.$source.', last_id) values(:source, :lastid) on duplicate key update last_id = :newid');
	$stmt->execute(array(
	":source" => $insert,
	":lastid" => $id,
	":newid" => $id,
	));
}
function add_new_user($link,$username,$bio,$website,$profpic,$fullname,$media,$followers,$follows,$id){
	$stmt = $link->prepare('INSERT INTO username(username, bio, website, profile_picture, full_name, media, followed_by, follows, id) values(:username, :bio, :website, :profile_picture, :full_name, :media, :followed_by, :follows, :id) ON DUPLICATE KEY UPDATE username = VALUES(username), bio = VALUES(bio), website = VALUES(website), profile_picture = VALUES(profile_picture), full_name = VALUES(full_name), media = VALUES(media), followed_by = VALUES(followed_by), follows = VALUES(follows)');
	$stmt->execute(array(
	":username" => $username,
	":bio" => $bio,
	":website" => $website,
	":profile_picture" => $profpic,
	":full_name" => $fullname,
	":media" => $media,
	":followed_by" => $followers,
	":follows" => $follows,
	":id" => $id
	));
}
function insert_media($link,$filter,$time,$links,$likes,$imglow,$imgthumb,$imgstandard,$usersinphoto,$caption,$id,$username,$profilpic,$userid,$fullname,$videos,$type,$comments,$location,$tagss)
{
	$users = '';
		// if there is users in photo or no
		if(empty($usersinphoto)){
			$users = '';
		}
		else {
			foreach($usersinphoto as $user){
				$users .= $user['user']['username'].", ";
			}
			
		}
		$tags='';
		// if there are tags in description or no
		if(empty($tagss)){
			$tags = '';
		}
		else {
			foreach($tagss as $tag){
				$tags .= $tag.", ";
			}
			
		}
		
		// if there is location or no
		if(empty($location)){
			$latitude='';
			$longitude='';
			$locname='';
			$locid='';
		}
		else {
			$latitude=$location['latitude'];
			$longitude=$location['longitude'];
			$locname=$location['name'];
			$locid=$location['id'];
			
			}
			
		// check if post is video 
		if($videos != ''){
			
			$vidlowband=$videos['low_bandwidth']['url'];
			$vidstandard=$videos['standard_resolution']['url'];
			$vidlowres=$videos['low_resolution']['url'];
		}
		else {
			$vidlowband='';
			$vidstandard='';
			$vidlowres='';
			
			
			}
		
	$stmt = $link->prepare('INSERT INTO media(filter, created_time, link, likes, low_resolution, thumbnail, standard_resolution, users_in_photo, caption, id, username, profile_picture, user_id, full_name, video_low_bandwidth, video_standard_resolution, video_low_resolution, tags, type, comments, latitude, longitude, location_name, location_id) values(:filter, :createtime, :link, :likes, :imglow, :imgthumb, :imgstandard, :usersonphoto, :caption, :id, :username, :profilpic, :userid, :fullname, :vidlowband, :vidstandard, :vidlowres, :tags, :type, :comments, :latitude, :longitude, :locname, :locid) ON DUPLICATE KEY UPDATE likes = VALUES(likes), caption = VALUES(caption), profile_picture = VALUES(profile_picture), username = VALUES(username), full_name = VALUES(full_name), tags = VALUES(tags), comments = VALUES(comments)');
	$stmt->execute(array(
	":filter" => $filter,
	":createtime" => $time,
	":link" => $links,
	":likes" => $likes,
	":imglow" => $imglow,
	":imgthumb" => $imgthumb,
	":imgstandard" => $imgstandard,
	":usersonphoto" => $users,
	":caption" => $caption,
	":id" => $id,
	":username" => $username,
	":profilpic" => $profilpic,
	":userid" => $userid,
	":fullname" => $fullname,
	":vidlowband" => $vidlowband,
	":vidstandard" => $vidstandard,
	":vidlowres" => $vidlowres,
	":tags" => $tags,
	":type" => $type,
	":comments" => $comments,
	":latitude" => $latitude,
	":longitude" => $longitude,
	":locname" => $locname,
	":locid" => $locid
	
	));
	
}
?>