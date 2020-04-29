
	var oTable_documento_persona;
	var oTable_adjuntos;
	$(document).ready(function() {
		
		$('#SUMINISTRO').inputmask('Regex', {
            regex:'[0-9]{'+11+'}'
        });
		$('#telefono').inputmask('Regex', {
            regex:'[0-9]{'+9+'}'
        });


	    $("#BUSCAR").on("click", function(){
            imprimir();
        });
	   

	} );

	function isEmpty(strIn)
	{
		if (strIn === undefined)
		{
			return true;
		}
		else if(strIn == null)
		{
			return true;
		}
		else if(strIn == "")
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function Alerta(titulo, mensaje, tipo) {

		if (tipo == '1')
		{
			swal({
				title: titulo,
				text: mensaje,
				type: "success",
				confirmButtonClass: "btn-success",
				confirmButtonText: "Ok",
				closeOnConfirm: false,
				html: true
			});
		}
		if (tipo == '2')
		{
			swal({
				title: titulo,
				text: mensaje,
				type: "error",
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ok",
				closeOnConfirm: false,
				html: true
			});
		}

		if (tipo == '3')
		{
			swal({
				title: titulo,
				text: mensaje,
				type: "info",
				confirmButtonClass: "btn-info",
				confirmButtonText: "Ok",
				closeOnConfirm: false,
				html: true
			});
		}

		if (tipo == '4')
		{

			swal({
				title: titulo,
				text: mensaje,
				type: "warning",
				confirmButtonClass: "btn-warning",
				confirmButtonText: "Ok",
				closeOnConfirm: false,
				html: true
			});


		}
	}
	


	function imprimir(){
		var suministro = ($("#SUMINISTRO").val()).trim();
		var mes = ($("#periodo_Mes").val()).trim();
		var anio = ($('#periodo_Anio').val()).trim();
		var telefono = ($('#telefono').val()).trim();
		var correo = ($('#correo').val()).trim();
		var captcha = ($('#CAPTCHA').val()).trim();
		var tipo = 	$('input:radio[name=radio]:checked').val();
		// ocultando y limpiando la data 
		$('#mostrando_datos').css('display', 'none');
		$("#rpta_importe_total").text('');
		$("#rpta_importe_recibo").text('');
		$("#rpta_consumo").text('');
		$("#rpta_periodo").text('');
		$("#rpta_suministro").text('');
		$("#rpta_numRecibo").text('');
		$("#rpta_titular").text('');
		if (suministro=="" || mes=="" ||  anio=="" || captcha =="" ||  correo =="") {
			Alerta("ADVERTENCIA", "Existen campos obligatorios por llenar" , "4");
			(suministro == '') ? $('#SUMINISTRO').css('border-color','red') : $('#SUMINISTRO').css('border-color','') ;
			(mes == '') ? $('#periodo_Mes').css('border-color','red') : $('#periodo_Mes').css('border-color','') ;
			(anio == '') ? $('#periodo_Anio').css('border-color','red') : $('#periodo_Anio').css('border-color','') ;
			(correo == '') ? $('#correo').css('border-color','red') : $('#correo').css('border-color','') ;
			(captcha == '') ? $('#CAPTCHA').css('border-color','red') : $('#CAPTCHA').css('border-color','') ;
		}else{
			$('#SUMINISTRO').css('border-color','');
            $('#periodo_Mes').css('border-color','');
            $('#periodo_Anio').css('border-color','');
			$('#correo').css('border-color','');
            $('#CAPTCHA').css('border-color','');
			if( suministro.length == 11 || suministro.length == 7 ){
				$('#SUMINISTRO').css('border-color','');
				if(correo == '' && telefono == ''){
					$('#correo').css('border-color','red');
					$('#telefono').css('border-color','red');
					Alerta("ADVERTENCIA", "Debe de Ingresar correo electronico o celular " , "4");
				}else{
					$('#correo').css('border-color','');
					$('#telefono').css('border-color','');
					if(telefono.length != 9 && telefono !='' ){
						Alerta("ADVERTENCIA", "Numero de telefono incorrecto" , "4");
					}else{
						if(correo != '' && correo.match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null){
							Alerta("ADVERTENCIA", "Correo electronico invalido" , "4");
							$('#correo').css('border-color','red');
						}else{
							$('#correo').css('border-color','');
							if(captcha == rango){
								$('#CAPTCHA').css('border-color','');
								swal({
									type: "info",
				              		title: "Buscando recibo.....",
				              		text: "",
				              		showConfirmButton: false
				            	});
								$.ajax({
						            type: "POST",
						            url: ruta,
						            data: {sumini     : suministro,
						            	   periodo    : anio+mes,
						            	   corr       : correo,
										   telf       : telefono,
										   tip		  : tipo
						            	},
						            dataType: 'json',
						            success: function(data) {
						                if(data.result) {
						                    $("#Img_captcha").empty();
											rango = data.numero;
											$("#Img_captcha").append(data.captcha.image);
											// pinto la data 
											$('#mostrando_datos').css('display', 'block');
											$("#rpta_importe_total").text(' S/ '+data.total+ ' SOLES');
											$("#rpta_importe_recibo").text(' S/ '+data.total_recibo+ ' SOLES');
											$("#rpta_consumo").text(data.consumo);
											$("#rpta_titular").text(data.busqueda[0].CLINOMBRE+"*****");
											$("#rpta_periodo").text(data.busqueda[0].DESMES+' - '+anio);
											$("#rpta_suministro").text(data.busqueda[0].CLICODFAX);
											$("#rpta_numRecibo").text('S'+data.busqueda[0].FACSERNRO+'-'+data.busqueda[0].FACNRO);
											
											if(data.tipo=='2'){
												Alerta("EXITO !!!", " Su recibo se envio correctamente a su correo electronico" , "1");
											}else{
												swal({
													type: "info",
													title: "Descargando recibo.....",
													text: "",
													showConfirmButton: false
												});	
												genero_pdf(suministro, (anio+mes), data.cadena );
											}
											
						                }else{
												$("#Img_captcha").empty();
						                    	rango = data.numero;
						                    	$("#Img_captcha").append(data.captcha.image);
											   //swal.close();
											   Alerta("ADVERTENCIA", data.mensaje , "4");
						                    
							                }
							            }
							    });
							}else{
								Alerta("ADVERTENCIA", "Codigo de seguridad  incorrecto" , "4");
								$('#CAPTCHA').css('border-color','red');
							}
						}
					}
				}

			}else{
				Alerta("ADVERTENCIA", "El codigo de suministro ingresado es incorrecto " , "4");
				$('#SUMINISTRO').css('border-color','red');
				

			}


			
		}
	}

	function genero_pdf(suministro, periodo, cadena){
		
		var json = JSON.stringify(new Array(suministro, periodo, cadena));

        //event.preventDefault();
        var form = jQuery('<form>', {
                    'action': rut2,
                    //'target': '_blank',
                    'method': 'post',
                    'type': 'hidden'
            }).append(jQuery('<input>', {
                    'name': 'descarga_recibo',
                    'value': json,
                    'type': 'hidden'
			}));
		console.log(form);
		$('body').append(form);
		form.submit();
		swal.close();
		
	}