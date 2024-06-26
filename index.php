<?php require_once('templates/header.php');
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$recipes = searchRecipe($searchQuery);
?>
<main class="bg-DFC8B4">
  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/images/pic1.jpg" class="d-block w-100" alt="First slide">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1 class="text-EEC965">Taste the Magic</h1>
            <p class="opacity-80 text-D6D3CE">Discover recipes that bring joy to your table!</p>
            <p><a class="btn btn-lg btn-EEC965" href="homepage/browse.php">Browse Recipes</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/pic2.jpg" class="d-block w-100" alt="Second slide">
        <div class="container">
          <div class="carousel-caption">
            <h1 class="text-EEC965">Delicious Delights Await</h1>
            <p class="text-D6D3CE">Explore a world of flavors with our curated recipes.</p>
            <p><a class="btn btn-lg btn-EEC965" href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/pic3.jpg" class="d-block w-100" alt="Third slide">
        <div class="container">
          <div class="carousel-caption text-end">
            <h1 class="text-EEC965">Kitchen Creativity</h1>
            <p class="text-D6D3CE">Unlock your culinary potential with our diverse recipes!</p>
            <p><a class="btn btn-lg btn-EEC965" href="#">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  
  <div class="container marketing bg-D6D3CE">
    <div class="row">
      <div class="col-lg-4">
        <img src="assets/images/pic4.jpg" class="circle-img" alt="Appetizers">
        <h2 class="fw-normal text-403F42">Delicious Appetizers</h2>
        <p class="text-808285">Start your meal with our mouth-watering appetizers that set the perfect tone for a delightful dining experience.</p>
        <p><a class="btn btn-secondary btn-EEC965" href="#">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img src="assets/images/pic5.jpg" class="circle-img" alt="Main Courses">
        <h2 class="fw-normal text-403F42">Satisfying Main Courses</h2>
        <p class="text-808285">Explore our collection of hearty main courses that are sure to satisfy your hunger and tantalize your taste buds.</p>
        <p><a class="btn btn-secondary btn-EEC965" href="#">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img src="assets/images/pic6.jpg" class="circle-img" alt="Desserts">
        <h2 class="fw-normal text-403F42">Delectable Desserts</h2>
        <p class="text-808285">End your meal on a sweet note with our irresistible dessert recipes that are perfect for any occasion.</p>
        <p><a class="btn btn-secondary btn-EEC965" href="#">View details &raquo;</a></p>
      </div>
    </div>
    <hr class="featurette-divider bg-6C6D70">
    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1 text-B88C14">Discover new flavors. <span class="text-403F42 ">Explore culinary delights.</span></h2>
        <p class="lead text-808285">Dive into a world of delicious recipes that will tantalize your taste buds and inspire your next meal.</p>
      </div>
      <div class="col-md-5">
        <img src="assets/images/pic7.jpg" class="d-block w-100 featurette-image img-fluid mx-auto" alt="Feature Image 1">
      </div>
    </div>
    <hr class="featurette-divider bg-6C6D70">
    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading fw-normal lh-1 text-B88C14">Oh yeah, it’s that good. <span class="text-403F42">See for yourself.</span></h2>
        <p class="lead text-808285">Savor the taste of expertly crafted recipes that bring the joy of cooking to your kitchen.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <img src="assets/images/pic8.jpg" class="d-block w-100 featurette-image img-fluid mx-auto" alt="Feature Image 2">
      </div>
    </div>
    <hr class="featurette-divider bg-6C6D70">
    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1 text-B88C14">And lastly, this one. <span class="text-403F42 ">Checkmate.</span></h2>
        <p class="lead text-808285">Experience the perfect blend of flavors with recipes that bring the finest ingredients together.</p>
      </div>
      <div class="col-md-5">
        <img src="assets/images/pic9.jpg" class="d-block w-100 featurette-image img-fluid mx-auto" alt="Feature Image 3">
      </div>
    </div>
    <hr class="featurette-divider bg-6C6D70">
  </div>
<?php require_once('templates/footer.php');?>
