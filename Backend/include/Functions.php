<?php ob_start(); ?>
<?php require_once("DB.php"); ?>
<?php require_once("Sessions.php"); ?>

<?php
function Redirect_to($New_Location)
{
    header("Location:".$New_Location);
	die($New_Location);
}

function Login_Attempt($Username, $Password){
    global $connection;

    $Query="SELECT * FROM registration WHERE username='$Username'";
    $Execute=mysqli_query($connection, $Query);

    $User = mysqli_fetch_assoc($Execute);

    if($User && password_verify($Password, $User['password'])){
        return $User;
    }
    else{
        return null;
    }
}

function User_Exist($Username){
    global $connection;
    $Query="SELECT * FROM registration WHERE username='$Username'";
    $Execute=mysqli_query($connection, $Query);

    if($user_exist=mysqli_fetch_assoc($Execute)){
        return true;
    }
    else{
        return false;
    }
}

function Login(){
    if(isset($_SESSION["User_Id"])){
        return true;
    }
}

function Confirm_Login(){
    if(!Login()){
        $_SESSION["ErrorMessage"]="Login Required!";
        Redirect_to("Login.php");
    }
}

function encrypt_password($Password){

        $New_password = password_hash($Password, PASSWORD_DEFAULT);
        return $New_password;
}



?>
