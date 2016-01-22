function loadModel(modelName, argPage, noRewrite)
{
	$("#ajax-container").stop().fadeOut(400).queue(function()
	{
		$(this).load('models/loading-ajax.php').fadeIn(400);

		if(typeof argPage === 'undefined')
		{
			argPage = null
		}

		$.post("src/php/executor.php", { action: "loadModel", modelName: modelName, argPage: argPage}, function(data)
		{
			if(data.result == true)
			{
				if(modelName == 'profile' && (argPage !== 'null' || typeof argPage !== undefined || argPage !== null))
				{
					window.history.pushState({page: data.modelName}, data.modelName, data.modelName+'/'+argPage);
				}
				else
				{
					window.history.pushState({page: data.modelName}, data.modelName, data.modelName);
				}

				activeNavLi();

				if(isFileExist("css/" + data.modelName + "_style.css"))
				{
					/*$("head").children('link.asynchronousStyleSheet').each(function () {
						if($(this).attr('href').replace('css/', '').replace('_style.css', '') !== data.modelName)
						{*/
							$("head").append('<link class="asynchronousStyleSheet" rel="stylesheet" type="text/css" href="css/' + data.modelName + '_style.css">').queue(function()
							{
								console.log("Model Loader >> Style '" + data.modelName + "' loaded");

								$("#ajax-container").fadeOut(400).queue(function(){
									$(this).html(data.reply).queue(function(){
										$(this).fadeIn(600);
										$(this).dequeue();
									});
									$(this).dequeue();
								});
									
								$(this).dequeue();
							});
					/*	}
					});*/
				}
			}
			else
			{
				alert(data.error);
				$("#ajax-container").fadeIn(200);
			}

		}, "json");

		$(this).dequeue();
	});
}

function loadHeader()
{
	$("#header-container").stop().fadeOut(200).queue(function()
	{
		$.post("src/php/executor.php", { action: "loadHeader"}, function(data)
		{
			if(data.result == true)
			{			
				$("#header-container").html(data.reply).queue(function(){
					$(this).fadeIn(200);
					activeNavLi();
					newsBarTextScroll();
					$(this).dequeue();
				});
			}
			else
			{
				alert(data.error);
				$("#header-container").fadeIn(200);
			}

		}, "json");

		$(this).dequeue();
	});
}

function searchSpecimen(specimenName, searchDiv)
{
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
}

function startBreeding()
{
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
}

function logUser(userid, userfirstname, userlastname, userpic)
{
	$.post("src/php/executor.php", { action: "logUser", userid: userid, userfirstname: userfirstname, userlastname: userlastname, userpic: userpic}, function(data)
	{
		if(data.result){
			console.log(data.reply);
			loadHeader();
		}
		if(data.error != null){
			console.log(data.error);
		}

	}, "json");
}

function searchUsers(searchContent)
{
	$('#search-container #result-container').stop().fadeOut(100).queue(function()
	{
		$.post("src/php/executor.php", { action: "searchUsers", searchContent: searchContent}, function(data)
		{
			if(data.result)
			{
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
			}
			else
			{
				$('#search-container #result-container').fadeOut(200).queue(function(){
					$('#search-container #error-container').fadeOut(200).queue(function() {
						$(this).children('h2').html(data.error).parent().fadeIn(200);
						$(this).dequeue();
					});
					$(this).dequeue();
				});
			}

		}, "json");

		$(this).dequeue();
	});
}

function getReleaseCounter(releaseName)
{
	$.post("src/php/executor.php", { action: "getReleaseDate", releaseName: releaseName}, function(data)
	{
		$('#portal-container #counter-container #counter').html(data.reply);

		console.log(data.reply);
		if(data.error != null){
			console.log(data.error);
		}

	}, "json");

	setTimeout("getReleaseCounter('portal')", 1000);
}

function changeFbPermission(state)
{
	$.post("src/php/executor.php", { action: "changeFbPermission", state: state}, function(data)
	{
		if(data.error != null){
			console.log(data.error);
		}else{
			console.log(data.reply);
		}

	}, "json");
}

function changeCharterAcceptance(state)
{
	$.post("src/php/executor.php", { action: "changeCharterAcceptance", state: state}, function(data)
	{
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
}

function changeUserMutant(mutantNameCode)
{
	$.post("src/php/executor.php", { action: "changeUserMutant", mutantNameCode: mutantNameCode}, function(data)
	{
		if(data.error != null){
			console.log(data.error);
		}else{
			console.log(data.reply);
		}

	}, "json");
}

function changeUserCenterLevel(centerLevel)
{
	$.post("src/php/executor.php", { action: "changeUserCenterLevel", centerLevel: centerLevel}, function(data)
	{
		if(data.error != null){
			console.log(data.error);
		}else{
			console.log(data.reply);
		}

	}, "json");
}

function changeUserFameLevel(fameLevel)
{
	$.post("src/php/executor.php", { action: "changeUserFameLevel", fameLevel: fameLevel}, function(data)
	{
		if(data.error != null){
			console.log(data.error);
		}else{
			console.log(data.reply);
		}

	}, "json");
}

function sendReport(reported_player)
{
	var report_message = $('.popup-box#report-box .box-content #report_message').val();

	$.post("src/php/executor.php", { action: "reportPlayer", reported_player: reported_player, report_message: report_message}, function(data)
	{
		if(data.result){
			$('.popup-box#report-box .box-content ul li:nth-child(2)').fadeOut(200);
			$('.popup-box#report-box .box-content ul li:first-child p').fadeOut(200).html(data.reply).fadeIn(200);
			$('.popup-box#report-box .box-content ul li:last-child .button').attr("onclick", "closePopUp('report-box');").children('p').html('Finish !');
		}
		if(data.error != null){
			$('.popup-box#report-box .box-content ul li:first-child p').fadeOut(200).html(data.error).fadeIn(200);
		}

	}, "json");
}