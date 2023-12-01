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
        $sql = "
        INSERT INTO user_login (
            name,
            email, 
            password,
            token,
            is_active
        ) VALUES (
            '{$this->name}',
            '{$this->email}',
            '{$this->password_hash}',
            '{$this->token}',
            '0'
        )
        ";

        $sqlQuery = $this->connection->query($sql);

        if (!$sqlQuery) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }

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

    function post_a_post($title, $content, $user_id) {
        $this->connection = new mysqli('localhost', 'root', '', 'loginsystem');
        
        // Prepare the INSERT statement with placeholders
        $stmt = $this->connection->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        
        // Bind the values to the prepared statement
        $stmt->bind_param("sss", $title, $content, $user_id);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Check if the statement was executed successfully
        if ($stmt->affected_rows === -1) {
            die("MySQL query failed!" . mysqli_error($this->connection));
        }
        
        // Close the statement and the database connection
        $stmt->close();
        $this->connection->close();
    }

}
