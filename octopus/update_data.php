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
	try {

		$dataCleanRequest = getValuesOfRequest($_POST["data"]);

		$responseUpdateModel = setValuesOfModelTemplate($hojaModel, $filenameModel, $dataCleanRequest);

		$valuesOfModelTemplate = getValuesOfModelTemplate($hojaModel);

		$responseUpdateCostos = setValuesOfCostos($hojaCostos, $filenameCostos, $valuesOfModelTemplate);

		$valuesOfCostosAndModelTemplate = getValuesOfCostosAndModelTemplate($hojaCostos, $hojaModel);

		$responseUpdateModelOne = setValuesOfModelOne($hojaModelOne, $filenameModelOne, $valuesOfCostosAndModelTemplate);

		$valuesOfModelOneAndModelTemplate = getValuesOfModelOneAndModelTemplate($hojaModelOne, $hojaModel);

		$responseUpdateModelTwo = setValuesOfModelTwo($hojaModelTwo, $filenameModelTwo, $valuesOfModelOneAndModelTemplate);

		$responseUpdateModelTree = setValuesOfModelTree($hojaModelTree, $filenameModelTree, $valuesOfModelOneAndModelTemplate);

		if
		(
			$responseUpdateModel 
			&& $responseUpdateCostos
			&& $responseUpdateModelOne
			&& $responseUpdateModelTwo
			&& $responseUpdateModelTree
		){
			$response = array(
				"state" => "success",
				"msg" => "Éxito. Cálculos Realizados",
			);
			echo json_encode($response);
		}else{
			$response = array(
				"state" => "error",
				"msg" => "Error. Algo inesperado ocurrió.",
			);
			echo json_encode($response);
		}

	} catch (Exception $e) {
		$response = array(
			"state" => "error",
			"msg" => "Error. ".$e,
		);
		echo json_encode($response);
	}
}else{
	$response = array(
		"state" => "error",
		"msg" => "Error. No hay acción especificada.",
	);
	echo json_encode($response);
}


// get data from request and set cell to save in new_model file
function getValuesOfRequest($arrayOfRequest){//done
	$arrayWithCellToUpdateInModel = array(
		"C5" => $arrayOfRequest["detalle_servicio_uno"],
		"C6" => $arrayOfRequest["detalle_servicio_dos"],
		"C7" => $arrayOfRequest["detalle_servicio_tres"],
		"C12" => $arrayOfRequest["total_estudiante_fia_uno"],
		"C13" => $arrayOfRequest["total_estudiante_fia_dos"],
		"C14" => $arrayOfRequest["total_estudiante_fia_tres"],
		"C18" => $arrayOfRequest["total_estudiante_ues_uno"],
		"C19" => $arrayOfRequest["total_estudiante_ues_dos"],
		"C20" => $arrayOfRequest["total_estudiante_ues_tres"],
		"C27" => $arrayOfRequest["costo_adquisicion_uno"],
		"C28" => $arrayOfRequest["costo_adquisicion_dos"],
		"C29" => $arrayOfRequest["costo_adquisicion_tres"],
		"C33" => $arrayOfRequest["servicios_generales_uno"],
		"C34" => $arrayOfRequest["servicios_generales_dos"],
		"C35" => $arrayOfRequest["servicios_generales_tres"],
		"C44" => $arrayOfRequest["consultoria_investigaciones_uno"],
		"C45" => $arrayOfRequest["consultoria_investigaciones_dos"],
		"C46" => $arrayOfRequest["consultoria_investigaciones_tres"],
		"C50" => $arrayOfRequest["activo_fijo_uno"],
		"C51" => $arrayOfRequest["activo_fijo_dos"],
		"C52" => $arrayOfRequest["activo_fijo_tres"],
		"C56" => $arrayOfRequest["remuneraciones_permanentes_uno"],
		"C57" => $arrayOfRequest["remuneraciones_permanentes_dos"],
		"C58" => $arrayOfRequest["remuneraciones_permanentes_tres"],
		"C62" => $arrayOfRequest["remuneraciones_eventuales_uno"],
		"C63" => $arrayOfRequest["remuneraciones_eventuales_dos"],
		"C64" => $arrayOfRequest["remuneraciones_eventuales_tres"],
		"D71" => $arrayOfRequest["cantidad_escuelas_fia"],
		"C77" => $arrayOfRequest["area_geografica_comunes"],
		"C78" => $arrayOfRequest["area_geografica_fia"],
		"C85" => $arrayOfRequest["personal_administrativo_fia_uno"],
		"C86" => $arrayOfRequest["personal_administrativo_fia_dos"],
		"C87" => $arrayOfRequest["personal_administrativo_fia_tres"],
		"C91" => $arrayOfRequest["personal_docente_fia_uno"],
		"C92" => $arrayOfRequest["personal_docente_fia_dos"],
		"C93" => $arrayOfRequest["personal_docente_fia_tres"],
		"C97" => $arrayOfRequest["poblacion_estudiantil_fia_uno"],
		"C98" => $arrayOfRequest["poblacion_estudiantil_fia_dos"],
		"C99" => $arrayOfRequest["poblacion_estudiantil_fia_tres"],
		"C109" => $arrayOfRequest["personal_administrativo_industrial_uno"],
		"C110" => $arrayOfRequest["personal_administrativo_industrial_dos"],
		"C111" => $arrayOfRequest["personal_administrativo_industrial_tres"],
		"C115" => $arrayOfRequest["personal_docente_industrial_uno"],
		"C116" => $arrayOfRequest["personal_docente_industrial_dos"],
		"C117" => $arrayOfRequest["personal_docente_industrial_tres"],
		"C121" => $arrayOfRequest["poblacion_estudiantil_industrial_uno"],
		"C122" => $arrayOfRequest["poblacion_estudiantil_industrial_dos"],
		"C123" => $arrayOfRequest["poblacion_estudiantil_industrial_tres"],
		"C130" => $arrayOfRequest["personal_docente_fia_uno"],
		"C131" => $arrayOfRequest["personal_docente_fia_dos"],
		"C132" => $arrayOfRequest["personal_docente_fia_tres"],
		"C136" => $arrayOfRequest["personal_docente_industrial_uno"],
		"C137" => $arrayOfRequest["personal_docente_industrial_dos"],
		"C138" => $arrayOfRequest["personal_docente_industrial_tres"],
		"C144" => $arrayOfRequest["area_geografica_comunes"],
		"C145" => $arrayOfRequest["area_geografica_fia"],
		"A189" => $arrayOfRequest["remuneraciones_ensenianza_par"],
		"A192" => $arrayOfRequest["remuneraciones_proyeccion_social"],
		"A195" => $arrayOfRequest["remuneraciones_trabajo_grado"],
		"A198" => $arrayOfRequest["remuneraciones_pera"],
		"A201" => $arrayOfRequest["remuneraciones_ensenianza_impar"],
	);

	return $arrayWithCellToUpdateInModel;
}

function setValuesOfModelTemplate($loader, $filename, $arrayOfValues){//done
	try {
		foreach($arrayOfValues as $cell => $valor){
			setValueCell($loader, $cell, $valor);
		}

		$write = new \PhpOffice\PhpSpreadsheet\Writer\Xls($loader);
		$write->save($filename);
		
		return true;
	} catch (Exception $e) {
		echo $e;
		return false;
	}
}

function getValuesOfModelTemplate($loader){//done
	try {
		$cellsToExtract = array(
			"costo_ues" => "F5",
			"costo_ues_factor_prorateo" => "F15",
			"CF_costo_adquisicion" => "F27",
			"CF_servicios_generales" => "F33",
			"CF_servicios_basicos" => "F39",
			"CF_consultorias" => "F44",
			"CF_activo_fijo" => "F50",
			"CF_remuneraciones" => "F58",
			"FP_costo_adquisicion" => "F71",
			"FP_servicios_generales" => "F77",
			"FP_servicios_basicos" => "F101",
			"FP_consultorias" => "F133",
			"FP_activo_fijo" => "F144",
			"CE_costo_adquisicion" => "F153",
			"CE_servicios_generales" => "F160",
			"CE_servicios_basicos" => "F167",
			"CE_consultorias" => "F174",
			"CE_activo_fijo" => "F181",
		);
		$resultFinal = [];
		foreach($cellsToExtract as $label => $cell){
			$resultFinal = array_merge($resultFinal, getValueCell($loader, $cell, $label));
		}
		return $resultFinal;
	} catch (Exception $e) {
		return false;
	}
}

function setValuesOfCostos($loader, $filename, $arrayOfValues){//done
	try {
		$arrayToUpdate = array(
			"B9" => $arrayOfValues["costo_ues"],
			"C9" => $arrayOfValues["costo_ues_factor_prorateo"],
			"E7" => $arrayOfValues["CF_costo_adquisicion"],
			"E8" => $arrayOfValues["CF_servicios_generales"],
			"E9" => $arrayOfValues["CF_servicios_basicos"],
			"E10" => $arrayOfValues["CF_consultorias"],
			"E11" => $arrayOfValues["CF_activo_fijo"],
			"E12" => $arrayOfValues["CF_remuneraciones"],
			"G7" => $arrayOfValues["FP_costo_adquisicion"],
			"G8" => $arrayOfValues["FP_servicios_generales"],
			"G9" => $arrayOfValues["FP_servicios_basicos"],
			"G10" => $arrayOfValues["FP_consultorias"],
			"G11" => $arrayOfValues["FP_activo_fijo"],
			"I7" => $arrayOfValues["CE_costo_adquisicion"],
			"I8" => $arrayOfValues["CE_servicios_generales"],
			"I9" => $arrayOfValues["CE_servicios_basicos"],
			"I10" => $arrayOfValues["CE_consultorias"],
			"I11" => $arrayOfValues["CE_activo_fijo"],
		);
		foreach($arrayToUpdate as $cell => $valor){
			setValueCell($loader, $cell, $valor);
		}

		$write = new \PhpOffice\PhpSpreadsheet\Writer\Xls($loader);
		$write->save($filename);
		
		return true;
	} catch (Exception $e) {
		echo $e;
		return false;
	}
}

function getValuesOfCostosAndModelTemplate($loaderCostos, $loaderModel){//done
	try {
		// Sacando datos para la hoja de MODEL -1
		$arrayExtractFromCostosToModelOne = array(
			"Costos_CE_servicios_basicos" => "I9",
			"Costos_CE_servicios_generales" => "I8",
			"Costos_CE_activo_fijo" => "I11",
			"Costos_CE_costo_adquisicion" => "I7",
			"Costos_CE_consultorias" => "I10"
		);

		// Extraer la cantidad de pesonal involucrado de la hoja de template
		$arrayExtractFromTemplateToModelOne = array(
			"Template_CantidadPersonalTotalIIE" => "E117",
			"Template_DineroPersonalDocente" => "H117",
			"Template_DineroPersonalAdministrativo" => "L120",
			"Template_remuneraciones_proceso_ensenianza" => "A189",
			"Template_remuneraciones_proyeccion_social" => "A192",
			"Template_remuneraciones_trabajo_grado" => "A195",
			"Template_remuneraciones_pera" => "A198",
		);

		$arrayMergedTemplateCostos = [];
		// Recorriendo los arrays para extraer Datos del Template
		foreach($arrayExtractFromTemplateToModelOne as $label => $cell){
			$arrayMergedTemplateCostos = array_merge($arrayMergedTemplateCostos, getValueCell($loaderModel, $cell, $label));
		}

		// Array para extraer datos del Costos Indirectos
		// Hacer load del archivo de costos indirectos
		foreach($arrayExtractFromCostosToModelOne as $label => $cell){
			$arrayMergedTemplateCostos = array_merge($arrayMergedTemplateCostos, getValueCell($loaderCostos, $cell, $label));
		}

		return $arrayMergedTemplateCostos;
	} catch (Exception $e) {
		return false;
	}
}

function setValuesOfModelOne($loader, $filename, $arrayMergedTemplateCostos){//done
	try {

		$arrayToUpdateInModelOne = array(
			"A7" => $arrayMergedTemplateCostos["Template_CantidadPersonalTotalIIE"],
			"A10" => $arrayMergedTemplateCostos["Template_DineroPersonalAdministrativo"],
			"A12" => $arrayMergedTemplateCostos["Costos_CE_servicios_basicos"],
			"A14" => $arrayMergedTemplateCostos["Costos_CE_servicios_generales"],
			"A16" => $arrayMergedTemplateCostos["Costos_CE_activo_fijo"],
			"A28" => $arrayMergedTemplateCostos["Costos_CE_costo_adquisicion"],
			"A30" => $arrayMergedTemplateCostos["Costos_CE_consultorias"],
			"A19" => $arrayMergedTemplateCostos["Template_remuneraciones_proceso_ensenianza"],
			"A21" => $arrayMergedTemplateCostos["Template_remuneraciones_proyeccion_social"],
			"A23" => $arrayMergedTemplateCostos["Template_remuneraciones_trabajo_grado"],
			"A25" => $arrayMergedTemplateCostos["Template_remuneraciones_pera"],
		);
		foreach($arrayToUpdateInModelOne as $cell => $valor){
			setValueCell($loader, $cell, $valor);
		}

		$write = new \PhpOffice\PhpSpreadsheet\Writer\Xls($loader);
		$write->save($filename);
		
		return true;
	} catch (Exception $e) {
		echo $e;
		return false;
	}
}


function getValuesOfModelOneAndModelTemplate($loaderModelOne, $loaderModel){
	try {
		$arrayExtractFromModelOneToModelTwo = array(
			"ModelOne_total_planificacion" => "P7",
			"ModelOne_total_provision" => "P8",
			"ModelOne_total_talento_humano" => "P9",
			"ModelOne_total_comunicacion" => "P10",
			"ModelOne_total_apoyo" => "P11",
			"ModelOne_total_proceso_ensenianza" => "P12",
			"ModelOne_total_proyeccion_social" => "P13",
			"ModelOne_total_trabajo_graduacion" => "P14",
			"ModelOne_total_pera" => "P15",
		);

		$arrayExtractFromTemplateToModelTwo = array(
			"Template_CantidadPromedioIIE" => "D121",
			"Template_remuneraciones_proceso_ensenianza" => "A189",
			"Template_remuneraciones_proceso_ensenianza_dos" => "A201",
			"Template_remuneraciones_proyeccion_social" => "A192",
			"Template_remuneraciones_trabajo_grado" => "A195",
			"Template_remuneraciones_pera" => "A198",
		);


		$arrayMergedTemplateModelOne = [];
// Recorriendo los arrays para extraer Datos del Template
		foreach($arrayExtractFromTemplateToModelTwo as $label => $cell){
			$arrayMergedTemplateModelOne = array_merge($arrayMergedTemplateModelOne, getValueCell($loaderModel, $cell, $label));
		}

// Array para extraer datos del Costos Indirectos
// Hacer load del archivo de costos indirectos
		foreach($arrayExtractFromModelOneToModelTwo as $label => $cell){

			$arrayMergedTemplateModelOne = array_merge($arrayMergedTemplateModelOne, getValueCellFormula($loaderModelOne, $cell, $label));

		}

		return $arrayMergedTemplateModelOne;
	} catch (Exception $e) {
		return false;
	}
}


function setValuesOfModelTwo($loader, $filename, $arrayMergedTemplateModelOne){
	try {

		$arrayToUpdateInModelTwo = array(
			"A11" => $arrayMergedTemplateModelOne["Template_CantidadPromedioIIE"],
			"B11" => $arrayMergedTemplateModelOne["ModelOne_total_planificacion"],
			"B12" => $arrayMergedTemplateModelOne["ModelOne_total_provision"],
			"B13" => $arrayMergedTemplateModelOne["ModelOne_total_talento_humano"],
			"B14" => $arrayMergedTemplateModelOne["ModelOne_total_comunicacion"],
			"B15" => $arrayMergedTemplateModelOne["ModelOne_total_apoyo"],
			"B16" => $arrayMergedTemplateModelOne["ModelOne_total_proceso_ensenianza"],
			"B17" => $arrayMergedTemplateModelOne["ModelOne_total_proyeccion_social"],
			"B18" => $arrayMergedTemplateModelOne["ModelOne_total_trabajo_graduacion"],
			"B19" => $arrayMergedTemplateModelOne["ModelOne_total_pera"],
			"F16" => $arrayMergedTemplateModelOne["Template_remuneraciones_proceso_ensenianza"],
			"F17" => $arrayMergedTemplateModelOne["Template_remuneraciones_proyeccion_social"],
			"F18" => $arrayMergedTemplateModelOne["Template_remuneraciones_trabajo_grado"],
			"F19" => $arrayMergedTemplateModelOne["Template_remuneraciones_pera"],
		);
		foreach($arrayToUpdateInModelTwo as $cell => $valor){
			setValueCell($loader, $cell, $valor);
		}

		$write = new \PhpOffice\PhpSpreadsheet\Writer\Xls($loader);
		$write->save($filename);
		
		return true;
	} catch (Exception $e) {
		echo $e;
		return false;
	}
}

function setValuesOfModelTree($loader, $filename, $arrayMergedTemplateModelOne){
	try {

		$arrayToUpdateInModelTree = array(
			"A11" => $arrayMergedTemplateModelOne["Template_CantidadPromedioIIE"],
			"B11" => $arrayMergedTemplateModelOne["ModelOne_total_planificacion"],
			"B12" => $arrayMergedTemplateModelOne["ModelOne_total_provision"],
			"B13" => $arrayMergedTemplateModelOne["ModelOne_total_talento_humano"],
			"B14" => $arrayMergedTemplateModelOne["ModelOne_total_comunicacion"],
			"B15" => $arrayMergedTemplateModelOne["ModelOne_total_apoyo"],
			"B16" => $arrayMergedTemplateModelOne["ModelOne_total_proceso_ensenianza"],
			"B17" => $arrayMergedTemplateModelOne["ModelOne_total_proyeccion_social"],
			"B18" => $arrayMergedTemplateModelOne["ModelOne_total_trabajo_graduacion"],
			"B19" => $arrayMergedTemplateModelOne["ModelOne_total_pera"],
			"F16" => $arrayMergedTemplateModelOne["Template_remuneraciones_proceso_ensenianza_dos"],
		);
		foreach($arrayToUpdateInModelTree as $cell => $valor){
			setValueCell($loader, $cell, $valor);
		}

		$write = new \PhpOffice\PhpSpreadsheet\Writer\Xls($loader);
		$write->save($filename);
		
		return true;
	} catch (Exception $e) {
		echo $e;
		return false;
	}
}



function getValueCell($loaderModel, $cell, $label, $returnMergeArray = false, $arrayState = []){
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
	$newStateArray = array($label => $valCell);
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