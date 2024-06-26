<!--admin_dashboard/user_register.php-->
<?php 
require_once('../templates/header2.php');
?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Register a new Chef!</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>index.php">Home</a></li>
              <li class="breadcrumb-item active">Register User</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-8">
          <?php
            if(isset($_GET['success']) && $_GET['success'] == 1){
              echo '<div class="alert alert-success" >The data has been successfully saved.</div>'; }

            else if(isset($_GET['error']) && $_GET['error'] == 1){
              echo '<div class="alert alert-danger" >Error: Unable to save.</div>'; }
          ?>
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Add New User</h3>
              </div>
              <form method="POST" action="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" name="fname" id="exampleName" placeholder="Enter first name">
                  </div>
                  <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="exampleName" placeholder="Enter last name">
                  </div>
                  <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" name="username" id="exampleUsername" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                      <label for="role">ROLE</label>
                      <select name="role" class="form-control" id="exampleRole">
                          <option value="Admin">Admin</option>
                          <option value="Chef">Chef</option>
                      </select>
                  </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                  <button type="submit" name="save" class="btn btn-success">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php require_once('../templates/footer2.php'); ?>
