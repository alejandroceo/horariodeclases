<?php


$pro = $_POST['pro'];

// Creacion de Tabla
if ($pro == 'table'){
	
// Dias
$dias = explode(',', $_POST['days']);
// Contar dias
$countdays = count($dias);

// Hora Inicio 12 Horas
$inicio24 = date('h:i A', strtotime($_POST['tiempo1']));

// Hora Final 12 Horas
$final24 = date('h:i A', strtotime($_POST['tiempo2']));

// Minutos
$minutos = $_POST['minutos'];


// Titulo
$titulo = $_POST['titulo'];

// Acomodar Dias
echo'
<h1 id="titleHorarioFinal" class="text-center">'.$titulo.'</h1>
<table id="thetable" class="table table-bordered">
<thead class="thead">
<th class="horarioheader"><i class="fa fa-clock-o"></i> Horario</th>
';
for ($i=0; $i < $countdays; $i++) { 
 if ($dias[$i] == 1) {
 	echo '<th>Lunes</th>';
 }elseif ($dias[$i] == 2){
 	echo '<th>Martes</th>';
 }elseif ($dias[$i] == 3){
 	echo '<th>Miercoles</th>';
 }elseif ($dias[$i] == 4){
 	echo '<th>Jueves</th>';
 }elseif ($dias[$i] == 5){
 	echo '<th>Viernes</th>';
 }elseif ($dias[$i] == 6){
 	echo '<th>Sabado</th>';
 }elseif ($dias[$i] == 7){
 	echo '<th>Domingo</th>';
 }
}
echo '
</thead>
<tbody>';


function resum($in,$fin,$minutos,$columnas){
$time = new DateTime($in);
$time->add(new DateInterval('PT' . $minutos . 'M'));
$stamp = $time->format('h:i a');
$format24 = $time ->format('G:i');

$uniq = str_replace(' ', '', str_replace(':', '', $stamp));
$reverse = strrev($uniq);



echo '<tr id="tr'.sha1($in).'">

<td class="td-time">

<div id="parent'.sha1($in).'" class="timeblock">
<strong id="data'.sha1($in).'">'.date('h:i a', strtotime($in)). ' - ' .$stamp.'</strong>
<button data-time="'.sha1($in).'" class="changethetime btn btn-warning btn-xs pull-right"><i class="fa-thin fa-pencil"></i></button>
</div>

<div id="edit'.sha1($in).'" class="hideedittime text-center">
  <input id="input'.sha1($in).'" type="text" class="form-control text-center" value="'.date('h:i a', strtotime($in)). ' - ' .$stamp.'"><p></p>

<div class="btn-group" role="group">
  <button data-save="'.sha1($in).'" class="savetime btn btn-xs btn-primary"><i class="fa-thin fa-floppy-disk"></i> Guardar</buttton>
  <button data-block="'.sha1($in).'" class="deleteblock btn btn-xs btn-warning"><i class="fa-thin fa-trash-can"></i> Eliminar</button>
  <button class="canceledit btn btn-xs btn-danger"><i class="fa-thin fa-circle-xmark"></i> Cancelar</buttton>
</div>

</div>

</td>';

for ($i=1; $i < $columnas; $i++) { 
	echo'
       <td class="td-line">
         <div id="'.$reverse.$i.'" class="col-sm-12 nopadding"></div>
         <div class="col-sm-12 text-center">
            <button id="edit-'.$reverse.$i.'" data-row="'.$reverse.$i.'" class="addinfo btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>
         </div>
      </td>
	';
}

echo '</tr>';

sumtime($format24,$fin,$minutos,$columnas);

}


function sumtime($in,$fin,$minutos,$columnas){
$parse1 = new DateTime($in);
$parse2 = new DateTime($fin);   
if ($parse2 <= $parse1){
  return;
}else{
$time = new DateTime($in);
$time->add(new DateInterval('PT' . $minutos . 'M'));
$stamp = $time->format('h:i a');
$format24 = $time ->format('G:i');
$uniq = str_replace(' ', '', str_replace(':', '', $stamp));
$reverse = strrev($uniq);

echo '<tr id="tr'.sha1($in).'">

<td class="td-time">

<div id="parent'.sha1($in).'" class="timeblock">
<strong id="data'.sha1($in).'">'.date('h:i a', strtotime($in)). ' - ' .$stamp.'</strong>
<button data-time="'.sha1($in).'" class="changethetime btn btn-warning btn-xs pull-right"><i class="fa-thin fa-pencil"></i></button>
</div>

<div id="edit'.sha1($in).'" class="hideedittime text-center">
  <input id="input'.sha1($in).'" type="text" class="form-control text-center" value="'.date('h:i a', strtotime($in)). ' - ' .$stamp.'"><p></p>

<div class="btn-group" role="group">
  <button data-save="'.sha1($in).'" class="savetime btn btn-xs btn-primary"><i class="fa-thin fa-floppy-disk"></i> Guardar</buttton>
  <button data-block="'.sha1($in).'" class="deleteblock btn btn-xs btn-warning"><i class="fa-thin fa-trash-can"></i> Eliminar</button>
  <button class="canceledit btn btn-xs btn-danger"><i class="fa-thin fa-circle-xmark"></i> Cancelar</buttton>
</div>


</div>

</td>';
for ($i=1; $i < $columnas; $i++) { 
	echo'
       <td class="td-line">
         <div  id="'.$reverse.$i.'" class="col-sm-12 nopadding"></div>
         <div class="col-sm-12 text-center">
            <button id="edit-'.$reverse.$i.'" data-row="'.$reverse.$i.'" class="addinfo btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>      
         </div>
      </td>
	';
}
echo'</tr>';
    resum($format24,$fin,$minutos,$columnas);
  }          
}
///////////////////////////////////////////////////////
sumtime($inicio24,$final24,$minutos,$countdays);
///////////////////////////////////////////////////////
echo '</tbody></table>
<div class="col-md-12 text-center">
   <div class="btn-group" role="group">
     <button type="button" class="btn btn-warning" onclick="SaveToPDF();">Guardar Como PDF <i class="fa-thin fa-file-pdf"></i></button>
     <button type="button" class="btn btn-danger" onclick="Ragain();">Empezar de Nuevo <i class="fa-thin fa-rotate-right"></i></button>
   </div>
</div>
';

}


// Creacion de Tabla
if ($pro == 'pdf'){

// HTML base64
$html = $_POST['html'];

$buffer = str_replace(array("\r", "\n"), '', $html);

//echo $buffer;
//exit();

// Include the main TCPDF library (search for installation path).
require_once('includes/pdf/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('dejavusans', '', 5);

// add a page
$pdf->AddPage();

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
$random = sha1($_POST['title']);
//Close and output PDF document
$pdf->Output(__DIR__.'/pdfs/'.str_replace(' ', '-', strtolower($_POST['title'])).'-'.date('d-m-Y').$random.'.pdf', 'F');
$done = 'pdfs/'.str_replace(' ', '-', strtolower($_POST['title'])).'-'.date('d-m-Y').$random.'.pdf';
echo $done;

}

if ($pro == 'delete') {
  $files = glob(__DIR__.'/pdfs/*'); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file)) {
      unlink($file); // delete file
    }
  }
}