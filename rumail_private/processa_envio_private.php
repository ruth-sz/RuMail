<?php
ob_start(); //buffer de saída

require __DIR__ . "/../htdocs/rumail/PHPmailer/Exception.php";
require __DIR__ . "/../htdocs/rumail/PHPmailer/PHPMailer.php";
require __DIR__ . "/../htdocs/rumail/PHPmailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mensagem {
    private $para = null;
    private $assunto = null;
    private $mensagem = null;
    public $status = array('codigo_status' => null, 'descricao_status' => '');

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function mensagemValida() {
        return !(empty($this->para) || empty($this->assunto) || empty($this->mensagem));
    }
}

$mensagem = new Mensagem();
$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if (!$mensagem->mensagemValida()) {
    header('Location: index.php');
    exit;
}

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $credenciais = require "credenciais.php";
    $mail->Username = $credenciais['email']; //e-mail completo do destinatário
    $mail->Password = $credenciais['senha']; //senha de app externo (2FA da google)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom($credenciais['email_remetente'], $credenciais['nome_remetente']);
    $mail->addAddress($mensagem->__get('para'), $credenciais['nome_destinatario']);

    $mail->isHTML(true);
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = strip_tags($mensagem->__get('mensagem'));

    $mail->send();
    $mensagem->status['codigo_status'] = 1;
    $mensagem->status['descricao_status'] = 'Mensagem enviada.';
    
} catch (Exception $e) {
    $mensagem->status['codigo_status'] = 2;
    $mensagem->status['descricao_status'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
            <h2>RuMail</h2>
            <p class="lead">Envio de e-mails pessoais</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if ($mensagem->status['codigo_status'] == 1): ?>
                    <div>
                        <h1 class="display-6 text-success">Sucesso</h1>
                        <p class="lead"><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class="btn btn-dark btn-md mt-5 text-white">Voltar</a>
                    </div>
                <?php elseif ($mensagem->status['codigo_status'] == 2): ?>
                    <div>
                        <h1 class="display-6 text-danger">Ops! Algo deu errado.</h1>
                        <p class="lead"><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class="btn btn-dark btn-md mt-5 text-white">Voltar</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
