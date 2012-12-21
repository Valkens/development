<div id="header">
	<div id="headerTitles">
		<h1><a href="#!"><?php echo $siteName?></a></h1>
   		<h2><?php echo $siteDesc;?></h2>
    </div>
    <div id="nav">
    	<?php echo $plNav;
		/* Look at this to edit your own titles, the href is from your url bar when you scroll to the corresponding tilegroup, it's the part after the # with the # included. */?>
	    <a id="home" class="navItem"  href="#&home">
	    	<img src="img/icons/home.png"/><br />
		   	HOME
	    </a>
	   	<a id="my_images" class="navItem" href="#&some_images">
		    <img src="img/icons/download_s.png"/><br />
		  	MY IMAGES
	    </a>
	    <a id="slideshows" class="navItem" href="#&slideshows">
		    <img src="img/icons/questionmark.png"/><br />
		   	SLIDESHOWS
	    </a>
	</div>
</div>