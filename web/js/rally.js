$(document).ready(function(){

    $('#content_btn').hide();
    $('#btnAgregar').attr('disabled',false);
    $('#newCompetitor').hide();
    $('#newTeam').hide();
    $('#viewTeam').hide();

    //Pendiente
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


  //Events


  //Activitys
  $(document).on('click', 'a[data-toggle="modal_activity"]', function(event) {
    $('#newActivity').hide();
    $('#viewActivity').show();
    var link = $(this);
    var id = link.data('id');
    team(id);
  });

  $('#closeViewActivity').click(function(event) {
    $('#viewActivity').hide();
  });

 /* $('#btnNewActivity').click(function(event) {
    var url = $('#formNewActivity').attr('action');
    var name = $('#name_activity').val();
    var station_id = $('#station_id').val();
    var question_id = $('#question_id').val();
    var intents = $('#intents').val();
    var time = $('#time').val();
    var penalty = $('#penalty').val();
    if ((name == "" && intents == "" && time = "") || (name == "" || intents == "" || time = "")) {
      Materialize.toast('Datos incompletos!', 4000, 'rounded')
    } else {
      $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: $('#formNewActivity').serialize(),
          success: function(data) {
            if(data.status == 1){
              Materialize.toast('Actividad&nbsp;<span class="yellow-text">registrada!<span>', 4000, 'rounded')
              teams();
              $('#newActivity').hide();
            } else if(data.status == 2){
              Materialize.toast('Error del servidor!', 4000, 'rounded')
            }
          }
        })
    }
  }); */

  //Equipos y participantes
  $('#btnCancelarCompetitor').click(function(event) {
    $('#newCompetitor').hide();
  });

  $('#btnCancelTeam').click(function(event) {
    $('#newTeam').hide();
  });

  $('#btnAddCompetitor').click(function(event) {
    $('#newCompetitor').show();
  });

  $('#btnAddTeam').click(function(event) {
    $('#viewTeam').hide();
    $('#newTeam').show();
  });

  $(document).on('click', 'a[data-toggle="modal_team"]', function(event) {
    $('#newTeam').hide();
    $('#viewTeam').show();
    var link = $(this);
    var id = link.data('id');
    team(id);
  });

  $('#closeViewTeam').click(function(event) {
    $('#viewTeam').hide();
  });

  $('#btnNewTeam').click(function(event) {
    var url = $('#formNewTeam').attr('action');
    var name = $('#name_team').val();
    var password = $('#password_team').val();
    if ((name == "" && password == "") || (name == "" || password == "")) {
      Materialize.toast('Datos incompletos!', 4000, 'rounded')
    } else {
      $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: $('#formNewTeam').serialize(),
          success: function(data) {
            if(data.status == 1){
              Materialize.toast('Equipo&nbsp;<span class="yellow-text">registrado!<span>', 4000, 'rounded')
              teams();
              $('#newTeam').hide();
            } else if(data.status == 2){
              Materialize.toast('Error del servidor!', 4000, 'rounded')
            }
          }
        })
    }
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

  //Stations
  $(document).on('click', 'a[data-toggle="modal_station"]', function(event) {
    $('#newTeam').hide();
    $('#viewTeam').show();
    var link = $(this);
    var id = link.data('id');
    team(id);
  });

  $('#closeViewStation').click(function(event) {
    $('#viewStation').hide();
  });

  $('#btnNewStation').click(function(event) {
    var url = $('#formNewStation').attr('action');
    var name = $('#name_station').val();
    var lat = $('#lat_station').val();
    var lng = $('#lng_station').val();
    if ((name == "" && password == "") || (name == "" || password == "")) {
      Materialize.toast('Datos incompletos!', 4000, 'rounded')
    } else {
      $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: $('#formNewStation').serialize(),
          success: function(data) {
            if(data.status == 1){
              Materialize.toast('Estación&nbsp;<span class="yellow-text">registrada!<span>', 4000, 'rounded')
              teams();
              $('#newStation').hide();
            } else if(data.status == 2){
              Materialize.toast('Error del servidor!', 4000, 'rounded')
            }
          }
        })
    }
  });

  //Questions
  $('#btnAddQuestion').click(function(event) {
    $('#newQuestion').openModal();
  });

  $('#btnNewQuestion').click(function(event) {
    var url = $('#formNewQuestion').attr('action');
    var message = $('#message').val();
    var answer = $('#answer').val();
    var track = $('#track').val();
    if ((message == "" && answer == "" && track == "") || (message == "" || answer == "" || track == "")) {
      Materialize.toast('Datos incompletos!', 4000, 'rounded')
    } else {
      $.ajax({
          url: url,
          type: "POST",
          dataType: "json",
          data: $('#formNewQuestion').serialize(),
          success: function(data) {
            if(data.status == 1){
              Materialize.toast('Pregunta y/o acertijo&nbsp;<span class="yellow-text">registrado!<span>', 4000, 'rounded')
              competitors();
            } else if(data.status == 2){
              Materialize.toast('Error del servidor!', 4000, 'rounded')
            }
          }
        })
    }
  });

  $('#btnAddQuestion').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');
    var descr = button.data('descr');
    var icon = button.data('icon');
    var modal = $(this);
    $('.form-group').each(function(index, el) {
      $(this).removeClass('has-error');
    });
    $('.help-block').each(function(index, el) {
      $(this).html('');
    });
    if(typeof name != 'undefined'){
      modal.find('.modal-title').text('Actualizar tipo incidente');
      modal.find('#id').val(id);
      modal.find('#name').val(name);
      modal.find('#descr').val(descr);
      modal.find('#icon').val(icon);
      modal.find('#update').val('true');
    } else {
      modal.find('.modal-title').text('Nuevo tipo incidente');
      modal.find('#id').val('0');
      modal.find('#name').val('');
      modal.find('#descr').val('');
      modal.find('#icon').val('');
      modal.find('#update').val('false');
    }
  });

  $('#btnDeleteQuestion').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var name = button.data('name');
    var modal = $(this);
    modal.find('b#tipo').text(name);
    modal.find('a#delete-button').attr('href',''+id);
  });

  //Funciones para vistas
  competitors();
  teams();
  stations();
  activitys();
  questions();

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
          //$('#listViewCompetitors').append('<h4>Sin participantes</h4>');
          $('#newCompetitor').show();
        };
      }
    });
  }

  function teams () {
    $.ajax({
      url: 'teams',
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        if (data.length) {
          $('#listViewTeams').empty();
          for (var i = data.length - 1; i >= 0; i--) {
            $('#listViewTeams').append('<a href="javascript:void(0);" class="collection-item avatar" data-toggle="modal_team" data-id="'+data[i].id+'"><i class="material-icons circle red left">group</i> Equipo <br> <b>'+data[i].name+'</b></a>');
          };
        } else {
          //$('#listViewTeams').append('<h4>Sin grupos</h4>');
          $('#newTeam').show();
        };
      }
    });
  }

  function stations () {
    $.ajax({
      url: 'stations',
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        if (data.length) {
          $('#listViewStations').empty();
          for (var i = data.length - 1; i >= 0; i--) {
            $('#listViewStations').append('<a href="javascript:void(0);" class="collection-item avatar" data-toggle="modal_station" data-id="'+data[i].id+'"><i class="material-icons circle red left">group</i> Equipo <br> <b>'+data[i].name+'</b></a>');
          };
        } else {
          //$('#listViewTeams').append('<h4>Sin grupos</h4>');
          $('#newStation').show();
        };
      }
    });
  }

  function activitys () {
    $.ajax({
      url: 'activitys',
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        if (data.length) {
          $('#listViewActivitys').empty();
          for (var i = data.length - 1; i >= 0; i--) {
            $('#listViewActivitys').append('<a href="javascript:void(0);" class="collection-item avatar" data-toggle="modal_activity" data-id="'+data[i].id+'"><i class="material-icons circle red left">group</i> Equipo <br> <b>'+data[i].name+'</b></a>');
          };
        } else {
          //$('#listViewTeams').append('<h4>Sin grupos</h4>');
          $('#newActivity').show();
        };
      }
    });
  }

  function questions () {
    $.ajax({
      url: 'questions',
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        if (data.length) {
          $('#listViewQuestions').empty();
          for (var i = data.length - 1; i >= 0; i--) {
            $('#listViewQuestions').append('<a href="javascript:void(0);" class="collection-item avatar" data-toggle="modal_question" data-id="'+data[i].id+'"><i class="material-icons circle red left">group</i> Equipo <br> <b>'+data[i].name+'</b></a>');
          };
        } else {
          //$('#listViewTeams').append('<h4>Sin grupos</h4>');
          $('#newQuestion').show();
        };
      }
    });
  }

  function team (id){
    $.ajax({
      url: 'team/'+id,
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        $('#view_nameteam').empty();
        $('#view_nameteam').html('Equipo <b>'+data.name+'</b> <p>Contraseña: '+data.password+'<p/>');
      }
    });
  }

  function station (id){
    $.ajax({
      url: 'station/'+id,
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        $('#view_namestation').empty();
        $('#view_namestation').html('Equipo <b>'+data.name+'</b> <p>Contraseña: '+data.password+'<p/>');
      }
    });
  }

  function activity (id){
    $.ajax({
      url: 'activities/'+id,
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        $('#view_nameactivity').empty();
        $('#view_nameactivity').html('Equipo <b>'+data.name+'</b> <p>Contraseña: '+data.password+'<p/>');
      }
    });
  }

  function question (id){
    $.ajax({
      url: 'question/'+id,
      type: 'GET',
      dataType: 'json',
      data: '',
      success: function(data) {
        $('#view_namequestion').empty();
        $('#view_namequestion').html('Equipo <b>'+data.name+'</b> <p>Contraseña: '+data.password+'<p/>');
      }
    });
  }


});
