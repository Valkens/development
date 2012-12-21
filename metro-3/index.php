<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/* METRO UI TEMPLATE v3.0.0
/* Copyright 2012 Thomas Verelst, http://metro-webdesign.info
/* Do not redistribute or sell this template, nor claim this is your own work. 
/* Donation required when using this online. */

require_once('config.php');

/* FILES*/
$cssFiles = array( /* Add your css files to this array */
	'css/main.css',
	'css/nav.css',
	'css/tiles.css',
	'themes/'.$theme.'/theme.css',
	'css/your.css'
);
$jsFiles = array( /* Add your js files to this array */
	'js/config.js',
	'js/tiles.js',
	'js/inc/functions.js',
	'js/inc/main.js'
);
$iecss='themes/'.$theme.'/theme_ie.php'; 

require_once("inc/compress.php");
require_once("inc/seo.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?php echo $siteMetaDesc;?>"/>
    <meta name="keywords" content="<?php echo $siteMetaKeywords;?>"/>
	<title><?php echo $siteTitle;?></title> 
    <meta name="viewport" content="width=200, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'><!-- Include a nice font -->
	<?php echo $css; if(file_exists($iecss)){include($iecss);};//include css lines?>  
    <script>
	siteTitle = "<?php echo $siteTitle;?>";
	siteTitleHome = "<?php echo $siteTitleHome;?>";
	enableMobile = "false";
	theme = "<?php echo $theme?>";
	</script>    
    <script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script> 
    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/inc/jquery181.js"><\/script>')</script>
    <?php echo $js;//include js lines?>
</head>
<body>
<div id="headerWrapper">
	<?php include("header.php");echo $plHeader;?>   
</div>
<div id="wrapper">   
    <div id="contentWrapper">
   		<div id="subNavWrapper">
	    	<div id="subNav"><?php if($bot){echo "<br/>".$links;}?></div>
            <?php echo $plSubNavWrapper;?>
		</div>
   		<div id="content">
            <noscript>It seems your browser doesn't support Javascript.<br /></noscript>
			<?php
			if($bot){
				echo "<br/>";	
				if($page == "" || $page == "home"){	
					/* You can echo here a description of your site too for better SEO. 
					It is recommend to add the content of your tiles here if you do not have the no-javascript version of the mobile template enabled.
					(because google won't see your tiles, as it's javascript)
					Example: echo "This is the demo of the Metro UI templating framework."*/			
				}else{
					if($reqUrl != "" && file_exists("pages/".$reqUrl)){		
						include("pages/".$reqUrl);
					}else{		
						echo "<h2 style='margin-top:0px;'>We're sorry :(</h2>the page you're looking for is not found.";
					}
				}		
			}
			?>
        </div>
         <?php echo $plContentWrapper;?>
	</div>
	<a id="footer" href="http://metro-webdesign.info" title="Metro UI template" alt="Metro UI template"><?php /*<-Please leave this link, only donators may remove this!*/
	echo $siteFooter;
	?></a>
    <?php echo $plBody;?>
</div>
</body>
</html>