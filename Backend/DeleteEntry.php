<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php //confirm_Login(); ?>

<?php
if (isset($_POST["Submit"])) {

    $Date=$_POST["Date"];
    $GrNo=$_POST["GrNo"];
    $Pkgs=$_POST["Pkgs"];
    $Awt=$_POST["awt"];
    $Cwt=$_POST["cwt"];
    $Invoice=$_POST["Invoice"];
    $Sender=$_POST["Sender"];
    $Receiver=$_POST["Receiver"];
    $Origin=$_POST["Origin"];
    $Destination=$_POST["Destination"];
    $Mode=$_POST["Mode"];
    $Freight=$_POST["Freight"];


    global $connection;
    $DeleteFromURL=$_GET['Delete'];

    $Query="DELETE FROM shippingdata WHERE grno='$DeleteFromURL'";

    $Execute=mysqli_query($connection, $Query);



    if($Execute)
    {
        $_SESSION["SuccessMessage"]="Record Deleted successfully";
        Redirect_to("DashboardPagination.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
        Redirect_to("DashboardPagination.php");
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
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

            <a class="navbar-brand" href="Dashboard.php">
                <h4 style="color: #ffffff; text-decoration: none; margin-top: -1px;
                    margin-right: 20px; font-family:cursive; font-weight: bold;">The United Cargo</h4>

            </a>
        </div>

</nav>
<div class="Line" style="height: 10px; background: #27aae1;"></div>









<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">

            <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                <li><a href="DashboardPagination.php">
                        <span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
                <li class="active"><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>

                <li><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>
                <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>



                <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>


        </div> <!-- Ending of side area-->

        <div class="col-sm-10">
            <h1>Delete Record</h1>

            <?php echo Message();
            echo SuccessMessage();
            ?>

            <div>

                <?php
                $SearchQueryParameter=$_GET['Delete'];
                global $connection;
                $Query="SELECT * FROM shippingdata WHERE grno='$SearchQueryParameter'";
                $ExecuteQuery=mysqli_query($connection, $Query);

                while($DataRows=mysqli_fetch_array($ExecuteQuery)) {


                    $UpdatedDate = $DataRows["date"];
                    $UpdatedGrNo = $DataRows["grno"];
                    $UpdatedPkgs = $DataRows["pkgs"];
                    $UpdatedAwt = $DataRows["awt"];
                    $UpdatedCwt = $DataRows["cwt"];
                    $UpdatedInvoice = $DataRows["invoiceno"];
                    $UpdatedSender = $DataRows["sender"];
                    $UpdatedReceiver = $DataRows["receiver"];
                    $UpdatedOrigin = $DataRows["origin"];
                    $UpdatedDestination = $DataRows["destination"];
                    $UpdatedMode = $DataRows["mode"];

                    $UpdatedKgCost = $DataRows["perkgcost"];
                    $UpdatedFreight = $DataRows["freight"];
                }


                ?>



                <form action="DeleteEntry.php?Delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="date"><span class="FieldInfo">Date:</span> </label>
                                <input class="form-control" type="Date" name="date" id="Date" placeholder="Date" value="<?php echo $UpdatedDate;?>">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="grno"><span class="FieldInfo">Gr.No:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedGrNo; ?>" type="text" name="grno" id="GrNo" placeholder="GrNo" >
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="pkgs"><span class="FieldInfo">Pkgs:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedPkgs;  ?>" type="text" name="pkgs" id="Pkgs" placeholder="Pkgs">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="awt"><span class="FieldInfo">A WT:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedAwt; ?>"  type="text" name="awt" id="awt" placeholder="awt">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="cwt"><span class="FieldInfo">C WT:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedCwt; ?>"  type="text" name="cwt" id="cwt" placeholder="cwt">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="invoice"><span class="FieldInfo">Invoice No:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedInvoice; ?>"  type="text" name="invoiceno" id="Invoice" placeholder="Invoice No">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="sender"><span class="FieldInfo">Sender:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedSender; ?>"  type="text" name="sender" id="Sender" placeholder="Sender">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="receiver"><span class="FieldInfo">Receiver:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedReceiver;  ?>"  type="text" name="receiver" id="Receiver" placeholder="Receiver">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="origin"><span class="FieldInfo">Origin:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedOrigin; ?>"  type="text" name="origin" id="Origin" placeholder="Origin">
                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="destination"><span class="FieldInfo">Destination:</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedDestination;  ?>"  type="text" name="destination" id="Destination" placeholder="Destination"   >

                            </div></div>

                        <div class="col-xs-4">
                            <br>
                            <div class="form-group">
                                <label for="mode"><span class="FieldInfo">Mode:</span> </label>
                                <br>
                                <input class="radio-inline" type="radio" name="mode" id="Mode" value="air" <?php echo ($UpdatedMode=='air')?'checked':'' ?> >Air
                                <input class="radio-inline" type="radio" name="mode" id="Mode" value="train" <?php echo ($UpdatedMode=='train')?'checked':'' ?> >Train
                                <input class="radio-inline" type="radio" name="mode" id="Mode" value="road" <?php echo ($UpdatedMode=='road')?'checked':'' ?> >Road

                            </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="cost"><span class="FieldInfo">Cost/Kg.</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedKgCost; ?>"  type="text" name="kgcost"  id="Cost" >
                            </div></div>



                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="cost"><span class="FieldInfo">Freight.</span> </label>
                                <input class="form-control" value="<?php echo $UpdatedFreight; ?>"  type="text" name="freight"  id="Freight" >
                            </div></div>




                        <br>
                        <div class="col-xs-4" style="margin-left: 300px; margin-top:50px ; margin-bottom: 100px ;">
                        <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Delete Record">
                        </div>
                            <br>


                    </fieldset>

                </form>


            </div>












        </div> <!-- Ending of main area-->

    </div> <!-- Ending of Row-->
</div> <!-- Ending of Container-->

<div id="Footer" style="padding: 10px;

	border-top: 1px solid black;
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

<div style="height: 10px; background: #27aae1;"></div>

</body>
</html>