
  $(document).on('change, keyup', '#tool_container .select .search input', function(){
    var specimenName = $(this).val();
    Engine.searchSpecimen(specimenName, $(this).parent());
  });
