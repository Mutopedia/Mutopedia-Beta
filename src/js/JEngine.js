var statePage;

if(typeof history.pushState == 'undefined')
{
	alert("Your browser is out of date !");
}	

window.onpopstate = function(event)
{
	statePage = event.state.page;

	loadModel(statePage);
}

function checkAcceptationCookies()
{
	var cookieValue = getCookie('AcceptationCookies');

	if(cookieValue != 1)
	{
		showPopUp('cookiesPrivacy');
	}
	else
	{
		closePopUp();
	}
}

function AcceptCookies()
{
	var today = new Date(), expires = new Date();
	expires.setTime(today.getTime() + (365*24*60*60*1000));
	document.cookie = "AcceptationCookies =" + encodeURIComponent(1) + ";expires=" + expires.toGMTString();

	closePopUp();
}

function getCookie(cookieName)
{
    var oRegex = new RegExp("(?:; )?" + cookieName + "=([^;]*);?");
 
	if (oRegex.test(document.cookie))
    {
		return decodeURIComponent(RegExp["$1"]);
	} 
	else 
	{
		return null;
	}
}

function isFileExist(src)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', src, true);
    http.send();
    return http.status!=404;
}


$(document).on('keyup', '#search-container #input-container input', function()
{
	var searchContent = $(this).val();
	searchUsers(searchContent);
});

$(document).on('change, keyup', '#tool_container .select .search input', function()
{
	var specimenName = $(this).val();
	searchSpecimen(specimenName, $(this).parent());
});


if(history.state.page != 'portal')
{
	$(window).scroll(function() 
	{	
		console.log('Scroll');

		if($(window).scrollTop() < $('#news-bar').offset().top)
		{
			$('#menu-nav').css({'position': 'relative', 'margin-top': '0', 'box-shadow': 'none'});
		}
		else if(($(window).scrollTop() + 52) > $('#menu-nav').offset().top)
		{
			$('header #header-container').css({'height': '121px'});
			$('#menu-nav').css({'position': 'fixed', 'margin-top': '-62px', 'box-shadow': '0px 0px 15px 10px rgba(0, 0, 0, 1)'});
		}
	});
}

if(history.state.page == 'portal')
{
	$(window).ready(function() 
	{
		getReleaseCounter('portal');
	});
}

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

function activeNavLi()
{
	$("#menu-nav ul li").attr('class', 'unactive');
	$("#menu-nav ul li[name='"+history.state.page+"']").attr('class', 'active');
	console.log('WORKS !'+history.state.page);
}