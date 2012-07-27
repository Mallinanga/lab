<style type="text/css">
/*
@font-face {
    font-family: "Font";
    src: url(http://paganis.net/portfolio/base.eot), local("Arial Black");
}
@font-face {
    font-family: "Font";
    src: url(http://paganis.net/portfolio/base.ttf) format("truetype"), local("Arial Black");
}
*/
@font-face {
    font-family: Font;
    /* font-weight: bold; */
    src: url('graublauweb.otf') format('opentype');
}

/* setup */
* {padding:0; margin:0; font-family:Font, "Segoe UI", Calibri, Helvetica, sans-serif;}
a {color:<? echo $link_color; ?>; outline:none; text-decoration:none;}
body{background-color:<? echo $bg_color; ?>; background-image:url(<? echo html_entity_decode($bg_image); ?>); background-repeat:<? echo html_entity_decode($bg_repeat); ?>; background-position:<? echo html_entity_decode($bg_pos); ?>; background-attachment:fixed;}
html {overflow-y:scroll; overflow-x:auto; font-size:15px; color:#FFF;}
img { -ms-interpolation-mode: bicubic;}

/* site basics */
.wrapper {width:930px; margin:0 auto; margin-top:9%;  color:<? echo $text_color; ?>;}
.footer {position:fixed; bottom:0px; right:0px; width:100%;  color:#777; background:url(images/transparent80.png) repeat;}
.footer p {text-align:right; padding:3px 6px; font-size:12px;}
.footer a span {color:#666666}
.left_column {width:300px; margin-right:40px; float:left; text-align:right; display:none;}
.right_column {float:left; max-width:590px; padding-top:4px; margin-top:0px !important; margin-top:-20px; display:block;}
.clear {clear:both; visibility:hidden; width:0px; height:0px; overflow:hidden;}
.login {text-align:right; background:url(images/transparent80.png) repeat;}
.login a {float:right; padding:5px 13px; color:#BBB; display:block; font-size:13px;}
.login a:hover {background:#333;}
.login a:active {background:#555;}
.login_box {display:none; padding:2px 16px;}
.login_box input {font-size:0.75em; padding:1px; border:1px solid #333; background:#222; margin:0px 3px; color:#FFFFFF;}
.reply {padding-bottom:6px; text-align:center; margin:0 auto; display:none;}
.side_links a {font-family: Font; display:block; padding:8px 0px; margin-right:4px; text-align:right; background:url(images/seperator.png) no-repeat top right; font-size:1.5em; font-weight:lighter; text-transform:uppercase; outline:none;}
.side_links a.end {background:none;}
.side_links_mini {display:none;}
.side_links_mini a {margin:0px 4px 4px 0px; line-height:60%; display:block; font-size:1.025em; background:none; text-transform:uppercase;}

/* site name */
.sitename {padding:0px 2px 25px 0px; font-size:1.7em; letter-spacing:-0.3px; text-transform:uppercase;}
.sitename .firstname {font-family: Font; color:<? echo $firstname_color; ?>; font-weight:lighter;}
/* .sitename .lastname {font-family: Font; <? if($lastname_color != '' || $lastname_color != '#'){ echo 'color:'.$lastname_color.';'; } ?>font-weight:normal;} */
.sitename .lastname {font-family: Font; <? if($lastname_color != '' || $lastname_color != '#'){ echo 'color:'.$lastname_color.';'; } ?> font-weight:lighter;}

/* content boxes */
.main {display:none;}
.meta {display:none; font-weight:bold;}
.content_box {padding:20px; background:url(images/transparent80.png) repeat; margin:-22px -20px; font-size:.9425em; line-height:130%; position:absolute; max-width:570px; -moz-border-radius: 10px; -webkit-border-radius: 10px;}
.button {padding:2px; border:1px solid #333333; background:#222; color:#FFFFFF;}
.button:hover {border-color:#666666; background:#444;}
.button:active {border-color:#666666; background:#000;}
.form_element {margin-bottom:20px;}
.form_element input, .form_element select {background:#FFFFFF; border:1px solid #333333; padding:3px; width:250px;}
.secondary_text {color:#999999; font-size:12px;}
.manage_list {clear:both; padding:4px; display:block; border-top:1px solid #999999; cursor:default;}
.manage_list:hover {background:#333333;}
.manage_list div.left {float:left; padding-right:40px; min-width:260px; cursor:default;}
.manage_list div.left:hover {color:#99A8F4;}
.manage_list div.right {float:right;}
.manage_list div.right a, .delete {color:#C8695F; padding:3px;}
.manage_list div.right a:hover {background:#C8695F; color:#FFF;}
.manage_list div.right span {padding-right:10px; color:#CCCCCC;}
.manage_list span.thumb {display:none; position:absolute; left:-122px; z-index:2000;}
.manage_list:hover span.thumb {display:inline;}

/* portfolio viewer */
.icon_holder {float:left; margin:2px;}
.icon_holder p {display:none;}
.icon {border:1px solid #000;}
.strip {overflow:hidden;}
.strip p {display:none;}
.overlay {position:fixed; top:0; left:0; height:100%; width:100%; opacity:0; filter:alpha(opacity=0); z-index:999; background:<? echo $lb_color; ?> url(images/<? if(strtolower(substr($lb_color, 0, 4)) == "#fff"){ $loader_img = "loading_wh.gif"; } else { $loader_img = "loading.gif"; } echo $loader_img; ?>) no-repeat center;}
/* .overlay span.close {position:fixed; top:10px; right:12px; width:18px; height:18px; background:url(images/xclose.png) no-repeat; cursor:pointer;} */
.container {position:absolute; opacity:0; filter:alpha(opacity=0); left:-9999em; z-index:1000; overflow:hidden; display:block; cursor:default;}
.container img {border:1px solid #1C1C1C;}
.container span.nav {height:100%; width:40%; position:absolute; top:0px; cursor:pointer; opacity:.001; filter:alpha(opacity=.001);}
.container span.navLeft {left:0; background:url(images/navleft.png) no-repeat 20% 50%;}
.container span.navRight {right:0; background:url(images/navright.png) no-repeat 80% 50%;}
.container div.caption {background:url(images/transparent80.png) repeat; padding:6px 12px; z-index:1009; display:block; position:relative; bottom:50px; height:9999px;}
.container p {font-size:1.15em; padding-bottom:4px; display:block;}
.container p span {font-size:.75em; color:#DDD; padding-top:3px; display:block;}
.container #titles {padding:3px; display:block;}

/* settings and info form */
#box_settings div, #box_customization div {margin-bottom:8px;}
#box_settings div input, #box_customization div input {width:280px; padding:3px; border:#D0D7F2 inset 1px; font-weight:bold;}
#box_settings div textarea {width:450px; height:200px; padding:3px; border:#D0D7F2 inset 1px; font-size:12px; background:#FFFFFF;}
#box_customization .categories {width:420px;}
#box_customization .color_chooser {width:150px; float:left;}
#box_customization .color_chooser input {width:100px; padding:3px; border:#D0D7F2 inset 1px; font-weight:bold;}
#box_customization .color_chooser select {width:126px; float:left;}
</style>

<!--[if lte IE 8]>
	<style type="text/css">
		.side_links a {background:none;}
	</style>
<![endif]-->

<!--[if IE]>
	<style type="text/css" media="screen">
	@font-face {
		font-family:'Font';
		src: url('graublauweb.eot');
	}
	</style>
<![endif]-->
