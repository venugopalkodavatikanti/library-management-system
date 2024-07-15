<?php 
include "header-section.php";

if(isset($_POST["login"])){

  $stmt = $db_connection_object->prepare("select user.*, user_role.role from user inner join user_role
  on user.user_role_id = user_role.role_id where email = ? and password = ? ");
	$stmt->bind_param("ss", $_POST["email"], $_POST["password"]);
	$stmt->execute();
  $result = $stmt->get_result();
  if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
      $user_id = $data["user_id"];
      $username = $data["name"];
      $email = $data["email"];
      $role = $data["role"];
    }
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
    header('location:index.php');
  } else {
    header('location:user-login.php?user_login=failed');
  }
}

?>

<div class="container">
    <div class="page-heading mt-4"><center><h2 class="text-light">Login</h2></center></div>
    <div class="row my-5">
        <div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">
            
            <div class="card">
                <div class="card-body">
                  <?php if(isset($_GET["user_registration"])){
                    if($_GET["user_registration"] == "success"){ ?>
                      <div class="alert alert-success" role="alert">
                        User has been registered successfully
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                      </div>
                      
                    <?php }
                  }
                    ?>
                     <?php if(isset($_GET["user_login"])){
                    if($_GET["user_login"] == "failed"){ ?>
                      <div class="alert alert-danger" role="alert">
                        User login credential is incorrect
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                      </div>
                      
                    <?php }
                  }
                    ?>
                    <form action="#" method="post">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required/>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        <div class="form-group">
    
                        <br>
                        <center>
                            <button type="submit" class="btn btn-purple" name="login"><b>Login</b></button>
                        </center>
                      </form>
                </div>
            </div>
        </div>
       
    </div>
    
</div>

<?php include "bottom-bar.php" ?>
