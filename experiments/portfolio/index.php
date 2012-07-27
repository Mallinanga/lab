<?
$profolio_Version = 1.05;

include("config.php");
include("functions.php");

if(file_exists("upgrade.php")){
	$red = "Location: upgrade.php";
	header($red);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Portfolio of <? echo ucwords($sitename); ?></title>
<? include("style.css.php"); ?>
<!-- <script src="http://www.google.com/jsapi"></script>
<script>google.load("jquery", "1");</script> -->
<script src="jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(window).bind("load",function(){
		<? if($ok != 1){ ?>
		$(".left_column").fadeIn(1000);
		//show home box when page loads
		focusCurrent("div.side_links a","div#box1");
		<? } ?>

		//clicking on links - fade out all .main divs, delay everything for 500 ms, fade links to half opacity, fade in current link, fade in current content box
		var fadeable = 1;
		function hidePlinks(){
			$("div.side_links_mini").slideUp("slow").dequeue()
		}
		function fadeMains(){
			$("div.main").fadeOut("slow").fadeTo(550, 1)
			$(".reply").css("display", "none")
		}
		function fadeSideLinks(){
			$("div.side_links a").fadeTo(250, .5).dequeue()
		}
		function focusCurrent(l,b){
			$(l).fadeTo(250, 1).dequeue()
			$(b).fadeIn("slow", function(){ fadeable = 1; })
		}
		function fadeIcons(){
			$("div.icon_holder").fadeTo(250, .75);
		}
		function showPage(l, p){
			if(fadeable == 1){
				fadeable = 0;
				$(this).dequeue()
				fadeMains()
				hidePlinks()
				fadeSideLinks()
				focusCurrent(l, p)
			}
		}
		function showPanel(p){
			$(this).dequeue()
			fadeMains()
			hidePlinks()
			fadeSideLinks()
			$(p).fadeIn("slow");
		}

		$("a#link1").click(function(){
			showPage("div.side_links a","div#box1")
		})
		$("a#link2").click(function(){
			showPage("a#link2","div#box2")
			$("div.side_links_mini").slideDown("slow")
		})
		$("a#link3").click(function(){
			showPage("a#link3","div#box3")
		})
		$("a#link4").click(function(){
			showPage("a#link4","div#box4")
		})
        //NANGA new page
		$("a#link5").click(function(){
			showPage("a#link5","div#box5")
		})
		//NANGA new page eof
		$("div.login").fadeTo(1000, .65);
		$("div.login").hover(
			function(){
				$(this).fadeTo(200, 1).dequeue();
			},
			function(){
				$(this).fadeTo(200, .65).dequeue();
			}
		);

		//portfolio subs
		<?
		$under_link_query = mysql_query("SELECT DISTINCT(type), type FROM ".$prefix."profolio_work");
		while($u_row = mysql_fetch_assoc($under_link_query)){
			$type = html_entity_decode($u_row['type']);
			?>
			$("a#link_<? echo str_replace(' ', '_', $type); ?>").click(function(){
				if(fadeable == 1){
				fadeable = 0;
					$(this).dequeue()
					fadeMains()
					fadeSideLinks()
					fadeIcons()
					focusCurrent("a#link_<? echo str_replace(' ', '_', $type); ?>","div#box_<? echo str_replace(' ', '_', $type); ?>");
				}
			})
			<?
		}
		?>
		$("div.icon_holder").mouseover(function(){
			$(this).fadeTo(150, 1).dequeue()
		})
		$("div.icon_holder").mouseout(function(){
			$(this).fadeTo(300, .75).dequeue()
		})

		//add to portfolio
		<? if($show_add == 1){ ?>
			$(".reply").css("display", "block");
			<? if($ok == 0){ ?>
				showPanel("div#box_add")
			<? } ?>
		<? } ?>
		$("a#link_add").click(function(){
			showPanel("div#box_add")
		})

		//change customization options
		$("a#link_customize").click(function(){
			showPanel("div#box_customization")
		})
		<? if($show_customize == 1){ ?>
			showPanel("div#box_customization")
		<? } ?>

		//change settings and info
		$("a#link_settings").click(function(){
			showPanel("div#box_settings")
		})
		<? if($show_settings == 1){ ?>
			showPanel("div#box_settings")
		<? } ?>

		//manage portfolio
		$("a#link_manage").click(function(){
			showPanel("div#box_manage")
		})
		<? if($show_manage == 1){ ?>
			showPanel("div#box_manage")
		<? } ?>

		//editing names of pieces
		$("span.managelist_title").click(function(){
			if(editable == 1){
				editable = 1;
				var title = $(this).text();
				title_ = title.split('(ID-EDIT-NUM)');
				var id = title_[0];
				//replace with input box
				$(this).replaceWith('<div style="height:0px;left:18px;top:-20px;position:relative;"<form name="editTitle" action="" enctype="multipart/form-data" method="post"><input name="title_form" type="text" value="' + title_[1] + '" /> <? echo createCategories($categories); ?><input name="id" type="hidden" value="' + id + '" /> <input name="editButton" class="button" type="submit" value="Edit" /></form></div');
			}

		})
		var editable = 1;

		//hide div w/id extra
        $("#preview").css("display","none");
        $("#type").click(function(){
			if ($("#animation_select").is(":selected")){
				$("#preview").slideDown("normal");
			} else {
				$("#preview").slideUp("normal");
			}
		});

		//login box
		login_shown = 1;
		$("div.login a#toggle_login").click(function(){
			if(login_shown == 1){
				$("div.login_box").fadeIn("normal");
				$("a#toggle_login").fadeTo(200, .2);
				login_shown = 0;
			} else {
				$("div.login_box").fadeOut("normal");
				$("a#toggle_login").fadeTo(200, 1);
				login_shown = 1;
			}
		})
	});

	//lightbox viewer
	$(document).ready(function(){
		//When you click on something with class, lightbox, it adds the overlay and shows the file that the a href was linked to.
		$(".lightbox").click(function(){
			overlayLink = $(this).attr("href"); //Show What's in the link
			title = $(this).attr("title"); //Grab the title
			string = $(this).next(".info").text(); //Get the parent div's p which contains the date
			elements = string.split("+br");
			window.startOverlay(overlayLink, title, elements[0], elements[3]); //Execute the lightbox
			return false; //Tells the browser to not actually go to the link when clicked on the a href
		});
	});
	$(document).ready(function(){
		$(".lightboxSWF").click(function(){
			overlayLink = $(this).attr("href"); //Show What's in the link
			title = $(this).attr("title"); //Grab the title
			string = $(this).next(".info").text(); //Get the parent div's p which contains the date
			elements = string.split("+br");
			window.startOverlaySWF(overlayLink, title, elements[0], elements[1], elements[2]); //Execute the lightbox
			return false; //Tells the browser to not actually go to the link when clicked on the a href
		});
	});

	//image lightbox
	function startOverlay(overlayLink, title, date, id, overlay) {
		//adds the overlay layer plus the container layer, which will contain the image and text
		if(overlay != 0){
			$("body").append('<div class="overlay"><span class="close"></span></div><div class="container"></div>')
		} else {
			$("body").append('<div class="container"></div>')
		}

		//animates the transparent black sheet covering the screen
		$(".overlay").animate({"opacity":"0.85"}, 450, "linear");

		//puts the image, title and date into the .container depending on browser type
		if($.browser.msie){
            //NANGA remove title and date from lightbox
			//$(".container").html('<img src="'+overlayLink+'" alt="" />');
			$(".container").html('<img src="'+overlayLink+'" alt="" /><div><p>'+title+'<br /><span>'+date+'</span></p></div>');
		} else {
            //NANGA remove title and date from lightbox
			//$(".container").html('<span class="nav navLeft"></span><span class="nav navRight"></span><img src="'+overlayLink+'" alt="" />');
			$(".container").html('<span class="nav navLeft"></span><span class="nav navRight"></span><img src="'+overlayLink+'" alt="" /><div class="caption"><p>'+title+'<br /><span>'+date+'</span></p></div>');
		}

		//alows for the removal of the lightbox.
		window.removeOverlay(id);

		//position the image accordingly.
		$(".container img").load(function() {
			var imgWidth = $(".container img").width() + 2; //plus 2 for the border
			var imgHeight = $(".container img").height() + 2; //plus 2 for the border
			$(".container").css({
				"top": "50%",
				"left": "50%",
				"width": imgWidth,
				"height": imgHeight,
				"margin-top": -(imgHeight/2),
				"margin-left":-(imgWidth/2) //position the image in the middle of the screen.
			}).animate({"opacity":"1"}, 550, "linear", function(){
				$(".overlay").css({"background-image": "none"});
			});

			//make necessary changes for ie
			if($.browser.msie){
				$(".overlay").css({"height": "150%"});
				$(".container div").css({"padding-left": "6px"});
				$(".container").css({"height": imgHeight + 50});
			}

			//show the actual image and hide stuff
			$(".container div").fadeTo(2000, 1).fadeTo(1000, .001); //Hide the comment after a while.
			//Hover over the comment above.
			$(".container div").hover(
				function(){
					$(this).fadeTo(300, 1).dequeue();
				},
				function(){
					$(this).fadeTo(300, .001).dequeue();
				}
			);
			//hover over nav links
			$("span.nav").hover(
				function(){
					$(this).fadeTo(200, 1).dequeue();
				},
				function(){
					$(this).fadeTo(200, .001).dequeue();
				}
			);
		});
	}

	//swf lightbox
	function startOverlaySWF(overlayLink, title, date, widthpop, heightpop) {
		var imgWidth = widthpop; //plus 2 for the border
		var imgHeight = heightpop; //plus 2 for the border

		//adds the overlay layer plus the container layer, which will contain the image and text
		$("body")
			.append('<div class="overlay"></div><div class="container"></div>');

		//animates the transparent black sheet covering the screen
		$(".overlay").animate({"opacity":"0.85"}, 450, "linear");

		//puts the image, title and date into the .container
		$(".container").html('<div><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0" id="Flash" width="'+imgWidth+'" height="'+imgHeight+'"> <param name="allowScriptAccess" value="sameDomain"><param name="movie" value="'+overlayLink+'"><param name="quality" value="high"><embed src="'+overlayLink+'" quality="high" width='+imgWidth+' height='+imgHeight+' name="Flash" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></object></div><div id="titles"><p>'+title+'<span>'+date+'</span></p></div>');

		//alows for the removal of the lightbox.
		window.removeOverlay();

		//position the image accordingly.
		$(".container").css({
			"top": "50%",
			"left": "50%",
			"width": imgWidth,
			"height": imgHeight,
			"margin-top": -(imgHeight/2),
			"margin-left":-(imgWidth/2) //position the image in the middle of the screen.
		}).animate({"opacity":"1"}, 550, "linear", function(){
			$(".overlay").css({"background-image": "none"});
		}); //show the actual image.
		$(".container div#titles").fadeTo(2000, 1).fadeTo(1000, .001); //hide the comment after a while.
		$(".container div#titles").hover(
			function(){
				$(".container div#titles").fadeTo(300, 1).dequeue();
			},
			function(){
				$(".container div#titles").fadeTo(300, .001).dequeue();
			}
		); //hover over the comment above.
	}

	//remove lightbox
	function removeOverlay(id) {
		// when the user clicks on the overlay, the lightbox goes away.
		$(".overlay, .container img").click(function(){
			$(".container, .overlay").animate({"opacity":"0"}, 250, "linear", function(){
				$(".container, .overlay").remove();
			});
		});
		//click next or previous
		$("span.navRight").click(function(){
			var nextPiece = $("#piece_"+id).next("div").children("a.lightbox");
			if(nextPiece.attr("href") === undefined){
				$(".container, .overlay").animate({"opacity":"0"}, 250, "linear", function(){
					$(".container, .overlay").remove();
				});
			} else {
				overlayLink = nextPiece.attr("href"); //show what's in the link
				title = nextPiece.attr("title"); //grab the title
				string = nextPiece.next(".info").text(); //get the parent div's p which contains the date
				elements = string.split("+br");
				$(".container").fadeTo(400, 0, function(){
					$(this).remove();
					window.startOverlay(overlayLink, title, elements[0], elements[3], 0); //execute the lightbox
				})
			}
		})
		$("span.navLeft").click(function(){
			var nextPiece = $("#piece_"+id).prev("div").children("a.lightbox");
			if(nextPiece.attr("href") === undefined){
				$(".container, .overlay").animate({"opacity":"0"}, 250, "linear", function(){
					$(".container, .overlay").remove();
				});
			} else {
				overlayLink = nextPiece.attr("href"); //show what's in the link
				title = nextPiece.attr("title"); //grab the title
				string = nextPiece.next(".info").text(); //get the parent div's p which contains the date
				elements = string.split("+br");
				$(".container").fadeTo(400, 0, function(){
					$(this).remove();
					window.startOverlay(overlayLink, title, elements[0], elements[3], 0); //execute the lightbox
				})
			}
		})
	}
</script>
</head>
<body>
    <div class="login">
		<? if($LOGGEDIN == 'no'){ ?>
        <a id="toggle_login" href="#"><img src="images/login.png" border="0" alt="" width="16" height="16"/></a>
        <div class="login_box">
        	<form name="login_form" action="" enctype="multipart/form-data" method="post">
            	<input name="username" value="username" onfocus="clearDefault(this)" onblur="makeDefault(this)" />
                <input name="password" value="000000" type="password" onfocus="clearDefault(this)" onblur="makeDefault(this)" />
                <input name="login_button" type="submit" value="login" />
            </form>
        </div>
        <? } else { ?>
        <a href="?logout=yes">logout</a>
        <a href="#" id="link_add">add</a>
        <a href="#" id="link_manage">manage</a>
        <a href="#" id="link_settings">settings</a>
        <a href="#" id="link_customize">customize</a>
        <!-- <a href="#" id="link_customize"><img src="images/customize.png" border="0" alt="" width="10" height="10"/>&nbsp;&nbsp;customize</a> -->
		<? } ?>
        <p class="clear"></p>
    </div>
    <div class="reply" align="center"><? echo $reply; ?></div>
	<div class="wrapper">
    	<div class="left_column">
        	<h1 class="sitename">
            	<a href="<? echo $_SERVER['PHP_SELF']; ?>" title="<? echo $sitename; ?>"><span class="firstname"><? echo $firstname; ?></span><span class="lastname"><? echo $lastname; ?></span></a>
            </h1>
            <div class="side_links">
            	<a href="#" id="link1" class="end"><? echo $link1; ?></a>
                <a href="#" id="link2"><? echo $link2; ?></a>
                <div class="side_links_mini">
                	<?
					$under_link_query = mysql_query("SELECT DISTINCT(type), type FROM ".$prefix."profolio_work ORDER BY type ASC");
					while($u_row = mysql_fetch_assoc($under_link_query)){
						$type = html_entity_decode($u_row['type']);
						?>
                    	<a href="#" id="link_<? echo str_replace(' ', '_', $type); ?>"><? echo ucfirst($type); ?></a>
                        <?
					}
					?>
                </div>
                <a href="#" id="link3"><? echo $link3; ?></a>
                <!--NANGA new page -->
                <a href="#" id="link5">projects</a>
                <!--NANGA new page eof -->
                <a href="#" id="link4"><? echo $link4; ?></a>
            </div>
        </div>
        <div class="right_column">
        	<div class="meta">
            	<h1><h2><h3><h4><strong>Portfolio of <? echo $sitename; ?></strong></h4></h3></h2></h1><br /><br />
            </div>
        	<div id="box1" class="main">
                <!--NANGA homepage content -->
                <!--NANGA bla? -->
			</div>
            <div id="box2" class="main">

			</div>
			<!--NANGA new page -->
            <div id="box5" class="content_box main">
                Hosting services<br />
            </div>
            <!--NANGA new page eof -->
            <div id="box3" class="content_box main">
                <? echo $about_page; if(empty($about_page)){ echo "About Page - 404"; } ?>
            </div>
      		<div id="box4" class="content_box main">
            	<?
				if($contact_page != ''){ echo $contact_page."<p>&nbsp;</p>"; }
				if(trim($email) != ''){ ?>
                <p><a href="mailto: <? echo $email; ?>"><img src="images/mail.png" width="14" height="10" border="0" alt="Mail: " /> &nbsp;<b><? echo $email; ?></b></a></p>
                <? }
				if(trim($phone) != ''){ ?>
                <p><img src="images/phone.png" width="14" height="13" border="0" alt="Phone: " /> &nbsp;<? echo $phone; ?></p>
            	<? } ?>
            </div>
            <div id="Portfolio_Boxes">
			<?
			$under_box_query = mysql_query("SELECT DISTINCT(type), type FROM ".$prefix."profolio_work");
			$i=1;
			while($u_row = mysql_fetch_assoc($under_box_query)){
				$type = html_entity_decode($u_row['type']);
				?>
				<div id="box_<? echo str_replace(' ', '_', $type); ?>" class="main">
                    <div class="strip" id="strip_<? echo str_replace(' ', '_', $type); ?>">
                    	<?
						$icon_query = mysql_query("SELECT id, date, title, type, file, preview, icon FROM ".$prefix."profolio_work WHERE type = '$type' ORDER BY id DESC");

						while($i_row = mysql_fetch_array($icon_query)){
							$title = html_entity_decode($i_row['title']);
							$date = $i_row['date'];
							$id = $i_row['id'];
							$icon = $i_row['icon'];
							list($width, $height) = getimagesize($icon);
							$file = $i_row['file'];
							list($width2, $height2) = getimagesize($file);
							$extension = strtolower(end(explode(".", $file)));
							?>
                            <div class="icon_holder" id="piece_<? echo $i; ?>">
                            	<a href="<? echo $file; ?>" class="<? if(!in_array($extension, $image_extensions)){ echo 'lightboxSWF'; } else { echo 'lightbox'; } ?>" title="<? echo $title; ?>"><img src="<? echo $icon; ?>" border="0" width="<? echo $width; ?>" height="<? echo $height; ?>" alt="<? echo $title; ?>" class="icon" /></a>
                            	<p class="info"><? echo date('F j, Y', $date).'+br'.$width2.'+br'.$height2.'+br'.$i; ?></p>
                            </div>
                            <?
							$i++;
						}
						?>
                        <p class="clear"></p>
                    </div>
				</div>
				<?
			}
			?>
            </div>
        <? if($LOGGEDIN == 'yes'){ ?>
            <div class="content_box main" id="box_add">
				<div style="width:100%;">
                <form name="add" action="" enctype="multipart/form-data" method="post">
                    <div class="form_element">
                        <p>title of your piece</p>
                        <p><input name="title" value="<? echo $default_title; ?>" onfocus="clearDefault(this)" onblur="makeDefault(this)" /></p>
                    </div>
                    <div class="form_element">
                        <p>category</p>
                        <p>
                            <? echo createCategories($categories); ?>
                        </p>
                    </div>
                    <div class="form_element">
                        <p>select the piece's file</p>
                        <p class="secondary_text">allowed filetypes: png, jpg, gif, swf</p>
                        <p><input name="file" type="file" /></p>
                    </div>
                    <div id="preview">
                        <p>select an image preview for this piece</p>
                        <p class="secondary_text">allowed filetypes: png, jpg, gif</p>
                        <p><input name="preview" type="file" /></p>
                    </div>
                    <p class="clear"><input name="human" type="text" value="" /></p>
                    <div>
                    	<p class="form_element_below">&nbsp;</p>
                        <p align="center"><input class="button" name="add_button" type="submit" value="add to your portfolio" onclick="this.value='please wait...'" /></p>
                    </div>
                </form>
                </div>
            </div>
          <div class="content_box main" id="box_manage" style="padding-bottom:80px;">
				<p><strong>click on the piece's names to edit them.</strong> you can only edit one piece at a time.</p>
                <p>&nbsp;</p>
				<?
                $query = mysql_query("SELECT id, title, type, icon FROM ".$prefix."profolio_work ORDER BY type, id DESC");
                $count = 1;
                while($row = mysql_fetch_assoc($query)){
                    $id = $row['id'];
                    $title = html_entity_decode($row['title']);
                    $type = html_entity_decode($row['type']);
                    $icon = $row['icon'];
                    ?>
                    <div class="manage_list" <? if($count == 1){ echo "style='border-top:none;'"; } ?>>
                        <span class="thumb"><img src="<? echo $icon; ?>" border="0" /></span>
                        <div class="left"><? echo $count.'. <span class="managelist_title"><span style="display:none;">'.$id.'(ID-EDIT-NUM)</span>'.$title.'</span>'; ?></div>
                        <div class="right">
                            <span><? echo $type; ?></span>
                            <a href="?i=<? echo $id; ?>&f=up">&nbsp;<img src="images/arrow_up.png" width="7" height="10" border="0" />&nbsp;</a>
                            <a href="?i=<? echo $id; ?>&f=dwn">&nbsp;<img src="images/arrow_down.png" width="7" height="10" border="0" />&nbsp;</a>
                            <a href="?i=<? echo $id; ?>&f=de" onClick="return confirm('Are you sure you\'d like to delete this piece from your Portfolio? This cannot be undone.')">Delete</a>                       </div>
                        <p class="clear"></p>
                    </div>
                    <?
                    $count++;
                }
                ?>
          </div>
           <div class="content_box main" id="box_customization">
            	<form name="customize" action="" enctype="multipart/form-data" method="post">
                    <div>
                    	<p>categories <span style="color:#999999">(comma seperated)</span></p>
                        <input type="text" class="categories" maxlength="400" name="categories" value="<? echo ucwords($categories); ?>"/>
                    </div>
                    <p>&nbsp;</p>
                    <div class="color_chooser">
                    	<p>first name color</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="firstname_color" id="firstname_color" value="<? echo $firstname_color; ?>"/>
                    </div>
                    <div class="color_chooser">
                    	<p>last name color</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="lastname_color" id="lastname_color" value="<? echo $lastname_color; ?>"/>
                    </div>
                    <div class="color_chooser">
                    	<p>link colors</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="link_color" id="link_color" value="<? echo $link_color; ?>"/>
                    </div>
                    <p class="clear"></p>
                    <div class="color_chooser">
                    	<p>text color</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="text_color" id="text_color" value="<? echo $text_color; ?>"/>
                    </div>
                    <div class="color_chooser">
                    	<p>background color</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="bg_color" id="bg_color" value="<? echo $bg_color; ?>"/>
                    </div>
                    <div class="color_chooser">
                    	<p>lightbox color</p>
                        <input type="text" class="iColorPicker" maxlength="7" name="lb_color" id="lb_color" value="<? echo $lb_color; ?>"/>
                    </div>
                    <p class="clear"></p>
                    <p>&nbsp;</p>
                    <div class="color_chooser">
                    	<p>background image</p>
                        <select name="bg_image">
                        	<option value="no">&nbsp;</option>
                        	<option value="">none</option>
                            <?
							$jpegs = glob('backgrounds/'."*.jpg");
							$pngs = glob('backgrounds/'."*.png");
							$gifs = glob('backgrounds/'."*.gif");
							$images = array_merge($jpegs, $pngs, $gifs);
							foreach($images as $image){
								echo "<option value='$image' ";
								if($bg_image == $image){
									echo ' selected="selected"';
								}
								echo ">".str_replace('backgrounds/', '', $image)."</option>";
							}
							?>
                        </select>
                    </div>
                    <div class="color_chooser">
                    	<p>background position</p>
                        <select name="bg_pos">
                        	<option value="">&nbsp;</option>
                            <?
							$positions = array('bottom right', 'bottom left', 'bottom center', 'top right', 'top left', 'top center','left center', 'right center', 'top', 'bottom', 'center');
							foreach($positions as $position){
								echo "<option value='$position' ";
								if($bg_pos == $position){
									echo ' selected="selected"';
								}
								echo ">".ucwords($position)."</option>";
							}
							?>
                        </select>
                    </div>
                    <div class="color_chooser">
                    	<p>background repeat</p>
                        <select name="bg_repeat">
                        	<option value="">&nbsp;</option>
                            <?
							$repeats = array('no-repeat', 'repeat', 'repeat-x', 'repeat-y');
							foreach($repeats as $repeat){
								echo "<option value='$repeat' ";
								if($bg_repeat == $repeat){
									echo ' selected="selected"';
								}
								echo ">".ucwords($repeat)."</option>";
							}
							?>
                        </select>
                    </div>
                    <p class="clear"></p>
                    <p>&nbsp;</p>
                    <input type="submit" class="button" name="change_customize" value="Save" />
                    <p>&nbsp;</p>
                </form>
            </div>
          <div class="content_box main" id="box_settings">
            	<form name="settings" action="" enctype="multipart/form-data" method="post">
                	<div>
                    	<p>username</p>
                        <input type="text" maxlength="30" name="username" value="<? echo $username; ?>" onfocus="clearDefault(this)" onblur="makeDefault(this)" />
                    </div>
                    <div style="display:none;">
                    	<p>bug pass - catch scripts</p>
                        <input type="password" maxlength="30" name="bug" value=""/>
                    </div>
                    <div>
                    	<p>new password</p>
                        <input class="new_password" type="password" maxlength="30" name="new_password" value=""/>
                    </div>
                    <div>
                    	<p>confirm password</p>
                        <input class="new_password" type="password" maxlength="30" name="confirm_password" value=""/>
                    </div>
                    <p>&nbsp;</p>
                    <div>
                    	<p>your first name</p>
                        <input type="text" maxlength="255" name="firstname" value="<? echo $firstname; ?>"/>
                    </div>
                    <div>
                    	<p>your last name (optional)</p>
                        <input type="text" maxlength="255" name="lastname" value="<? echo $lastname; ?>"/>
                    </div>
                    <div>
                    <div>
                    	<p>contact email address (optional)</p>
                        <input type="text" maxlength="255" name="email" value="<? echo $email; ?>" />
                    </div>
                    <div>
                    	<p>contact phone number (optional)</p>
                        <input type="text" maxlength="255" name="phone" value="<? echo $phone; ?>"/>
                    </div>
                    <p>&nbsp;</p>
                    <div>
                    	<p>about page</p>
                        <textarea name="about_page"><? echo str_replace('<br />', '', $about_page); ?></textarea>
                    </div>
                    <div>
                    	<p>contact page</p>
                        <textarea name="contact_page"><? echo str_replace('<br />', '', $contact_page); ?></textarea>
                    </div>
                    <p>&nbsp;</p>
                    <input type="submit" class="button" name="change_settings" value="save settings and info" />
                    <p>&nbsp;</p>
                </form>
            </div>
          <? } ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="meta">
    	<h1>Portfolio of <? echo $sitename; ?>.</h1>
        <h2>Portfolio Web Design Development Projects Works Paganis Panagiotis Mallinanga</h2>
    </div>
</body>
<div class="footer"><p><a href="http://dropnet.gr/" target="_blank" title="<? echo $profolio_Version; ?>"><span>Hosted by</span> dropnet.gr</a></p></div>
<script type="text/javascript">
	function clearDefault(el){
	if(el.defaultValue==el.value)el.value=""
	}
	function makeDefault(el){
	if(el.value=="")el.value=el.defaultValue
	}
</script>
<? if($LOGGEDIN == 'yes'){ ?>
<script type="text/javascript" src="includes/icolorpicker.js"></script>
<? } ?>
</html>
