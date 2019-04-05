<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/DB.php"); ?>

<?php //confirm_Login(); ?>


<?php if($_SESSION['Access']=='no') redirect_to('Login.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/adminstyles.css">
</head>
<body style="background-color: #2f4050;">


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
    <div class="row">
        <div class="col-sm-2">

            <?php
            global $connection;

            //Search button code

            if (isset($_GET["SearchButton"])) {

                $Search = $_GET["Search"];
                $ViewQuery = "SELECT * FROM shippingdata 
                    WHERE grno LIKE '%$Search%' OR sender LIKE '%$Search%' OR receiver LIKE '%$Search%' OR origin LIKE '%$Search%'
                    OR destination LIKE '%$Search%' ";

            }
                // for pagination
                elseif(isset($_GET["Page"])) {

                    $Page = $_GET["Page"];

                    if ($Page == 0 || $Page < 1) {
                        $ShowData = 0;
                    } else {
                        $ShowData = ($Page * 7) - 7;
                        //echo $ShowData;
                    }


                    $ViewQuery = "SELECT * FROM shippingdata ORDER BY date desc LIMIT $ShowData,7";

                }

                else {
                    $Page = 1;


                    $ViewQuery = "SELECT * FROM shippingdata ORDER BY date desc LIMIT 0, 7";

                }




            $Execute=mysqli_query($connection, $ViewQuery);

            while($DataRows=mysqli_fetch_array($Execute)) {
                $Date = $DataRows["date"];
                $GrNo = $DataRows["grno"];
                $Pkgs = $DataRows["pkgs"];
                $Awt = $DataRows["awt"];
                $Cwt = $DataRows["cwt"];
                $Invoice = $DataRows["invoiceno"];
                $Sender = $DataRows["sender"];
                $Receiver = $DataRows["receiver"];
                $Origin = $DataRows["origin"];
                $Destination = $DataRows["destination"];

                $Mode = $DataRows["mode"];
                $Freight = $DataRows["freight"];


            }
            ?>



            <br>
            <br>

            <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                <li class="active"><a href="DashboardPagination.php">
                        <span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
                <li><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>

                <li><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>
                <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>


                <li><a href="Settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>


                <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>


        </div> <!-- Ending of side area-->


        <div class="col-sm-10">  <!-- Main Area-->

            <div><?php echo Message();
                echo SuccessMessage();
                ?></div>

            <h1>Admin Dashboard</h1>


            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Date</th>
                        <th>Gr.No</th>
                        <th>Pkgs</th>
                        <th>A WT</th>
                        <th>C WT</th>
                        <th>Invoice No</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Mode</th>
                        <th>Freight</th>
                        <th>Action</th>

                    </tr>

                    <?php

                    $connection;



                    // for pagination
                    if(isset($_GET["Page"])) {

                        $Page = $_GET["Page"];

                        if ($Page == 0 || $Page < 1) {
                            $ShowData = 0;
                        } else {
                            $ShowData = ($Page * 7) - 7;
                            //echo $ShowData;
                        }


                        $ViewQuery = "SELECT * FROM shippingdata ORDER BY date desc LIMIT $ShowData,7";

                    }

                    else {
                        $Page = 1;


                        $ViewQuery = "SELECT * FROM shippingdata ORDER BY date desc LIMIT 0, 7";

                    }


                    //The default one
                    /*  elseif($Page=""){
                          $Page==1;

                          $ViewQuery="SELECT * FROM shippingdata ORDER BY date desc LIMIT 0,10";


                      }
                      else{
                          $Page = "";

                          $ViewQuery="SELECT * FROM shippingdata ORDER BY date desc LIMIT 0,10";
                      }
          */



                    // $ViewQuery="SELECT * FROM shippingdata ORDER BY date desc LIMIT $ShowData,5";
                    $Execute=mysqli_query($connection, $ViewQuery);


                    while($DataRows=mysqli_fetch_array($Execute)) {

                        $Date = $DataRows["date"];
                        $GrNo = $DataRows["grno"];
                        $Pkgs = $DataRows["pkgs"];
                        $Awt=$DataRows["awt"];
                        $Cwt=$DataRows["cwt"];
                        $Invoice=$DataRows["invoiceno"];
                        $Sender=$DataRows["sender"];
                        $Receiver=$DataRows["receiver"];
                        $Origin=$DataRows["origin"];
                        $Destination=$DataRows["destination"];
                        $Mode=$DataRows["mode"];
                        $Freight=$DataRows["freight"];

                        ?>

                        <tr>
                            <td><?php echo $Date; ?></td>
                            <td><?php echo $GrNo; ?></td>
                            <td><?php echo $Pkgs; ?></td>
                            <td><?php echo $Awt; ?></td>
                            <td><?php echo $Cwt; ?></td>
                            <td><?php echo $Invoice; ?></td>
                            <td><?php echo $Sender; ?></td>
                            <td><?php echo $Receiver; ?></td>
                            <td><?php echo $Origin; ?></td>
                            <td><?php echo $Destination; ?></td>
                            <td><?php echo $Mode; ?></td>
                            <td><?php echo $Freight; ?></td>

                            <td><a href="EditRecord.php?Edit=<?php echo $GrNo; ?>">
                                    <span class="btn btn-warning">Edit</span>
                                </a>

                                <a href="DeleteEntry.php?Delete=<?php echo $GrNo; ?>">
                                    <span class="btn btn-danger">Delete</span>
                                </a>

                            </td>

                        </tr>


                    <?php } ?>
                </table>
            </div>

            <div>
            <nav>
                <ul class="pagination pull-left">

                    <?php
                    if(isset($Page)){

                        if($Page>1) {
                            ?>

                            <li><a href="DashboardPagination.php?Page=<?php echo $Page - 1; ?>">&laquo;</a></li>
                            <?php

                        }


                    } ?>



                    <?php

                    // Pagination code

                    global $connection;

                    $QPagination = "SELECT COUNT(*) FROM shippingdata";
                    $ExecutePagination = mysqli_query($connection, $QPagination);
                    $RowPagination = mysqli_fetch_array($ExecutePagination);

                    $TotalData =  array_shift($RowPagination);
                    //echo $TotalData;

                    $PerPageData = $TotalData/10;
                    $PerPageData = ceil($PerPageData);
                    //echo $PerPageData;

                    for($i=1; $i<=$PerPageData; $i++) {

                        if(isset($Page)) {

                            if ($i == $Page) {

                                ?>


                                <li class="active"><a
                                            href="DashboardPagination.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } else { ?>

                                <li><a href="DashboardPagination.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                                <?php


                            }
                        }
                    }

                    ?>

                    <?php
                    if(isset($Page)){

                        if($Page+1<=$PerPageData) {
                            ?>

                            <li><a href="DashboardPagination.php?Page=<?php echo $Page + 1; ?>">&raquo;</a></li>
                            <?php

                        }


                    } ?>

                </ul>
            </nav>
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
