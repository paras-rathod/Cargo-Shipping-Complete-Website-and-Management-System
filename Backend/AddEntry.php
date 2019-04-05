<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/Predefined.php"); ?>
<?//php confirm_Login(); ?>

<?php

if($_SESSION["Access"]=="no"){
    Redirect_to("AddEntryUser.php");
}



if (isset($_POST["Submit"])) {

    $Date=mysqli_real_escape_string($_POST["date"]);
    $GrNo=mysqli_real_escape_string($_POST["grno"]);
    $Pkgs=mysqli_real_escape_string($_POST["pkgs"]);
    $Awt=mysqli_real_escape_string($_POST["awt"]);
    $Cwt=mysqli_real_escape_string($_POST["cwt"]);
    $Invoice=mysqli_real_escape_string($_POST["invoiceno"]);
    $Sender=mysqli_real_escape_string($_POST["sender"]);
    $Receiver=mysqli_real_escape_string($_POST["receiver"]);
    $InvoiceClient=mysqli_real_escape_string($_POST["invoiceclient"]);
    $Origin=mysqli_real_escape_string($_POST["origin"]);
    $Destination=mysqli_real_escape_string($_POST["destination"]);
    $Mode=mysqli_real_escape_string($_POST["mode"]);
    $KgCost=mysqli_real_escape_string($_POST["kgcost"]);


    $DocketCharge=mysqli_real_escape_string($_POST["perdocketcharge"]);
    $Rate=mysqli_real_escape_string($_POST["gstrate"]);

    $Invoice = strtolower($Invoice);
    $Sender = strtolower($Sender);
    $Receiver = strtolower($Receiver);
    $Origin = strtolower($Origin);
    $Destination = strtolower($Destination);
    $InvoiceClient = strtolower($InvoiceClient);

    if(empty($KgCost))
    {
        $KgCost = $PerKgCost;
    }

    if(empty($DocketCharge))
    {
        $DocketCharge = $PerDocketCharge;
    }

    if(empty($Rate))
    {
        $Rate = $GstRate;
    }


    if (empty($Date) || empty($GrNo) || empty($Pkgs) || empty($Awt) || empty($Cwt) || empty($Invoice) || empty($Sender)
    || empty($Receiver) || empty($Origin) || empty($Destination) || empty($Mode) || empty($InvoiceClient)) {
        $_SESSION["ErrorMessage"]="All fields must be filled";
        Redirect_to("AddEntry.php");
    }


    else
    {
        global $ConnectionDB;

        $Freight = $KgCost * $Cwt;
        $_SESSION['CalculatedFreight'] = $Freight;

        $_SESSION["CalculatedPerDocketCharge"]=  $DocketCharge;

        $_SESSION["CalculatedGstRate"]= ($Freight+$DocketCharge)*$Rate/100;

        $_SESSION["TotalCost"] = $_SESSION["CalculatedGstRate"] + $_SESSION["CalculatedPerDocketCharge"] + $_SESSION['CalculatedFreight'];


        $Query="INSERT INTO shippingdata(date, grno, pkgs, awt, cwt, invoiceno, sender, receiver, invoiceclient, origin, destination, mode, perkgcost, freight)
	VALUES('$Date','$GrNo','$Pkgs','$Awt','$Cwt','$Invoice','$Sender','$Receiver','$InvoiceClient','$Origin','$Destination','$Mode','$KgCost','$Freight')";

        $Execute=mysqli_query($Query);



        if($Execute)
        {
            $_SESSION["SuccessMessage"]="Entry added successfully";
            Redirect_to("AddEntry.php");
        }
        else
        {
            $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
            Redirect_to("AddEntry.php");
        }
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

        <div class="collapse navbar-collapse" id="collapse">

            <form action="DashboardSearch.php" class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="Search">
                </div>
                <button class="btn btn-default" name="SearchButton">Go</button>
            </form>

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
                <li class="active"><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>

                <li><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>
                <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>
                <li><a href="Settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>



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

            <div>
                <form action="AddEntry.php" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>
                        <div class="col-xs-4"><br><br><br></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="date"><span class="FieldInfo">Date:</span> </label>
                            <input class="form-control" type="Date" name="date" id="Date" placeholder="Date" value="<?php echo date("Y-m-d");?>">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="grno"><span class="FieldInfo">Gr.No:</span> </label>
                            <input class="form-control" type="text" name="grno" id="GrNo" placeholder="GrNo" >
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="pkgs"><span class="FieldInfo">Pkgs:</span> </label>
                            <input class="form-control" type="text" name="pkgs" id="Pkgs" placeholder="Pkgs">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="awt"><span class="FieldInfo">A WT:</span> </label>
                            <input class="form-control" type="text" name="awt" id="awt" placeholder="awt">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="cwt"><span class="FieldInfo">C WT:</span> </label>
                            <input class="form-control" type="text" name="cwt" id="cwt" placeholder="cwt">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="invoice"><span class="FieldInfo">Invoice No:</span> </label>
                            <input class="form-control" type="text" name="invoiceno" id="Invoice" placeholder="Invoice No">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="sender"><span class="FieldInfo">Sender:</span> </label>
                            <input class="form-control" type="text" name="sender" id="Sender" placeholder="Sender">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="receiver"><span class="FieldInfo">Receiver:</span> </label>
                            <input class="form-control" type="text" name="receiver" id="Receiver" placeholder="Receiver">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="origin"><span class="FieldInfo">Origin:</span> </label>
                            <input class="form-control" type="text" name="origin" id="Origin" placeholder="Origin">
                        </div></div>

                        <div class="col-xs-4">
                        <div class="form-group">
                            <label for="destination"><span class="FieldInfo">Destination:</span> </label>
                            <input class="form-control" type="text" name="destination" id="Destination" placeholder="Destination"   >

                        </div></div>

                        <div class="col-xs-4">
                            <br>
                        <div class="form-group">
                            <label for="mode"><span class="FieldInfo">Mode:</span> </label>
                            <br>
                            <input class="radio-inline" type="radio" name="mode" id="Mode" value="air" >Air
                            <input class="radio-inline" type="radio" name="mode" id="Mode" value="train" >Train
                            <input class="radio-inline" type="radio" name="mode" id="Mode" value="road" >Road
                        </div></div>

                            <div class="col-xs-4">
                        <div class="form-group">
                            <label for="cost"><span class="FieldInfo">Cost/Kg.</span> </label>
                            <input class="form-control" type="text" name="kgcost"  id="Cost" value="<?php echo $PerKgCost?>" >
                        </div></div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="invoiceclient"><span class="FieldInfo">Invoice/Client.</span> </label>
                                <input class="form-control" type="text" name="invoiceclient"  id="InvoiceClient" value="" >
                            </div></div>



                        <div class="col-xs-4" style="margin-bottom:-20px;">
                            <br>
                        <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Entry">
                        <br>
                            <br>
                        </div>

                        <div class="col-xs-4 pull-right">
                            <br>
                            <br>


                            <table class="table table-hover table-bordered text-right">
                                <tr>
                                    <td style="width: 40%;"></td>
                                    <td style="width: 60%;"
                                        class="amount"></td>
                                </tr>
                                <tr>
                                    <td><b>Freight</b></td>
                                    <td class="amount"><?php echo $_SESSION['CalculatedFreight'] ?></td>
                                </tr>

                                <tr>
                                    <td class="td-vert-middle"></td>
                                    <td class="clearfix">

                                            <div class="form-group">
                                                <input disabled="disabled" id="perdocketcharge" name="perdocketcharge"
                                                       class="form-control"
                                                       value="<?php if(isset($_POST['perdocketcharge'])) echo $_POST['perdocketcharge'];
                                                       else echo $PerDocketCharge?>"
                                                <div class="input-group-addon">Docket Charge</div>
                                            </div>


                                            <div class="form-group">
                                                <input disabled="disabled" id="gstrate" name="gstrate"
                                                       class="form-control"
                                                       value="<?php if(isset($_POST['gstrate'])) echo $_POST['gstrate'];
                                                       else echo $GstRate?>"


                                                <div class="input-group-addon">GST&percnt;</div>
                                            </div>

                                    </td>
                                </tr>
                                <tr>

                                    <td class="amount"><b>Docket</b></td>
                                    <td><?php echo $_SESSION["CalculatedPerDocketCharge"] ?></td>
                                </tr>
                                <tr>

                                    <td class="amount"><b>GST</b></td>
                                    <td><?php echo $_SESSION["CalculatedGstRate"] ?></td>
                                </tr>
                                <tr>

                                    <td class="amount"><b>Total</b></td>
                                    <td><b><?php echo $_SESSION["TotalCost"] ?></b></td>
                                </tr>
                            </table>

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

<div id="Footer" style="padding: 15px;

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