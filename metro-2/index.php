<?php
/* METRO UI TEMPLATE v2.0.2
/* Copyright 2012 Thomas Verelst, http://metro-webdesign.info
/* Do not redistribute or sell this template, nor claim this is your own work. 
/* For commercial use, please think about donating. */

require_once('config.php');
require_once('jsminplus.php');

/* FILES*/
$cssFiles = array( /* Add your css files to this array */
	'css/main.css',
	'css/tiles.css',
	'css/misc.css'
);
$jsFiles = array( /* Add your js files to this array */
	'js/plugins.js',
	'js/config.js',
	'js/tiles.js',
	'js/functions.js',
	'js/main.js'
);


/*CSS COMPRESS*/
$css = '';
if($enableCompressionCss){
	if(!file_exists("compress/compressed.css")){
		$handle = fopen("compress/compressed.css",'w');	
		$compressedCss = '';
		foreach ($cssFiles as $cssFile) {
	  		$compressedCss .= file_get_contents($cssFile);
		}
		$compressedCss = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $compressedCss);// Remove comments
		$compressedCss = str_replace(': ', ':', $compressedCss);// Remove space after colons
		$compressedCss = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $compressedCss);// Remove whitespace
		fwrite($handle,$compressedCss);
	}
	$css = '<link rel="stylesheet" type="text/css" href="compress/compressed.css" />';
}else{
	foreach($cssFiles as $cssFile){
		$css .= '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" />';
	}
}
/*JAVASCRIPT COMPRESS*/
$js = '';
if($enableCompressionJs){
	if(!file_exists("compress/compressed.js")){
		$handle = fopen("compress/compressed.js",'w');	
		$compressedJs = '';
		foreach ($jsFiles as $jsFile) {
	  		$compressedJs .= file_get_contents($jsFile)."\n";
		}
		$compressedJs = JSMinPlus::minify($compressedJs);
		fwrite($handle,$compressedJs);	
	}
	$js = '<script type="text/javascript" src="compress/compressed.js" /></script>';
}else{
	foreach($jsFiles as $jsFile){
		$js .= '<script type="text/javascript" src="'.$jsFile.'" /></script>';
	}
}

/*SEO OPTIMIZATION */
if(isset($_GET['_escaped_fragment_'])){ /* If Google is crawling our pages */
    $bot = true; /* The bot is here! */
	$js = ''; // Mr. Google doesnt like Javascript
    $pages = explode("&",$_GET['_escaped_fragment_']);$page = str_replace("_"," ",$pages[0]); /* Get the page he wants from the url */
	
	/*Fake our menu for crawling*/
	$links = '<a href="#!">Home</a> | ';
	foreach($pageLink as $i => $name){
		$links .= "<a href=#!".str_replace(" ","_",$i).">".$i."</a> | ";
	}
	/* Please leave the following line, you get this framework, for free, and I worked 100's of hours on it and give support, 
	   and nobody will see this url... */
	$links .= "<a href='http://metro-webdesign.info'>Free Metro UI templating framework</a>";
}else{$bot = false;}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?php echo $siteDescription?>"/>
    <meta name="keywords" content="<?php echo $siteKeywords?>"/>
    <meta http-equiv="language" content="EN"/>
	<title><?php echo $siteTitle?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'><!-- Include a nicce font -->
	<?php echo $css//include css lines?>  
    <!--[if lte IE 8]>
	<style>
    #leftArrow{filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);}
    </style>
	<![endif]-->
    <script>
	siteTitle = "<?php echo $siteTitle?>";
	siteTitleHome = "<?php echo $siteTitleHome?>";
	</script>
    
    <script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
    <?php echo $js//include js lines?>
    
    <?php if($enableBackgroundImg):?> <!-- stretch a background image to cover the whole page -->
		<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
		<script type="text/javascript">$.backstretch("<?php echo $backgroundImg?>");</script>
    <?php endif; ?>
</head>
<body style="background-color:<?php echo $backgroundColor?>;">
<div id="catchScroll"></div>
<div id="wrapper">
	<div id="header">
		<a id="siteTitle" href="#"><?php echo $siteName?></a>
        <div id="nav"></div>
   		<div id="navStripe"></div>
	</div>
   	<div id="content">
		<!--You can place here some content that will be seen by non-javascript users-->
		<?php
		if($bot){
			echo "<br/><br/>".$links;
			if($page == "" || $page == "home"){
				/* You can echo here a description of your site too for better SEO.
				   Example: echo "This is the demo of the Metro UI templating framework."*/
			}else{
				if(isset($pageLink[$page]) && file_exists("pages/".$pageLink[$page])){
					include("pages/".$pageLink[$page]);
				}	
			}
			
		}
		?>
	</div>
	<a id="footer" href="http://metro-webdesign.info" alt="Metro UI template"><!--Please leave this link --><?php echo $siteFooter?></a>  
</div>
</body>
</html>