
  $(document).on('click', '.select .value, .select .icon', function(){
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
