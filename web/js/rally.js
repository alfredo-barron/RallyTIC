$(document).ready(function(){

    $('#content_btn').hide();
    $('#btnAgregar').attr('disabled',false);
    $('#newCompetitor').hide();


    $('#btnAgregar').click(function(event) {
      var equipo = $('#n_teams option:selected').val();
      if (equipo != "") {
        for (var i = 1; i <= equipo; i++) {
          $('#content').append('<div class="input-field col s8 offset-s2 m8 offset-m2"><input type="text" class="validate" id="_name_team_'+i+'" name="_name_team_'+i+'" autocomplete="off"><label for="_name_team_'+i+'"> Nombre del equipo '+i+'</label></div>');
        };
        $('#btnAgregar').attr('disabled',true);
        $('#content_btn').show();
      };
    });

    $('#btnCancelarTeam').click(function(event) {
      //$('#btnAgregar').attr('disabled',false);
      $('#content_btn').hide();
    });

  $('#btnCancelarCompetitor').click(function(event) {
    $('#newCompetitor').hide();
  });

  $('#btnAddCompetitor').click(function(event) {
    $('#newCompetitor').show();
  });

  $('#btnNewCompetitor').click(function(event) {
    var url = $('#formNewCompetitor').attr('action');
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();
    var username = $('#username').val();
    if ((first_name == "" && last_name == "" && email == "" && username == "") || (first_name == "" || last_name == "" || email == "" || username == "")) {
      Materialize.toast('Datos incompletos!', 4000, 'rounded')
    } else {
      $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: $('#formNewCompetitor').serialize(),
          success: function(data) {
            if(data.status == 1){
              Materialize.toast('Participante&nbsp;<span class="yellow-text">registrado!<span>', 4000, 'rounded')
              competitors();
            } else if(data.status == 2){
              Materialize.toast('Error del servidor!', 4000, 'rounded')
            }
          }
        })
    }
  });

  competitors();

  function competitors () {
    $.ajax({
      url: 'competitors',
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        if (data.length) {
          for (var i = data.length - 1; i >= 0; i--) {
            $('#listViewCompetitors').append('<a href="#'+data[i].id+'" class="collection-item avatar"><i class="material-icons circle blue left">person</i><b>'+data[i].first_name+'</b> <br> '+data[i].last_name+'</a>');
          };
        } else {
          $('#listViewCompetitors').append('<h4>Sin participantes</h4>');
          $('#newCompetitor').show();
        };
      }
    });
  }

});
