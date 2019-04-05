<?php require_once("DB.php"); ?>

<?php
/**
 * Created by PhpStorm.
 * User: rahulsharma
 * Date: 1/22/18
 * Time: 11:30 AM
 */


global $ConnectionDB;


$Query="SELECT * FROM constantfields WHERE name='gstrate'";
$Execute=mysqli_query($Query);
$Row = mysqli_fetch_assoc($Execute);

$GstRate = $Row["value"];


$Query="SELECT * FROM constantfields WHERE name='perkgcost'";
$Execute=mysqli_query($Query);
$Row = mysqli_fetch_assoc($Execute);

$PerKgCost = $Row["value"];


$Query="SELECT * FROM constantfields WHERE name='perdocketcharge'";
$Execute=mysqli_query($Query);
$Row = mysqli_fetch_assoc($Execute);

$PerDocketCharge = $Row["value"];

$Query="SELECT * FROM constantfields WHERE name='perodacharge'";
$Execute=mysqli_query($Query);
$Row = mysqli_fetch_assoc($Execute);

$PerODACharge = $Row["value"];

$CountElements = 0;

