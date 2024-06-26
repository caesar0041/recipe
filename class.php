<?php

class Database {
    private static $conn;

    public static function connect() {
        if (!self::$conn) {
            $host = 'localhost';
            $dbname = 'recipe';
            $user = 'root';
            $pass = '';
            $dsn = "mysql:host=$host;dbname=$dbname";
            try {
                self::$conn = new PDO($dsn, $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                self::$conn = null;
            }
        }
        return self::$conn;
    }
}

class User {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function save($fname, $lname, $username, $password, $role) {
        if (!$this->conn) {
            echo "Error: Unable to connect to the database.";
            return false;
        }
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = $this->conn->prepare("INSERT INTO users (fname, lname, username, password, role) VALUES (:fname, :lname, :username, :password, :role)");

            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $hashed_password);
            $query->bindParam(':role', $role);

            $response = $query->execute();
            if ($response) {
                return $this->conn->lastInsertId();
            } else {
                echo "Error: Unable to execute the query.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAll() {
        try {
            $query = $this->conn->prepare("SELECT * FROM users");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function search($searchQuery = '') {
        try {
            $sql = "SELECT * FROM users";
            if (!empty($searchQuery)) {
                $sql .= " WHERE fname LIKE :searchQuery OR lname LIKE :searchQuery OR username LIKE :searchQuery OR role LIKE :searchQuery";
            }

            $query = $this->conn->prepare($sql);

            if (!empty($searchQuery)) {
                $searchQuery = '%' . $searchQuery . '%';
                $query->bindParam(':searchQuery', $searchQuery);
            }

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($user_id, $fname, $lname, $username, $password, $role) {
        try {
            if (empty($password)) {
                $query = $this->conn->prepare("SELECT password FROM users WHERE user_id = :user_id");
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

            $query = $this->conn->prepare("UPDATE users SET fname = :fname, lname = :lname, username = :username, password = :password, role = :role, updated_at = NOW() WHERE user_id = :user_id");
            $query->bindParam(':user_id', $user_id);
            $query->bindParam(':fname', $fname);
            $query->bindParam(':lname', $lname);
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $hashed_password);
            $query->bindParam(':role', $role);

            return $query->execute();
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function delete($user_id) {
        try {
            $query = $this->conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $query->bindParam(':user_id', $user_id);
            return $query->execute();
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function getById($user_id) {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $query->bindParam(':user_id', $user_id);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function getByUsername($username) {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $query->bindParam(':username', $username);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function authenticate($username, $password) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $query = $this->conn->prepare($sql);

            $query->bindParam(':username', $username);
            $query->execute();

            if ($query->rowCount() > 0) {
                $user = $query->fetch(PDO::FETCH_ASSOC);
                $hashed_password_db = $user['password'];

                if (password_verify($password, $hashed_password_db)) {
                    $updateQuery = $this->conn->prepare("UPDATE users SET last_login = NOW() WHERE user_id = :user_id");
                    $updateQuery->bindParam(':user_id', $user['user_id']);
                    $updateQuery->execute();

                    return $user;
                } else {
                    error_log("Invalid password for user: $username");
                    return false;
                }
            } else {
                error_log("User not found: $username");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error in authenticate function: " . $e->getMessage());
            return false;
        }
    }
}

class Category {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function add($category_name, $category_type) {
        try {
            $query = $this->conn->prepare("INSERT INTO CATEGORY (category_name, category_type) VALUES (:category_name, :category_type)");
            $query->bindParam(':category_name', $category_name);
            $query->bindParam(':category_type', $category_type);
            return $query->execute();
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function search($searchQuery = '') {
        try {
            $sql = "SELECT c.*, COUNT(r.recipe_id) AS recipe_count
                    FROM category c
                    LEFT JOIN recipe_category rc ON c.category_id = rc.category_id
                    LEFT JOIN recipe r ON rc.recipe_id = r.recipe_id AND r.status = 1";
        
            if (!empty($searchQuery)) {
                $sql .= " WHERE c.category_name LIKE :searchQuery OR c.category_type LIKE :searchQuery";
            }

            $sql .= " GROUP BY c.category_id";

            $query = $this->conn->prepare($sql);

            if (!empty($searchQuery)) {
                $searchQuery = '%' . $searchQuery . '%';
                $query->bindParam(':searchQuery', $searchQuery);
            }

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function getAll() {
        try {
            $query = $this->conn->prepare("SELECT * FROM CATEGORY");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }
}

class Recipe {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function add($recipe_title, $description, $category_id, $video_link) {
        try {
            $query = $this->conn->prepare("INSERT INTO recipe (recipe_title, description, video_link, status) VALUES (:recipe_title, :description, :video_link, 1)");
            $query->bindParam(':recipe_title', $recipe_title);
            $query->bindParam(':description', $description);
            $query->bindParam(':video_link', $video_link);
            $query->execute();

            $recipe_id = $this->conn->lastInsertId();

            $query = $this->conn->prepare("INSERT INTO recipe_category (recipe_id, category_id) VALUES (:recipe_id, :category_id)");
            $query->bindParam(':recipe_id', $recipe_id);
            $query->bindParam(':category_id', $category_id);
            return $query->execute();
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function update($recipe_id, $recipe_title, $description, $video_link, $category_id) {
        try {
            $query = $this->conn->prepare("UPDATE recipe SET recipe_title = :recipe_title, description = :description, video_link = :video_link WHERE recipe_id = :recipe_id");
            $query->bindParam(':recipe_id', $recipe_id);
            $query->bindParam(':recipe_title', $recipe_title);
            $query->bindParam(':description', $description);
            $query->bindParam(':video_link', $video_link);
            $query->execute();

            $query = $this->conn->prepare("UPDATE recipe_category SET category_id = :category_id WHERE recipe_id = :recipe_id");
            $query->bindParam(':recipe_id', $recipe_id);
            $query->bindParam(':category_id', $category_id);
            return $query->execute();
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function getAll() {
        try {
            $query = $this->conn->prepare("SELECT r.*, c.category_name FROM recipe r JOIN recipe_category rc ON r.recipe_id = rc.recipe_id JOIN category c ON rc.category_id = c.category_id");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }

    public function search($searchQuery = '') {
        try {
            $sql = "SELECT r.*, c.category_name
                    FROM recipe r
                    JOIN recipe_category rc ON r.recipe_id = rc.recipe_id
                    JOIN category c ON rc.category_id = c.category_id";
            if (!empty($searchQuery)) {
                $sql .= " WHERE r.recipe_title LIKE :searchQuery OR c.category_name LIKE :searchQuery";
            }
            $sql .= " AND r.status = 1";

            $query = $this->conn->prepare($sql);

            if (!empty($searchQuery)) {
                $searchQuery = '%' . $searchQuery . '%';
                $query->bindParam(':searchQuery', $searchQuery);
            }

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query execution failed: " . $e->getMessage();
            return false;
        }
    }
}


