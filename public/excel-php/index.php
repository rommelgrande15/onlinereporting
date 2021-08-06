<?php
//for the cmd: composer require phpoffice/phpspreadsheet


require_once "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once "Librosphp.php";
?>

<form action="" method="get">
                <button type="submit" id="btnExport" name='export'
                    value="expgasto" class="btn btn-info">Export
                    to Excel</button>
            </form>

<?php

//only when button is clicked to export
if (isset($_REQUEST["export"])) {
		$libros = new Libros();
		//create array with results
		$librosResult = $libros->getAll();
		//new instance of the Libros class
		$libros = new Libros();
		//create array with results
		$librosResult = $libros->getAll();
		//create the document
    	$documento = new Spreadsheet();
		$sheetBooks = $documento->getActiveSheet();
		//set headers
		$header = ["Name", "address", "City", "Postal", "Country"];
		//set cell for headers as A1
		$sheetBooks->fromArray($header, null, 'A1');
		//as headers are in row 1, our data will start at row 2
		$rowNumb = 2;
		//iterate thru each of the records in the results array and place each data piece in each cell
		foreach ($librosResult as $row) {
			$sheetBooks->setCellValueByColumnAndRow(1, $rowNumb, $row['CustomerName']);
		    $sheetBooks->setCellValueByColumnAndRow(2, $rowNumb, $row['Address']);
		    $sheetBooks->setCellValueByColumnAndRow(3, $rowNumb, $row['City']);
		    $sheetBooks->setCellValueByColumnAndRow(4, $rowNumb, $row['PostalCode']);
		    $sheetBooks->setCellValueByColumnAndRow(5, $rowNumb, $row['Country']);
		    $rowNumb++;
		}
		//prepre the file for export and write it using composer magic
		$extension = 'Xlsx';
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documento, $extension);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"Books-".date('Y_m_d-H_i_s').".xlsx\"");
		//clear buffer
		ob_end_clean();
		$writer->save('php://output');
		//$writer->save('reportABC.xlsx');
		exit();
}

/*


if you dont want to hardcode the headers, you can use the headers coming from you query, MAKE SURE that you use aliases and not original column names from your tables.

instead of:
$header = ["Id", "Nombre", "Clasificacion", "Pags", "Autor"];

write:
$header = array_keys($librosResult[0]);

for the "foreach" loop to be automated and no hard writing the key names, you need to change the whole foreach part by the following

    foreach ($librosResult as $row) {

        $col = 1;
        $col_header = 0;
        foreach ($header as $row_in) {
            $sheetBooks->setCellValueByColumnAndRow($col, $rowNumb, $row[$header[$col_header]]);
            $col++;
            $col_header++;
        }
       
        $rowNumb++;
    }


*/

?>