$(window).ready(function(){
  $(document).on('click', '#slider-nav .slide', function() {
  	var maxImgNb = 2;
  	var imgNumber = $("#slider-nav #img-view img").length;

  	var slideId = $(this).attr('id');

  	var imgId = parseInt($('#slider-nav #img-view img.active').attr('id'), 10);
  	console.log(imgId);

  	var nextImg;

  	if(slideId == "slide-left"){
  		if(imgId > 1){
  			nextImg = --imgId;
  		}else {
  			nextImg = maxImgNb;
  	   }
  	}else {
  		if(imgId < maxImgNb){
  			nextImg = ++imgId;
  		}else {
  			nextImg = 1;
  		}
  	}

  	changeSlider(nextImg);
  });

  $(document).on('click', '#slider-nav #img-view img.unactive', function() {
  	var imgId = $(this).attr('id');
  	changeSlider(imgId);
  });
});
