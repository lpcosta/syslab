<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crypto
 *
 * @author lpcosta
 */
class Senha {
    public function setSenha($senha)
    {return hash('whirlpool',hash('sha512',hash('sha384',hash('sha256',sha1(md5('mjll'.$senha))))));}
}

