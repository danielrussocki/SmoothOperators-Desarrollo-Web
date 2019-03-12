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
    <title>Header</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
      <link href="css/estilo.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ActiveBox</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>

<?php include("includes/_navbar.php") ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

        <h1 class="h2">Header</h1>
        <div class="alert alert-danger" id="infoDH" style="display: none;"></div>
        <div class="alert alert-success" id="infoSH" style="display: none;"></div>
        <div class="btn-toolbar mb-2 mb-md-0">
              <div class= "btn-group mr-2">  
                         <form action="" enctype="form-data" id="form_data">               
                <button type="button" class="btn btn-sm btn-outline-success" id="guardar_datos" ">Guardar</button>
          </div>
        </div>
      </div>

            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="tituloHeader">Title</label>
                  <textarea id="tituloHeader" name="tituloHeader" class="form-control" rows="3" ></textarea>
                </div>
                <div class="form-group">
                  <label for="textoHeader">Text</label>
                  <textarea  id="textoHeader" name="textoHeader" class="form-control" rows="3"></textarea>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="botonHeader">Button text</label>
                  <textarea  id="botonHeader" name="botonHeader" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label for="linkHeader">Link</label>
                  <textarea id="linkHeader" name="linkHeader" class="form-control" rows="3"></textarea>
                </div>

              </div>
            </div>
          </form>
        </div>
                </main>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>  
<script>

$(function updateHeader(){
  $("#guardar_datos").click(function(){
   let titulo = $("#tituloHeader").val();
   let texto = $("#textoHeader").val();
   let boton = $("#botonHeader").val();
   let link = $("#linkHeader").val();
   let obj ={
    "accion" : "update_header",
    "titulo" : titulo,
    "texto" : texto,
    "boton" : boton,
    "link" : link
   }

   $("#form_data").find("input").each(function(r){
    $(this).removeClass("has-error");
   if ($(this).val() != "") {
      obj[$(this).prop("name")] = $(this).val();
   }else{
    $(this).addClass("has-error").focus();
    return false;
   }

  });

   $.post('includes/_funciones.php', obj, function(i) {

    if (i == "1") {
       $("#infoSH").html("Actualizado Correctamente").show().delay(2000).fadeOut(400);
       consultarHeader();

     } else {
       $("#infoDH").html("Error al Actualizar").show().delay(2000).fadeOut(400);
      
     }

   });

   });
   });

$(function consultarHeader(){

    let obj = {
      "accion" : "consultar_header"
    };

    $.post('includes/_funciones.php', obj, function(r){

    $("#tituloHeader").val(r.title_header);
    $("#textoHeader").val(r.content_header);
    $("#botonHeader").val(r.link_header);
    $("#linkHeader").val(r.href_header);
    }, "JSON");

   });

</script>
</body>
</html>

<?php 
  }
  else 
  {
header("Location:index.php");
  }
?>