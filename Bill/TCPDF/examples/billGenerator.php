<?php

require_once __DIR__ . '/../../../Class/DatabasesManager.php';
$dbManager = new DatabasesManager();

// Include the main TCPDF library (search for installation path).
require_once __DIR__ . '/tcpdf_include.php';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FloconHome');
$pdf->SetTitle('Facture de Prestation');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print
$billRequest = $dbManager->getPdo()->prepare(
'SELECT * FROM bills WHERE fk_prestation = ?');
$clientInfo = $dbManager->getPdo()->prepare(
    'SELECT fk_account FROM prestation WHERE id = ?');
$providerInfo = $dbManager->getPdo()->prepare(
    'SELECT fk_provider FROM prestation WHERE id = ?');
$jobInfo = $dbManager->getPdo()->prepare(
    'SELECT fk_service FROM prestation WHERE id = ?');

$billRequest->execute(array($_GET['billNumber']));
$resultsBill = [];
while($result = $billRequest->fetch()){
    $resultsBill[] = $result;
}

$clientInfo->execute(array($resultsBill[0][1]));
$resultsClient = [];
while($result = $clientInfo->fetch()){
    $resultsClient[] = $result;
}
$clientInfo = $dbManager->getPdo()->prepare(
    'SELECT lastname, firstname, address, city, postal_code FROM account WHERE id = ?');
$clientInfo->execute(array($resultsClient[0][0]));
while($result = $clientInfo->fetch()){
    $resultsClient[] = $result;
}

$providerInfo->execute(array($resultsBill[0][1]));
$resultsProvider = [];
while($result = $providerInfo->fetch()){
    $resultsProvider[] = $result;
}
$providerInfo = $dbManager->getPdo()->prepare(
    'SELECT lastname, firstname FROM provider WHERE id = ?');
$providerInfo->execute(array($resultsProvider[0][0]));
while($result = $providerInfo->fetch()){
    $resultsProvider[] = $result;
}

$jobInfo->execute(array($resultsBill[0][1]));
$resultsJob = [];
while($result = $jobInfo->fetch()){
    $resultsJob[] = $result;
}
$jobInfo = $dbManager->getPdo()->prepare(
    'SELECT name FROM service WHERE id = ?');
$jobInfo->execute(array($resultsJob[0][0]));
while($result = $jobInfo->fetch()){
    $resultsJob[] = $result;
}
//var_dump($resultsBill, $resultsClient, $resultsProvider, $resultsJob);

$billNumber = $_GET['billNumber'];
$billNumber = str_pad($billNumber, 4, '0', STR_PAD_LEFT);
$date = $resultsBill[0][2];
$clientName = $resultsClient[1][0] . ' ' . $resultsClient[1][1];
$clientAddress = $resultsClient[1][2];
$clientCity = $resultsClient[1][3];
$clientPostalCode = $resultsClient[1][4];
$providerName = $resultsProvider[1][0] . ' ' . $resultsProvider[1][1];
$providerJob = $resultsJob[1][0];
$description = $resultsBill[0][3];
$hour = $resultsBill[0][4];
$rate = $resultsBill[0][5];
$cost = $resultsBill[0][6];
$total = $resultsBill[0][6];

$html = <<<EOD
<table style="width:100.0%;border-collapse:collapse;border:none;text-align: center" xmlns="http://www.w3.org/1999/html">
    <tbody>
    <tr>
        <td style="width: 251.75pt;padding: 0cm 5.75pt 28.8pt;vertical-align: top;">
            <h1 style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:16px;font-family:"Arial",sans-serif;font-weight:bold;'>FloconHome</h1>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;">242 Rue du Faubourg Saint-Antoine</span></p>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><span style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: center; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;">75012 Paris</span> </p>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><br></p>
        </td>
        <td style="width: 251.75pt;padding: 0cm 5.75pt 28.8pt;vertical-align: top;">
            <h1 style='margin-top:0cm;margin-right:0cm;margin-bottom:34.0pt;margin-left:0cm;text-align:right;line-height:110%;font-size:27px;font-family:"Arial",sans-serif;color:#595959;'>FACTURE</h1>
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>N° FACTURE : $billNumber</p>
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>Date : $date</p>
        </td>
    </tr>
    <tr>
        <td style="width: 251.75pt;padding: 0cm 5.75pt 36pt;vertical-align: top;">
            <h2 style='margin-top:2.0pt;margin-right:0cm;margin-bottom:3.0pt;margin-left:0cm;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>Client :</h2>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$clientName</p>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$clientAddress</p>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$clientPostalCode $clientCity<br></p>
        </td>
        <td style="width: 251.75pt;padding: 0cm 5.75pt 36pt;vertical-align: top;">
            <h2 style='margin-top:2.0pt;margin-right:0cm;margin-bottom:3.0pt;margin-left:0cm;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>Prestataire&nbsp;:</h2>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$providerName</p>
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$providerJob</p>
        </td>
    </tr>
    </tbody>
</table>
<table style="width: 100%;border-collapse:collapse;border:none;text-align: center;">
    <thead>
    <tr>
        <td style="width:284.7pt;border:solid windowtext 1.0pt;padding:2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;font-weight:bold;'>DESCRIPTION</p>
        </td>
        <td style="width:72.75pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:center;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;font-weight:bold;'>HEURES</p>
        </td>
        <td style="width:72.4pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:center;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;font-weight:bold;'>TAUX</p>
        </td>
        <td style="width:73.65pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:center;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;font-weight:bold;'>MONTANT</p>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="width:284.7pt;border:none;border-left:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:   2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$description<br></p>
        </td>
        <td style="width:72.75pt;border:none;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$hour heures<br></p>
        </td>
        <td style="width:72.4pt;border:none;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$rate €/heure<br></p>
        </td>
        <td style="width:73.65pt;border:none;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$cost €<br></p>
        </td>
    </tr>
    <tr>
        <td style="width:284.7pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:   2.15pt 5.75pt 2.15pt 5.75pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><br></p>
        </td>
        <td style="width:72.75pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><br></p>
        </td>
        <td style="width:72.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><br></p>
        </td>
        <td style="width:73.65pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:2.15pt 10.8pt 2.15pt 10.8pt;height:14.4pt;">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'><br></p>
        </td>
    </tr>
    </tbody>
</table>
<table style="width:100.02%;border-collapse:collapse;border:none;">
    <tbody>
    <tr>
        <td style="width: 85.28%;border-top: none;border-bottom: none;border-left: none;border-image: initial;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 14.4pt;vertical-align: top;text-align: right">
            <p style='margin:0cm;margin-bottom:.0001pt;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>TOTAL</p>
        </td>
        <td style="width: 14.72%;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 14.4pt;vertical-align: top;text-align: center">
            <p style='margin:0cm;margin-bottom:.0001pt;text-align:right;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;'>$total €</p>
        </td>
    </tr>
    </tbody>
</table>
<table style="text-align: center">
    <p style='margin-top:30.0pt;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:110%;font-size:15px;font-family:"Arial",sans-serif;font-weight:bold;'>FloconHome vous remercie de votre confiance.</p>
</table>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+