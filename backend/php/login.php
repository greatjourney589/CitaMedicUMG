<?php 
    require '../backend/bd/Conexion.php';

    if(isset($_POST['login'])) {
    $errMsg = '';

    // Get data from FORM
    $username = $_POST['username'];
    
    $password = MD5($_POST['password']);

    if($username == '')
      $errMsg = 'Digite su usuario';
    if($password == '')
      $errMsg = 'Digite su contraseña';

    if($errMsg == '') {
      try {
$stmt = $connect->prepare('SELECT id, username, name, email, password, rol FROM users WHERE username = :username');


        $stmt->execute(array(
          ':username' => $username
          
          
          ));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data == false){
          $errMsg = "El usuario: $username no se encuentra , puede solicitarlo con el administrador.";
        }
        else {
          if($password == $data['password']) {

            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['name'] = $data['name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['password'] = $data['password'];
            $_SESSION['rol'] = $data['rol'];
           
            
            
          if($_SESSION['rol'] == 1){
                header('Location: admin/escritorio.php');
              }
                  exit;
                }
                else
                  $errMsg = 'Contraseña incorrecta.';
        }
      }
      catch(PDOException $e) {
        $errMsg = $e->getMessage();
      }
    }
  }
 ?>