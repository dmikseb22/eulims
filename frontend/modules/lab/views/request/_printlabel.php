<!-- <barcode code="20889 CHE-0859" type="C39" /> -->
<style>
body {
	font-family: \'DejaVu Sans Condensed\';
}
@page {
	margin-top: 0cm;
	margin-bottom: 0cm;
	margin-left: 0cm;
	margin-right: 0cm;
	margin-header: 0mm;
	margin-footer: 0mm;
	background-color:#ffffff;
}
</style>
<?php
    foreach ($samplesquery as $sample) {
              echo $sample['samplename']."<br>";
               $mpdf->AddPage('','','','','',0,0, 0, 0);
            }       
?>



