<?php

class Datas {
    
    private $dtini;
    private $dtfim;
    private $checaFormatDataIni;
    private $checaFormatDataFim;
    private $res;
    private $difenca;
    private $dias;
    
    public function setData($dt_ini,$dt_fim){
        $this->dtini = str_replace('-', '/',$dt_ini);
        $this->dtfim = str_replace('-','/',$dt_fim);   
        return $this->getDias();
    }
    
    public function geraDatas(){
        $data_incio = mktime(0, 0, 0, date('m') , 1 , date('Y'));
        $data_fim = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        return [date('Y-m-d',$data_incio),date('Y-m-d',$data_fim)];
     }

    /*FUNÇÕES PRIVADAS*/
    private function getDias()
            {

                $this->dtini   = explode("/", $this->validaDataEntrada());

                $this->dtini   = mktime(0, 0, 0, $this->dtini[1], $this->dtini[0], $this->dtini[2]);

                $this->dtfim   = explode('/', $this->validaDataFinal());

                $this->dtfim   = mktime(0, 0, 0, $this->dtfim[1], $this->dtfim[0], $this->dtfim[2]); 

                $this->difenca      = $this->dtfim - $this->dtini; // segundos
                //Calcula a diferença de dias
                $this->dias       = (int)floor( $this->difenca  / (60 * 60 * 24)); //dias

                return $this->dias;
            }
   
    private function validaDataEntrada(){
        $this->checaFormatDataIni = explode("/", $this->dtini);
         /*setando a data inicial*/
        if(strlen($this->checaFormatDataIni[0])==4):
            $this->dtini = date_format(date_create_from_format('Y/m/d', $this->dtini), 'd/m/Y');
        elseif(strlen($this->checaFormatDataIni[0]==2)):
            $this->dtini = date_format(date_create_from_format('d/m/Y', $this->dtini), 'd/m/Y');
        endif;
        return $this->validaData($this->dtini);
    }
    
    private function validaDataFinal(){
        $this->checaFormatDataFim = explode("/", $this->dtfim);
         /*setando a data final*/
        if(strlen($this->checaFormatDataFim[0])==4):
             $this->dtfim = date_format(date_create_from_format('Y/m/d', $this->dtfim), 'd/m/Y');
        elseif(strlen($this->checaFormatDataFim[0]==2)):
             $this->dtfim = date_format(date_create_from_format('d/m/Y', $this->dtfim), 'd/m/Y');
        endif;
        return $this->validaData($this->dtfim);
    }

    private function validaData($dt){
        $data = explode("/","$dt"); // fatia a string $data em pedados, usando / como referência
	$dia = $data[0];
	$mes = $data[1];
	$ano = $data[2];
        
	$this->res = checkdate($mes,$dia,$ano);
	if ($this->res == 1){
            return $dt;
	} else {
            return "Data Inválida";
	}
    }
}


                        
           