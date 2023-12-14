<!DOCTYPE html>
<head>
<link rel='stylesheet' href="icons/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>

<?php



class User {
    public $name = "";
    public $email = "";
    public $password = "";
    public $password_hash = "";
    public $token = "";
    private $connection;
    public $authenticated = false;
    public $id;
    public $like_button = "0";

    function __construct() {

    }

    // Assume that the email and password are UNSAFE:
    function sign_up($connection, $name, $email, $password) {
        $this->name  = mysqli_real_escape_string($connection, $name);
        $this->email = mysqli_real_escape_string($connection, $email);
        $this->password = mysqli_real_escape_string($connection, $password);

        $this->token = md5(rand() . time());
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);

        $this->connection = $connection;
    }

    function user_email_check($email) {
        $email = mysqli_real_escape_string($this->connection, $email); 
    
        $sql = "SELECT email FROM user_login WHERE email = '$email'"; 
        $sqlQuery = $this->connection->query($sql);
    
        if ($sqlQuery && $sqlQuery->num_rows > 0) {
            header("Location: user_email_inuse.php");
        } else {
            return "email_unused"; 
        }
    }

    function insert() {
        $stmt = $this->connection->prepare("
            INSERT INTO user_login (
                name,
                email, 
                password,
                token,
                is_active
            ) VALUES (?, ?, ?, ?, '0')
        ");
    
        $stmt->bind_param("ssss", $this->name, $this->email, $this->password_hash, $this->token);
    
        $stmt->execute();
    
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }
    
        $stmt->close();
    }

    function load($connection, $email, $password) {

        $this->email = mysqli_real_escape_string($connection, $email);
        $this->password = mysqli_real_escape_string($connection, $password);
        $this->connection = $connection;

        $sql = "
        SELECT id, email, password, token, is_active FROM user_login WHERE email=\"{$this->email}\";
        ";

        $result = $this->connection->query($sql);
        if ($row = $result->fetch_assoc()) {
            $this->id = $row["id"];
            $this->token = $row["token"];

            

            //echo "ID". $this->id;
            // TODO:
            // $this->is_active = $row["is_active"] ;
        }
    }

    function authenticate() {
        $sql = "
        SELECT id, email, password, token, is_active FROM user_login WHERE email=\"{$this->email}\";
        ";

        $result = $this->connection->query($sql);
        if ($row = $result->fetch_assoc()) {
            if (password_verify($this->password, $row["password"])){
                $this->authenticated = true;
            }
        }
    }

    function is_logged_in() {
        return $this->authenticated;
    }

    function post_a_post($title, $content, $user_id , $hashtags) {
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');
        
        $stmt = $this->connection->prepare("INSERT INTO posts (title, content, user_id , hashtags) VALUES (?, ?, ?, ?)");
    
        $stmt->bind_param("ssss", $title, $content, $user_id, $hashtags);
        
        $stmt->execute();
        
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }

        $stmt->close();
        $this->connection->close();
    }

    function display_posts() {
    $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');

    $sql = "SELECT * FROM posts";
    $result = $this->connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $title = $row['title'];
        $content = $row['content'];
        $post_id = $row['id'];
        $user_id = $row['user_id']; 

        echo '<div class="post">';
        echo '<div class="title">';
        echo $title;
        echo '</div>';
        echo '<div class="content">';
        echo $content;
        echo '</div>';
        echo '<div class="user">';
        
        $sql2 = "SELECT name FROM user_login WHERE id = '$user_id'"; 
        $result2 = $this->connection->query($sql2);
        
        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $user_name = $row2['name'];
            echo 'Posted by: ' . $user_name;
        } else {
            echo 'Posted by: Deleted User';
        }
        
        echo '</div>';
        echo '<div class="buttons">';

        $sql = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'"; 
        $sqlQuery = $this->connection->query($sql);

        if ($sqlQuery && $sqlQuery->num_rows > 0) {
            //if you have liked the post
            echo '<a href="like_post_action.php?post_id='. $post_id . '"><i class="fi fi-br-social-network"></i></a>';
        } else {
            echo '<a href="like_post_action.php?post_id='. $post_id . '"><i class="fi fi-rr-social-network"></i></a>';
        }
        $_SESSION["post_id"] =  $post_id;

        $sql3 = "SELECT COUNT(*) AS c FROM comments WHERE post_id = $post_id";
        $sqlQuery = $this->connection->query($sql3);
        $row = $sqlQuery->fetch_assoc();
        $c = $row['c'];

        echo '<a href="comments.php?post_id='. $post_id . '"><i class="fi fi-rr-comment-alt-dots"></i></a>';
        echo '<a href="favourite_post_action.php?post_id='. $post_id . '"><i class="fi fi-rr-heart"></i></a>';
        
        
        echo '</div>';
        echo '</div>';
    }
}

    function like_a_post($post_id) {
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');

        $user_id = $this->id;

        $sql = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'"; 
        $sqlQuery = $this->connection->query($sql);
    
        if ($sqlQuery && $sqlQuery->num_rows > 0) {
            $sql = "DELETE FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
            $sqlQuery = $this->connection->query($sql);
        }
        else{

        
        $stmt = $this->connection->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");

        $stmt->bind_param("ii", $user_id, $post_id);
        
        $stmt->execute();
        
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }
        
        $stmt->close();
        $this->connection->close();
    }
    }

    function check_if_liked($post_id , $user_id) {
        $user_id = $this->id;

        $sql = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'"; 
        $sqlQuery = $this->connection->query($sql);
    
        if ($sqlQuery && $sqlQuery->num_rows > 0) {
            return true;
        }
        else{
            return false;
        }
    }

    function post_comment($post_id, $content) {
        $user_id = $this->id;
    
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');
        
        $stmt = $this->connection->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    
        $stmt->bind_param("iss", $post_id, $user_id, $content);
        
        $stmt->execute();
        
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }

        $stmt->close();
        $this->connection->close();
    }

    function display_comments($post_id) {
        $user_id = $this->id;

        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');

        $sql = "SELECT * FROM comments WHERE post_id = '$post_id'";
        $result = $this->connection->query($sql);
       
    
        while ($row = $result->fetch_assoc()) {
            $created_at = $row['created_at'];
            $content = $row['content'];
            $user_id = $row['user_id'];
            echo '<div class="post">';
            echo '<div class="user">';
            $sql2 = "SELECT name FROM user_login WHERE id = '$user_id'"; 
            $result2 = $this->connection->query($sql2);
        
        if ($result2 && $result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $user_name = $row2['name'];
            echo 'Posted by: ' . $user_name . ' at ' . $row['created_at'];
        } else {
            echo 'Posted by: Deleted User';
        }
            echo '</div>';
            echo '<div class="content">';
            echo $content;
            echo '</div>';
            echo '</div>';
        }
    



    }

    function search($search_input) {
        $user_id = $this->id;
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');
        $found_nothing = 0;

        $stmt = $this->connection->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ?");
        $search_term = '%' . $search_input . '%';
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $content = $row['content'];
    
                echo ' ';
                echo $title;
                echo $content;

            }
        } else {
            $found_nothing = $found_nothing + 1;
        }
        
        $stmt2 = $this->connection->prepare("SELECT * FROM user_login WHERE Name LIKE ?");
        $search_term2 = '%' . $search_input . '%';
        $stmt2->bind_param("s", $search_term2);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $name = $row['Name'];
    
                echo $name;
            }
        } else {
            $found_nothing = $found_nothing + 1;
        }

        $stmt3 = $this->connection->prepare("SELECT * FROM posts WHERE hashtags LIKE ?");
        $search_term3 = '%' . $search_input . '%';
        $stmt3->bind_param("s", $search_term2);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        
        if ($result3->num_rows > 0) {
            while ($row = $result3->fetch_assoc()) {
                $title = $row['title'];
                $content = $row['content'];
    
                echo '';
                echo $title;
                echo $content;
            }
        } else {
            //echo "No post tagged with " . htmlspecialchars($search_input) . ".";
            $found_nothing = $found_nothing + 1;
            if ($found_nothing == 3){
                echo "no posts, users, or # called". htmlspecialchars($search_input) . "." ;
            }
        }
        

        $stmt->close();
        $stmt2->close();
        $this->connection->close();
    }

    function favourite_post($post_id) {
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');

        $user_id = $this->id;

        $sql = "SELECT * FROM favourites WHERE user_id = '$user_id' AND post_id = '$post_id'"; 
        $sqlQuery = $this->connection->query($sql);
    
        if ($sqlQuery && $sqlQuery->num_rows > 0) {
            $sql = "DELETE FROM favourites WHERE user_id = '$user_id' AND post_id = '$post_id'";
            $sqlQuery = $this->connection->query($sql);
        }
        else{

        
        $stmt = $this->connection->prepare("INSERT INTO favourites (user_id, post_id) VALUES (?, ?)");

        $stmt->bind_param("ii", $user_id, $post_id);
        
        $stmt->execute();
        
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }
        
        $stmt->close();
        $this->connection->close();
    }
    }

    function display_favourite_posts() {
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');
    
        $sql = "SELECT * FROM posts";
        $result = $this->connection->query($sql);
    
        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $content = $row['content'];
            $post_id = $row['id'];
            $user_id = $row['user_id']; 
            
            
    
            $sql = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'"; 
            $sqlQuery = $this->connection->query($sql);

            $_SESSION["post_id"] =  $post_id;
    
            $sql3 = "SELECT COUNT(*) AS c FROM post_likes WHERE post_id = $post_id";
            $sqlQuery = $this->connection->query($sql3);
            $row = $sqlQuery->fetch_assoc();
            $c = $row['c'];
            if ($c > 0) {
                echo '<div class="post">';
            echo '<div class="title">';
            echo $title;
            echo '</div>';
        echo '<div class="content">';
        echo $content;
        echo '</div>';
        echo '<div class="user">';
        echo '</div>';
        

                if ($sqlQuery && $sqlQuery->num_rows > 0) {
                    //if you have liked the post
                    echo '<a href="like_post_action.php?post_id='. $post_id . '"><i class="fi fi-br-social-network"></i></a>';
                } else {
                    echo '<a href="like_post_action.php?post_id='. $post_id . '"><i class="fi fi-rr-social-network"></i></a>';
                }
                echo '<a href="comments.php?post_id='. $post_id . '"><i class="fi fi-rr-comment-alt-dots"></i></a>';
            echo '<a href="favourite_post_action.php?post_id='. $post_id . '"><i class="fi fi-rr-heart"></i></a>';
            
            
            echo '</div>';
           echo '</div>';
           echo '</div>';
            }

        }
    }

}