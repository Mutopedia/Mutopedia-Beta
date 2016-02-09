$("#profile-container").ready(function(){
  $(document).on('change', '#profile-container #infos-container #facebook-infos-container #fb-permission-container input', function() {
  	var checkBoxValue = $(this).prop('checked');
  	Engine.changeFbPermission(checkBoxValue);
  });

  $(document).on('change', '#profile-container #infos-container #user-info-container #charter-acceptance-container input', function() {
  	var checkBoxValue = $(this).prop('checked');
  	Engine.changeCharterAcceptance(checkBoxValue);
  });

  $(document).on('click', '#profile-container #infos-container #user-info-container #user-mutant-container .select .ul .li', function() {
  	var selectValue = $(this).attr('value');
  	Engine.changeUserMutant(selectValue);
  });

  $(document).on('change', '#profile-container #infos-container #user-info-container #center-level-container input', function() {
  	var selectValue = $(this).val();
  	Engine.changeUserCenterLevel(selectValue);
  });

  $(document).on('change', '#profile-container #infos-container #user-info-container #fame-level-container input', function() {
  	var selectValue = $(this).val();
  	Engine.changeUserFameLevel(selectValue);
  });

  $(document).on('change, keyup', '#profile-container .select .search input', function(){
    var specimenName = $(this).val();
    Engine.searchSpecimen(specimenName, $(this).parent());
  });
});
