<?php
$time_start = microtime(true);
$starting = date("h:i:sa, d M, Y");


$access_token = ""; // access token from Instagram 
$email = "";

include "config.php";
$source = 'username';

$countcalls = 1; // count number of API calls
$countposts = 0; // count posts added

$lines = file("username.txt");
	foreach($lines as $line){
		
		$original_username = strtolower($line);

		
		

		$link = connect();
		
		$check = check_table($link,$source,$original_username);
		
		/* Need to grab recent 50k posts, with 1 call you grab recent 20 posts, so 2500 to be exact, but you can't be sure it will grab 20 posts everytime*/
		
		
		
		// check if there is user in table if yes, update it, if no, get his ID and then insert him
		if ($check->rowCount() == 0 ){
			$url = "https://api.instagram.com/v1/users/search?q=".$original_username."&access_token=".$access_token;
			$get = file_get_contents($url);
			$result = json_decode($get,true);
			 
			foreach($result['data'] as $post){
				if($post['username'] == $original_username){
					$original_username_id = $post['id'];
				}
			}
			$countcalls++;
		}
		else {$row = $check->fetch(PDO::FETCH_ASSOC); 
			$original_username_id= $row['id'];
			}
		
		$url = "https://api.instagram.com/v1/users/".$original_username_id."/?access_token=".$access_token;
		$get = file_get_contents($url);
		$result = json_decode($get,true);

		$countcalls++;

		add_new_user($link,$result['data']['username'], $result['data']['bio'], $result['data']['website'], $result['data']['profile_picture'], $result['data']['full_name'], $result['data']['counts']['media'], $result['data']['counts']['followed_by'], $result['data']['counts']['follows'], $result['data']['id']);
		
		
		// 2nd phase, check if user has some recent ID 
		
		$url = "https://api.instagram.com/v1/users/".$original_username_id."/media/recent/?access_token=".$access_token;
		$get = file_get_contents($url);
		$result = json_decode($get,true);
		
		$checkk = check_table($link,'user',$original_username);
		$old = true;
		$done = false;
		if ($checkk->rowCount() == 0 ){
			//add newest media we found to table
			adding_new($link,'user',$result['data'][0]['id'],$original_username);
		
		
		
			foreach ($result['data'] as $post){
			
				
				 
				 
				 $video = ($post['type'] == 'video') ? $post['videos'] : '';
				insert_media($link,$post['filter'],$post['created_time'],$post['link'],$post['likes']['count'],$post['images']['low_resolution']['url'],$post['images']['thumbnail']['url'],$post['images']['standard_resolution']['url'],$post['users_in_photo'],$post['caption']['text'],$post['id'],$post['user']['username'],$post['user']['profile_picture'],$post['user']['id'],$post['user']['full_name'],$video,$post['type'],$post['comments']['count'],$post['location'],$post['tags']); 
				
				$countposts++;
			}
		
			$old = false;
			$done = false;
		} // end if row count
		else {
			
			$row = $checkk->fetch(PDO::FETCH_ASSOC); 
			$last_id = $row['last_id'];
			
			adding_new($link,'user',$result['data'][0]['id'],$original_username);
			
				foreach ($result['data'] as $post){
					if($post['id'] != $last_id){
					
				
				 
						$video = ($post['type'] == 'video') ? $post['videos'] : '';
						insert_media($link,$post['filter'],$post['created_time'],$post['link'],$post['likes']['count'],$post['images']['low_resolution']['url'],$post['images']['thumbnail']['url'],$post['images']['standard_resolution']['url'],$post['users_in_photo'],$post['caption']['text'],$post['id'],$post['user']['username'],$post['user']['profile_picture'],$post['user']['id'],$post['user']['full_name'],$video,$post['type'],$post['comments']['count'],$post['location'],$post['tags']); 
				
				
						$countposts++;		
					} 
					else {
						$done=true;  break; 
						}
					
			
				} // end foreach in else
			
			
		} // else end
		
		// start of next phase, if there is new media insert it
		$url = $result['pagination']['next_url'];
		
		if($old == false){
			
			// 1000 is the limit of 
			for($i=0; $i < 1000; $i++){
				$get = file_get_contents($url);
				$result = json_decode($get,true);	
				
				
				foreach ($result['data'] as $post){
				
				
				 
					$video = ($post['type'] == 'video') ? $post['videos'] : '';
					insert_media($link,$post['filter'],$post['created_time'],$post['link'],$post['likes']['count'],$post['images']['low_resolution']['url'],$post['images']['thumbnail']['url'],$post['images']['standard_resolution']['url'],$post['users_in_photo'],$post['caption']['text'],$post['id'],$post['user']['username'],$post['user']['profile_picture'],$post['user']['id'],$post['user']['full_name'],$video,$post['type'],$post['comments']['count'],$post['location'],$post['tags']); 
				
					$countposts++;	
				}
				
				
				
				$countcalls++;
				if(empty($result['pagination']['next_url'])){
						break;
					}
					else{
						$url = $result['pagination']['next_url'];}
				
			
			} // end for count posts/calls
		
		} // end if old
		
		 // else for if, we are asking if old is true, so if old is true then we already had that tag and we search until we get to last id we saved
		 else {
			 
			 if ($done == false){
				for($i=0; $i < 1000; $i++){
					
					$get = file_get_contents($url);
					$result = json_decode($get,true);
					
					foreach ($result['data'] as $post){
						if($post['id'] != $last_id){
						
					 
						$video = ($post['type'] == 'video') ? $post['videos'] : '';
						insert_media($link,$post['filter'],$post['created_time'],$post['link'],$post['likes']['count'],$post['images']['low_resolution']['url'],$post['images']['thumbnail']['url'],$post['images']['standard_resolution']['url'],$post['users_in_photo'],$post['caption']['text'],$post['id'],$post['user']['username'],$post['user']['profile_picture'],$post['user']['id'],$post['user']['full_name'],$video,$post['type'],$post['comments']['count'],$post['location'],$post['tags']); 
					}
						else {
							break 2;
							}
						$countposts++;	
						}
					
					
					
					$countcalls++;
					if(empty($result['pagination']['next_url'])){
							break;
						}
						else{
						$url = $result['pagination']['next_url'];}
					
				
						 
						 
				 } // if done=false do this end 
				 
				
				
		 } // end of else for 2nd phase 
		 
		 } // end of else
		

					
					
	 
} // endforeach

	// when everything is done send mail and add to logfile
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	$ending = date("h:i:sa, d M, Y");
	

	
			$message = 'Script started : '.$starting.PHP_EOL;
			$message .= 'Script finished :'.$ending.PHP_EOL;
			$message .= 'Posts added to database : '.$countposts.PHP_EOL;
			$message .= 'API calls made : '.$countcalls.PHP_EOL;
			$message .='Script was running : '.round($time,2).' seconds'.PHP_EOL;
			
			mail($email,'Script finished',$message);
			
				
			$file = 'logs.txt';
			$current = file_get_contents($file);
			$current .= "\n".$message;   
			file_put_contents($file, $current);	


?>
			
			