<?
$info_query = mysql_query("SELECT * FROM ".$prefix."profolio_info ORDER BY id DESC LIMIT 0,1");

if(mysql_num_rows($info_query) < 1){
	$red = "Location: install.php";
	header($red);
	die();
}

while($info_row = mysql_fetch_array($info_query)){
	//login information
	$username = $info_row['username'];
	$password = $info_row['password'];

	//specific variables
	$info_id = $info_row['id'];
	$firstname = html_entity_decode($info_row['firstname']);
	$lastname = html_entity_decode($info_row['lastname']);
	$email = html_entity_decode($info_row['email']);
	$phone = html_entity_decode($info_row['phone']);
	$about_page = html_entity_decode($info_row['page_about']);
	$contact_page = html_entity_decode($info_row['page_contact']);
	$sitename = ucwords(strtolower($firstname)).' '.ucwords(strtolower($lastname));
}

//you can change these headings below. they will affect the words that show up on the lefthand side links.
$link1 = "home";
$link2 = "works";
$link3 = "about";
$link4 = "contact";

//login system - for security reasons, do not change the following unless your know what you're changing
$LOGGEDIN = 'no';
$username = trim(strtolower($username));
$password = trim(strtolower($password));
if($_GET['logout'] == 'yes'){
	setcookie("PFlogin", "", mktime(12,0,0,1, 1, 1000));
	setcookie("PFpassw", "", mktime(12,0,0,1, 1, 1000));
	$self = "Location: ".str_replace("?logout=yes", "", $_SERVER['REQUEST_URI']);
	header( "$self" );
}
if(isset($_COOKIE['PFlogin']) && isset($_COOKIE['PFpassw'])){
	if($_COOKIE['PFlogin'] == md5($username)){
		if($_COOKIE['PFpassw'] == md5($password)){
			$LOGGEDIN = 'yes';
		}
	}
}
if(isset($_POST['login_button'])){
	$sub_username = trim(strtolower($_POST['username']));
	$sub_password = trim(strtolower($_POST['password']));
	if($username == $sub_username && $password == $sub_password){
		$time = 86400 + time();
		setcookie('PFlogin', md5($username), $time);
		setcookie('PFpassw', md5($password), $time);
		$LOGGEDIN = "yes";
	}
}

//general variables
$default_title = '';
$reply = '';
$show_customize = 0;
$show_manage = 0;
$show_settings = 0;
$show_add = 0;
$imagetypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/jpg", "image/png", "image/png-x");
$image_extensions = array("jpg", "pjpeg", "png-x", "png", "jpeg", "gif");
$ok = 0;

if($LOGGEDIN == 'yes'){
	//show manage if after delete
	if($_GET['s'] == 'm'){
		$show_manage = 1;
	}
	if($_GET['s'] == 'e'){
		$show_settings = 1;
	}

	function clean($n){
		$n = trim(strip_tags($n));
		$n = htmlentities($n, ENT_QUOTES);
		return $n;
	}
	function clean_page($n){
		$n = nl2br(trim($n));
		$n = htmlentities($n, ENT_QUOTES);
		return $n;
	}

	//add to portfolio if set (make sure it isn't a bot)
	if(isset($_POST['add_button']) && $_POST['human'] == '' && $LOGGEDIN == 'yes'){
		$show_manage = 0;
		$show_add = 1;
		if(!file_exists('files')){
			mkdir('files', 0777);
		}
		if(!file_exists('files_icons')){
			mkdir('files_icons', 0777);
		}
		if(!file_exists('files_previews')){
			mkdir('files_previews', 0777);
		}
		function file_clean($n){
			$n = str_replace(' ', '_', $n);
			$n = str_replace("'", '', $n);
			$n = str_replace('"', '', $n);
			$n = str_replace('/', '', $n);
			$n = str_replace('\\', '', $n);
			return $n;
		}

		$title = clean($_POST['title']);
		$type = $_POST['type'];
		$file = file_clean($_FILES['file']['name']);
		$file = time().'.'.end(explode(".", $file));
		$file_type = strtolower($_FILES['file']['type']);
		$file_tmpname = $_FILES['file']['tmp_name'];
		$preview = file_clean($_FILES['preview']['name']);
		$preview = time().'.'.end(explode(".", $preview));
		$preview_type = strtolower($_FILES['preview']['type']);
		$preview_tmpname = $_FILES['preview']['tmp_name'];

		$all_types = array("image/gif", "image/jpeg", "image/pjpeg", "image/jpg", "image/png", "image/png-x", "application/x-shockwave-flash");

		//check to see if all fields were filled out
		if($title == '' || $title == $default_title || $type == '' || $file == ''){
			$reply = "Please give this piece a title, category and choose a file for it.";
		} else {
			if(!in_array($file_type, $all_types)){
				$reply = "Your file's type isn't allowed.";
			} else {
				if(!in_array($file_type, $imagetypes) && !in_array($preview_type, $imagetypes)){
					$reply = "Please select an image preview for your piece.";
				}
				if(in_array($file_type, $imagetypes) || in_array($preview_type, $imagetypes)){

					//new paths for files
					$file_path = "files/".$file;
					if($preview != ''){
						$preview_path = "files_previews/".$preview;
					}
					//determine endings we'll use for file creations
					if(!in_array($file_type, $imagetypes)){
						$ending = $preview;
					} else {
						$ending = $file;
					}
					$icon_path = "files_icons/".$ending;

					//move files
					move_uploaded_file($file_tmpname, $file_path);
					if($preview != ''){
						move_uploaded_file($preview_tmpname, $preview_path);
					}

					//Determine if we'll use the file or preview image
					if(!in_array($file_type, $imagetypes)){
						$source = $preview_path;
					} else {
						$source = $file_path;
					}

					//Make Icon
					include_once('includes/thumbnail.inc.php');

					list($width, $height) = getimagesize($source);
					$thumb = new Thumbnail($source);

					if($width > $height){
						$thumb->resize(9999,150);
					} else {
						$thumb->resize(150,9999);
					}
					$thumb->cropFromCenter(120);
					$thumb->crop(0,0,120,85);
					$thumb->save($icon_path,100);
					$thumb->destruct();

					//resize either file or preview, depending on which is the image
					$thumb2 = new Thumbnail($source);
					if($width > 680 || $height > 850){
                        //NANGA resize(width,height)
						$thumb2-> resize(850,680);
					}
					if(!in_array($file_type, $imagetypes)){
                        //NANGA 100: resized image quality 1-100
						$thumb2->save($preview_path,100);
						move_uploaded_file($file_tmpname, $file_path);
					} else {
                        //NANGA 100: resized image quality 1-100
						$thumb2->save($file_path,100);
					}
					$thumb2->destruct();

					//Insert Informaiton Into Database
					$date = time();
					$query = mysql_query("INSERT INTO ".$prefix."profolio_work (date, title, type, file, preview, icon) VALUES ('$date', '$title', '$type', '$file_path', '$preview_path', '$icon_path')");
					if($query){
						$title = "";
						$ok = 1;
						$red = "Location: index.php?add=$title";
						header($red);
					} else {
						$reply = "There was a problem inserting the information into the database.";
					}
				}
			}
		}
		$default_title = $title;
	}
	if($_GET['add'] != ''){
		$reply = "<b>".$_GET['add']."</b> was add to your portfolio!";
	}

	//Delete From Portfolio If Set
	if($_GET['f'] == 'de' && $LOGGEDIN == 'yes'){
		$id = mysql_real_escape_string($_GET['i']);
		if($id > 0){
			$query = mysql_query("SELECT file, icon, preview FROM ".$prefix."profolio_work WHERE id = $id");
			while($row = mysql_fetch_array($query)){
				$file = $row['file'];
				$preview = $row['preview'];
				$icon = $row['icon'];
			}
			if(file_exists($file)){
				unlink($file);
			}
			if(file_exists($preview)){
				unlink($preview);
			}
			if(file_exists($icon)){
				unlink($icon);
			}
			mysql_query("DELETE FROM ".$prefix."profolio_work WHERE id = '$id'");

			$red = "Location: index.php?s=m";
			header($red);
		}
	}

	//Edit Portfolio Items If Set
	if(isset($_POST['editButton'])){
		if($LOGGEDIN == 'yes'){
			$show_manage = 1;
			$edit_id = clean($_POST['id']);
			$edit_title = clean($_POST['title_form']);
			$edit_type = clean($_POST['type']);

			$exists = mysql_num_rows(mysql_query("SELECT title FROM ".$prefix."profolio_work WHERE id = '$edit_id'"));
			if($exists == 1){
				if($edit_title != ''){
					mysql_query("UPDATE ".$prefix."profolio_work SET title = '$edit_title' WHERE id = '$edit_id'");
				}
				if($edit_type != ''){
					mysql_query("UPDATE ".$prefix."profolio_work SET type = '$edit_type' WHERE id = '$edit_id'");
				}
			}
		}
	}

	//reorder portfolio items if set
	if($_GET['f'] == 'up' && $LOGGEDIN == 'yes'){
		$show_manage = 1;
		$id = mysql_real_escape_string($_GET['i']);
		if($id > 0){
			//find type of piece
			$query = mysql_query("SELECT type FROM ".$prefix."profolio_work WHERE id = '$id'");
			$type = mysql_fetch_assoc($query);
			$type = $type['type'];

			//reorder only if others in type
			if(mysql_num_rows(mysql_query("SELECT id FROM ".$prefix."profolio_work WHERE type = '$type' AND id > '$id'")) > 0){
				//Get id of piece that current piece will switch with.
				$new_query = mysql_query("SELECT id, date FROM ".$prefix."profolio_work WHERE type = '$type' AND id > '$id' ORDER BY id ASC LIMIT 0, 1");
				while($row = mysql_fetch_assoc($new_query)){
					$new_id = $row['id'];
				}
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '0' WHERE id = '$id'");
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '$id' WHERE id = '$new_id'");
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '$new_id' WHERE id = '0'");
				$red = "Location: index.php?s=m";
				header($red);
			}
		}
	}
	if($_GET['f'] == 'dwn' && $LOGGEDIN == 'yes'){
		$show_manage = 1;
		$id = mysql_real_escape_string($_GET['i']);
		if($id > 0){
			//find type of piece
			$query = mysql_query("SELECT type FROM ".$prefix."profolio_work WHERE id = '$id'");
			$type = mysql_fetch_assoc($query);
			$type = $type['type'];

			//reorder only if others in type
			if(mysql_num_rows(mysql_query("SELECT id FROM ".$prefix."profolio_work WHERE type = '$type' AND id < '$id'")) > 0){
				//Get id of piece that current piece will switch with.
				$new_query = mysql_query("SELECT id, date FROM ".$prefix."profolio_work WHERE type = '$type' AND id < '$id' ORDER BY id DESC LIMIT 0, 1");
				while($row = mysql_fetch_assoc($new_query)){
					$new_id = $row['id'];
				}
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '0' WHERE id = '$id'");
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '$id' WHERE id = '$new_id'");
				mysql_query("UPDATE ".$prefix."profolio_work SET id = '$new_id' WHERE id = '0'");
				$red = "Location: index.php?s=m";
				header($red);
			}
		}
	}

	//Edit Settings And Information If Set
	if(isset($_POST['change_settings']) && $LOGGEDIN == 'yes'){
		$new_username = clean($_POST['username']);
		$new_password = clean($_POST['new_password']);
		$confirm_password = clean($_POST['confirm_password']);
		$new_firstname = clean($_POST['firstname']);
		$new_lastname = clean($_POST['lastname']);
		$new_email = clean($_POST['email']);
		$new_phone = clean($_POST['phone']);
		$new_aboutpage = clean_page($_POST['about_page']);
		$new_contactpage = clean_page($_POST['contact_page']);
		$relogin = 0;
		$show_settings = 1;

		if($new_username != clean($username) && $new_username != ''){
			mysql_query("UPDATE ".$prefix."profolio_info SET username = '$new_username' WHERE id = '$info_id'");
			$relogin = 1;
		}
		if($new_password != clean($password) && $new_password != ''){
			if( $new_password == $confirm_password){
				mysql_query("UPDATE ".$prefix."profolio_info SET password = '$new_password' WHERE id = '$info_id'");
				$relogin = 1;
			} else {
				$reply = 'Your new passwords didn\'t match. Enter the exact same password in the "new password" field and "confirm password" field.<br />';
			}
		}
		if($relogin == 1){
			$reply = "<br />You now need to re-login in order for your new username/password to take effect.<br /><span style='color:#999;'>You are now being logged out...</span>";
			$reply .= '<meta http-equiv="refresh" content="4">';
			$show_settings = 0;
		}
		if($new_email != clean($email)){
			mysql_query("UPDATE ".$prefix."profolio_info SET email = '$new_email' WHERE id = '$info_id'");
		}
		if($new_phone != clean($phone)){
			mysql_query("UPDATE ".$prefix."profolio_info SET phone = '$new_phone' WHERE id = '$info_id'");
		}
		if($about_page != $new_aboutpage){
			mysql_query("UPDATE ".$prefix."profolio_info SET page_about = '$new_aboutpage' WHERE id = '$info_id'");
		}
		if($contact_page != $new_contactpage){
			mysql_query("UPDATE ".$prefix."profolio_info SET page_contact = '$new_contactpage' WHERE id = '$info_id'");
		}
		if($new_firstname != clean($firstname)){
			mysql_query("UPDATE ".$prefix."profolio_info SET firstname = '$new_firstname' WHERE id = '$info_id'");
		}
		if($new_lastname != clean($lastname)){
			mysql_query("UPDATE ".$prefix."profolio_info SET lastname = '$new_lastname' WHERE id = '$info_id'");
		}

		if($relogin == 1){
			$reply = "<br />You now need to re-login in order for your new username/password to take effect.<br /><span style='color:#999;'>You are now being logged out...</span>";
			$reply .= '<meta http-equiv="refresh" content="4">';
			$show_settings = 0;
		}

		//Re-query database to get updated information for display
		$info_query = mysql_query("SELECT * FROM ".$prefix."profolio_info ORDER BY id DESC LIMIT 0,1");
		while($info_row = mysql_fetch_array($info_query)){
			//Login Information
			$username = $info_row['username'];
			$password = $info_row['password'];

			//Specific Variables
			$firstname = html_entity_decode($info_row['firstname']);
			$lastname = html_entity_decode($info_row['lastname']);
			$email = html_entity_decode($info_row['email']);
			$phone = html_entity_decode($info_row['phone']);
			$about_page = html_entity_decode($info_row['page_about']);
			$contact_page = html_entity_decode($info_row['page_contact']);
			$sitename = ucfirst(strtolower($firstname)).' '.ucfirst(strtolower($lastname));
		}
	}

	//customize
	if(isset($_POST['change_customize']) && $LOGGEDIN == 'yes'){
		function makeColor($n){
			$n = trim($n);
			$n = str_replace('#', '', $n);
			$n = substr($n, 0, 6);
			$n = '#'.$n;
			return $n;
		}
		$show_customize = 1;
		$new_categories = clean($_POST['categories']);
		$new_firstname_color = makeColor($_POST['firstname_color']);
		$new_lastname_color = makeColor($_POST['lastname_color']);
		$new_link_color = makeColor($_POST['link_color']);
		$new_text_color = makeColor($_POST['text_color']);
		$new_bg_color = makeColor($_POST['bg_color']);
		$new_lb_color = makeColor($_POST['lb_color']);
		$new_bg_image = clean($_POST['bg_image']);
		$new_bg_pos = clean($_POST['bg_pos']);
		$new_bg_repeat = clean($_POST['bg_repeat']);
		if($new_categories != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET categories = '$new_categories'");
		}
		if($new_firstname_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_firstname = '$new_firstname_color'");
		}
		if($new_lastname_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_lastname = '$new_lastname_color'");
		}
		if($new_link_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_links = '$new_link_color'");
		}
		if($new_text_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_text = '$new_text_color'");
		}
		if($new_bg_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_background = '$new_bg_color'");
		}
		if($new_lb_color != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET color_lightbox = '$new_lb_color'");
		}
		if($new_bg_image != 'no'){
			mysql_query("UPDATE ".$prefix."profolio_customize SET opt_backgroundimg = '$new_bg_image'");
		}
		if($new_bg_pos != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET opt_backgroundpos = '$new_bg_pos'");
		}
		if($new_bg_repeat != ''){
			mysql_query("UPDATE ".$prefix."profolio_customize SET opt_backgroundrep = '$new_bg_repeat'");
		}
	}

} //ending if loggedin bracket

//query data for customize
$query = mysql_query("SELECT * FROM ".$prefix."profolio_customize ORDER BY id DESC LIMIT 0,1");
while($row = mysql_fetch_array($query)){
	$categories = html_entity_decode($row['categories']);
	function createCategories($list){
		$list = explode(',', $list);
		$output = '<select id="type" name="type"><option selected="selected" value="">Please Choose A Category &nbsp;&nbsp;</option><option disabled="disabled">&nbsp;</option>';
		foreach($list as $option){
			if(trim($option) != ''){
				$option = trim($option);
				$option = '<option value="'.ucwords($option).'">'.ucwords($option).'</option>';
				$output .= $option;
			}
		}
		$output .= '<option disabled="disabled">&nbsp;</option><option value="Animation" id="animation_select">Animation (Beta)</option>';
		$output .= '</select>';
		return $output;
	}
	$firstname_color = $row['color_firstname'];
	$lastname_color = $row['color_lastname'];
	$link_color = $row['color_links'];
	$text_color = $row['color_text'];
	$bg_color = $row['color_background'];
	$lb_color = $row['color_lightbox'];
	$bg_image = $row['opt_backgroundimg'];
	$bg_pos = $row['opt_backgroundpos'];
	$bg_repeat = $row['opt_backgroundrep'];
}
?>
