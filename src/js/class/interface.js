var Interface = {
  ajaxContainer: "",
  newsbarText: "",
  newsbarTextContainerWidth: "",
  newsbarTextWidth: "",
  newsbarWidth: "",

  init: function(){
    this.ajaxContainer = $('#ajax-loader #ajax-container');
    this.headerContainer = $('#header-container');
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

          $.post(App.phpPath+"executor.php", { action: 'loadModel', modelName: modelName, argPage: argPage }, function( data ) {
            Engine.historyPushState(modelName, argPage);
            Interface.ajaxContainer.html(data.reply).stop().animate({'opacity': '1'}, 400);
            Interface.activeNavLi(modelName);
          }, 'json');

          $(this).dequeue();
        });
      }
    }
  },

  loadHeader: function(){
    this.headerContainer.stop().animate({'opacity': '0'}, 100).queue(function(){
      $.post( App.phpPath+"executor.php", { action: 'loadModel', modelName: 'header', argPage: null }, function( data ) {
        Interface.headerContainer.html(data.reply).stop().animate({'opacity': '1'}, 400);
        Interface.newsBarTextScroll();
      }, 'json');
      $(this).dequeue();
    });
  },

  activeNavLi: function(pageName){
  	$("#menu-nav ul li").attr('class', 'unactive');
  	$("#menu-nav ul li[name='"+pageName+"']").attr('class', 'active');
  },

  newsBarTextScroll: function(){
    var newsbarText = $('#news-bar p');
    var newsbarTextContainerWidth = $('#news-bar p').width();
    var newsbarTextWidth = $('#news-bar p').textWidth();
    var newsbarWidth = newsbarTextContainerWidth + newsbarTextWidth;

  	newsbarText.css({'margin-right': -50});
  	newsbarText.css({'margin-left': newsbarTextContainerWidth});

  	newsbarText.animate({
  		'margin-left': '-'+newsbarTextWidth+'px'
  	}, 50000, "linear").queue(function(){
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
