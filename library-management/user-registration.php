<?php
include "header-section.php";

if (isset($_POST["register"])) {
  $stmt = $db_connection_object->prepare("insert into user(name, email, phone, address, password, user_role_id) values(?, ?, ?, ?, ?, (select role_id from user_role where role=?))");
  $stmt->bind_param("ssssss", $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["address"], $_POST["password"], $_POST["user_role"]);
  $stmt->execute();

  header('location:user-login.php?user_registration=success');
}

?>

<div class="container">
  <div class="page-heading mt-4">
    <center>
      <h2 class="text-light">Register</h2>
    </center>
  </div>
  <div class="row my-5">
    <div class="col-sm-8 col-md-6 offset-sm-2 offset-md-3">

      <div class="card">
        <div class="card-body">
          <form action="#" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" required />
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required />
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Phone</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" required />
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Home Address</label>
              <textarea type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="address" required ></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" minlength="8" required>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">User Role</label>
              <select class="form-control" id="exampleFormControlSelect1" name="user_role" required>
                <option  value="Student">Student</option>
                <option  value="Librarian">Librarian</option>
              </select>
            </div>
            <br>
            <center>
              <button type="submit" class="btn btn-purple" name="register"><b>Register</b></button>
            </center>
          </form>
        </div>
      </div>
    </div>

  </div>

</div>

<?php include "bottom-bar.php" ?>