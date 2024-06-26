<!--homepage/contact.php-->
<?php require_once('../templates/header.php'); 
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$recipes = searchRecipe($searchQuery);
?>

<main>
  <div class="container marketing">
    <hr class="featurette-divider">
    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">Contact Us<span class="text-body-secondary"></span></h2>
        <p class="lead">Feel free to reach out to us with any questions or feedback. <p>Lorem ipsum dolor sit amet. Ut doloribus aliquam et vitae vero est porro autem At veritatis laudantium. Est repudiandae repudiandae ea expedita consectetur cum temporibus quia ut autem dolore eos odit cumque vel aperiam necessitatibus qui sequi perferendis? </p></p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">
<?php require_once('../templates/footer.php'); ?>
