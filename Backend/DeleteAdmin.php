<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php //confirm_Login(); ?>
<?php
if(isset($_GET["id"])){
    $IdFromURL=$_GET["id"];
    $ConnectingDB;

    $Query="DELETE FROM registration WHERE id='$IdFromURL'";
    $Execute=mysqli_query($Query);

    if($Execute)
    {
        $_SESSION["SuccessMessage"]="Admin deleted successfully";
        Redirect_to("Admins.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
        Redirect_to("Admins.php");
    }



}


?>