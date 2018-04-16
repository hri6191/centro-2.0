<?php $customer = $this->general->get_data_wer('vendor_reg', 'id', $sale_data['customer_id']); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="STYLESHEET" href="<?php echo CSS_PATH . 'pdf_css.css'; ?>" type="text/css" />
    </head>

    <body>
<?php if(strtotime($sale_data['sale_date']) < strtotime(date('2017-07-01'))) { ?>
        <div id="body">

            <div id="section_header">
            </div>

            <div id="content">

                <div class="page" style="font-size: 8pt">
                    <div>
                        <div style="text-align: left; font-size: 8pt;">
                            TIN NO: <strong>32080796436</strong>
                        </div>
                        <div style="text-align: center; font-size: 9pt;">
                            <b><u style="font-size: 13pt;">BEST SANITARY</u></b><br/>
                            Behind Ragam Theatre, Mannadiar Lane<br/>
                            Thrissur, Kerala - 680 001<br/>
                            TAX INVOICE CASH/CREDIT<br/>
                            KERALA VALUE ADDED TAX RULES - 2005 FORM NO 8B
                        </div>
                    </div>
                    <table style="width: 100%; font-size: 8pt;">
                        

                        <tr>
                            <td style="text-align: left">Customer(s): <strong><?php echo $customer[0]->vendor_name; ?></strong></td>
                            <td></td><td></td><td style="text-align: right"><b><?php echo 'Invoice No: ' . $sale_data['invoice_number']; ?></b></td>
                        </tr>

                        <tr>
                            <td style="text-align: left"><strong><?php echo $customer[0]->address1; ?></strong></td>
                            <td></td><td></td><td style="text-align: right">Date: <b><?php echo date("d-m-y", strtotime($sale_data['sale_date'])); ?></b></td>
                        </tr>

                        <tr>
                            <td style="text-align: left"><strong><?php echo $customer[0]->address2; ?></strong></td>
                            <td></td><td></td><td></td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left"><?php echo "Ph: <b>" . $customer[0]->phone_no."</b>"; ?></td>
                            <td></td><td></td><td></td>
                        </tr>
                        
                        <?php if($customer[0]->tin_no) { ?>
                        <tr>
                            <td style="text-align: left"><?php echo "TIN NO: <b>" . $customer[0]->tin_no."</b>"; ?></td>
                            <td></td><td></td><td></td>
                        </tr>
                        <?php } ?>
                        
                        <?php if($customer[0]->cst) { ?>
                        <tr>
                            <td style="text-align: left"><?php echo "CST: <b>" . $customer[0]->cst."</b>"; ?></td>
                            <td></td><td></td><td></td>
                        </tr>
                        <?php } ?>
                    </table>

                    <hr>

                    <table class="change_order_items">

<!--                        <tr><td></td><td colspan="8"><h2>Details of Products:</h2></td></tr>-->

                        <tbody>
                            <tr>
                                <th width="5%">SI No.</th>
                                <th width="34%">Item Name</th>
                                <th>Tax%</th>
                                <th>Unit Price</th>
                                <th colspan="2">Qty</th>
                                <th>Gross Amt</th>
                                <th>Tax Amt</th>
                                <th width="10%">Total</th>
                            </tr>

                            <?php
                            $gross_amount = 0;
                            $tax_amount = 0;
                            $n = sizeof($inventory_name);
                            for ($i = 0; $i < $n; $i++) {
                                ?>
                                <tr class="<?php if ($i % 2 == 0) echo 'even_row'; ?>">
                                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                                    <td style="font-size: 10pt;"><?php echo $inventory_name[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $sale_tax[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $sale_price[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;" colspan="2"><?php echo $quantity[$i].' '.$unit[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo round(($sale_price[$i]*$quantity[$i]), 2); ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo round(($sale_price[$i]*$quantity[$i]*$sale_tax[$i]/100), 2); ?></td>
                                    <td class="change_order_total_col" style="font-size: 10pt;"><?php echo $total[$i]; ?></td>
                                </tr>
                            <?php 
                            $gross_amount = $gross_amount+round(($sale_price[$i]*$quantity[$i]), 2);
                            $tax_amount = $tax_amount+round(($sale_price[$i]*$quantity[$i]*$sale_tax[$i]/100), 2);
                            }
                            ?>

                        </tbody>




<!--<tr><td></td>
<td colspan="4" style="text-align: right;"></td>
<td colspan="2" style="text-align: right;"><strong>TOTAL:</strong></td>
<td class="change_order_total_col"><strong>Rs. <?php //echo $sale_total_without_discount; ?>/-</strong></td></tr>-->
                        
                        <?php if ($sale_data['discount']) { ?>
                        <tr><td></td>
                            <td colspan="2" style="text-align: right;"></td>
                            <td colspan="3" style="text-align: right;"><strong>TOTAL:</strong></td>
                            <td class="change_order_total_col"><strong><?php echo $gross_amount; ?></strong></td>
                            <td class="change_order_total_col"><strong><?php echo $tax_amount; ?></strong></td>
                            <td class="change_order_total_col"><strong><?php echo round($tax_amount+$gross_amount); ?>/-</strong></td></tr>
                            <tr><td></td>
                                <td colspan="5" style="text-align: right;"></td>
                                <td colspan="2" style="text-align: right;"><strong>DISCOUNT (<?php echo $sale_data['discount']; ?>%)</strong></td>
                                <td class="change_order_total_col"><strong><?php echo round(($tax_amount+round($gross_amount))*$sale_data['discount']/100); ?></strong></td></tr>
                                <tr><td></td>
                                <td colspan="5" style="text-align: right;"></td>
                                <td colspan="2" style="text-align: right; font-size: 10pt;"><strong>GRAND TOTAL:</strong></td>
                                <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $sale_data['sale_total']; ?>/-</strong></td></tr>
                                    <?php } else { ?>
                                <tr><td></td>
                            <td colspan="2" style="text-align: right;"></td>
                            <td colspan="3" style="text-align: right; font-size: 10pt;"><strong>GRAND TOTAL:</strong></td>
                            <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $gross_amount; ?></strong></td>
                            <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $tax_amount; ?></strong></td>
                            <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $sale_data['sale_total']; ?>/-</strong></td></tr>
                                    <?php } ?>
                    </table>
                    
                    <?php
            $no = round($sale_data['sale_total']);
            $point = abs(round($sale_data['sale_total'] - $no, 2) * 100);
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
$words2 = array('0' => 'zero', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                            " " . $digits[$counter] . $plural . " " . $hundred :
                            $words[floor($number / 10) * 10]
                            . " " . $words[$number % 10] . " "
                            . $digits[$counter] . $plural . " " . $hundred;
                } else
                    $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
		 $point = $point>50?(100-$point):$point;
            $points = ($point) ?
                    "." . $words2[$point / 10] . " " .
                    $words2[$point = $point % 10] : '';
            $amount_in_words = $result . "  " . $points . " ";
            ?>
                    Total (in words) Rupees <b><?php echo strtoupper($amount_in_words); ?> Only</b>
                    <table class="sa_signature_box" style="border-top: 1px solid black;">
                        <tr>
                            <td style="font-size: 8pt;"><b>E&OE</b></td>
                            <td style="text-align: center; font-size: 8pt;"><b>DECLARATION</b> (To be furnished by the seller)</td>
                        </tr>
                        <tr><td colspan="3" style="white-space: normal; font-size: 7pt; text-align: justify;">
                                Certified that all the particulars shown in the above tax invoice are true & correct in all respects and the goods on which the tax charged and collected are in accordance with the provisions of the KVAT ACT 2003 and the rules made there under. It is also certified that my/our Registration under KVAT Act 2003 is not subject to any suspension/cancellation and it is valid as on the date of this bill.<br/>
                            </td>
                        </tr>
                        <tr>
                            <td></td><td></td><td style="text-align: center; font-size: 8pt;">FOR BEST SANITARY</td>
                        </tr>
                        <tr>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td></td><td></td><td style="text-align: center; font-size: 8pt;">Authorised Signatory</td>
                        </tr>
                    </table>

                </div>

            </div>
        </div>

        
        <?php } else { ?>
        <div id="body">

            <div id="section_header">
            </div>

            <div id="content">

                <div class="page" style="font-size: 10pt">
                    <table style="width: 100%; font-size: 10pt;">
                        <tr>
                            <td><b>GSTIN: 32AJEPB9105G2Z6</b></td><td></td><td></td>
                            <td style="text-align: right"><strong></strong></td>
                        </tr>
                    </table>
                    <div style="text-align: center; font-size: 10pt">
                        <b><u style="font-size: 13pt;">BEST SANITARY</u></b><br/>
                        Behind Ragam Theatre, Mannadiar Lane<br/>
                            Thrissur, Kerala - 680 001,<br/>
                             Ph: 0487-420279, +91 9388600946<br/>
                        <u>TAX INVOICE</u><br/>
                    </div>
                    <table style="width: 100%; font-size: 10pt;">
                        <tr>
                            <td><b><?php echo 'Invoice No: A' . str_pad($sale_data['invoice_number'], 3, '0', STR_PAD_LEFT); ?></b></td><td></td><td></td>
                            <td style="text-align: right"><strong>Date: <?php echo date("d-m-Y", strtotime($sale_data['sale_date'])); ?></strong></td>
                        </tr>

                        <tr>
                            <td><b>Customer:</b> <?php echo $customer[0]->vendor_name.', '.$customer[0]->address1.', '.$customer[0]->address2; ?></td><td></td><td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <td><?php if($customer[0]->phone_no) { echo "<b>Ph: </b>" . $customer[0]->phone_no; } ?></td><td></td><td></td>
                            <td></td>
                        </tr>
                        
                        <?php if($customer[0]->kgst) { ?>
                        <tr>
                            <td><?php echo "<b>GSTIN: </b>" . $customer[0]->kgst; ?></td><td><?php if($customer[0]->cst) { echo "<b>CST: </b>" . $customer[0]->cst; } ?></td><td></td>
                            <td></td>
                        </tr>
                        <?php } ?>
                    </table><br/>
                    <?php if($sale_data['dc_no']) { ?>
                    <b>Delivery Note No & Date:</b> <?php echo $sale_data['dc_no'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; } ?>
                    <?php if($sale_data['vehicle_no']) { ?>
                    <b>Vehicle No: </b> <?php echo $sale_data['vehicle_no']; } ?>
                    <hr>

                    <table class="change_order_items">

                        <tbody>
                            <tr>
                                <th width="5%">SI No.</th>
                                <th width="30%">Item Name</th>
                                <th>HSN</th>
<!--                                <th width="5%">Description</th>-->
                                <th>Unit Price</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Gross Amt</th>
                                <th>CGST Rate%</th>
                                <th>CGST Amt</th>
                                <th>SGST Rate%</th>
                                <th>SGST Amt</th>
                                <th width="10%">Total</th>
                            </tr>

                            <?php
                            $gross_amount = 0;
                            $tax_amount = 0;
                            $n = sizeof($inventory_name);
                            for ($i = 0; $i < $n; $i++) {
                                ?>
                                <tr class="<?php if ($i % 2 == 0) echo 'even_row'; ?>">
                                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                                    <td style="font-size: 10pt;"><?php echo $inventory_name[$i].' ('.$inventory_code[$i].')'; ?></td>
                                    <td style="font-size: 10pt;"></td>
<!--                                    <td style="text-align: center"><?php //echo $inventory_code[$i]; ?></td>-->
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $sale_price[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $unit[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $quantity[$i]; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo round(($sale_price[$i]*$quantity[$i]), 2); ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $sale_tax[$i]/2; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo round(($sale_price[$i]*$quantity[$i]*$sale_tax[$i]/100), 2)/2; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo $sale_tax[$i]/2; ?></td>
                                    <td style="text-align: center; font-size: 10pt;"><?php echo round(($sale_price[$i]*$quantity[$i]*$sale_tax[$i]/100), 2)/2; ?></td>
                                    <td class="change_order_total_col" style="font-size: 10pt;"><?php echo $total[$i]; ?></td>
                                </tr>
                            <?php 
                            $gross_amount = $gross_amount+round(($sale_price[$i]*$quantity[$i]), 2);
                            $tax_amount = $tax_amount+round(($sale_price[$i]*$quantity[$i]*$sale_tax[$i]/100), 2);
                            }
                            ?>

                        </tbody>




<!--<tr><td></td>
<td colspan="4" style="text-align: right;"></td>
<td colspan="2" style="text-align: right;"><strong>TOTAL:</strong></td>
<td class="change_order_total_col"><strong>Rs. <?php //echo $sale_total_without_discount; ?>/-</strong></td></tr>-->
                        <?php if ($sale_data['discount']) { ?>
                            <tr>
                                <td colspan="11" style="text-align: right;"><strong>DISCOUNT:</strong></td>
                                <td class="change_order_total_col"><strong>Rs. <?php echo $sale_data['discount']; ?>/-</strong></td></tr><?php } ?>
                        <!--<tr>
                            <td colspan="6" style="text-align: right; font-size: 10pt;"><strong>GRAND TOTAL:</strong></td>
                            <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $gross_amount; ?></strong></td>
                            <td colspan="2" class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $tax_amount/2; ?></strong></td>
                            <td colspan="2" class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $tax_amount/2; ?></strong></td>
                            <td class="change_order_total_col" style="font-size: 10pt;"><strong><?php echo $sale_data['sale_total']; ?>/-</strong></td></tr>-->
                        <tr>
                            <td colspan="10" style="text-align: right; font-size: 8pt;"><strong>Total Amount Before Tax:</strong></td>
                            <td class="change_order_total_col" colspan="2" style="font-size: 8pt;"><strong><?php echo $gross_amount; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right; font-size: 8pt;"><strong>CGST:</strong></td>
                            <td colspan="2" class="change_order_total_col" style="font-size: 8pt;"><strong><?php echo $tax_amount/2; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right; font-size: 8pt;"><strong>SGST:</strong></td>
                            <td colspan="2" class="change_order_total_col" style="font-size: 8pt;"><strong><?php echo $tax_amount/2; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right; font-size: 8pt;"><strong>Tax Amount: GST</strong></td>
                            <td colspan="2" class="change_order_total_col" style="font-size: 8pt;"><strong><?php echo $tax_amount; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: right; font-size: 8pt;"><strong>Total Amount After Tax</strong></td>
                            <td class="change_order_total_col" colspan="2" style="font-size: 8pt;"><strong><?php echo $sale_data['sale_total']; ?>/-</strong></td>
                        </tr>
                    </table>
                    
                    <?php
            $no = round($sale_data['sale_total']);
            $point = abs(round($sale_data['sale_total'] - $no, 2) * 100);
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
$words2 = array('0' => 'zero', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                            " " . $digits[$counter] . $plural . " " . $hundred :
                            $words[floor($number / 10) * 10]
                            . " " . $words[$number % 10] . " "
                            . $digits[$counter] . $plural . " " . $hundred;
                } else
                    $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
		 $point = $point>50?(100-$point):$point;
            $points = ($point) ?
                    "." . $words2[$point / 10] . " " .
                    $words2[$point = $point % 10] : '';
            $amount_in_words = $result . "  " . $points . " ";
            ?>
                    Total (in words) Rupees <b><?php echo strtoupper($amount_in_words); ?> Only</b>
                    <table class="sa_signature_box" style="border-top: 1px solid black;">
                        <tr>
                            <td></td>
                            <td style="text-align: center;"><b>DECLARATION</b> (To be furnished by the seller)</td>
                        </tr>
                        <tr><td colspan="3" style="white-space: normal">
                                Certified that all the particulars shown in the above tax invoice are true & correct in all respects.<br/>
                            </td>
                        </tr>
                        <tr>
                            <td></td><td></td><td style="text-align: center;">FOR BEST SANITARY</td>
                        </tr>
                        <tr>
                            <td></td><td></td><td></td>
                        </tr>
                        <tr>
                            <td></td><td></td><td style="text-align: center;">Authorised Signatory</td>
                        </tr>
                    </table>

                </div>

            </div>
        </div>
        <?php } ?>
        
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