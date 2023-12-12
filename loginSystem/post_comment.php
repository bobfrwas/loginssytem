<?PHP


include_once 'models/db.php';
include_once 'models/user.php';

session_start();
$logged_in = false;
if ( !isset($_SESSION['user'])) {
    //
    header('Location: http://localhost/loginSystem/sign_up.php');
    //
}

$content = $_POST['comment'];
$post_id = $_SESSION['post_id'];



$logged_in = true;
$user = unserialize($_SESSION['user']);
$user->post_comment($post_id, $content);



header("Location: comments.php?post_id=" . $post_id);
?>