<?php
ob_start();
require_once('../templates/header3.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);
$recipeData = getPublishedRecipesForUser($user_id);
$recipes = $recipeData['recipes'];
$recipeCount = $recipeData['recipe_count'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $conn = getDbConnect();
            $query = $conn->prepare("UPDATE users SET user_image = :user_image WHERE user_id = :user_id");
            $query->bindParam(':user_image', $target_file);
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            $conn = null;
            $user['user_image'] = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center d-flex justify-content-center mx-auto" style="width: 128px; height: 128px; overflow: hidden; border-radius: 50%;">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?php echo !empty($user['user_image']) ? $user['user_image'] : '../../dist/img/user4-128x128.jpg'; ?>"
                                     alt="User profile picture"
                                     style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <h3 class="profile-username text-center"><?php echo (string)$user['fname'] . ' ' . $user['lname']; ?></h3>
                            <p class="text-muted text-center"><?php echo (string)$user['role']; ?></p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Published Recipes:</b> <a class="float-right"><strong><?php echo $recipeCount . " Recipes"; ?></strong></a>
                                </li>
                            </ul>

                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Upload:</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-secondary">Cancel</a>
                                        <input type="submit" name="submit" value="Upload Profile Picture" class="btn btn-success float-right">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once('../templates/footer2.php'); ?>
