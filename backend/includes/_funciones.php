<?php 
require_once("_db.php");

switch ($_POST["accion"]) {

		case 'login':
		login();
		break;

		case 'consultar_usuarios':
		consultar_usuarios();
		break;

		case 'insertar_usuarios':
		insertar_usuarios();
		break;

		case 'consultar_slider':
		consultar_slider();
		break;

		case 'insertar_slider':
		insertar_slider();
		break;

		case 'consultar_test':
		consultar_test($_POST['id']);
		break;

		case 'editar_slider':
		editar_slider($_POST['id']);
		break;

		case 'insertar_slider':
		insertar_slider();
		break;

		case 'eliminar_slider':
		eliminar_slider($_POST['id']);
		break;

		case 'eliminar_registro':
		eliminar_usuario($_POST['id']);
		break;

		case 'editar_usuarios':
		editar_usuarios($_POST['id']);
		break;

		case 'consultar_registro':
		consultar_registro($_POST['id']);
		break;

		case 'carga_foto':
		carga_foto();
		break;

		case 'consultar_header':
		consultar_header();
		break;

		case 'consultar_footer':
		consultar_footer();
		break;

		case 'consultar_download':
		consultar_download();
		break;

		case 'consultar_shareFooter':
		consultar_shareFooter();
		break;

		case 'consultar_iconsFooter':
		consultar_iconsFooter();
		break;

		case 'update_header':
		update_header();
		break;

		case 'update_download':
		update_download();
		break;

		case 'update_footer':
		update_footer();
		break;

		case 'update_shareIcons':
		update_shareIcons();
		break;

		case "insertar_team":
  		insertar_team();
  		break;

  		case "eliminar_team":
  		eliminar_team($_POST["id"]);
		break;

		case 'editar_team':
    	editar_team($registro= $_POST["id"]);
		break;

  		case 'consultar_miembro':
    	consultar_miembro($registro= $_POST["id"]);		
		default;

		case "consultar_team":
  		consultar_team();

  break;
			
	break;
}

function carga_foto(){
	if (isset($_FILES["foto"])) {
		$file = $_FILES["foto"];
		$nombre = $_FILES["foto"]["name"];
		$temporal = $_FILES["foto"]["tmp_name"];
		$tipo = $_FILES["foto"]["type"];
		$tam = $_FILES["foto"]["size"];
		$dir = "../../img/usuarios/";
		$respuesta = [
			"archivo" => "../img/usuarios/logotipo.png",
			"status" => 0
		];
		if(move_uploaded_file($temporal, $dir.$nombre)){
			$respuesta["archivo"] = "../img/usuarios/".$nombre;
			$respuesta["status"] = 1;
		}
		echo json_encode($respuesta);
	}
}

function consultar_usuarios(){
	global $mysqli;
	$consulta = "SELECT * FROM usuarios";
	$resultado = mysqli_query($mysqli, $consulta);
	$arreglo = [];
	while($fila = mysqli_fetch_array($resultado)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function editar_usuarios(){
	global $mysqli;
	extract($_POST);
	$consulta = "UPDATE usuarios SET nombre_usr = '$nombre', correo_usr = '$correo', 
	pswd_usr = '$password', telefono_usr = '$telefono' WHERE id_usr = '$id' ";
	$resultado = mysqli_query($mysqli, $consulta);
	if($resultado){
		echo "Se editó correctamente";
	}else{
		echo "Se generó un error, intentalo nuevamente";
	}
}


function consultar_registro($id){
	global $mysqli;
	$consulta = "SELECT * FROM usuarios where id_usr = $id LIMIT 1";
	$resultado = mysqli_query($mysqli, $consulta);
	$fila = mysqli_fetch_array($resultado);
	echo json_encode($fila); 
}

function eliminar_usuario($id){
	global $mysqli;
	$query = "DELETE FROM usuarios WHERE id_usr = $id";
	$resultado = mysqli_query($mysqli, $query);
	if ($resultado) {
		echo "1";
	} else {
		echo "0";
	}
}

function login(){
		// Conectar a la base de datos
	global $mysqli;
		// Si usuario y contraseña están vacíos imprimir 3
	$correo = $_POST['correo']; 
	$password = $_POST['pswd'];
	$consulta = "SELECT * FROM usuarios WHERE correo_usr ='$correo'";
	$resultado = mysqli_query($mysqli, $consulta);
	$fila = mysqli_fetch_array($resultado);
	if($fila["pswd_usr"] == "$password" ){
		
		session_start();
        error_reporting(0);
        $_SESSION['usuario'] = $correo;
  
        echo "1"; 
      }
    else 
      {
        echo "Error en la contraseña o usuario";
      }
	}

function insertar_usuarios(){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    global $mysqli;
    if ($nombre!=''&&$correo!=''&&$telefono!=''&&$password!='') {
        $verif = "SELECT * FROM usuarios WHERE correo_usr = '$correo'";
        $resultado = $mysqli->query($verif);
        if ($resultado->num_rows == 0) {
            $query = "INSERT INTO usuarios VALUES('','$nombre','$correo','$telefono','$password','1')";
            $data = $mysqli->query($query);
            echo "Usuario agregado correctamente";
        } else{
            echo "correo ya existente";
        }
    }
}

function consultar_slider(){
	global $mysqli;
	$consulta = "SELECT * FROM slider";
	$resultado = mysqli_query($mysqli, $consulta);
	$arreglo = [];
	while($fila = mysqli_fetch_array($resultado)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function consultar_test($id){
	global $mysqli;
	$consulta = "SELECT * FROM slider WHERE id_slider = $id  LIMIT 1";
	$resultado = mysqli_query($mysqli, $consulta);
	$arreglo = [];
	while($fila = mysqli_fetch_array($resultado)){
		array_push($arreglo, $fila);
	}
	echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function insertar_slider(){
	global $mysqli;
	$img_slider = $_POST["ruta"];
	$quote_slider = $_POST["texto"];	
	$name_slider = $_POST["nombre"];
	$consulta = "INSERT INTO slider VALUES('','$img_slider','$quote_slider','$name_slider')";
	$resultado = mysqli_query($mysqli, $consulta);
	$array = [];
	while($fila1 = mysqli_fetch_array($resultado)){
		array_push($array, $fila);
	}
	echo json_encode($array); //Imprime el JSON ENCODEADO
}

 function eliminar_slider($id){
  global $mysqli;
  $query = "DELETE FROM slider WHERE id_slider = $id";
  $resultado = mysqli_query($mysqli, $query);
  if ($resultado) {
    echo "1";
  } else {
    echo "0";
  }
}

function editar_slider($id){
  global $mysqli;
  extract($_POST);
  $consulta = "UPDATE slider SET img_slider = '$ruta', quote_slider = '$texto', 
  name_slider = '$nombre' WHERE id_slider = '$id' ";
  $resultado = mysqli_query($mysqli, $consulta);
  if($resultado){
    echo "Se editó correctamente";
  }else{
    echo "Se generó un error, intentalo nuevamente";
  }
}

 function consultar_header(){
 	global $db;
 	$query = "SELECT * FROM smoothop_segundo_parcial.header";
	$stmt = $db->prepare($query);
	$stmt->execute();
	$fila = $stmt->fetch(PDO::FETCH_ASSOC);
	echo json_encode($fila);

 }

 function consultar_footer(){
 	global $db;
 	$query = "SELECT * FROM smoothop_segundo_parcial.footer";
	$stmt = $db->prepare($query);
	$stmt->execute();
	$fila = $stmt->fetch(PDO::FETCH_ASSOC);
	echo json_encode($fila);

 }

  function consultar_download(){
 	global $db;
 	$query = "SELECT * FROM smoothop_segundo_parcial.download";
	$stmt = $db->prepare($query);
	$stmt->execute();
	$fila = $stmt->fetch(PDO::FETCH_ASSOC);
	echo json_encode($fila);

 }

 function consultar_shareFooter(){
 	global $db;
 	$query = "SELECT * FROM smoothop_segundo_parcial.share_footer WHERE status_share_footer = 1";
 	$array = [];
	foreach($db->query($query) as $fila) {

	$temp =	"<li><a href='".$fila['link_share_footer']."' ><img src='".$fila['icon_share_footer']."'alt=''></a></li>" ; 

	array_push($array, $temp);
				}
			echo json_encode($array);
  }

function consultar_iconsFooter(){
 	global $db;
 	$query = "SELECT id_share_footer,link_share_footer, status_share_footer FROM smoothop_segundo_parcial.share_footer";
 	$array = [];
	foreach($db->query($query) as $fila) {

	array_push($array, array('id_share_footer'=>$fila[0], 'link_share_footer'=>$fila[1], 
		'status_share_footer'=>$fila[2]) );
				}
			echo json_encode($array);
	  }

function update_header(){
$titulo= $_POST["titulo"];
$texto= $_POST["texto"];
$boton = $_POST["boton"];
$link = $_POST["link"];

 	global $db;
 	$stmt = $db->prepare("UPDATE smoothop_segundo_parcial.header SET title_header =?, content_header =?, link_header =?, href_header =? WHERE id_header = 1");
 	$stmt->execute(array($titulo, $texto, $boton, $link));
 	$affected_rows = $stmt->rowCount();
 	if ($affected_rows > 0) {
 		echo "1";
 	} else {
 		echo"0";
 	}
 }

function update_download(){
$titulo= $_POST["titulo"];
$texto= $_POST["texto"];
$boton = $_POST["boton"];

 	global $db;
 	$stmt = $db->prepare("UPDATE smoothop_segundo_parcial.download SET title_download =?, content_download =?, button_download =? WHERE id_download = 1");
 	$stmt->execute(array($titulo, $texto, $boton));
 	$affected_rows = $stmt->rowCount();
 	if ($affected_rows > 0) {
 		echo "1";
 	} else {
 		echo"0";
 	}
 }


function update_footer(){
$location= $_POST["location"];
$about= $_POST["about"];
$copyright = $_POST["copyright"];

 	global $db;
 	$stmt = $db->prepare("UPDATE smoothop_segundo_parcial.footer SET location_content_footer =?, about_content_footer =?, copyright_content_footer =? WHERE id_footer = 1");
 	$stmt->execute(array($location, $about, $copyright));
 	$affected_rows = $stmt->rowCount();
 	if ($affected_rows > 0) {
 		echo "1";
 	} else {
 		echo"0";
 	}
 }

function update_shareIcons(){
$id = $_POST["id"];
$link = $_POST["link_"];
$status = $_POST["status_"];
global $db;
 	$stmt = $db->prepare("UPDATE smoothop_segundo_parcial.share_footer SET link_share_footer =?, status_share_footer =?  WHERE id_share_footer =? ");
 	$stmt->execute(array($link, $status, $id));
 	$affected_rows = $stmt->rowCount();
 	if ($affected_rows > 0) {
 		echo "1";
 	} else {
 		echo"0";
	}
 }


 function consultar_team(){
  global $mysqli;
  $consulta = "SELECT * FROM team";
  $resultado = mysqli_query($mysqli, $consulta);
  $arreglo = [];
  while($fila = mysqli_fetch_array($resultado)){
    array_push($arreglo, $fila);
  }
  echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}


function consultar_miembro($id){
  global $mysqli;
  $consulta = "SELECT * FROM team WHERE team_id = $id";
  $resultado = mysqli_query($mysqli, $consulta);
  $fila = mysqli_fetch_array($resultado);
  echo json_encode($fila); //Imprime el JSON ENCODEADO
}

function insertar_team(){
  global $mysqli;
  $team_img = $_POST["imagen"];
  $team_name = $_POST["nombre"]; 
  $team_position = $_POST["cargo"];
  $team_description = $_POST["descripcion"];
  $consulta = "INSERT INTO team VALUES('','$team_img','$team_name','$team_position','$team_description')";
  $resultado = mysqli_query($mysqli, $consulta);
    if ($resultado) {
    echo "Se agrego correctamente";
  } else {
    echo "Se generó un error, intenta nuevamente";
  }

}


function editar_team($id){
  global $mysqli;
  extract($_POST);
  $consulta = "UPDATE team SET team_img = '$imagen', team_name = '$nombre', 
  team_position = '$cargo', team_description = '$descripcion' WHERE team_id = '$id' ";
  $resultado = mysqli_query($mysqli, $consulta);
  if($resultado){
    echo "Se editó correctamente";
  }else{
    echo "Se generó un error, intentalo nuevamente";
  }
}



function eliminar_team($id){
  global $mysqli;
  $query = "DELETE FROM team WHERE team_id = $id";
  $resultado = mysqli_query($mysqli, $query);
  if ($resultado) {
    echo "Se eliminó correctamente";
  } else {
    echo "Se generó un error, intenta nuevamente";
  }
}

  
?>