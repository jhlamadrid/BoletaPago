<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Copia de Recibo</title>
	<link rel="stylesheet" href="<?php base_url();?>assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/sweetalert/dist/sweetalert.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/fecha/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="<?php base_url();?>assets/css/bootstrap.min.css">
	<style type="text/css">
		body {
		  /* Ubicación de la imagen */
		  background-image: url(assets/img/fondo.jpg);
		  background-position: center center;
		  background-repeat: no-repeat;
		  background-attachment: fixed;
		  background-size: cover;
		  overflow-x: hidden;
		}
		.btn-circle {
			width: 30px;
			height: 30px;
			text-align: center;
			padding: 6px 0;
			font-size: 12px;
			line-height: 1.428571429;
			border-radius: 15px;
		}
		.btn-circle.btn-lg {
			width: 50px;
			height: 50px;
			padding: 10px 16px;
			font-size: 18px;
			line-height: 1.33;
			border-radius: 25px;
		}

		.modal-header{
			background-color: #2F71AB;
			color:#fff;
		}
		.modal-footer{
			background-color: #2F71AB;
			color:#fff;
		}

		/* The container */
		.clasRadio {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 15px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		}

		/* Hide the browser's default radio button */
		.clasRadio input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		}

		/* Create a custom radio button */
		.checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 25px;
		width: 25px;
		background-color: #eee;
		border-radius: 50%;
		}

		/* On mouse-over, add a grey background color */
		.clasRadio:hover input ~ .checkmark {
		background-color: #ccc;
		}

		/* When the radio button is checked, add a blue background */
		.clasRadio input:checked ~ .checkmark {
		background-color: #2196F3;
		}

		/* Create the indicator (the dot/circle - hidden when not checked) */
		.checkmark:after {
		content: "";
		position: absolute;
		display: none;
		}

		/* Show the indicator (dot/circle) when checked */
		.clasRadio input:checked ~ .checkmark:after {
		display: block;
		}

		/* Style the indicator (dot/circle) */
		.clasRadio .checkmark:after {
			top: 9px;
			left: 9px;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background: white;
		}

		hr.style-two {
			border: 0;
			height: 1px;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}

	</style>

</head>

<body >
<div class="row">
	<div class="center-block">
		<img src="<?php base_url();?>assets/img/logo.png" class="img-responsive center-block" alt="Cinque Terre" width="504" height="436">
		<br>
	</div>
	<div class="container">
		<div class="panel-group">
			<div class="panel panel-primary">
		      <div class="panel-heading"> <h4 style='color:#000;'> <strong> <span class="fa fa-file"> </span> BOLETA DE PAGO  <span style='color:#fff;'> (#YoMeQuedoEnCasa)</span> </strong> </h4> </div>
		      <div class="panel-body">
		      		
					<div class="row" style='margin-top:20px;'>
						<div class='col-md-9 col-sm-12'>
							<div class="row">	
								<div class="col-md-4">
									<label for="usr">CODIGO DE SUMINISTRO (<span style='color:red'>*</span>):</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-file"></i></span>
											<input type="text" class="form-control" id="SUMINISTRO" maxlength="11">
										</div>
								</div>
								<div class="col-md-4">
									<label for="usr">MES (<span style='color:red'>*</span>):</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<select class="form-control" id="periodo_Mes">
											<option value="04">Abril</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="usr">AÑO (<span style='color:red'>*</span>):</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<select class="form-control" id="periodo_Anio">
											<option value="2020">2020</option>
										</select>
									</div>
								</div>	
							</div>
							<div class='row' style='margin-top:20px;'>
								<div class="col-md-6">
									<label for="usr">Correo (<span style='color:red'>*</span>):</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
										<input type="text" class="form-control" id="correo" placeholder="Correo" >
									</div>
								
								</div>
								<div class="col-md-6">
									<label for="usr">CELULAR :</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
										<input id="telefono" type="text" class="form-control"  placeholder="Celular">
									</div>
								</div>
							</div>
							<div class="row" style='margin-top:20px;'>
								<div class="col-md-6 col-sm-6  col-xs-6">
									<label for="usr">CODIGO DE SEGURIDAD (IMAGEN) (<span style='color:red'>*</span>):</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-paste"></i></span>
										<input type="text" class="form-control" id="CAPTCHA" maxlength="6">
									</div>
								</div>
								<div class="col-md-2 col-sm-2  col-xs-2">
									<img src="<?php base_url();?>assets/img/flecha.png" style='margin-top:20px'  alt="Cinque Terre" width="100%" height="40"> 
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4 ">
									<label for="usr" style='margin-bottom:1px;'>IMAGEN </label>
									<div class="input-group" style='margin-top:0px;'>
										<label for="captcha" style="margin-top: 1px;" id="Img_captcha"><?php echo $captcha['image']; ?></label>
									</div>
								</div>
							</div>
							<div class="row" style='margin-top:20px;'>
								<div class="col-md-4">
									<label for="usr">OPCIONES:</label>
									<label class="clasRadio">Descargar 
										<input type="radio"  name="radio" value='1'>
										<span class="checkmark"></span>
									</label>
									<label class="clasRadio">Enviar a correo 
										<input type="radio" checked="checked" name="radio" value='2'>
										<span class="checkmark"></span>
									</label>
								</div>
								<div class='col-md-8'style="display:none;" id="mostrando_datos" >
									<div class='panel panel-primary'>
										<div class='panel-heading'>
											<h5 class='text-center' style="margin: 0px;"> <strong>DATOS DE CONSULTA </strong></h5>
										</div>
										<div class='panel-body'>
											<div class='row'>
												<div class='col-md-12'>
													<strong>CODIGO DE SUMINISTRO : </strong>   <span id='rpta_suministro'> </span>
												</div>
												<div class='col-md-12'>
													<strong> TITULAR &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>  		<span id='rpta_titular'> </span>
												</div>
												<div class='col-md-12'>
													<strong> NRO DE RECIBO &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  : </strong> 		<span id='rpta_numRecibo'> </span>
												</div>
												<div class='col-md-12'>
													<hr class='style-two'>
												</div>
												
												<div class='col-md-12' >
													<strong>  PERIODO DE FACTURACIÓN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong> 		<span id='rpta_periodo'> </span>
												</div>
												<div class='col-md-12'>
													<strong> CONSUMO FACTURADO &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;: </strong> 		<span id='rpta_consumo'> </span>
												</div>
												<div class='col-md-12'>
													<strong> IMPORTE TOTAL DEL RECIBO &nbsp; : </strong> 		<span id='rpta_importe_recibo'> </span>
												</div>
												<div class='col-md-12'>
													<hr class='style-two'>
												</div>
												<div class='col-md-12'>
													<strong> DEUDA TOTAL (INCLUYE MESES ANTERIORES) &nbsp;&nbsp;: </strong> 		<span id='rpta_importe_total'> </span>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<button type="button" class="btn btn-primary form-control" id="BUSCAR"><i class="fa fa-file-pdf-o"></i> GENERAR</button>
								</div>
							</div>
							<div class='row' style="margin-top:15px;">
								<div class='col-md-12'>
									<h4><strong> <i class="fa fa-info"></i> ) Estimado Cliente:</strong>  </h4>
								</div>
								<div class='col-md-12'>
									<div class="alert alert-info" role="alert">
										<p class="mb-0"> <i class="fa fa-comment-o" aria-hidden="true"></i> Sírvase ingresar un correo electrónico valido para poder enviarle el recibo. </p>
										<p> <i class="fa fa-comment-o" aria-hidden="true"></i> El recibo en formato PDF le llegará a su correo electrónico en un lapso de 5 a 10 minutos.</p>
										<p class="mb-0"> <i class="fa fa-comment-o" aria-hidden="true"></i> En caso de demora, puede buscar el correo enviado por Sedalib en su bandeja de SPAM. </p>
										<p class="mb-0"> <i class="fa fa-comment-o" aria-hidden="true"></i> Puede realizar el pago de su recibos con su código de suministro, en cualquier punto de cobranza físico o virtual asociados a SEDALIB S.A. </p>
									</div>
								</div>
							</div>
						</div>
						<div class='col-md-3 hidden-sm .hidden-xs'>
							<div class="row">
								<div class='col-md-12'>
									<img src="<?php base_url();?>assets/img/emergencia.png" class="img-thumbnail" alt="Cinque Terre" width="100%" height="180"> 
								</div>
								<div class='col-md-12' style=' margin-top:15px;'>
									<img src="<?php base_url();?>assets/img/call.png" class="img-thumbnail" alt="Cinque Terre" width="100%" height="180"> 
								</div>
								<div class='col-md-12' style=' margin-top:15px;'>
									<a href="https://www.facebook.com/SedalibOficial/" target="_blank">
										<img src="<?php base_url();?>assets/img/face.png" class="img-thumbnail" alt="Cinque Terre" width="100%" height="200">
									</a>
								</div>
								
							</div>
							
						</div>
					  	
		      		</div>
		      		
		      		
					  
					<div class='row'>
						<div class='col-md-12'>
							<h4 class='text-center'>
								<strong> Copyright © 2020 | SEDALIB S.A. </strong> 
							</h4>
						</div>
					</div>
		      </div>
		    </div>
		</div>
	</div>

</div>



<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/mascara.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.regex.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/inputmask/inputmask.numeric.extensions.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/inputmask-3.x/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/fecha/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>assets/fecha/locales/bootstrap-datepicker.es.min.js"></script>
<script src="<?php echo base_url();?>assets/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
var rango = "<?php echo $_SESSION['clave']; ?>";
var ruta = "<?php echo base_url();?>Welcome/buscar?ajax=true";
var rut2 = '<?php echo base_url();?>Welcome/genera_recibo';
</script>
<script src="<?php echo base_url();?>assets/js/main.min.js"></script>
</body>
</html>
