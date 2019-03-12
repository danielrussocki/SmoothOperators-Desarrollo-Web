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
    <title>Footer</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

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

        <h1 class="h2">Footer</h1>
        <div class="alert alert-danger" id="infoDF" style="display: none;"></div>
        <div class="alert alert-success" id="infoSF" style="display: none;"></div>
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
                  <label for="locationFooter">Location</label>
                  <textarea id="locationFooter" name="locationFooter" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                  <label for="aboutFooter">About</label>
                 <textarea id="aboutFooter" name="aboutFooter" class="form-control" rows="3"></textarea>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="copyrightFooter">Copyright</label>
                  <textarea id="copyrightFooter" name="copyrightFooter" class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
               <div class="form-group">
                  <label for="iconsFooter">Share Icons</label>
                    <div class="row">
                      <div class="form-group">
                      <div class="col-sm">                        
                      <i class="fab fa-facebook"></i>
                      <label for="facebook">Facebook</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input type="checkbox" id="status_0" name="status" >
                        </div>
                      </div>
                      <input type="text" id ="href_0" name="href_facebook" class="form-control">
                    </div>
                    </div>
                  </div>
                      <div class="form-group">
                     <div class="col-sm">
                      <i class="fab fa-twitter"></i>
                       <label for="twitter">Twitter</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input type="checkbox" id="status_1" name="status" >
                        </div>
                      </div>
                      <input type="text" id ="href_1"  name="href_twitter" class="form-control">
                    </div>
                    </div>
                    </div>

                      <div class="form-group">
                      <div class="col-sm">
                     <i class="fab fa-linkedin"></i>
                       <label for="linkedin">Linkedin</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input type="checkbox" id="status_2" name="status" >
                        </div>
                      </div>
                      <input type="text" id ="href_2"  name="href_linkedin" class="form-control">
                    </div>
                    </div>
                    </div>
                  </div>
                </div>
                </div>
          </form>
        </div>
         </main>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script><script>

$(function updateFooter() { 
  $("#guardar_datos").click(function() {
   let location = $("#locationFooter").val();
   let about = $("#aboutFooter").val();
   let copyright = $("#copyrightFooter").val();
   let obj ={
    "accion" : "update_footer",
    "location" : location,
    "about" : about,
    "copyright" : copyright,
   };

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
       $("#infoSF").html("Actualizado Correctamente").show().delay(2000).fadeOut(400);
        consultarFooter();

     } 

   });
   });
   });

function consultarFooter(){

    let obj = {
      "accion" : "consultar_footer"
    };

    $.post('includes/_funciones.php', obj, function(r) {

    $("#locationFooter").val(r.location_content_footer);
    $("#aboutFooter").val(r.about_content_footer);
    $("#copyrightFooter").val(r.copyright_content_footer);
    }, "JSON");
    
   };

       
   $(":checkbox").on('change', function(){
   $(this).val($(this).is(":checked") ? 1 : 0);
    });


function consultar_iconsFooter(){

    let obj = {
      "accion" : "consultar_iconsFooter"
    };

    $.post('includes/_funciones.php', obj, function(r) {

    for (var n = 0; n < r.length; n++) {
    var bool = JSON.parse(r[n].status_share_footer , (k, v) => v === "1" ? true : v === "0" ? false : v);  
    $("#href_"+[n]).val(r[n].link_share_footer);
    $("#status_"+[n]).prop("checked", bool);
    $("#status_"+[n]).val(bool);
    }

     }, "JSON");
    
   };

$(function update_shareIcons() { 
  $("#guardar_datos").click(function() {

    for (var n = 0; n < 3; n++) {

   let link_ = $("#href_"+n).val();
   let status_ = $("#status_"+n).val();

    let obj ={
    "accion" : "update_shareIcons",
    "id" : n+1,
    "link_": link_,
    "status_" : status_,

   };
  
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
       $("#infoSF").html("Actualizado Correctamente").show().delay(2000).fadeOut(400);
        consultar_iconsFooter();
     } 

   });
   }
   });
   });

  $(document).ready(function(){
    consultar_iconsFooter();
    consultarFooter();
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