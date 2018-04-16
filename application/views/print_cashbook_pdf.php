<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="STYLESHEET" href="<?php echo CSS_PATH.'pdf_css.css'; ?>" type="text/css" />
</head>

<body>

<div id="body">

<div id="section_header">
</div>

<div id="content">
  
<div class="page" style="font-size: 7pt">
<table style="width: 100%;" class="header">
<tr>
    <td style="text-align: left; font-size: 15px; color: #ce0a86;">
 <b>KOMBANS JEWELLERY & LADIES FASHION CENTRE</b><br/>Market Road, Mannuthy<br/>Thrissur, Mob: 9020515846
    </td>
<td></td>
<td><h1 style="text-align: right"><?php //echo date('d-m-Y'); ?></h1></td>
</tr>
<tr>
<td></td>
<td></td>
<td><h3 style="text-align: right"></h3></td>
</tr>
</table>

<!--<table style="width: 100%; font-size: 8pt;">
<tr>
<td>Ramanilayam Jn. Shopping Complex</td><td></td><td></td>
<td style="text-align: right">Purchaser(s): <strong><?php echo $customer[0]->vendor_name; ?></strong></td>
</tr>

<tr>
<td>Chembukkavu, Thrissur</td><td></td><td></td>
<td style="text-align: right"><strong><?php echo $customer[0]->address1; ?></strong>, <?php echo $customer[0]->address2; ?></td>
</tr>

<tr>
<td>Ph: <strong>09961922246</strong></td><td></td><td></td>
<td style="text-align: right"><?php echo "TIN NO: ".$customer[0]->tin_no; ?></td>
</tr>
</table>-->

    <hr>
<table class="change_order_items" style=" font-size: 12px;">

<tr><td></td><td colspan="5"><h2>CASHBOOK [<?php  echo $select_date; ?>] - OPENING BALANCE: <?php echo $opening_balance; ?></h2></td></tr>

<tbody>
<tr>
<th>SI No.</th>
<th>Date</th>
<th>Ledger Name</th>
<!--<th>Account Group</th>-->
<th>Narration</th>
<th>Debit</th>
<th>Credit</th>
</tr>

<?php 
    $n = sizeof($txn_date);
    for ($i=0; $i < $n; $i++) { ?>
        <tr class="<?php if($i%2 == 0) echo 'even_row'; ?>">
        <td style="text-align: center"><?php echo $i+1; ?></td>
        <td style="text-align: center"><?php echo $txn_date[$i]; ?></td>
        <td><?php echo $account[$i]; ?></td>
        <!--<td style="text-align: center"><?php echo $account_group[$i]; ?></td>-->
        <td style="text-align: center;"><?php echo $narration[$i]; ?></td>
        <td style="text-align: right"><?php echo $debit[$i]; ?></td>
        <td class="change_order_total_col"><?php echo $credit[$i]; ?></td>
        </tr>
    <?php }
?>






<tr>
<td colspan="4" style="text-align: right;"><i><strong>BALANCE: Rs. <?php echo $balance_sum[0]; ?>/-</strong></i></td>
<td colspan="1" style="text-align: right;"><i><strong>Rs. <?php echo $debit_sum[0]; ?>/-</strong></i></td>
<td class="change_order_total_col"><i><strong>Rs. <?php echo $credit_sum[0]; ?>/-</strong></i></td></tr>
<tr>
<td colspan="6" style="text-align: center;"><strong>CLOSING BALANCE: Rs. <?php echo $closing_balance; ?>/-</strong></td></tr></tbody>
</table>
<table class="sa_signature_box" style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">
  
<!--  <tr>
      <td><b>Terms & Conditions</b></td>
  </tr>

<tr><td colspan="4" style="white-space: normal">
This change order shall have no force or effect until approved and signed
by an authorizing signing officer of the supplier.  Any change or special
request not noted on this document is not contractual.<br/><br/>

1 year free service will be available<br/><br/>

After 1 year, There will be Annual Maintenance Cost. (15% of the total price of package).Its optional.<br/><br/>
DVR Demands uninterrupted power supply. We are not responsible for the data loss due to such power losses.

</td>
</tr>-->
<tr><td></td></tr><tr><td></td></tr>
<!--<tr>    
    <td>AUTHORIZED SIGNATURE:</td><td class="written_field" style="padding-left: 2.5in">&nbsp;</td>
    <td style="padding-left: 1em">CUSTOMER:</td><td class="written_field" style="padding-left: 2.5in; text-align: right;">X</td>
</tr>-->
</table>

</div>

</div>
</div>

<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("verdana");
  // If verdana isn't available, we'll use sans-serif.
  if (!isset($font)) { Font_Metrics::get_font("sans-serif"); }
  $size = 6;
  $color = array(0,0,0);
  $text_height = Font_Metrics::get_font_height($font, $size);

  $foot = $pdf->open_object();
  
  $w = $pdf->get_width();
  $h = $pdf->get_height();

  // Draw a line along the bottom
  $y = $h - 2 * $text_height - 24;
  $pdf->line(16, $y, $w - 16, $y, $color, 1);

  $y += $text_height;

  $text = "Job: 132-003";
  $pdf->text(16, $y, $text, $font, $size, $color);

  $pdf->close_object();
  $pdf->add_object($foot, "all");

  global $initials;
  $initials = $pdf->open_object();
  
  // Add an initals box
  $text = "Initials:";
  $width = Font_Metrics::get_text_width($text, $font, $size);
  $pdf->text($w - 16 - $width - 38, $y, $text, $font, $size, $color);
  $pdf->rectangle($w - 16 - 36, $y - 2, 36, $text_height + 4, array(0.5,0.5,0.5), 0.5);
    

  $pdf->close_object();
  $pdf->add_object($initials);
 
  // Mark the document as a duplicate
  $pdf->text(110, $h - 240, "DUPLICATE", Font_Metrics::get_font("verdana", "bold"),
             110, array(0.85, 0.85, 0.85), 0, 0, -52);

  $text = "Page {PAGE_NUM} of {PAGE_COUNT}";  

  // Center the text
  $width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
  
}
</script>
    <!--<script>
        $('body , document').keyup(function(e){
 if(e.ctrlKey && e.keyCode == 80){
<?php 
//code
?>
}
});
    </script>-->

</body>
</html>