<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/Predefined.php"); ?>
<?//php confirm_Login(); ?>


<?php if($_SESSION['Access']=='no') redirect_to('Login.php');



if (isset($_POST["Submit"])) {

    $GST=$_POST["gst"];
    $ODACHARGE=$_POST["oda"];
    $DOCKETCHARGE=$_POST["docket"];



    if(empty($GST))
    {
        $GST = $GstRate;
    }

    if(empty($ODACHARGE))
    {
        $ODACHARGE = $PerODACharge;
    }

    if(empty($DOCKETCHARGE))
    {
        $DOCKETCHARGE = $PerDocketCharge;
    }


    global $connection;
    $Query = "UPDATE constantfields SET value='$GST' WHERE name='gstrate'";

    $Execute=mysqli_query($connection, $Query);



        if(!$Execute)
        {

            $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
            Redirect_to("Settings.php");
        }


    $Query = "UPDATE constantfields SET value='$DOCKETCHARGE' WHERE name='perdocketcharge'";

    $Execute=mysqli_query($connection, $Query);


    if(!$Execute)
    {

        $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
        Redirect_to("Settings.php");
    }


    $Query = "UPDATE constantfields SET value='$ODACHARGE' WHERE name='perodacharge'";

    $Execute=mysqli_query($connection, $Query);



    if(!$Execute)
    {

        $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
        Redirect_to("Settings.php");
    }

    else{

        $_SESSION["SuccessMessage"]="Entry added successfully";
        Redirect_to("Settings.php");
    }

}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New Entry</title>

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

        body {

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

            <a class="navbar-brand" href="DashboardPagination.php">
                <h4 style="color: #ffffff; text-decoration: none; margin-top: -1px;
                    margin-right: 20px; font-family:cursive; font-weight: bold;">The United Cargo</h4>

            </a>
        </div>


    </div>
</nav>
<div class="Line" style="height: 10px; background: #27aae1;"></div>




<div class="container-fluid">

    <div class="row" style="display:flex; margin-bottom: -15px;">
        <br>
        <div class="col-sm-2" style="color: #ff0000; ">
            <br>
            <br>
            <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                <li><a href="DashboardPagination.php">
                        <span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
                <li><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>
                <li><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>
                <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>

                <li class="active"><a href="Settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>

                <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>


        </div> <!-- Ending of side area-->

        <div class="col-sm-1" style="background-color: #fff; ">



        </div> <!-- Ending of Right Column-->

        <div class="col-sm-8" style="background-color: #fff">

            <!--<h2 style="font-family:times, serif; margin-bottom:40px;" class="text-center"><u>Add New Entry</u></h2>
            -->

            <?php echo Message();
            echo SuccessMessage();
            ?>

            <div style="margin-top: 100px; margin-bottom: 200px;">
                <form action="Settings.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>



                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="gst"><span class="FieldInfo">GST:</span> </label>
                                <input class="form-control" type="text" name="gst" id="Gst" placeholder="GST" >
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="oda"><span class="FieldInfo">ODA Charge:</span> </label>
                                <input class="form-control" type="text" name="oda" id="Oda" placeholder="ODA">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="docket"><span class="FieldInfo">Docket Charge:</span> </label>
                                <input class="form-control" type="text" name="docket" id="docket" placeholder="DOCKET">
                            </div></div>





                        <div class="col-xs-4" style="margin-bottom:-20px;">
                            <br>
                            <input style="text-align: center;" class="btn btn-success btn-block" type="Submit" name="Submit" value="Save">
                            <br>
                            <br>
                        </div>

                        <div class="col-xs-4 pull-right">
                            <br>
                            <br>


                        </div>


                        <br>
                    </fieldset>

                </form>

            </div>










        </div> <!-- Ending of main area-->


        <div class="col-sm-1" style="background-color: #fff; ">



        </div> <!-- Ending of Right Column-->

    </div> <!-- Ending of Row-->
</div> <!-- Ending of Container-->>


<div id="Footer" style=" padding: 15px;

	color: #eeeeee;
	background-color: #211f22;
	text-align: center;">


    <hr>
    <p style="text-align: center; color: #ffffff;">United Cargo | &copy; 2017-2018</p>
    <p style="text-align: center; color: #ffffff;">Door to Door Cargo Air and Train Services</p>
    <p style="text-align: center; color: #ffffff;">Sr.No. 16/1D/2K/1, Behind Durga Hotel, Wadgaon Shinde Road, Lohegaon, Pune-411047</p>
    <p style="text-align: center; color: #ffffff;">Ph.: 9373344474, 9371344474 E-mail: singh.neeraj02@gmail.com</p>

    <hr>
</div>


</body>
</html>