<?php error_reporting(E_ERROR | E_PARSE);
?>
<?php ob_start() ?>
<?php
session_start();

function message()
{
    if(isset($_SESSION["ErrorMessage"]))
    {
        $Output="<div class = \"alert alert-danger \">";
        $Output.=htmlentities($_SESSION["ErrorMessage"]);
        $Output.="</div>";
        $_SESSION["ErrorMessage"]=null;
        return $Output;
    }
}

function SuccessMessage()
{
    if(isset($_SESSION["SuccessMessage"]))
    {
        $Output="<div class = \"alert alert-success \">";
        $Output.=htmlentities($_SESSION["SuccessMessage"]);
        $Output.="</div>";
        $_SESSION["SuccessMessage"]=null;
        return $Output;
    }
}




?>