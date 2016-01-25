var newsbarTextContainerWidth;
var newsbarTextWidth;
var newsbarWidth;

$(window).ready(function()
{
	$('#slider img').fadeOut();

	newsbarTextContainerWidth = $('#news-bar p').width();
	newsbarTextWidth = $('#news-bar p').textWidth();
	newsbarWidth = newsbarTextContainerWidth + newsbarTextWidth;
	$('#news-bar p').css({'margin-right': -50});

	newsBarTextScroll();
});

$(window).resize(function()
{
	newsBarTextScroll();
});

$.fn.textWidth = function(text, font) {
	if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
	$.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
	return $.fn.textWidth.fakeEl.width();
};

function newsBarTextScroll()
{
	$('#news-bar p').css({'margin-left': newsbarTextContainerWidth});
	console.log("newsBarTextScroll >> newsbarTextContainerWidth :" + newsbarTextContainerWidth);
	console.log("newsBarTextScroll >> newsbarWidth :" + newsbarWidth);

	$('#news-bar p').animate({
		'margin-left': '-'+newsbarTextWidth+'px'
	}, 35000, "linear").queue(function(){
		newsBarTextScroll();
		$(this).dequeue();
	});
}

$(document).on('click', '#slider-nav .slide', function() 
{
	var maxImgNb = 2;
	var imgNumber = $("#slider-nav #img-view img").length;

	var slideId = $(this).attr('id');

	var imgId = parseInt($('#slider-nav #img-view img.active').attr('id'), 10);
	console.log(imgId);

	var nextImg;

	if(slideId == "slide-left")
	{
		if(imgId > 1)
		{
			nextImg = --imgId;
		}
		else
		{
			nextImg = maxImgNb;
		}
	}
	else
	{
		if(imgId < maxImgNb)
		{
			nextImg = ++imgId;
		}
		else
		{
			nextImg = 1;
		}
	}

	changeSlider(nextImg);
});

$(document).on('click', '#slider-nav #img-view img.unactive', function() 
{
	var imgId = $(this).attr('id');
	changeSlider(imgId);
});

function changeSlider(imgId)
{
	$('#slider #img-container img').fadeOut(300).queue(function(){
		$(this).attr('src', "slider/img_"+imgId+".jpg");
		$(this).fadeIn(300);
		$(this).dequeue();
	});

	$('#slider-nav #img-view img').switchClass("active", "unactive", "easeInOut");
	$('#slider-nav #img-view img#'+imgId).switchClass("unactive", "active", "easeInOut");
}

function showPopUp(name)
{
	showBackground();
	$('#'+ name +'.popup-box').stop().fadeIn(200);
}

function closePopUp(name)
{
	$('#'+ name +'.popup-box').stop().fadeOut(400);
	closeBackground();
}

function showBackground()
{
	$('#background-container').stop().fadeIn(400);
}

function closeBackground()
{
	$('#background-container').stop().fadeOut(600);
}

$(document).on('click', '.select .value, .select .icon', function()
{
	var selectDiv = $(this).parent();
	var searchDiv = $(this).parent().children('.search');
	var ulDiv = $(this).parent().children('.ul');
	var iconDiv = $(this).parent().children('.icon');

	if(ulDiv.css('display') == 'none')
	{
		searchDiv.stop().slideDown();
		ulDiv.stop().slideDown();
		iconDiv.stop().animate({borderSpacing: + 180}, {
			duration: 300,
			step: function(now) {
				$(this).css('-webkit-transform','rotate('+now+'deg)'); 
   				$(this).css('-moz-transform','rotate('+now+'deg)');
				$(this).css('transform','rotate('+now+'deg)');
			}
		}, 0)

		selectDiv.css({"border-radius": "3px 3px 0px 0px"});
	}
	else
	{
		searchDiv.stop().slideUp();
		ulDiv.stop().slideUp();
		iconDiv.stop().animate({borderSpacing: + 0}, {
   			duration: 300,
			step: function(now) {
				$(this).css('-webkit-transform', 'rotate('+now+'deg)'); 
				$(this).css('-moz-transform', 'rotate('+now+'deg)');
				$(this).css('transform', 'rotate('+now+'deg)');
			}
        }, 0)

		selectDiv.css({"border-radius": "3px"});
	}
});

$(document).on('click', '.select .ul .li', function() {
	$(this).parent().parent().children('.search').stop().slideUp().children('input').val("");
	$(this).parent().parent().children('.icon').click();

	var value = $(this).attr("value");

	$(this).parent().parent().attr("value", value);

	var valueHtml = $('p', this).html();

	var selectHtml = $(this).parent().parent().children(".value");
	$('h3', selectHtml).html(valueHtml);
});

$(document).on('change', '#profile-container #infos-container #facebook-infos-container #fb-permission-container input', function() 
{
	var checkBoxValue = $(this).prop('checked');
	changeFbPermission(checkBoxValue);
});

$(document).on('change', '#profile-container #infos-container #user-info-container #charter-acceptance-container input', function() 
{
	var checkBoxValue = $(this).prop('checked');
	changeCharterAcceptance(checkBoxValue);
});

$(document).on('click', '#profile-container #infos-container #user-info-container #user-mutant-container .select .ul .li', function() 
{
	var selectValue = $(this).attr('value');
	changeUserMutant(selectValue);
});

$(document).on('change', '#profile-container #infos-container #user-info-container #center-level-container input', function() 
{
	var selectValue = $(this).val();
	changeUserCenterLevel(selectValue);
});

$(document).on('change', '#profile-container #infos-container #user-info-container #fame-level-container input', function() 
{
	var selectValue = $(this).val();
	changeUserFameLevel(selectValue);
});

$(document).on('click', '#search-container #option-layout-container .option-layout-button.unactive', function() 
{
	$('#search-container #option-layout-container .option-layout-button').addClass('unactive');
	$(this).removeClass('unactive');

	var buttonValue = $(this).attr('value');

	if(buttonValue == "block")
	{
		$('#search-container #result-container .user-container').removeClass('row');
		$('#search-container #option-row-container').slideUp(200);
	}
	else
	{
		$('#search-container #result-container .user-container').addClass('row');
		$('#search-container #option-row-container').slideDown(200);
	}
});

$(document).on('click', '#search-container #option-sort-container .select .ul .li', function() 
{
	searchUsers('');
});