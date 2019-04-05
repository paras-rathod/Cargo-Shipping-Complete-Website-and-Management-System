<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once ("include/Predefined.php"); ?>


<?php
if (isset($_POST["Submit"])) {

    $Username=$_POST["Username"];
    $Password=$_POST["Password"];


    if (empty($Username) || empty($Password)) {
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        Redirect_to("Login.php");
    }

    else
    {
        $Found_Account=Login_Attempt($Username, $Password);


        if($Found_Account){

            // Admin credentials
            $_SESSION["User_Id"]=$Found_Account["id"];
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["Access"]=$Found_Account["privileged"];

            // For Entries and updates
            $_SESSION["CalculatedFreight"]=0;  // Total Entry Freight
            $_SESSION["CalculatedPerDocketCharge"]=0; // Per Docket Charge with User's entry
            $_SESSION["CalculatedGstRate"]=0;   // Gst Calculation with User's entry
            $_SESSION["TotalCost"]=0; // Total Cost

            // For Invoice
            $_SESSION["CalculatedInvoiceFreight"] = 0;
            $_SESSION["CalculatedInvoiceDocketCharge"]=0;
            $_SESSION["CalculatedInvoiceODACharge"]=0;
            $_SESSION["CalculatedInvoiceGstRate"]=0;
            $_SESSION["CalculatedInvoiceTotalCost"]=0;

            // For PDF

            $_SESSION['InvoiceClient'] = "";       // for invoice generation and display
            $_SESSION['ClientInvoice'] = "";
            $_SESSION['Origin'] = "";
            $_SESSION['DateFrom'] = "";
            $_SESSION['DateTo'] = "";
            $_SESSION['InvoiceDate'] = "";
            $_SESSION['ClientAddress']="";

            $_SESSION["SuccessMessage"]="Welcome {$_SESSION["Username"]}";

            if($_SESSION["Access"]=="yes")  Redirect_to("DashboardPagination.php");
            else  Redirect_to("AddEntry.php");

        }
        else{
            $_SESSION["ErrorMessage"]="Invalid username / password";
            Redirect_to("Login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/adminstyles.css">
    <style type="text/css">
        .FieldInfo
        {
            color: rgb(251, 174, 44);
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-size: 1.2em;
        }

        body{
            background-color: #ffffff;
        }
    </style>
</head>
<body>




<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-tatget="#collapse">

                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>


            </button>

            <a class="navbar-brand" href="../index.html">
                <h4 style="color: #ffffff; text-decoration: none; margin-top: -1px;
                    margin-right: 20px; font-family:cursive; font-weight: bold;">The United Cargo</h4>

            </a>
        </div>


    </div>
</nav>

<div class="Line" style="height: 10px; background: #27aae1;"></div>









<div class="container-fluid">
    <div class="row">

        <div class="col-sm-offset-4 col-sm-4">


            <br>  <br>  <br>  <br>
            <?php echo Message();
            echo SuccessMessage();
            ?>

            <h2>Welcome!</h2>



            <div>
                <form action="Login.php" method="post">
                    <fieldset>
                        <div class="form-group">

                            <label for="Username"><span class="FieldInfo">UserName:</span> </label>

                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope text-primary"></span>
                                </span>
                                <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="Password"><span class="FieldInfo">Password:</span> </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock text-primary"></span>
                                </span>
                                <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
                            </div>
                        </div>





                        <br>
                        <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
                        <br>
                    </fieldset>

                </form>
            </div>



        </div> <!-- Ending of main area-->

    </div> <!-- Ending of Row-->
</div> <!-- Ending of Container-->



</body>
</html>