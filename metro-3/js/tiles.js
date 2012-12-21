/*TILES*/
tiles = function(){ /*Insert your own tiles here*/

	/* READ THE TUTORIAL AT METRO-WEBDESIGN.INFO */
	tileTitleText(0,0,0,2,1,'#789600','external:http://metro-webdesign.info','Welcome','This is the Lite version of the template!! Many tiles and functions are not included. This version is for testing purposes. For real use, go to http://metro-webdesign.info and Donate to get the full version!',['','',''],'');
	tileLive(0,2,0,1,1,"#C33","","Live tile","","","","",3000,["Welcome","Be Creative","And make it yours","Change the tiles...","..the tile config is just an example"],['','',''],"noClick");

	tileTitleText(0,0,1,1,1,"#F90","Typography","<h3 class='white' style='font-weight:lighter'>Typography</h3>","",['','',''],'');
	tileTitleTextImage(0,1,1,2,1,"#F60","","","Please read the tutorial at <br> <strong>http://metro-webdesign.info</strong> when you start. Remember this is the lite version, many functions are not supported! Donate to get many Cool FX tiles, compressing system, mobile version, no-javascript version, Admin Panel with file-editing, ...","",0,0,0,['','',''],'noClick');
	
	tileImageSlider(0,0,2,2,1,'#854C8F','Terms of service','img/bg/img_300x145.jpg',1,"<h4 class='white'>Terms of Use! Must read!</h4>",0.4,['Must read','#854C8F','top'],'');
	tileImageSlider(0,2,2,1,1,"#BBB","#&slideshows","img/arrows/arrowRight.png",0.3,"<h5 class='align-center'>Go to last tilegroup</h5>",0.5,['','',''],'');
	
	tileLive(0,1,3,2,1,"#3B659C","Slider Example","Another live tile","img/icons/box_hint.png",50,2,5,6000,['With an image','As example'],['Click for slider page','#789600','bottom'],'');
	
	/*GROUP 2 */
	
	
	tileImg(1,0,0,1,1,"#F60","Images 3","img/bg/img_square.jpg",1,1,['Image, hover','#789600','bottom','Some description',true],'');
	tileImg(1,1,0,1,1,"#F90","","img/bg/img_square.jpg",1,1,['Test','#F90','top','Label at top',true],'noClick');
	tileImg(1,2,0,1,1,"#C33","","img/bg/img_square.jpg",1,1,['Another','#C33','bottom','Some description',false],'noClick');
	
	/*GROUP 3 */
	/*Fadeslide and fliphorizontal are effects, other options are 'fade','flipvertical'*/
	tileSlideshow(2,0,0,2,2,"","",5000,true,"fadeslide",["img/bg/img1.png","img/bg/img2.jpg","img/bg/img3.jpg"],['Slideshow','#789600','top'],'noClick');
	tileSlideshow(2,0,2,1,1,"","",2500,false,"fliphorizontal",["img/bg/img1.png","img/bg/img2.jpg","img/bg/img3.jpg"],['','',''],'noClick');
	
	tileCustom(2,1,2,1,1,"#BBB","#&home","<img src='img/arrows/arrowLeft.png' style='margin-top:42px;margin-left:52px;padding-bottom:15px;' height='41'><h4 class='align-center'>Go home</h4>",['','',''],'');
}

/*Tile Templates */
tileTitleText = function(group,x,y,width,height,bg,linkPage,title,text,labelSettings,optClass){ /* Tile with only a title and description */	
	if(labelSettings!='' && labelSettings[0] != ''){
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		if(labelposition=='top'){
			var labelText ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div></div>";
		}else{
			var labelText ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div></div>";
		}
	}else{
		labelText='';
	}
	$page.content += (
	"<a "+makeLink(linkPage)+" class='tile group"+group+" "+optClass+"' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px; margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+(width*$tile.scalespacing-$tile.spacing)+"px; height:"+(height*$tile.scalespacing-$tile.spacing)+"px; \
	background:"+bg+";'>\
	<div class='tileTitle'>"+title+"</div>\
	<div class='tileDesc'>"+text+"</div>\
	"+labelText+"\
	</a>");
}
tileImg = function(group,x,y,width,height,bg,linkPage,img,imgSizeWidth,imgSizeHeight,labelSettings,optClass){
	if(labelSettings!='' && labelSettings[0] != ''){
		var id= "tileimg_"+(group+''+x+''+y).replace(/\./g,'_')
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		var desc=labelSettings[3];
		var showDescOnHover=labelSettings[4];		
		var displayLabel = (showDescOnHover) ? " showOnHover": ""; 
		var labelDescText = (desc!='') ? "<div class='tileLabelDesc "+displayLabel+"'>"+desc+"</div>" : '';	
		if(labelposition=='top'){
			var totalLabel ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div>"+labelDescText+"</div>";
		}else{
			
			var totalLabel ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div>"+labelDescText+"</div>";
		}		
		$(function(){
			$.plugin($afterTilesAppend,{
				tileImg:function(){
					var id2 = id;
					if(labelposition=='top'){
						$("."+id2).bind("mouseenter",function(){$(this).find("div.showOnHover").show(200);});
						$("."+id2).bind("mouseleave",function(){$(this).find("div.showOnHover").stop().hide(200);});
					}else{
						$("."+id2).bind("mouseenter",function(){$(this).find("div.showOnHover").css("bottom",0).slideDown(200);});
						$("."+id2).bind("mouseleave",function(){$(this).find("div.showOnHover").css("top",0).stop().slideUp(200);});	
					}
				}
			});
		});
	}else{
		var id="";
		var totalLabel = "";
	}
	var drawHeight = (imgSizeWidth*$tile.scalespacing-$tile.spacing)
	var drawWidth = (imgSizeHeight*$tile.scalespacing-$tile.spacing)
	var tileHeight = (height*$tile.scalespacing-$tile.spacing)
	var tileWidth = (width*$tile.scalespacing-$tile.spacing)
	$page.content += ("<a "+makeLink(linkPage)+" class='tile tileImg group"+group+" "+id+" "+optClass+"' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px ;margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+tileWidth+"px; height:"+tileHeight+"px; \
	background:"+bg+";'>\
	<img src='"+img+"' width="+drawWidth+" height="+drawHeight+" \
	style='margin-left: "+((tileWidth-drawWidth)*0.5)+"px; \
	margin-top: "+((tileHeight-drawHeight)*0.5)+"px'/>\
	"+totalLabel+"\
	</a>");
}

tileTitleTextImage = function(group,x,y,width,height,bg,linkPage,title,text,img,imgSize,imgToTop,imgToLeft,labelSettings,optClass){ // Tile with an image on the left side, a title, and a description, width is always 2
	if(labelSettings!='' && labelSettings[0] != ''){
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		if(labelposition=='top'){
			var labelText ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div></div>";
		}else{
			var labelText ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div></div>";
		}
	}else{
		labelText='';
	}
	$page.content += (
	"<a "+makeLink(linkPage)+" class='tile group"+group+" "+optClass+"' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px;margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+(width*$tile.scalespacing-$tile.spacing)+"px; height:"+(height*$tile.scalespacing-$tile.spacing)+"px; \
	background:"+bg+";'>\
	<img style='float:left; margin-top:"+imgToTop+"px;margin-left:"+imgToLeft+"px;' src='"+img+"' height="+imgSize+" width="+imgSize+"/> \
	<div class='tileTitle' style='margin-left:"+(imgSize+5+imgToLeft)+"px;'>"+title+"</div>\
	<div class='tileDesc' style='margin-left:"+(imgSize+6+imgToLeft)+"px;'>"+text+"</div>\
	"+labelText+"\
	</a>");
}
tileLive = function(group,x,y,width,height,bg,linkPage,title,img,imgSize,imgToTop,imgToLeft,speed,textArray,labelSettings,optClass){
	if(labelSettings!='' && labelSettings[0] != ''){
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		if(labelposition=='top'){
			var labelText ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div></div>";
		}else{
			var labelText ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div></div>";
		}
	}else{
		labelText='';
	}
	var id= "livetile_"+(group+''+x+''+y).replace(/\./g,'_')
	if(img!=''){
		imgInsert = "<img style='float:left; margin-top:"+imgToTop+"px;margin-left:"+imgToLeft+"px;' src='"+img+"' height="+imgSize+" width="+imgSize+"/>"
	}else{
		imgInsert = '';
		imgSize = 0;
		imgToLeft = 0;
	}
	$page.content += (
	"<a "+makeLink(linkPage)+" class='tile group"+group+" "+optClass+"' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px; margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+(width*$tile.scalespacing-$tile.spacing)+"px; height:"+(height*$tile.scalespacing-$tile.spacing)+"px; \
	background:"+bg+";'>\
	"+imgInsert+"\
	<div class='tileTitle' style='margin-left:"+(imgSize+5+imgToLeft)+"px;'>"+title+"</div>\
	<div class='livetile' style='margin-left:"+(imgSize+10+imgToLeft)+"px;' id='"+id+"' >"+textArray[0]+"</div>\
	"+labelText+"\
	</a>");
	setTimeout(function(){newLiveTile(id,group,textArray,speed,0)},speed); // init this tile
}
tileImageSlider = function(group,x,y,width,height,bg,linkPage,img,imgsize, text,slideDistance,labelSettings,optClass){
	if(labelSettings!='' && labelSettings[0] != ''){
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		if(labelposition=='top'){
			var labelText ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div></div>";
		}else{
			var labelText ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div></div>";
		}
	}else{
		labelText='';
	}
	tileWidth = width*$tile.scalespacing-$tile.spacing
	tileHeight = height*$tile.scalespacing-$tile.spacing
	$page.content += ("<a "+makeLink(linkPage)+" class='tile group"+group+" "+optClass+" tileImageSlider' id='"+slideDistance+" ' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px;margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+tileWidth+"px; height:"+tileHeight+"px; \
	background:"+bg+"; text-align:center;'>\
	<div class='tileImageSliderWrapper' style='position:absolute;'>\
	<div style='width: "+tileWidth+"px; height:"+tileHeight+"px;'>\
	<img src='"+img+"' height="+tileHeight*imgsize+" style='margin-top: "+((tileHeight-tileHeight*imgsize)*0.5)+"px'/>\
	</div>\
	<div text='tileImageSliderText'>"+text+"</div>\
	"+labelText+"\
	</div>\
	</a>");
	$(document).on("mouseover",'.tileImageSlider',function(){
		$(this).find(".tileImageSliderWrapper").stop(true,false).animate({"margin-top":-$(this).height()*$(this).attr("id")},250,"linear");
	}).on("mouseleave",'.tileImageSlider',function(){
		$(this).find(".tileImageSliderWrapper").stop(true,false).animate({'margin-top':0},300,"linear");
	});
}
tileCustom = function(group,x,y,width,height,bg,linkPage,content,labelSettings,optClass){ // make your own tiles
	if(labelSettings!='' && labelSettings[0] != ''){
		var label=labelSettings[0];
		var labelcolor=labelSettings[1];
		var labelposition=labelSettings[2];
		if(labelposition=='top'){
			var labelText ="<div class='tileLabelWrapper top' style='border-top-color:"+labelcolor+";'><div class='tileLabel top' >"+label+"</div></div>";
		}else{
			var labelText ="<div class='tileLabelWrapper bottom'><div class='tileLabel bottom' style='border-bottom-color:"+labelcolor+";'>"+label+"</div></div>";
		}
	}else{
		labelText='';
	}
	$page.content += (
	"<a "+makeLink(linkPage)+" class='tile group"+group+" "+optClass+"' style=' \
	margin-top:"+((y*$tile.scalespacing)+45)+"px;margin-left:"+(x*$tile.scalespacing+group*$group.spacing)+"px; \
	width: "+(width*$tile.scalespacing-$tile.spacing)+"px; height:"+(height*$tile.scalespacing-$tile.spacing)+"px; \
	background:"+bg+";'>\
	"+content+"\
	"+labelText+"\
	</a>");
}