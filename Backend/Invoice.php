<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/Predefined.php"); ?>
<?php// confirm_Login(); ?>

<?php

if($_SESSION["Access"]=="no"){
    Redirect_to("AddEntryUser.php");
}

?>


<?php

if (isset($_POST["Submit"])) {

    $DateFrom=$_POST["datefrom"];
    $DateTo=$_POST["dateto"];
    $InvoiceClient=$_POST["invoiceclient"];
    $ClientInvoice=$_POST["clientinvoice"];
    $InvoiceDate=$_POST["invoicedate"];
    $Origin=$_POST["origin"];
    $DocketCharge=$_POST["perdocketcharge"];
    $ODACharge=$_POST["perodacharge"];
    $Gst=$_POST["gstrate"];
    $Address=$_POST["clientaddress"];

    $_SESSION['ClientAddress'] = $Address;
    if(empty($DocketCharge)){
        $DocketCharge = $PerDocketCharge;
    }

    if(empty($ODACharge)){
        $ODACharge = $PerODACharge;
    }

    if(empty($Gst)){
        $Gst = $GstRate;
    }

    $InvoiceClient = strtolower($InvoiceClient);
    $Origin = strtolower($Origin);


    if (empty($DateFrom) || empty($DateTo) || empty($Origin) || empty($InvoiceClient) || empty($ClientInvoice) || empty($InvoiceDate)) {
        $_SESSION["ErrorMessage"]="All fields must be filled";
        Redirect_to("Invoice.php");
    }





    else
    {
        global $connection;

        $Query="SELECT * FROM shippingdata WHERE invoiceclient='$InvoiceClient' AND origin='$Origin'  AND date>='$DateFrom' AND date<='$DateTo'";
        $Execute=mysqli_query($connection, $Query);


        $_SESSION['InvoiceClient'] = $InvoiceClient;       // for invoice generation and display
        $_SESSION['ClientInvoice'] = $ClientInvoice;
        $_SESSION['Origin'] = $Origin;
        $_SESSION['DateFrom'] = $DateFrom;
        $_SESSION['DateTo'] = $DateTo;
        $_SESSION['InvoiceDate'] = $InvoiceDate;


        $TotalFreight = 0;
        $Count = 0;
        while($DataRows=mysqli_fetch_assoc($Execute)){
            $Count++;
            $TotalFreight += $DataRows['freight'];
        }

        $_SESSION["CalculatedInvoiceFreight"] = $TotalFreight;
        $_SESSION["CalculatedInvoiceDocketCharge"] = $DocketCharge*$Count;
        $_SESSION["CalculatedInvoiceODACharge"] = $ODACharge*$Count;
        $_SESSION["CalculatedInvoiceGstRate"] = ($_SESSION["CalculatedInvoiceFreight"] + $_SESSION["CalculatedInvoiceDocketCharge"] + $_SESSION["CalculatedInvoiceODACharge"])*$Gst/100;
        $_SESSION["CalculatedInvoiceTotalCost"]= $_SESSION["CalculatedInvoiceFreight"] + $_SESSION["CalculatedInvoiceDocketCharge"] +  $_SESSION["CalculatedInvoiceODACharge"] + $_SESSION["CalculatedInvoiceGstRate"];


        if($Execute)
        {
            $_SESSION["SuccessMessage"]="Invoice Generated Successfully.";
            Redirect_to("Invoice.php");
        }
        else
        {
            $_SESSION["ErrorMessage"]="Something went wrong. Try again !";
            Redirect_to("Invoice.php");
        }
    }
}
?>


<?php function fetch_table()
{

    $output = "";
    global $CountElements;

    $InvoiceClient = $_SESSION['InvoiceClient'];
    $Origin = $_SESSION['Origin'];
    $DateTo = $_SESSION['DateTo'];
    $DateFrom = $_SESSION['DateFrom'];


    $Query="SELECT * FROM shippingdata WHERE invoiceclient='$InvoiceClient' AND origin='$Origin'  AND date>='$DateFrom' AND date<='$DateTo'";
    $Execute=mysqli_query($Query);


    while($DataRows=mysqli_fetch_assoc($Execute)) {
        $CountElements = $CountElements+1;
        $output .= '
<tbody>
        <tr>
            <td>'.$DataRows["date"].'</td>
            <td>'.$DataRows["grno"].'</td>
            <td>'.$DataRows["pkgs"].'</td>
            <td>'.$DataRows["awt"].'</td>
            <td>'.$DataRows["cwt"].'</td>
            <td>'.$DataRows["invoiceno"].'</td>
            <td>'.strtoupper($DataRows["sender"]).'</td>
            <td>'.strtoupper($DataRows["receiver"]).'</td>
            <td>'.strtoupper($DataRows["origin"]).'</td>
            <td>'.strtoupper($DataRows["destination"]).'</td>
            <td>'.strtoupper($DataRows["mode"]).'</td>
            <td>'.$DataRows["freight"].'</td>
            
        </tr>
        </tbody>
        ';


    }

    return $output;

}


if(isset($_POST['generatepdf'])){
    
    
    require_once '../vendor/autoload.php';

    ob_start();
    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('stylesheet.css');

    $content = '';
    $header = '';

    $header = $header . '

   <div id="header" style="font-size: 12px;">
    <div class="child_div_1"  style="width: 25%;  float:left; min-width: 100px;">
        <img align="center" src="2.png" height="100px" width="150px" style="display:inline-block; " >
    </div>



    <div class="child_div_2"  style="width: 75%;float:left; margin-left: 10px; font-size: 14px;">

        <h3 class="" style="color: orange; margin-left: 70px; ">THE UNITED CARGO</h3>
        <p class="" style="margin-left: 0px;">DOOR TO DOOR CARGO AIR & TRAIN SERVICE</p>
        <p class="" style="margin-left: 20px;">SR.NO.16/1D/2K/1, WADGAON SHINDHE</p>
        <p class="" style="margin-left: 10px;">ROAD, BEHIND DURGA HOTEL, LOHEGAON</p>
        <p class="" style="margin-left: 120px;">PUNE-47</p>
        <h3 class="" style="margin-left: 80px;">&nbsp;<strong>TAX INVOICE</strong></h3>
    </div>                     <!-- End of Heading Text -->


     <p>M/S-</p>
    <div class="client-address" style="width: 50%;float:left; line-height: 8px">

        <p style="line-height: 8px;"> '. $_SESSION['ClientAddress'] . '</p>
        
    </div>
    
    <div class="clientee-address"  style="width: 50%;float:left; text-align: right;">
      <p>SERVICE TAX NO: AQSPR2247JSD001</p>
      <p>OUR PAN NO: AQSPR2247J</p>
      <p>INVOICE NO:' . $_SESSION['ClientInvoice'] . '</p>
      <p>INVOICE DATE:' . $_SESSION['InvoiceDate'] . '</p>
    </div>
 
 </div>   
    ';

    $content .= '
                    <table style="autosize:1; page-break-inside:avoid; " >
                    <thead>
                <tr>
                    <th width="8%">DATE</th>
                    <th width="8%">GR.NO</th>
                    <th width="5%">PKGS.</th>
                    <th width="5%">A.WT</th>
                    <th width="5%">C.WT</th> 
                    <th width="15%">INVOICENO</th> 
                    <th width="11%">SENDER</th> 
                    <th width="11%">RECEIVER</th> 
                    <th width="8%">ORIGIN</th> 
                    <th width="8%">DEST</th> 
                    <th width="5%">MODE</th> 
                    <th width="10%">FREIGHT</th> 
                      
                </tr>
                </thead>
                ';

    $content .= fetch_table();
    $content .= '</table>';

    # $content = '<style>'.file_get_contents('stylesheet.css').'</style>' . $content;
    #$obj_pdf->writeHTML($content);

    # $obj_pdf->Output('sample.pdf', 'I');


    $footer = '
   <!-- <hr style=" background-color: black; height: 1px; border: 0; "> -->
    <div class="modal-footer" style="font-size: 12px;">
    
    
         <p style="text-align: right; border-bottom: 1px solid black; border-top: 1px solid black; padding-top: 4px; padding-bottom: 4px; ">ODA CHARGES FROM ' . strtoupper($_SESSION['InvoiceClient']) .' TO W.H @1000'  . $_SESSION["CalculatedInvoiceODACharge"] .'</p>
         
    
        <div class="client-address" style="width: 58%;float:left; line-height: 14px; padding-bottom: 10px;">
               <p>Note:</p>
               <br>
               <br>
        </div>
    
        <div class="clientee-address"  style="width: 40%;float: right; border-left: 1px solid black; padding-bottom: 10px ; line-height: 14px;">
           
               
        <div class="client-address" style="width: 48%;float:left; line-height: 14px; margin-left: 2px;">
               <p>Total Freight</p>
               <p>Docket Charge</p>
               <p>S.Tax</p>
         </div>
         
           <div class="clientee-address"  style="width: 50%;float:left; text-align: right; line-height: 14px;">
         
               <p>' . $_SESSION["CalculatedInvoiceFreight"] .'</p>
               <p>' . $_SESSION["CalculatedInvoiceDocketCharge"] . '</p>
               <p>' . $_SESSION["CalculatedInvoiceGstRate"] .'</p>
           </div>
        </div>

        

        <div style="width: 100%; border-bottom: 1px solid black; border-top: 1px solid black;">

            <div class="client-address" style="width: 58%;float:left; padding-top: 4px; padding-bottom: 4px;  ">
               <p>TOTAL</p>
         </div>
         
           <div class="clientee-address"  style="width: 40%; border-left: 1px solid black; float: right; text-align: right;  padding-top: 4px; padding-bottom: 4px; ">
                <p>' . $_SESSION["CalculatedInvoiceTotalCost"] . '</p>
    
         </div> 
  
        </div>
        <div style=" border-bottom: 1px solid black">

            <div style="width: 58%; float:left; line-height: 14px;">


                <p style="text-align: left">NB: This is a bill not receipt if the payment is not made within
                    15 day from the date of receipt of Bill. The interes will be charged @3% P.M. Any
                    objection regarding this Bill can be raise within 7 days from  the arbitrator under the
                    Arbitration Act. The Arbitrator will be fixed by MD of the company.</p>
            </div>

            <div style="width: 40%; float: right; border-left: 1px solid black;">
                <p style="text-align: center;">for The United Cargo</p>
               
               
                 <div class="client-address" style="width: 48%;float:left; margin-left: 2px;  padding-bottom: 10px;">

                        <br>
                        <br>
                        <br>
                        <br>
                        <p>Prepared</p>
                        
                    </div>
                    
                    <div class="clientee-address"  style="width: 50%;float:left; text-align: right;  padding-bottom: 10px;">
                     <br>
                        <br>
                        <br>
                        <br>
                      <p>Checked</p>
                    </div>
                               
               
            </div>


        </div>
        
        
    </div>';


#    $mpdf->SetDisplayMode('fullpage');
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->autoMarginPadding = -20;
    $mpdf->SetHTMLHeader($header);
   # $mpdf->WriteHTML(file_get_contents('./css/bootstrap.css'), 1);
    $mpdf->WriteHTML($stylesheet,1);

    # $mpdf->SetHTMLHeader($content);






    $mpdf->WriteHTML($content,2);


    while(floor($CountElements/25)>=1){
        $mpdf->AddPage();
        $CountElements -= 34;
    }

    for($Count=0; $Count<floor($CountElements/25); $Count++){
        $mpdf->AddPage();
    }

    $mpdf->setAutoBottomMargin = 'stretch';

    $mpdf->SetHTMLFooter($footer);



    $mpdf->Output();
    ob_end_flush(); 
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


    <?php echo Message();
    echo SuccessMessage();
    ?>

    <div class="row" style="display:flex; margin-bottom: -15px;">
        <br>
        <div class="col-sm-2" style="color: #ff0000; ">
            <br>
            <br>
            <ul id="Side_Menu" class="nav nav-pills nav-stacked">
                <li><a href="DashboardPagination.php">
                        <span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
                <li><a href="AddEntry.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Entry</a></li>
                <li class="active"><a href="Invoice.php"><span class="glyphicon glyphicon-usd"></span> Invoice</a></li>

                <li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span> Manage Admins</a></li>


                <li><a href="Settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>

                <li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>


        </div> <!-- Ending of side area-->

            <div class="col-sm-10">
                <div>
                    <form action="Invoice.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="col-xs-4"><br><br><br></div>
                            <div class="col-xs-4"><br><br><br></div>
                            <div class="col-xs-4"><br><br><br></div>

                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="datefrom"><span class="FieldInfo">Date From:</span> </label>
                                    <input class="form-control" type="Date" name="datefrom" id="DateFrom"  value="<?php echo date("Y-m-d");?>">
                                </div></div>

                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="dateto"><span class="FieldInfo">Date To:</span> </label>
                                    <input class="form-control" type="Date" name="dateto" id="DateTo" value="<?php echo date("Y-m-d");?>" >
                                </div></div>



                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="origin"><span class="FieldInfo">Origin:</span> </label>
                                    <input class="form-control" type="text" name="origin" id="Origin" placeholder="Origin">
                                </div></div>


                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="invoiceclient"><span class="FieldInfo">Invoice/Client.</span> </label>
                                    <input class="form-control" type="text" name="invoiceclient"  id="InvoiceClient" placeholder="itw" >
                                </div></div>


                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="clientinvoice"><span class="FieldInfo">Client Invoice No.</span> </label>
                                    <input class="form-control" type="text" name="clientinvoice"  id="ClientInvoice" placeholder="ASPG/2102/190" >
                                </div></div>


                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="date"><span class="FieldInfo">Invoice Date:</span> </label>
                                    <input class="form-control" type="Date" name="invoicedate" id="InvoiceDate" placeholder="Date" value="<?php echo date("Y-m-d");?>">
                                </div></div>

                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="clientaddress"><span class="FieldInfo"></span>Client Address</label>
                                 <textarea style="height: 100px" class="form-control" id="ClientAddress" name="clientaddress" placeholder="Your Message *" required data-validation-required-message="Please enter a message."></textarea>

                                </div></div>




                            <div class="col-xs-4" style="margin-bottom:-20px;">
                                <br>
                                <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Generate">
                                <br>
                                <br>
                            </div>


                            <div class="col-xs-4" style="">

                                <form target="_blank" method="post" >
    <input type="submit" class="btn btn-primary" name="generatepdf" id="generatepdf" value="GeneratePDF">
</form>
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
                                        <td class="amount"><?php echo  $_SESSION["CalculatedInvoiceFreight"] ?></td>
                                    </tr>

                                    <tr>
                                        <td class="td-vert-middle"></td>
                                        <td class="clearfix">

                                            <div class="form-group">
                                                <input id="perdocketcharge" name="perdocketcharge"
                                                       class="form-control"
                                                       value="<?php if(isset($_POST['perdocketcharge'])) echo $_POST['perdocketcharge'];
                                                       else echo $PerDocketCharge?>"
                                                <div class="input-group-addon">Docket Charge</div>
                                            </div>


                                            <div class="form-group">
                                                <input id="gstrate" name="gstrate"
                                                       class="form-control"
                                                       value="<?php if(isset($_POST['gstrate'])) echo $_POST['gstrate'];
                                                       else echo $GstRate?>"
                                                <div class="input-group-addon">GST&percnt;</div>
                                            </div>

                                            <div class="form-group">
                                                <input id="perodacharge" name="perodacharge"
                                                       class="form-control"
                                                       value="<?php if(isset($_POST['perodacharge'])) echo $_POST['perodacharge'];
                                                       else echo $PerODACharge?>"
                                                <div class="input-group-addon">ODA Charge</div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="amount"><b>Docket</b></td>
                                        <td><b><?php echo $_SESSION["CalculatedInvoiceDocketCharge"] ?></b></td>
                                    </tr>
                                    <tr>

                                        <td class="amount"><b>ODA</b></td>
                                        <td><b><?php echo $_SESSION["CalculatedInvoiceODACharge"] ?></b></td>
                                    </tr>
                                    <tr>

                                        <td class="amount"><b>GST</b></td>
                                        <td><b><?php echo $_SESSION["CalculatedInvoiceGstRate"] ?></b></td>
                                    </tr>

                                    <tr>

                                        <td class="amount"><b>Total</b></td>
                                        <td><b><?php echo $_SESSION["CalculatedInvoiceTotalCost"] ?></b></td>
                                    </tr>
                                </table>




                            </div>


                        </fieldset>

                    </form>

                </div>
            </div>


    </div>
</div>



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
</div>  <!-- Footer-->


</body>
</html>