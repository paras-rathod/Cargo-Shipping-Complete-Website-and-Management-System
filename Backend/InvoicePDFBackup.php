<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>
<?php require_once("include/Predefined.php"); ?>
<?php //confirm_Login(); ?>



<?php

if($_SESSION["Access"]=="no"){
    Redirect_to("AddEntryUser.php");
}

?>

<?php function fetch_table()
{

    $output = "";

    $InvoiceClient = $_SESSION['InvoiceClient'];
    $Origin = $_SESSION['Origin'];
    $DateTo = $_SESSION['DateTo'];
    $DateFrom = $_SESSION['DateFrom'];

    $Query="SELECT * FROM shippingdata WHERE invoiceclient='$InvoiceClient' AND origin='$Origin'  AND date>='$DateFrom' AND date<='$DateTo'";
    $Execute=mysqli_query($Query);


    while($DataRows=mysqli_fetch_assoc($Execute)) {

        $output .= '
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
        ';


    }

    return $output;

}


if(isset($_POST['generatepdf'])){
    require_once("../vendor/tcpdf/tcpdf.php");

    ob_start();

    // image-logo


    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("The United Cargo");
    $obj_pdf->SetHeaderData("2.png99", '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins('1', '5', '1');
    $obj_pdf->setPrintHeader(false);
    $obj_pdf->setPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 6);
    $obj_pdf->AddPage();
    $content = '';

    $content .= '
                    <table border="0" cellspacing="0" cellpadding="5">
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
                ';

    $content .= fetch_table();
    $content .= '</table>';
    $content = '<style>'.file_get_contents('stylesheet.css').'</style>' . $content;
    $obj_pdf->writeHTML($content);

    $obj_pdf->Output('sample.pdf', 'I');
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New Entry</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>


    <style type="text/css">

        body{
            align-content: center;
            line-height: 8px;
        }
        .container-fluid{
            width: 100%;
            background-color: #eee;
        }

        .address{
            display: block;
            margin: 10px;
        }

        .address span{
            display:block;float:right;margin-left:10px;
        }

        .last-cell{
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display:         flex;
        }

    </style>

</head>
<body>
<div class="container-fluid">



    <div style="display: inline;">
        <img  align="middle" src="2.png" height="100px" width="150px" style="margin-top:40px; margin-left: 400px; margin-right: 40px; display: inline-block; clear-after: right; float: left ">
    </div>

    <div class="heading-text" style=" display: inline;">

        <h3 class="" style="color: orange; margin-left: 40px; ">&nbsp;&nbsp;&nbsp;&nbsp;THE UNITED CARGO</h3>
        <p class="" style="margin-left: 40px;">&nbsp;DOOR TO DOOR CARGO AIR & TRAIN SERVICE</p>
        <p class="" style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;SR.NO.16/1D/2K/1, WADGAON SHINDHE</p>
        <p class="" style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;ROAD, BEHIND DURGA HOTEL, LOHEGAON</p>
        <p class="" style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PUNE-47</p>
        <h3 class="" style="margin-left: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>TAX INVOICE</strong></h3>
    </div>                     <!-- End of Heading Text -->


    <div class="address">

        <p>M/S-</p>
        <p>ITW INDIA PVT.LTD<span>SERVICE TAX NO: AQSPR2247JSD001</span></p>
        <p>ITW D ELTAR INT.COMPONENTS GROUP<span>OUR PAN NO: AQSPR2247J</span></p>
        <p>995/2/1,DINGRAJWADI<span>INVOICE NO: <?php echo $_SESSION['ClientInvoice']?></span></p>
        <p>PUNE,NAGAR ROAD,SHIRUR<span>INVOICE DATE: <?php echo $_SESSION['InvoiceDate']?></span></p>
    </div>


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

            </tr>

            <?php

            global $ConnectionDB;

            $InvoiceClient = $_SESSION['InvoiceClient'];
            $Origin = $_SESSION['Origin'];
            $DateTo = $_SESSION['DateTo'];
            $DateFrom = $_SESSION['DateFrom'];

            $Query="SELECT * FROM shippingdata WHERE invoiceclient='$InvoiceClient' AND origin='$Origin'  AND date>='$DateFrom' AND date<='$DateTo'";
            $Execute=mysqli_query($Query);
            $Count = 0;

            while($DataRows=mysqli_fetch_assoc($Execute)) {
                $Count++;
                $Date = $DataRows["date"];
                $GrNo = $DataRows["grno"];
                $Pkgs=$DataRows["pkgs"];
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
                    <td><?php echo $Awt; ?></td>
                    <td><?php echo $Cwt; ?></td>
                    <td><?php echo $Invoice; ?></td>
                    <td><?php echo $Sender; ?></td>
                    <td><?php echo $Receiver; ?></td>
                    <td><?php echo $Destination; ?></td>
                    <td><?php echo $Mode; ?></td>
                    <td><?php echo $Freight; ?></td>


                </tr>


            <?php } ?>


        </table>
        <br>
        <br>

        <?php if($Count<5) {
            echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
        }?>
    </div>

    <hr style=" background-color: black; height: 1px; border: 0; ">
    <div class="modal-footer">
        <p style="text-align: center; font-size: 15px;  font-weight: bold">ODA CHARGES FROM <?php echo strtoupper($InvoiceClient) ?> TO W.H @1000<span style='float: right; padding-right: 40px'><?php echo $_SESSION["CalculatedInvoiceODACharge"] ?></span></p>

        <hr style=" background-color: black; height: 1px; border: 0; ">


        <hr style=" background-color: black; height: 1px; border: 0; ">

        <div class="row">
            <div class="col-xs-8" >
                <p class="pull-left">Note:</p>
            </div>

            <div class="col-xs-4">
                <p style="text-align: left">Total Freight<span style="float: right; margin-right: 40px"><?php echo  $_SESSION["CalculatedInvoiceFreight"]?></span></p>
            </div>

            <div class="col-xs-8">

            </div>

            <div class="col-xs-4">
                <p style="text-align: left">Docket Charge<span style="float: right; margin-right: 40px"><?php echo $_SESSION["CalculatedInvoiceDocketCharge"]?></span></p>
            </div>


            <div class="col-xs-8">

            </div>

            <div class="col-xs-4">
                <p style="text-align: left">S.Tax<span style="float: right; margin-right: 40px"><?php echo $_SESSION["CalculatedInvoiceGstRate"]?></span></p>
            </div>

            <hr size="40">


            <br>
            <br>
            <br>
            <div class="col-xs-8">

                <p class="pull-left">TOTAL</p>

            </div>

            <div class="col-xs-4">
                <p style="margin-right: 40px"><?php echo $_SESSION["CalculatedInvoiceTotalCost"]?></p>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>

            <hr style=" background-color: black; height: 1px; border: 0; ">


            <div class="col-xs-8" style="line-height: 20px;">


                <p style="text-align: left">NB: This is a bill not receipt if the payment is not made within
                    15 day from the date of receipt of Bill. The interes will be charged @3% P.M. Any
                    objection regarding this Bill can be raise within 7 days from  the arbitrator under the
                    Arbitration Act. The Arbitrator will be fixed by MD of the company.</p>
            </div>

            <div class="col-xs-4" >
                <p style="text-align: left; vertical-align: bottom;">Prepared By<span style="float: right">Checked By</span></p>
            </div>


        </div>

        <hr style=" background-color: black; height: 1px; border: 0; ">
        <hr style=" background-color: black; height: 1px; border: 0; ">
    </div>

</div>
<form target="_blank" method="post" action="newInvoice.php">
    <input type="submit" class="btn btn-primary" name="generatepdf" id="generatepdf" value="GeneratePDF">
</form>

</body>
</html>




