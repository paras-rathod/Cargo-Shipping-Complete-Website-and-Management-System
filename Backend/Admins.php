<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?//php confirm_Login(); ?>



<?php if($_SESSION['Access']=='no') redirect_to('Login.php');
?>


<?php
if (isset($_POST['Submit'])) {

    $Username=$_POST["Username"];
    $Password=$_POST["Password"];
    $ConfirmPassword=$_POST["ConfirmPassword"];
    $Privileged=$_POST["privileged"];
    $Privileged=strtolower($Privileged);

    date_default_timezone_set("Asia/Kolkata");

    $CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
//$DateTime;
    $Admin=$_SESSION["Username"];

    if(User_Exist($Username)){
        $_SESSION["ErrorMessage"]="That Username is alreadey taken";
        Redirect_to("Admins.php");
    }

    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        Redirect_to("Admins.php");
    }
    elseif (strlen($Password)<4) {
        $_SESSION["ErrorMessage"]="At least 4 characters for password are required";
        Redirect_to("Admins.php");

    }

    elseif ($Password != $ConfirmPassword) {
        $_SESSION["ErrorMessage"]="Password / ConfirmPassword does not match";
        Redirect_to("Admins.php");

    }



    else
    {
        global $connection;
        
        $New_password = encrypt_password($Password);
        $Query="INSERT INTO registration(datetime, username, password, addedby, privileged)
	VALUES('$DateTime', '$Username','$New_password', '$Admin', '$Privileged')";
        $Execute=mysqli_query($connection, $Query);

        if($Execute)
        {
            $_SESSION["SuccessMessage"]="Admin added successfully";
            Redirect_to("Admins.php");
        }
        else
        {
            $_SESSION["ErrorMessage"]="Admin failed to add";
            Redirect_to("Admins.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Admins</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/adminstyles.css">
    <style type="text/css">
        .FieldInfo
        {
            color: darkblue;
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
    <div class="row" style="display: flex; margin-bottom: -15px;">
        <div class="col-sm-2" style="margin-top: 40px;">

            <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                <li><a href="DashboardPagination.php">
                        <span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
                <li><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>

                <li><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>
                <li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>


                <li><a href="Settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>

                <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>


        </div> <!-- Ending of side area-->

        <div class="col-sm-2" style="background-color: #fff"></div>

        <div class="col-sm-6" style="background-color: #fff">
            <h1 class="text-center" style="padding-bottom: 20px">Manage Admin Access</h1>

            <?php echo Message();
            echo SuccessMessage();
            ?>

            <div>
                <form action="Admins.php" method="post">
                    <fieldset>
                        <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="Username"><span class="FieldInfo">UserName:</span> </label>
                            <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                        </div></div>

                        <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="Password"><span class="FieldInfo">Password:</span> </label>
                            <input class="form-control" type="password" name="Password" id="Password" placeholder="Password">
                        </div></div>

                        <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span> </label>
                            <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype same password">
                        </div></div>

                        <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="privileged"><span class="FieldInfo">Privileged?</span> </label>
                            <input class="form-control" type="text" name="privileged" id="privileged" placeholder="specify the access level">
                        </div></div>


                        <br>
                        <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
                        <br>
                    </fieldset>

                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Admin Name</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    global $connection;
                   
                    $ViewQuery="SELECT * FROM registration ORDER BY datetime desc";
                    $Execute=mysqli_query($connection, $ViewQuery);
                    $SrNo=0;  //for proper serial numbers

                    while ($DataRows=mysqli_fetch_array($Execute)) {
                        $Id=$DataRows["id"];
                        $DateTime=$DataRows["datetime"];
                        $Username=$DataRows["username"];
                        $Admin=$DataRows["addedby"];
                        $SrNo++;

                        ?>
                        <!--//Fetch and print-->

                        <tr>
                            <td><?php echo $SrNo; ?></td>
                            <td><?php echo $DateTime; ?></td>
                            <td><?php echo $Username; ?></td>
                            <td><?php echo $Admin; ?></td>
                            <td><a href="DeleteAdmin.php?id=<?php echo $Id ?>"><span onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</span></a> </td>
                        </tr>

                    <?php } ?>
                </table>
            </div>


        </div> <!-- Ending of main area-->
        <div class="col-sm-2" style="background-color: #fff"></div>

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
