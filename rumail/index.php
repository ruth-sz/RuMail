<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <title>RuMail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
		.bg-image{
			background-image: url('fundo_rumail.png'); 
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			height: 100vh; 
		}
		.container{
			color: white;
			font-family: Helvetica, Arial;
			font-size: 1em;
		}
		.form-wrapper{
			background-color: rgba(255, 255, 255, 0.5);
			color: black;
      		padding: 25px;
    		border-radius: 10px;
    		width: 100%;
    		max-width: 450px;
			margin: 0 auto;
		}
		h2{
			font-size: 2em;
		}
		.lead, .card-body{
			font-size: 1em;
		}
		.card-body input,
		.card-body textarea,
		.card-body button{
  			font-size: inherit; 
		}
		.btn-wrapper {
			display: flex;
			justify-content: center;
			margin-top: 20px;
		}
		</style>
</head>
<body class="bg-image">
	<div class="container">  

		<div class="py-3 text-center">
			<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
			<h2>RuMail</h2>
			<p class="lead">Envio de e-mails pessoais</p>
		</div>

      	<div class="row">
      		<div class="col-md-12">
  				
				<div class="card-body font-weight-bold">
					<div class="form-wrapper text-left">
						<form action="processa_envio.php" method="post"> <!-- destino do formulario -->
							<div class="form-group">
								<label for="para">Para</label>
								<input name="para" type="text" class="form-control" id="para" placeholder="fulano@dominio.com.br">
							</div>

							<div class="form-group">
								<label for= "assunto">Assunto</label>
								<input name="assunto" type="text" class="form-control" id="assunto" placeholder="Assunto do e-mail">
							</div>

							<div class="form-group">
								<label for="mensagem">Mensagem</label>
								<textarea name="mensagem" class="form-control" id="mensagem"></textarea>
							</div>

							<div class="btn-wrapper">
								<button type="submit" class="btn btn-dark btn-md">Enviar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
      	</div>
    </div>
</body>
</html>