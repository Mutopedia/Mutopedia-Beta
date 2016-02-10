var Engine = {
  documentTitle: "",

  init: function(){
    this.documentTitle = document.title;
  },

  fileExists: function(filePath){
    if(filePath){
      var http = new XMLHttpRequest();
      http.open('HEAD', filePath, false);
      http.send();
      return http.status==200;
    }else {
      return false;
    }
  },

  historyPushState: function(modelName, argName){
    document.title = this.documentTitle + ' | ' + modelName.toUpperCase();
    if (modelName) {
      if(argName == null) {
        window.history.pushState({'pageName': modelName}, modelName, modelName);
      }else{
        window.history.pushState({'pageName': modelName, 'argName': argName}, modelName+'/'+argName, modelName+'/'+argName);
      }
    }
  },

  AcceptCookies: function(){
  	var today = new Date(), expires = new Date();
  	expires.setTime(today.getTime() + (365*24*60*60*1000));
  	document.cookie = "AcceptationCookies =" + encodeURIComponent(1) + ";expires=" + expires.toGMTString();

  	Interface.closePopUp();
  },

  getCookie: function(cookieName){
      var oRegex = new RegExp("(?:; )?" + cookieName + "=([^;]*);?");

  	if (oRegex.test(document.cookie)){
  		return decodeURIComponent(RegExp["$1"]);
  	}else {
  		return null;
  	}
  },

  checkAcceptationCookies: function(){
  	var cookieValue = getCookie('AcceptationCookies');

  	if(cookieValue != 1){
  		showPopUp('cookiesPrivacy');
  	}else {
  		closePopUp();
  	}
  },

  openInNewTab: function(url) {
    var win = window.open(url, '_blank');
    win.focus();
  },

  searchSpecimen: function(specimenName, searchDiv){
  	searchDiv.parent().children('.ul').fadeOut(100).html('<h2 style="text-align: center;">Loading ...</h2>').fadeIn(100);

  	$.post("src/php/executor.php", { action: "searchSpecimen", specimenName: specimenName}, function(data)
  	{
  		searchDiv.parent().children('.ul').fadeOut(100).queue(function() {
  			$(this).html(data.reply).queue(function() {
  				$(this).fadeIn(100);
  				$(this).dequeue();
  			});
  			$(this).dequeue();
  		});

  	}, "json");
  },

  startBreeding: function(){
  	var specimenNameCode_1 = $('#left_panel .select').attr('value');
  	var specimenNameCode_2 = $('#right_panel .select').attr('value');

  	$('#odds_container').fadeOut(200).queue(function()
  	{
  		$(this).html('<h2 style="text-align: center;">Breeding in progress ...</h2>').fadeIn(200).queue(function()
  		{
  			$.post("src/php/executor.php", { action: "startBreeding", specimenNameCode_1: specimenNameCode_1, specimenNameCode_2: specimenNameCode_2}, function(data)
  			{
  				if(data.result)
  				{
  					$('#odds_container').fadeOut(200).queue(function(){
  						$(this).html(data.reply).fadeIn(300);
  						$(this).dequeue();
  					});
  				}
  				else
  				{
  					$('#odds_container').fadeOut(200).queue(function(){
  						$(this).html(data.error).fadeIn(300);
  						$(this).dequeue();
  					});
  				}

  			}, "json");

  			$(this).dequeue();
  		});
  		$(this).dequeue();
  	});
  },

  logUser: function(userid, userfirstname, userlastname, userpic){
  	$.post("src/php/executor.php", { action: "logUser", userid: userid, userfirstname: userfirstname, userlastname: userlastname, userpic: userpic}, function(data){
  		if(data.result){
  			console.log(data.reply);
  			Interface.loadHeader();
  		}
  		if(data.error != null){
  			console.log(data.error);
  		}

  	}, "json");
  },

  searchUsers: function(searchContent){
  	var sortByValue = $("#search-container #option-sort-container .select").attr('value');

  	$('#search-container #result-container').stop().fadeOut(100).html('<h2 style="text-align: center;">Loading ...</h2>').fadeIn(200).queue(function(){
  		$.post("src/php/executor.php", { action: "searchUsers", searchContent: searchContent, sortByValue: sortByValue}, function(data){
  			if(data.result){
  				$('#search-container #error-container').fadeOut(200).queue(function(){
  					$('#search-container #result-container').fadeOut(200).queue(function() {
  						$(this).html(data.reply).queue(function() {
  							$(this).fadeIn(400);
  							$(this).dequeue();
  						});
  						$(this).dequeue();
  					});
  					$(this).dequeue();
  				});
  			}else {
  				$('#search-container #result-container').fadeOut(200).queue(function(){
  					$('#search-container #error-container').fadeOut(200).html('<h2 style="text-align: center;">Loading ...</h2>').fadeIn(200).queue(function() {
  						$(this).children('h2').fadeOut(200).html(data.error).parent().fadeIn(200);
  						$(this).dequeue();
  					});
  					$(this).dequeue();
  				});
  			}

  		}, "json");

  		$(this).dequeue();
  	});
  },

  getReleaseCounter: function(releaseName){
  	$.post("src/php/executor.php", { action: "getReleaseDate", releaseName: releaseName}, function(data)
  	{
  		$('#portal-container #counter-container #counter').html(data.reply);

  		console.log(data.reply);
  		if(data.error != null){
  			console.log(data.error);
  		}

  	}, "json");

  	setTimeout("getReleaseCounter('portal')", 1000);
  },

  changeFbPermission: function(state){
  	$.post("src/php/executor.php", { action: "changeFbPermission", state: state}, function(data){
  		if(data.error != null){
  			console.log(data.error);
  		}else{
  			console.log(data.reply);
  		}
  	}, "json");
  },

  changeCharterAcceptance: function(state){
  	$.post("src/php/executor.php", { action: "changeCharterAcceptance", state: state}, function(data){
  		if(data.error != null){
  			console.log(data.error);
  		}else{
  			console.log(data.reply);
  			console.log(data.return);

  			if(data.result){
  				if(data.return == 'true'){
  					$('#profile-container #infos-container #user-info-container #charter-acceptance-blocker').removeClass('activate').addClass('unactivate');
  				}else{
  					$('#profile-container #infos-container #user-info-container #charter-acceptance-blocker').removeClass('unactivate').addClass('activate');
  				}
  			}
  		}
  	}, "json");
  },

  changeUserMutant: function(mutantNameCode){
  	$.post("src/php/executor.php", { action: "changeUserMutant", mutantNameCode: mutantNameCode}, function(data){
  		if(data.error != null){
  			console.log(data.error);
  		}else{
  			console.log(data.reply);
  		}
  	}, "json");
  },

  changeUserCenterLevel: function(centerLevel){
  	$.post("src/php/executor.php", { action: "changeUserCenterLevel", centerLevel: centerLevel}, function(data)
  	{
  		if(data.error != null){
  			console.log(data.error);
  		}else{
  			console.log(data.reply);
  		}
  	}, "json");
  },

  changeUserFameLevel: function(fameLevel){
  	$.post("src/php/executor.php", { action: "changeUserFameLevel", fameLevel: fameLevel}, function(data){
  		if(data.error != null){
  			console.log(data.error);
  		}else{
  			console.log(data.reply);
  		}
  	}, "json");
  },

  sendReport: function(reported_player){
  	var report_message = $('.popup-box#report-box .box-content #report_message').val();

  	$.post("src/php/executor.php", { action: "reportPlayer", reported_player: reported_player, report_message: report_message}, function(data){
  		if(data.result){
  			$('.popup-box#report-box .box-content ul li:nth-child(2)').fadeOut(200);
  			$('.popup-box#report-box .box-content ul li:first-child p').fadeOut(200).html(data.reply).fadeIn(200);
  			$('.popup-box#report-box .box-content ul li:last-child .button').attr("onclick", "Interface.closePopUp('report-box');").children('p').html('Finish !');
  		}
  		if(data.error != null){
  			$('.popup-box#report-box .box-content ul li:first-child p').fadeOut(200).html(data.error).fadeIn(200);
  		}
  	}, "json");
  }
}

$(window).scroll(function() {
  if(history.state.pageName !== 'portal'){
    if($(window).scrollTop() < $('#news-bar').offset().top){
      $('#menu-nav').css({'position': 'relative', 'margin-top': '0', 'box-shadow': 'none'});
    }
    else if(($(window).scrollTop() + 52) > $('#menu-nav').offset().top){
      $('header #header-container').css({'height': '121px'});
      $('#menu-nav').css({'position': 'fixed', 'margin-top': '-62px', 'box-shadow': '0px 0px 15px 10px rgba(0, 0, 0, 1)'});
    }
  }
});

$(window).ready(function() {
  if(typeof history.pushState == 'undefined'){
  	alert("Your browser is out of date !");
  }else{
    if(history.state.pageName == 'portal'){
  		getReleaseCounter('portal');
    }

    window.onpopstate = function(event){
      if(event.state){
        Interface.loadModel(event.state.pageName);
      }
    }
  }
});

$(window).resize(function(){
  Interface.newsBarTextScroll();
});

$.fn.textWidth = function(text, font){
	if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
	$.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
	return $.fn.textWidth.fakeEl.width();
};
