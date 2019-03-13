<?php
  session_start();
  error_reporting(0);
  $varsesion = $_SESSION['usuario'];
  if (isset($varsesion)){
  ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.5">
  <title>Dashboard Template · Bootstrap</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Custom styles for this template -->
  <link href="css/estilo.css" rel="stylesheet">
</head>
<body>
  <?php 
    include("includes/_navbar.php");
   ?>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Team</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
              <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
            </div>
          </div>
        </div>
        
        <h2>Registrar Integrante</h2>
        <div class="table-responsive view" id="show_data">
          <table class="table table-striped table-sm" id="list-team">
            <thead>
              <tr>
                <th>Ubicación de las Imágenes</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Descripción</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <div id="insert_data" class="view">
          <form action="#" id="form_data" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="file" id="foto" name="foto">
                  <input type="hidden" id="ruta" name="ruta" readonly="readonly">
                </div>
                <div>
                 <div id="preview"></div>
                </div>
                <div class="form-group">
                  <label for="nombre"><b>Nombre</b></label>
                  <input type="text" id="nombre" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                  <label for="cargo"><b>Cargo</b></label>
                  <input type="text" id="cargo" name="cargo" class="form-control">
                </div>
                <div class="form-group">
                  <label for="descripcion"><b>Descripción</b></label>
                  <input type="text" id="descripcion" name="descripcion" class="form-control">
              </div>
              <button type="button" class="btn btn-success " id="guardar_datos">Guardar</button>
            </div>
            </div>
          </form>
        </div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    function change_view(vista = 'show_data'){
      $("#main").find(".view").each(function(){
        // $(this).addClass("d-none");
        $(this).slideUp('fast');
        let id = $(this).attr("id");
        if(vista == id){
          $(this).slideDown(300);
          // $(this).removeClass("d-none");
        }
      });
    }
    function consultar(){
      let obj = {
        "accion" : "consultar_team"
      };
      $.post("includes/_funciones.php", obj, function(respuesta){
        let template = ``;
        $.each(respuesta,function(i,e){
          template += `
          <tr>
          <td>${e.team_img}</td>
          <td>${e.team_name}</td>
          <td>${e.team_position}</td>
          <td>${e.team_description}</td>
          <td>
          <a href="#" data-id="${e.team_id}" class="editar_team">Editar</a>
          <a href="#" data-id="${e.team_id}" class="eliminar">Eliminar</a>
          </td>
          </tr>
          `;
        });
        $("#list-team tbody").html(template);
      },"JSON");
    }
    $(document).ready(function(){
      consultar();
      change_view();
    });
    $("#nuevo_registro").click(function(){
      change_view('insert_data');
    });
    $("#guardar_datos").click(function(respuesta){
      let imagen = $("#ruta").val();
      let nombre = $("#nombre").val();
      let cargo = $("#cargo").val()
      let descripcion = $("#descripcion").val();
      let obj ={
        "accion" : "insertar_team",
        "imagen" : imagen,
        "nombre" : nombre,
        "cargo" : cargo,
        "descripcion" : descripcion
      }
      $("#form_data").find("input").each(function(){
        $(this).removeClass("has-error");
        if($(this).val() != ""){
          obj[$(this).prop("name")] =  $(this).val();
        }else{
          $(this).addClass("has-error").focus();
          return false;
        }
      });

     if($(this).data("editar") == 1) {
    obj["accion"] = "editar_team";
    obj["id"] = $(this).data('id');
    $(this).text("Guardar").removeData("editar").removeData("id");
   }
     
      $.post("includes/_funciones.php", obj, function(verificado){ 
      
       alert(verificado);
     }
     );
    });

    $("#foto").on("change", function (e) {
      let formDatos = new FormData($("#form_data")[0]);
      formDatos.append("accion", "carga_foto");
      $.ajax({
        url: "includes/_funciones.php",
        type: "POST",
        data: formDatos,
        contentType: false,
        processData: false,
        success: function (datos) {
          let respuesta = JSON.parse(datos);
          if(respuesta.status == 0){
            alert("No se cargó la foto");
          }
          let template = `
          <img src="${respuesta.archivo}" alt="" class="img-fluid" />
          `;
          $("#ruta").val(respuesta.archivo);
          $("#preview").html(template);
        }
      });
    });

        $('#list-team').on("click",".eliminar",function(e){
        e.preventDefault();
        let confirmacion = confirm("Desea eliminar este registro?");
        if (confirmacion) {
          let id = $(this).data('id'),
          obj = {
            "accion":"eliminar_team",
            "id":id
          };
          $.post("includes/_funciones.php",obj,function(respuesta){
            alert(respuesta);
            consultar();
          });
        }else{
          alert("El registro no se ha eliminado");
        }
      });

    $("#list-team").on("click",".editar_team", function(e){
      e.preventDefault();
      $("#form_data")[0].reset();
      change_view('insert_data');
      let id = $(this).data('id');

       obj = {
        "accion" : "consultar_miembro",
        "id" : id, 
       };
          $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);
          $.post("includes/_funciones.php",obj,function(r){
            $("#ruta").val(r.team_img);
            $("#nombre").val(r.team_name);
            $("#cargo").val(r.team_position);
            $("#descripcion").val(r.team_description);
          },"JSON");

     });
     


    $("#main").find(".cancelar").click(function(){
      change_view();
      $("#form_data")[0].reset();
    });
  </script>
  <img src"">
</body>
</html>

<?php 
 }
  else 
  {
header("Location:index.php");
  }