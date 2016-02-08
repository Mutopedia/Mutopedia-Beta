var Interface = {
  ajaxContainer: "",
  newsbarText: "",
  newsbarTextContainerWidth: "",
  newsbarTextWidth: "",
  newsbarWidth: "",

  init: function(){
    this.ajaxContainer = $('#ajax-loader #ajax-container');
    this.headerContainer = $('#header-container');
    this.newsbarText = $('#news-bar p');
    this.newsbarTextContainerWidth = $('#news-bar p').width();
    this.newsbarTextWidth = $('#news-bar p').textWidth();
    this.newsbarWidth = this.newsbarTextContainerWidth + this.newsbarTextWidth;

    this.newsbarText.css({'margin-right': -50});
  },

  loadModel: function(modelName, argPage){
    if(modelName){
      if(Engine.fileExists(App.modelsPath+modelName+".php")){
        this.ajaxContainer.stop().animate({'opacity': '0'}, 200).queue(function(){
          if(Engine.fileExists(App.cssPath+modelName+".css")){
            var currentStylesheet = $('link[name='+modelName+']');
            if(currentStylesheet){
              currentStylesheet.remove();
            }
            $('link.default-stylesheet').after('<link name="'+modelName+'" rel="stylesheet" type="text/css" href="'+App.cssPath+modelName+".css"+'"></link>');
          }
          if(Engine.fileExists(App.animationsPath+modelName+".js")){
            var currentAnimation = $('script[name='+modelName+']');
            if(currentStylesheet){
              currentAnimation.remove();
            }
            $('script.default-animation').after('<script name="'+modelName+'" type="text/javascript" src="'+App.animationsPath+modelName+".js"+'"></script>');
          }
          $(this).load(App.modelsPath+modelName+".php", function() {
            Engine.historyPushState(modelName, argPage);
            $(this).stop().animate({'opacity': '1'}, 400);
          });
          $(this).dequeue();
        });
      }
    }
  },

  loadHeader: function(){
    this.headerContainer.stop().animate({'opacity': '0'}, 100).queue(function(){
      $(this).load(App.modelsPath+"header.php", function() {
        $(this).stop().animate({'opacity': '1'}, 200);
      });
      $(this).dequeue();
    });
  },

  activeNavLi: function(){
  	$("#menu-nav ul li").attr('class', 'unactive');
  	$("#menu-nav ul li[name='"+history.state.pageName+"']").attr('class', 'active');
  },

  newsBarTextScroll: function(){
  	this.newsbarText.css({'margin-left': this.newsbarTextContainerWidth});

  	this.newsbarText.animate({
  		'margin-left': '-'+this.newsbarTextWidth+'px'
  	}, 35000, "linear").queue(function(){
  		Interface.newsBarTextScroll();
  		$(this).dequeue();
  	});
  },

  changeSlider: function(imgId){
  	$('#slider #img-container img').fadeOut(300).queue(function(){
  		$(this).attr('src', "slider/img_"+imgId+".jpg");
  		$(this).fadeIn(300);
  		$(this).dequeue();
  	});

  	$('#slider-nav #img-view img').switchClass("active", "unactive", "easeInOut");
  	$('#slider-nav #img-view img#'+imgId).switchClass("unactive", "active", "easeInOut");
  },

  showPopUp: function(name){
  	Interface.showBackground();
  	$('#'+ name +'.popup-box').stop().fadeIn(200);
  },

  closePopUp: function(name){
  	$('#'+ name +'.popup-box').stop().fadeOut(400);
  	Interface.closeBackground();
  },

  showBackground: function(){
  	$('#background-container').stop().fadeIn(400);
  },

  closeBackground: function(){
  	$('#background-container').stop().fadeOut(600);
  }
}
