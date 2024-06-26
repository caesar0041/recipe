<!--function.php-->
<?php
function getDbConnect() {
    $host = 'localhost';
    $dbname = 'recipe';
    $user = 'root';
    $pass = '';
    $dsn = "mysql:host=$host;dbname=$dbname";
    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

/*function saveData($fname, $lname, $username, $password, $role) {
    $conn = getDbConnect();
    if (!$conn) {
        echo "Error: Unable to connect to the database.";
        return false;
    }
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = $conn->prepare("INSERT INTO users (fname, lname, username, password, role) VALUES (:fname, :lname, :username, :password, :role)");

        $query->bindParam(':fname', $fname);
        $query->bindParam(':lname', $lname);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $hashed_password);
        $query->bindParam(':role', $role);

        $response = $query->execute();
        if ($response) {
            $user_id = $conn->lastInsertId();
            $conn = null;
            return $user_id;
        } else {
            $conn = null;
            echo "Error: Unable to execute the query.";
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}*/

function getAllRecords() {
    $conn = getDbConnect();
    $query = $conn->prepare("SELECT * FROM users");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function searchUser($searchQuery = '') {
    $conn = getDbConnect();
    $sql = "SELECT * FROM users";
    if (!empty($searchQuery)) {
        $sql .= " WHERE fname LIKE :searchQuery OR lname LIKE :searchQuery OR username LIKE :searchQuery OR role LIKE :searchQuery";    }
    
        $query = $conn->prepare($sql);

    if (!empty($searchQuery)) {
        $searchQuery = '%' . $searchQuery . '%';
        $query->bindParam(':searchQuery', $searchQuery);    }

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function updateUser($user_id, $fname, $lname, $username, $password, $role) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        if (empty($password)) {
            $query = $conn->prepare("SELECT password FROM users WHERE user_id = :user_id");
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if (!$user) {
                throw new PDOException("User not found");
            }
            $hashed_password = $user['password'];
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }

        $query = $conn->prepare("UPDATE users SET fname = :fname, lname = :lname, username = :username, password = :password, role = :role, updated_at = NOW() WHERE user_id = :user_id");
        $query->bindParam(':user_id', $user_id);
        $query->bindParam(':fname', $fname);
        $query->bindParam(':lname', $lname);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $hashed_password);
        $query->bindParam(':role', $role);

        $response = $query->execute();

        $conn = null;
        return $response;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function deleteUser($user_id) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $query = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
        $query->bindParam(':user_id', $user_id);

        $response = $query->execute();

        $conn = null;
        return $response;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function countData() {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $count = array();

        $query = $conn->prepare("SELECT COUNT(*) AS user_count FROM users WHERE role = 'Chef'");
        $query->execute();
        $count['user'] = $query->fetch(PDO::FETCH_ASSOC)['user_count'];

        $query = $conn->prepare("SELECT COUNT(*) AS recipe_count FROM recipe WHERE status=1");
        $query->execute();
        $count['recipe'] = $query->fetch(PDO::FETCH_ASSOC)['recipe_count'];

        $query = $conn->prepare("SELECT COUNT(*) AS category_count FROM category");
        $query->execute();
        $count['category'] = $query->fetch(PDO::FETCH_ASSOC)['category_count'];

        $conn = null;
        return $count;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
function getUserById($user_id) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $query = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->bindParam(':user_id', $user_id);

        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $conn = null;
        return $result;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function getUserByUsername($username) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $conn = null;
        return $result;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function authenticate_user($username, $password) {
    $conn = getDbConnect();

    if (!$conn) {
        error_log("Failed to connect to the database.");
        return false;
    }

    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $query = $conn->prepare($sql);

        $query->bindParam(':username', $username);
        $query->execute();

        if ($query->rowCount() > 0) {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $hashed_password_db = $user['password'];

            if (password_verify($password, $hashed_password_db)) {
                $updateQuery = $conn->prepare("UPDATE users SET last_login = NOW() WHERE user_id = :user_id");
                $updateQuery->bindParam(':user_id', $user['user_id']);
                $updateQuery->execute();

                $conn = null;
                return $user;
            } else {
                error_log("Invalid password for user: $username");
                $conn = null;
                return false;
            }
        } else {
            error_log("User not found: $username");
            $conn = null;
            return false;
        }
    } catch (PDOException $e) {
        error_log("Error in authenticate_user function: " . $e->getMessage());
        return false;
    }
}
function addCategory($category_name, $category_type) {
    $conn = getDbConnect();

    if (!$conn) {
        return false;
    }

    try {
        $query = $conn->prepare("INSERT INTO CATEGORY (category_name, category_type) VALUES (:category_name, :category_type)");
        $query->bindParam(':category_name', $category_name);
        $query->bindParam(':category_type', $category_type);

        $response = $query->execute();

        $conn = null;
        return $response;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function searchCategory($searchQuery = '') {
    $conn = getDbConnect();

    $sql = "SELECT c.*, COUNT(r.recipe_id) AS recipe_count
            FROM category c
            LEFT JOIN recipe_category rc ON c.category_id = rc.category_id
            LEFT JOIN recipe r ON rc.recipe_id = r.recipe_id AND r.status = 1";
    
    if (!empty($searchQuery)) {
        $sql .= " WHERE c.category_name LIKE :searchQuery OR c.category_type LIKE :searchQuery";
    }

    $sql .= " GROUP BY c.category_id";

    $query = $conn->prepare($sql);

    if (!empty($searchQuery)) {
        $searchQuery = '%' . $searchQuery . '%';
        $query->bindParam(':searchQuery', $searchQuery);
    }

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
function getAllCategories() {
    $conn = getDbConnect();

    try {
        $query = $conn->prepare("SELECT * FROM CATEGORY");
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
        return false;
    }
    return true;
}

function insertRecipe($user_id, $recipe_data) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $conn->beginTransaction();

        $query = $conn->prepare("INSERT INTO RECIPE (user_id, recipe_name, cooking_time, serving_size, instructions, recipe_image, status) VALUES (:user_id, :recipe_name, :cooking_time, :serving_size, :instructions, :recipe_image, :status)");
        $query->execute([
            ':user_id' => $user_id,
            ':recipe_name' => $recipe_data['recipe_name'],
            ':cooking_time' => $recipe_data['cooking_time'],
            ':serving_size' => $recipe_data['serving_size'],
            ':instructions' => $recipe_data['instructions'],
            ':recipe_image' => $recipe_data['recipe_image'],
            ':status' => $recipe_data['status']
        ]);

        $recipe_id = $conn->lastInsertId();

        $query = $conn->prepare("INSERT INTO RECIPE_CATEGORY (recipe_id, category_id) VALUES (:recipe_id, :category_id)");
        foreach ($recipe_data['category_ids'] as $category_id) {
            $query->execute([
                ':recipe_id' => $recipe_id,
                ':category_id' => $category_id
            ]);
        }

        foreach ($recipe_data['ingredients'] as $ingredient) {
            $ingredient_id = getIngredientIdByName($ingredient['name']);
            if (!$ingredient_id) {
                $query = $conn->prepare("INSERT INTO INGREDIENT (ingredient_name) VALUES (:ingredient_name)");
                $query->execute([':ingredient_name' => $ingredient['name']]);
                $ingredient_id = $conn->lastInsertId();
            }

            $query = $conn->prepare("INSERT INTO RECIPE_INGREDIENT (recipe_id, ingredient_id, quantity) VALUES (:recipe_id, :ingredient_id, :quantity)");
            $query->execute([
                ':recipe_id' => $recipe_id,
                ':ingredient_id' => $ingredient_id,
                ':quantity' => $ingredient['quantity']
            ]);
        }

        $conn->commit();
        return true;
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getIngredientIdByName($ingredient_name) {
    $conn = getDbConnect();
    if (!$conn) {
        return null;
    }

    try {
        $query = $conn->prepare("SELECT ingredient_id FROM INGREDIENT WHERE ingredient_name = :ingredient_name");
        $query->execute([':ingredient_name' => $ingredient_name]);
        $ingredient = $query->fetch(PDO::FETCH_ASSOC);

        return $ingredient ? $ingredient['ingredient_id'] : null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}
function getPublishedRecipesForUser($user_id) {
    $conn = getDbConnect();
    if (!$conn) {
        error_log("Failed to connect to the database.");
        return ['recipes' => [], 'recipe_count' => 0];
    }

    try {
        $query = $conn->prepare("SELECT * FROM RECIPE WHERE user_id = :user_id");
        $query->execute([':user_id' => $user_id]);
        $recipes = $query->fetchAll(PDO::FETCH_ASSOC);

        $countQuery = $conn->prepare("SELECT COUNT(*) AS recipe_count FROM RECIPE WHERE user_id = :user_id AND status =1");
        $countQuery->execute([':user_id' => $user_id]);
        $recipeCount = $countQuery->fetch(PDO::FETCH_ASSOC)['recipe_count'];

        if (empty($recipes)) {
            error_log("No recipes found for user_id: $user_id");
        }

        return ['recipes' => $recipes, 'recipe_count' => $recipeCount];
    } catch (PDOException $e) {
        error_log("Error fetching recipes: " . $e->getMessage());
        return ['recipes' => [], 'recipe_count' => 0];
    }
}
function updateRecipe($recipe_id, $recipe_data) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $conn->beginTransaction();

        $sql = "UPDATE RECIPE SET 
                    recipe_name = :recipe_name, 
                    cooking_time = :cooking_time, 
                    serving_size = :serving_size, 
                    instructions = :instructions, 
                    status = :status";
        
        if (!empty($recipe_data['recipe_image'])) {
            $sql .= ", recipe_image = :recipe_image";
        }

        $sql .= " WHERE recipe_id = :recipe_id";
        
        $query = $conn->prepare($sql);

        $params = [
            ':recipe_name' => $recipe_data['recipe_name'],
            ':cooking_time' => $recipe_data['cooking_time'],
            ':serving_size' => $recipe_data['serving_size'],
            ':instructions' => $recipe_data['instructions'],
            ':status' => $recipe_data['status'],
            ':recipe_id' => $recipe_id
        ];

        if (!empty($recipe_data['recipe_image'])) {
            $params[':recipe_image'] = $recipe_data['recipe_image'];
        }

        $query->execute($params);
        $deleteQuery = $conn->prepare("DELETE FROM RECIPE_CATEGORY WHERE recipe_id = :recipe_id");
        $deleteQuery->execute([':recipe_id' => $recipe_id]);

        $insertQuery = $conn->prepare("INSERT INTO RECIPE_CATEGORY (recipe_id, category_id) VALUES (:recipe_id, :category_id)");
        foreach ($recipe_data['category_ids'] as $category_id) {
            $insertQuery->execute([
                ':recipe_id' => $recipe_id,
                ':category_id' => $category_id
            ]);
        }

        $deleteQuery = $conn->prepare("DELETE FROM RECIPE_INGREDIENT WHERE recipe_id = :recipe_id");
        $deleteQuery->execute([':recipe_id' => $recipe_id]);

        $insertQuery = $conn->prepare("INSERT INTO RECIPE_INGREDIENT (recipe_id, ingredient_id, quantity) VALUES (:recipe_id, :ingredient_id, :quantity)");
        foreach ($recipe_data['ingredients'] as $ingredient) {
            $ingredient_id = getIngredientIdByName($ingredient['name']);
            if (!$ingredient_id) {
                $query = $conn->prepare("INSERT INTO INGREDIENT (ingredient_name) VALUES (:ingredient_name)");
                $query->execute([':ingredient_name' => $ingredient['name']]);
                $ingredient_id = $conn->lastInsertId();
            }

            $insertQuery->execute([
                ':recipe_id' => $recipe_id,
                ':ingredient_id' => $ingredient_id,
                ':quantity' => $ingredient['quantity']
            ]);
        }

        $conn->commit();
        return true;
    } catch (PDOException $e) {
        $conn->rollBack();
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function getRecipeById($recipe_id) {
    $conn = getDbConnect();
    if (!$conn) {
        return null;
    }

    try {
        $query = $conn->prepare("
            SELECT r.*, u.username 
            FROM RECIPE r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.recipe_id = :recipe_id
        ");
        $query->bindParam(':recipe_id', $recipe_id);
        $query->execute();
        $recipe = $query->fetch(PDO::FETCH_ASSOC);

        return $recipe ? $recipe : null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}
function deleteRecipe($recipe_id) {
    $conn = getDbConnect();
    if (!$conn) {
        return false;
    }

    try {
        $query = $conn->prepare("DELETE FROM recipe WHERE recipe_id = :recipe_id");
        $query->bindParam(':recipe_id', $recipe_id);

        $response = $query->execute();

        $conn = null;
        return $response;
    } catch (PDOException $e) {
        echo "Query execution failed: " . $e->getMessage();
        return false;
    }
}
function searchRecipe($searchQuery = '') {
    $conn = getDbConnect();
    if (!$conn) {
        return [];
    }

    try {
        $sql = "
            SELECT DISTINCT r.*, u.username
            FROM recipe r
            JOIN users u ON r.user_id = u.user_id
            WHERE u.role = 'Chef' AND r.status = 1
        ";

        if (!empty($searchQuery)) {
            $sql .= " AND (
                        r.recipe_name LIKE :searchQuery 
                        OR r.cooking_time LIKE :searchQuery 
                        OR r.serving_size LIKE :searchQuery
                        OR u.username LIKE :searchQuery
                        OR EXISTS (
                            SELECT 1
                            FROM recipe_category rc
                            JOIN category c ON rc.category_id = c.category_id
                            WHERE rc.recipe_id = r.recipe_id
                            AND c.category_name LIKE :searchQuery
                        )
                        OR EXISTS (
                            SELECT 1
                            FROM recipe_ingredient ri
                            JOIN ingredient i ON ri.ingredient_id = i.ingredient_id
                            WHERE ri.recipe_id = r.recipe_id
                            AND i.ingredient_name LIKE :searchQuery
                        )
                    )";
        }

        $sql .= " ORDER BY r.published_at DESC";


        $query = $conn->prepare($sql);

        if (!empty($searchQuery)) {
            $searchQuery = '%' . $searchQuery . '%';
            $query->bindParam(':searchQuery', $searchQuery, PDO::PARAM_STR);
        }

        $query->execute();
        $recipes = $query->fetchAll(PDO::FETCH_ASSOC);
  
        return $recipes;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    } finally {
        $conn = null;
    }
}

function getCategoriesByRecipeId($recipeId) {
    $conn = getDbConnect();
    if (!$conn) {
        return [];
    }

    try {
        $sql = "
            SELECT c.category_id, c.category_name, c.category_type
            FROM category c
            JOIN recipe_category rc ON c.category_id = rc.category_id
            WHERE rc.recipe_id = :recipeId
        ";

        $query = $conn->prepare($sql);
        $query->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    } finally {
        $conn = null;
    }
}

function getIngredientsForRecipe($recipeId) {
    $conn = getDbConnect();
    if (!$conn) {
        return [];
    }

    try {
        $sql = "
            SELECT i.ingredient_name, ri.quantity
            FROM ingredient i
            JOIN recipe_ingredient ri ON i.ingredient_id = ri.ingredient_id
            WHERE ri.recipe_id = :recipeId
        ";

        $query = $conn->prepare($sql);
        $query->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    } finally {
        $conn = null;
    }
}
