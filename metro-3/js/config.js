/* METRO UI TEMPLATE
/* Copyright 2012 Thomas Verelst, http://metro-webdesign.info

/*GENERAL SETTINGS VARS */
$tile.scale = 145;
$tile.spacing = 10;

$group.spacing = 700;//Space between the first elements of groups of tiles on the homepage.
$group.titles = new Array("Home","Some images","Slideshows");
$group.inactive.opacity = 1;//opacity of inactive tiles (tiles that are not in the current tilegroup) , set to 0 for invisible, 1 for fully visible and any value between for transparent
$group.inactive.clickable  = true;/* can users click tiles that are not in the current tileGroup? If false, a click on a tile of another tilegroup will make the screen go to that tilegroup
It doesnt work when opaTiles = 1, and if opaTiles is a value close to 1, it is recommend to set this to TRUE!! otherwise this is very confusing */
$group.showEffect = 0; // Only works when opaTiles = 1 || 0= each tile one after one, cool effect || 1 = fade in together || 2 = increase size

$page.showSpeed = 400;// how fast the content is fade in
$page.hideSpeed = 300;//how fast should the content fade out when switching pages

jQuery.fx.interval=25; // Smoothness of effects, higher = less smooth & less CPU utilization. Too low can be choppy! default 25

/*PAGES information: EVERY page on your site that must be opened with the framework must be included here, see tutorial for more information */
pageLink= new Array(); /* the index of pageLink MUST be the pagename (like it will be shown in the titlebar)*/
pageLink['Typography'] = 'typography.php';
pageLink['Slider example'] = 'sliders.php';
pageLink['Images 1'] = 'myimages.html';
pageLink['Images 2'] = 'otherimages.php';
pageLink['Images 3'] = 'images3.php';
pageLink['Terms of service'] = 'tos.php';