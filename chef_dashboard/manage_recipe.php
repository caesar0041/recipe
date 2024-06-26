<?php
ob_start();
require_once('../templates/header3.php');
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);
$recipeData = getPublishedRecipesForUser($user_id);
$recipes = $recipeData['recipes'];
$recipeCount = $recipeData['recipe_count'];
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Manage Recipes</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Manage Recipes</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
  <section class="content">
    <div class="album">
      <div class="row justify-content-center">
        <?php if (!empty($recipes)): ?>
          <?php foreach ($recipes as $recipe): ?>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <?php if (!empty($recipe['recipe_image'])): ?>
                  <img class="card-img-top" style="width: 100%; height: 300px; max-height: 300px; object-fit: cover;" src="../uploads/<?php echo htmlspecialchars($recipe['recipe_image']); ?>" alt="<?php echo htmlspecialchars($recipe['recipe_name']); ?>">
                <?php endif; ?>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><strong><?php echo htmlspecialchars($recipe['recipe_name']); ?></strong></h5>
                    <?php if ($recipe['status'] == 1): ?>
                      <span class="badge badge-success">Published</span>
                    <?php else: ?>
                      <span class="badge badge-warning">Not Published</span>
                    <?php endif; ?>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="edit_recipe.php?recipe_id=<?php echo htmlspecialchars($recipe['recipe_id']); ?>">Edit</a>
                        <a class="dropdown-item delete-btn" href="#" data-id="<?php echo htmlspecialchars($recipe['recipe_id']); ?>">Delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-md-12">
            <p>You have not published any recipes yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this recipe?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<?php require_once('../templates/footer2.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    let recipeIdToDelete;

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        recipeIdToDelete = this.getAttribute('data-id');
        $('#deleteModal').modal('show');
      });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
      fetch(`delete_recipe.php?recipe_id=${recipeIdToDelete}`, {
          method: 'DELETE'
        })
        .then(response => {
          if (response.ok) {
            window.location.reload();
          } else {
            console.error('Error deleting recipe');
          }
        })
        .catch(error => console.error('Error:', error));
    });
  });
</script>
