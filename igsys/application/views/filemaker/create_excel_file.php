<?php
header("Content-type: application/vnd.ms-excel");
header("Content-disposition:  attachment; filename=" . $reportName . date("d-m-Y").".csv");
print $results;
?>
