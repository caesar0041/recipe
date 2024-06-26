<!--admin_dashboard/user_edit.php-->
<?php
require_once('../function.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $user_data = getUserById($user_id);

    if ($user_data) {
        if (isset($_POST['update'])) {
            $fname = (string)(trim($_POST['fname']));
            $lname = (string)(trim($_POST['lname']));
            $username = (string)(trim($_POST['username']));
            $password = trim($_POST['password']);
            $role = (string)(trim($_POST['role']));

            if (!empty($fname) && !empty($lname) && !empty($username) && !empty($role)) {
                $response = updateUser($user_id, $fname, $lname, $username, $password, $role);

                if ($response) {
                    header("Location: users.php?success=1");
                    exit();
                } else {
                    header("Location: users.php?error=1");
                    exit();
                }
            } else {
                header("Location: user_edit.php?user_id=$user_id&error=1");
                exit();
            }
        }
        require_once('../templates/header2.php');
?>

<div class="content-wrapper">
    <section class="content">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit User Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
              <li class="breadcrumb-item active">RECIPE</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                <?php
							if(isset($_GET['success']) && $_GET['success'] == 1){
                                echo '<div class="alert alert-success" >The data has been successfully saved.</div>'; }
							else if(isset($_GET['error']) && $_GET['error'] == 1)
							{ echo '<div class="alert alert-danger" >Error: Unable to save.</div>';	}
				?>
                    <div class="card card-info">
                    <div class="card-header">
                <h3 class="card-title">Edit User Information</h3>
              </div>
                        <form method="POST" action="user_edit.php?user_id=<?php echo $user_id; ?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control" name="fname" value="<?php echo (string)($user_data['fname']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="<?php echo (string)($user_data['lname']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo (string)($user_data['username']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <small class="form-text text-muted">Leave blank to keep current password</small>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" class="form-control">
                                        <option value="Admin" <?php if ($user_data['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                                        <option value="Chef" <?php if ($user_data['role'] == 'Chef') echo 'selected'; ?>>Chef</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <input type="hidden" name="update" value="true">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once('../templates/footer2.php');
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}
?>
