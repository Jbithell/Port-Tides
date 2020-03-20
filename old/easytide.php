<?php 

// Load HTML 
$html = @DOMDocument::loadHTMLFile("http://easytide.ukho.gov.uk/EasyTide/EasyTide/ShowPrediction.aspx?PortID=0033&PredictionLength=7"); 
// Convert to SimpleXML object 
$xml = simplexml_import_dom($html); 

// Parse data tables from HTML 
$data = $xml->xpath('//div[@id="_ctl1_HWLWTable1_pnlHWLW"]'); 

// Image / data tables variables for use in current page - assume we only have one so just take the first array index 
$dataTables = $data[0]->asXML(); 
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
        "http://www.w3.org/TR/html4/strict.dtd"> 

<html> 
    <head> 
        <title>Easy Tide Scrape</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
         
        <style type="text/css"> 
            img { border: 0 } 
            .HWLWTable { float: left; padding: 10px; } 
            .HWLWTableHeaderCell { background-color: pink; } 
        </style> 
    </head> 

    <body> 
        <?php echo $dataTables; ?> 
    </body> 
</html>