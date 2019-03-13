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
    <title>Download</title>

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

        <h1 class="h2">Download</h1>
        <div class="alert alert-danger" id="infoDH" style="display: none;"></div>
        <div class="alert alert-success" id="infoSH" style="display: none;"></div>
        <div class="btn-toolbar mb-2 mb-md-0">
              <div class= "btn-group mr-2">  
          <form action="#" id="form_data" enctype="multipart/form-data">          
                <button type="button" class="btn btn-sm btn-outline-success" id="guardar_datos" ">Guardar</button>
          </div>
        </div>
      </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="titleDownload">Title</label>
                  <input type="text" id="titleDownload" name="titleDownload" class="form-control" ></input>
                </div>
                <div class="form-group">
                  <label for="contentDownload">Content</label>
                  <input type="text" id="contentDownload" name="contentDownload" class="form-control" ></input>
                </div>
                <label for="filedownload">Upload File:</label>
                <div class="input-group">
              <div class="input-group-prepend">
                <span class="custom-file-label" id="inputGroupFileAddon01">Upload</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="filedownload" name="filedownload" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
              </div>
            </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="buttonDownload">Button Text</label>
                  <input type="text" id="buttonDownload" name="contentDownload" class="form-control" ></input>
                </div>
                  </div>
            </div>
                  <input type="hidden" name="linkdownload" id="linkdownload" readonly="readonly">
          </form>
        </div>
                </main>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>  
<script>

$(function updateDownload(){
  $("#guardar_datos").click(function(){
   let titulo = $("#titleDownload").val();
   let texto = $("#contentDownload").val();
   let boton = $("#buttonDownload").val();
   let link = $("#linkDownload").val();
   let obj ={
    "accion" : "update_download",
    "titulo" : titulo,
    "texto" : texto,
    "boton" : boton,
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
       consultarDownload();

     } else {
       $("#infoDH").html("Error al Actualizar").show().delay(2000).fadeOut(400);
      
     }

   });

   });
   });

$(function consultarDownload(){

    let obj = {
      "accion" : "consultar_download"
    };

    $.post('includes/_funciones.php', obj, function(r){

    $("#titleDownload").val(r.title_download);
    $("#contentDownload").val(r.content_download);
    $("#buttonDownload").val(r.button_download);
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