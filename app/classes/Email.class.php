<?php
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';

class Email {

    private $Mail;
    private $enviado;
    private $assunto;
    private $destinatario;
    private $mensagem;
    private $error;
    
    function __construct() {
        $this->Mail = new PHPMailer\PHPMailer\PHPMailer;
        $this->Mail->IsSMTP();
        $this->Mail->Port = '465';
        $this->Mail->Host = 'br24.hostgator.com.br'; 
        $this->Mail->IsHTML(true);
        $this->Mail->Mailer = 'smtp';
        $this->Mail->SMTPSecure = 'ssl';
        $this->Mail->SMTPAuth = true;
        $this->Mail->Username = 'lpcosta@lpcosta.com.br';
        $this->Mail->Password = 'klmnopq';
        $this->Mail->From = "Syslab@lpcosta.com.br";
        $this->Mail->FromName = "Syslab";
        $this->Mail->CharSet = 'UTF-8';
    }
    
    public function enviaMail($assunto,$destinatario,$mensagem){
        $this->assunto = (string) $assunto;
        $this->destinatario = (string) $destinatario;
        $this->mensagem = (string) $mensagem;
        
        $this->sendMail();
        
    }

    public function getError() {
        return $this->error;        
    }



    private function sendMail() {
        $this->Mail->Subject = $this->assunto;
        $this->Mail->AddBCC("lpcosta@santoandre.sp.gov.br"); // Envia Cópia Oculta
        $this->Mail->addAddress($this->destinatario); // email do destinatario.
        
	$this->MailBody = $this->mensagem;
        
	$this->enviado = $this->Mail->Send();
        
	// Limpa os destinatários e os anexos
	$this->Mail->ClearAllRecipients();
	$this->Mail->ClearAttachments();
	// Exibe uma mensagem de resultado se ocorrer erro
	if ($this->enviado)
        {
            $this->error = false;
            return $this->error;
            
        }
        else{
            $this->error = "Não foi possível enviar o e-mail<br /> Informações do erro: <strong>".$this->Mail->ErrorInfo."</strong>";
            return $this->error;
	}
    }
}
