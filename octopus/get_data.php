<?php 
require("vendor/autoload.php");
use \PhpOffice\PhpSpreadsheet\IOFactory;
$filenameModel = "../datafiles/xls/new_model.xls";
$filenameCostos = "../datafiles/xls/HOJA_COSTOS_INDIRECTOS.xls";
$filenameModelOne = "../datafiles/xls/HOJA_MODEL_1.xls";
$filenameModelTwo = "../datafiles/xls/HOJA_MODEL_2.xls";
$filenameModelTree = "../datafiles/xls/HOJA_MODEL_3.xls";

$reader = IOFactory::createReader("Xls");
$reader->setReadDataOnly(true);
$hojaModel = $reader->load($filenameModel);
$hojaCostos = $reader->load($filenameCostos);
$hojaModelOne = $reader->load($filenameModelOne);
$hojaModelTwo = $reader->load($filenameModelTwo);
$hojaModelTree = $reader->load($filenameModelTree);

if(isset($_POST["action"])){

	if($_POST["action"] == "getInitialData"){
		try {

			$arrayInitial = getInitialData($hojaModel);
			$response = array(
				"state" => "success",
				"msg" => "Exito.",
				"datos" => $arrayInitial
			);
			echo json_encode($response);

		} catch (Exception $e) {
			$response = array(
				"state" => "error",
				"msg" => "Error. ".$e,
			);
			echo json_encode($response);
		}
	}


	if($_POST["action"] == "getInitialDataResultados98"){
		try {

			$arrayInitial = getInitialData98($hojaModelTwo);
			$response = array(
				"state" => "success",
				"msg" => "Exito.",
				"datos" => $arrayInitial
			);
			echo json_encode($response);

		} catch (Exception $e) {
			$response = array(
				"state" => "error",
				"msg" => "Error. ".$e,
			);
			echo json_encode($response);
		}
	}

	if($_POST["action"] == "getInitialDataResultados17"){
		try {

			$arrayInitial = getInitialData17($hojaModelTree);
			$response = array(
				"state" => "success",
				"msg" => "Exito.",
				"datos" => $arrayInitial
			);
			echo json_encode($response);

		} catch (Exception $e) {
			$response = array(
				"state" => "error",
				"msg" => "Error. ".$e,
			);
			echo json_encode($response);
		}
	}
	
}else{
	$response = array(
		"state" => "error",
		"msg" => "Error. No hay acción especificada.",
	);
	echo json_encode($response);
}

function getInitialData($loader){
	try {
		$cellsToExtract = array(
			"C5", 
			"C6", 
			"C7", 
			"C12", 
			"C13", 
			"C14", 
			"C18", 
			"C19", 
			"C20", 
			"C27", 
			"C28", 
			"C29", 
			"C33", 
			"C34", 
			"C35", 
			"C44", 
			"C45", 
			"C46", 
			"C50", 
			"C51", 
			"C52", 
			"C56", 
			"C57", 
			"C58", 
			"C62", 
			"C63", 
			"C64", 
			"D71", 
			"C77", 
			"C78", 
			"C85", 
			"C86", 
			"C87", 
			"C91", 
			"C92", 
			"C93", 
			"C97", 
			"C98", 
			"C99", 
			"C109", 
			"C110", 
			"C111", 
			"C115", 
			"C116", 
			"C117", 
			"C121", 
			"C122",
			"C123", 
			"A189", 
			"A192", 
			"A195", 
			"A198", 
			"A201", 
		);
		$resultFinal = [];
		foreach($cellsToExtract as $cell){
			$resultFinal = array_merge($resultFinal, getValueCell($loader, $cell));
		}
		return $resultFinal;
	} catch (Exception $e) {
		return false;
	}
}

function getInitialData98($loader){
	try {
		$cellsToExtract = array(
			"E7",
			"G7",
			"I7",
			"G8",
			"E11",
			"G11",
			"E12",
			"G12",
			"E13",
			"G13",
			"E14",
			"G14",
			"E15",
			"G15",
			"E16",
			"F16",
			"G16",
			"E17",
			"F17",
			"G17",
			"E18",
			"F18",
			"G18",
			"E19",
			"F19",
			"G19",
			"G20",
			"G21",
			"G24",

		);
		$resultFinal = [];
		foreach($cellsToExtract as $cell){
			$resultFinal = array_merge($resultFinal, getValueCell($loader, $cell));
		}

		$newResultFinal = [];
		foreach($resultFinal as $cell){
			$newResultFinal = array_merge($newResultFinal, array(number_format( round($cell, 2), 2,".","," )));
		}
		return $newResultFinal;
	} catch (Exception $e) {
		return false;
	}
}

function getInitialData17($loader){
	try {
		$cellsToExtract = array(
			"E7",
			"G7",
			"I7",
			"G8",
			"E11",
			"G11",
			"E12",
			"G12",
			"E13",
			"G13",
			"E14",
			"G14",
			"E15",
			"G15",
			"E16",
			"F16",
			"G16",
			"E17",
			"F17",
			"G17",
			"E18",
			"F18",
			"G18",
			"E19",
			"F19",
			"G19",
			"G20",
			"G21",
			"G24",

		);
		$resultFinal = [];
		foreach($cellsToExtract as $cell){
			$resultFinal = array_merge($resultFinal, getValueCell($loader, $cell));
		}

		$newResultFinal = [];
		foreach($resultFinal as $cell){
			$newResultFinal = array_merge($newResultFinal, array(number_format( round($cell, 2), 2,".","," )));
		}
		return $newResultFinal;
	} catch (Exception $e) {
		return false;
	}
}



function getValueCell($loaderModel, $cell, $returnMergeArray = false, $arrayState = []){
	$dataCellArrayAsocc =(array)($loaderModel->getActiveSheet()->getCell($cell));
	$dataCellArrayIndex = array_values($dataCellArrayAsocc);
	$valCell = "";

	if(
		strpos($dataCellArrayIndex[0], "xlfn") !== false ||
		strpos($dataCellArrayIndex[0], "=") !== false
	){
		$valCell = $dataCellArrayIndex[1];
	}else{
		$valCell = $dataCellArrayIndex[0];
	}
	$newStateArray = array($valCell);
	if($returnMergeArray){
		return array_merge($arrayState, $newStateArray);
	}
	return $newStateArray;
}

function getValueCellFormula($loaderModel, $cell, $label, $returnMergeArray = false, $arrayState = []){
	$dataCell =($loaderModel->getActiveSheet()->getCell($cell)->getCalculatedValue());

	$newStateArray = array($label => $dataCell);
	if($returnMergeArray){
		return array_merge($arrayState, $newStateArray);
	}
	return $newStateArray;
}

function setValueCell($loaderCostos, $cell, $value){
	try{
		$updateCell = $loaderCostos->getActiveSheet()->setCellValue($cell, $value);
	}catch(Exception $e){
		echo $e;
	}
}