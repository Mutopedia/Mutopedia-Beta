
  $(document).on('click', '#search-container #option-layout-container .option-layout-button.unactive', function() {
  	$('#search-container #option-layout-container .option-layout-button').addClass('unactive');
  	$(this).removeClass('unactive');

  	var buttonValue = $(this).attr('value');

  	if(buttonValue == "block"){
  		$('#search-container #result-container .user-container').removeClass('row');
  		$('#search-container #option-row-container').slideUp(200);
  	}else{
  		$('#search-container #result-container .user-container').addClass('row');
  		$('#search-container #option-row-container').slideDown(200);
  	}
  });

  $(document).on('click', '#search-container #option-sort-container .select .ul .li', function() {
  	Engine.searchUsers('');
  });

  $(document).on('keyup', '#search-container #input-container input', function(){
  	var searchContent = $(this).val();
  	Engine.searchUsers(searchContent);
  });
