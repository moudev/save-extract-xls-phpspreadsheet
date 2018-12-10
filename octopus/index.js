
$(document).ready(function(){
	getInitialData();
	getInitialDataResultados98();
	getInitialDataResultados17();

	jQuery.validator.addClassRules({
		dato: {
			required: true,
			min: 1
		},
		dolar:{
			number: true
		},
		cant:{
			digits: true
		}
	});

	jQuery.validator.messages.required = "Campo requerido";
	jQuery.validator.messages.min = "Ingrese cantidades mayores a cero";
	jQuery.validator.messages.number = "Ingrese cantidad de dinero";
	jQuery.validator.messages.digits = "Ingrese solo cantidades enteras";


	$("#form-template").validate({
		submitHandler: function() { 
			var data = $("#form-template").serializeArray();
			var cleanData = getCleanDataArray(data);
			var objectData = assignValuesInArray(cleanData);
			console.log(objectData);
			dataSendToPHP(objectData);
		}
	});

});

function getCleanDataArray(array){
	return array.map(item => { return item.value });
}

function assignValuesInArray(cleanArrayValues){
	console.log(cleanArrayValues);
	var objectArray = {
		"detalle_servicio_uno": cleanArrayValues[0],
		"detalle_servicio_dos": cleanArrayValues[1],
		"detalle_servicio_tres": cleanArrayValues[2],
		"total_estudiante_fia_uno": cleanArrayValues[3],
		"total_estudiante_fia_dos": cleanArrayValues[4],
		"total_estudiante_fia_tres": cleanArrayValues[5],
		"total_estudiante_ues_uno": cleanArrayValues[6],
		"total_estudiante_ues_dos": cleanArrayValues[7],
		"total_estudiante_ues_tres": cleanArrayValues[8],
		"costo_adquisicion_uno": cleanArrayValues[9],
		"costo_adquisicion_dos": cleanArrayValues[10],
		"costo_adquisicion_tres": cleanArrayValues[11],
		"servicios_generales_uno": cleanArrayValues[12],
		"servicios_generales_dos": cleanArrayValues[13],
		"servicios_generales_tres": cleanArrayValues[14],
		"consultoria_investigaciones_uno": cleanArrayValues[15],
		"consultoria_investigaciones_dos": cleanArrayValues[16],
		"consultoria_investigaciones_tres": cleanArrayValues[17],
		"activo_fijo_uno": cleanArrayValues[18],
		"activo_fijo_dos": cleanArrayValues[19],
		"activo_fijo_tres": cleanArrayValues[20],
		"remuneraciones_permanentes_uno": cleanArrayValues[21],
		"remuneraciones_permanentes_dos": cleanArrayValues[22],
		"remuneraciones_permanentes_tres": cleanArrayValues[23],
		"remuneraciones_eventuales_uno": cleanArrayValues[24],
		"remuneraciones_eventuales_dos": cleanArrayValues[25],
		"remuneraciones_eventuales_tres": cleanArrayValues[26],
		"cantidad_escuelas_fia": cleanArrayValues[27],
		"area_geografica_comunes": cleanArrayValues[28],
		"area_geografica_fia": cleanArrayValues[29],
		"personal_administrativo_fia_uno": cleanArrayValues[30],
		"personal_administrativo_fia_dos": cleanArrayValues[31],
		"personal_administrativo_fia_tres": cleanArrayValues[32],
		"personal_docente_fia_uno": cleanArrayValues[33],
		"personal_docente_fia_dos": cleanArrayValues[34],
		"personal_docente_fia_tres": cleanArrayValues[35],
		"poblacion_estudiantil_fia_uno": cleanArrayValues[36],
		"poblacion_estudiantil_fia_dos": cleanArrayValues[37],
		"poblacion_estudiantil_fia_tres": cleanArrayValues[38],
		"personal_administrativo_industrial_uno": cleanArrayValues[39],
		"personal_administrativo_industrial_dos": cleanArrayValues[40],
		"personal_administrativo_industrial_tres": cleanArrayValues[41],
		"personal_docente_industrial_uno": cleanArrayValues[42],
		"personal_docente_industrial_dos": cleanArrayValues[43],
		"personal_docente_industrial_tres": cleanArrayValues[44],
		"poblacion_estudiantil_industrial_uno": cleanArrayValues[45],
		"poblacion_estudiantil_industrial_dos": cleanArrayValues[46],
		"poblacion_estudiantil_industrial_tres": cleanArrayValues[47],
		"remuneraciones_ensenianza_par": cleanArrayValues[48],
		"remuneraciones_proyeccion_social": cleanArrayValues[49],
		"remuneraciones_trabajo_grado": cleanArrayValues[50],
		"remuneraciones_pera": cleanArrayValues[51],
		"remuneraciones_ensenianza_impar": cleanArrayValues[52],
	}
	return objectArray;
}

function dataSendToPHP(dataArray){
	var arrayAction = {
		"action": "insert",
		"data": dataArray
	}
	
	$.ajax({
		method: "POST",
		url: "update_data.php",
		data: arrayAction,
		dataType: 'json'
	})
	.done(function( res ) {
		if(res.state === 'success'){
			Swal({
				type: 'success',
				title: res.msg,
				showConfirmButton: false,
				allowOutsideClick: false,
			})
			 setTimeout(function(){ window.location.href = "resultados.php"; }, 2000);
			
		}else{
			Swal({
				type: 'error',
				title: res.msg,
				showConfirmButton: false,
				showCloseButton: true,
				allowOutsideClick: false,
			})
		}
	});
}


function getInitialData(){
	var arrayAction = {
		"action": "getInitialData",
	}
	
	$.ajax({
		method: "POST",
		url: "get_data.php",
		data: arrayAction,
		dataType: 'json'
	})
	.done(function( res ) {
		if(res.state === 'success'){
			console.log(res.datos);
			setFieldsWithDataInitial(res.datos);
		}else{
			Swal({
				type: 'error',
				title: res.msg,
				showConfirmButton: false,
				showCloseButton: true,
				allowOutsideClick: false,
			})
		}
	});
}

function setFieldsWithDataInitial(arrayInitial){
	var campos = $(".dato").map(function(index){
		$(this).val(arrayInitial[index]);
	});
}


function getInitialDataResultados98(){
	var arrayAction = {
		"action": "getInitialDataResultados98",
	}
	
	$.ajax({
		method: "POST",
		url: "get_data.php",
		data: arrayAction,
		dataType: 'json'
	})
	.done(function( res ) {
		if(res.state === 'success'){
			console.log(res.datos);
			setFieldsWithDataInitialResultados98(res.datos);
		}else{
			Swal({
				type: 'error',
				title: res.msg,
				showConfirmButton: false,
				showCloseButton: true,
				allowOutsideClick: false,
			})
		}
	});
}

function setFieldsWithDataInitialResultados98(arrayInitial){
	var campos = $(".dato_98").map(function(index){
		$(this).text(arrayInitial[index]);
	});
}


function getInitialDataResultados17(){
	var arrayAction = {
		"action": "getInitialDataResultados17",
	}
	
	$.ajax({
		method: "POST",
		url: "get_data.php",
		data: arrayAction,
		dataType: 'json'
	})
	.done(function( res ) {
		if(res.state === 'success'){
			console.log(res.datos);
			setFieldsWithDataInitialResultados17(res.datos);
		}else{
			Swal({
				type: 'error',
				title: res.msg,
				showConfirmButton: false,
				showCloseButton: true,
				allowOutsideClick: false,
			})
		}
	});
}

function setFieldsWithDataInitialResultados17(arrayInitial){
	var campos = $(".dato_17").map(function(index){
		$(this).text(arrayInitial[index]);
	});
}