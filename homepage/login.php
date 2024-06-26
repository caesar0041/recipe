<!--homepage/login.php-->
<?php
ob_start();
require_once('../templates/header.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = authenticate_user($username, $password);

        if ($user) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];

            if ($_SESSION['user_role'] == 'Admin') {
                header("Location: ../admin_dashboard/index.php");
            } elseif ($_SESSION['user_role'] == 'Chef') {
                header("Location: ../chef_dashboard/index.php");
            } else {
                header("Location: homepage/login.php");
            }
            exit;
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    }
}
ob_end_flush();
?>


<main class="container-md col-md-5 mt-5 bg-DFC8B4">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h3 class="card-title">SIGN IN</h3>
        </div>
        <div class="card-body">
            <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label text-968853">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-968853">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                        <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn">Show</button>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="save" class="btn btn-success">Sign In</button>
                </div>
            </form>
        </div>

    </div>
</main>

<script src="<?php echo BASE_URL;?>/assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const showPasswordBtn = document.getElementById('showPasswordBtn');

        showPasswordBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordBtn.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                showPasswordBtn.textContent = 'Show';
            }
        });
    });
</script>

</body>
</html>
