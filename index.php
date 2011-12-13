<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Labs</title>
  <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="stylesheets/foundation.css">
  <link rel="stylesheet" href="stylesheets/app.css">
  <link rel="stylesheet" href="stylesheets/flickrbomb.css">
  <!--[if lt IE 9]>
  <link rel="stylesheet" href="stylesheets/ie.css">
  <![endif]-->
  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <h1>Yeah baby, Labs!</h1>
        <h4 class="subheader">Logo, print and web design. Browse &amp; enjoy.</h4>
      </div>
    </div>
    <div class="row">
      <div class="twelve columns">
        <div id="featured">
          <div style="text-align:center;background:url(images/logo128.png) #e9e9e9 no-repeat center"></div>
          <img src="http://placehold.it/980x150/E9E9E9/DF3030&text=Here we make experiments..." data-caption="#caption1" alt="" />
          <img src="http://placehold.it/980x150/E9E9E9/DF3030&text=...and then we bring them alive." alt="" />
        </div>
        <div class="orbit-caption" id="caption1" style="display:none;"><strong>I'm A Badass Caption:</strong> I can haz <a href="#">links</a>, <em>style</em> or anything that is valid markup :)</div>
      </div>
    </div>
    <div class="row">
      <div class="nine columns">
        <section id="container">
          <ul id="stage">
            <li data-tags="print design">Lab Name</li>
            <li data-tags="logo design,print design">Lab Name</li>
            <li data-tags="web design,logo design"><a href="#">Lab Name</a></li>
            <li data-tags="web design,print design"><a href="#">Lab Name</a></li>
            <li data-tags="logo design">Lab Name</li>
            <li data-tags="web design,logo design,print design"><a href="#">Lab Name</a></li>
            <li data-tags="logo design,print design">Lab Name</li>
            <li data-tags="web design"><a href="#">Lab Name</a></li>
            <li data-tags="web design,logo design"><a href="#">Lab Name</a></li>
            <li data-tags="web design"><a href="#">Lab Name</a></li>
            <li data-tags="logo design,print design">Lab Name</li>
            <li data-tags="logo design,print design">Lab Name</li>
            <li data-tags="print design">Lab Name</li>
            <li data-tags="web design,logo design"><a href="#">Lab Name</a></li>
            <li data-tags="print design">Lab Name</li>
            <li data-tags="logo design">Lab Name</li>
            <li data-tags="web design,logo design,print design"><a href="#">Lab Name</a></li>
            <li data-tags="web design"><a href="#">Lab Name</a></li>
            <li data-tags="web design,print design"><a href="#">Lab Name</a></li>
            <li data-tags="logo design,print design">Lab Name</li>
            <li data-tags="web design,logo design"><a href="#">Lab Name</a></li>
            <li data-tags="print design">Lab Name</li>
            <li data-tags="logo design,print design">Lab Name</li>
            <?php /***
            <?php $dir='labs'; $files=array_diff(scandir($dir, 0),array(".","..",".DS_Store")); foreach($files as $file){ ?>
            <?php if (substr($file,0,1) == '_') $tag="resources"; elseif (substr($file,0,1) == '#') $tag="skata"; else $tag="labs"; ?>

            <li data-tags="<?php echo $tag; ?>">
              <a href="<?php echo $dir."/".$file;?>">
                <img title="<?php echo $file;?>" src="http://placehold.it/229x100/E9E9E9/DF3030&text=Lab" />
              </a>
            </li>
            <?php } ?>
            ***/ ?>
          </ul>
        </section>
      </div>
      <div class="three columns">
        <nav id="filter"></nav>
        <dl class="nice tabs vertical hide-on-phones">
          <dd><a href="#" class="active">Home</a></dd>
          <dd><a href="#">Menu#1</a></dd>
          <dd><a href="#">Menu#2</a></dd>
          <dd><a href="#">Menu#3</a></dd>
        </dl>
      </div>
    </div>
    <!-- <div class="row">
      <div class="twelve columns">
        <dl class="nice contained tabs">
          <dd><a href="#nice1" class="active">Nice Tab 1</a></dd>
          <dd><a href="#nice2">Nice Tab 2</a></dd>
          <dd><a href="#nice3">Nice Tab 3</a></dd>
        </dl>
        <ul class="nice tabs-content contained">
          <li class="active" id="nice1Tab">This is nice tab 1's content. Pretty neat, huh?</li>
          <li id="nice2Tab">This is nice tab 2's content. Now you see it!</li>
          <li id="nice3Tab">This is nice tab 3's content. It's, you know...okay.</li>
        </ul>
      </div>
    </div> -->
  </div>
  <script src="javascripts/foundation.js"></script>
  <script src="javascripts/app.js"></script>
  <script src="javascripts/quicksand.js"></script>
  <script src="javascripts/quicksand-app.js"></script>
  <!-- <script src="javascripts/flickrbomb.js"></script> -->
</body>
</html>
