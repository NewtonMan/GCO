<?php
   /**
    * Gerenciador Cl�nico Odontol�gico
    * Copyright (C) 2006 - 2009
    * Autores: Ivis Silva Andrade - Engenharia e Design(ivis@expandweb.com)
    *          Pedro Henrique Braga Moreira - Engenharia e Programa��o(ikkinet@gmail.com)
    *
    * Este arquivo � parte do programa Gerenciador Cl�nico Odontol�gico
    *
    * Gerenciador Cl�nico Odontol�gico � um software livre; voc� pode
    * redistribu�-lo e/ou modific�-lo dentro dos termos da Licen�a
    * P�blica Geral GNU como publicada pela Funda��o do Software Livre
    * (FSF); na vers�o 2 da Licen�a invariavelmente.
    *
    * Este programa � distribu�do na esperan�a que possa ser �til,
    * mas SEM NENHUMA GARANTIA; sem uma garantia impl�cita de ADEQUA��O
    * a qualquer MERCADO ou APLICA��O EM PARTICULAR. Veja a
    * Licen�a P�blica Geral GNU para maiores detalhes.
    *
    * Voc� recebeu uma c�pia da Licen�a P�blica Geral GNU,
    * que est� localizada na ra�z do programa no arquivo COPYING ou COPYING.TXT
    * junto com este programa. Se n�o, visite o endere�o para maiores informa��es:
    * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html (Ingl�s)
    * http://www.magnux.org/doc/GPL-pt_BR.txt (Portugu�s - Brasil)
    *
    * Em caso de d�vidas quanto ao software ou quanto � licen�a, visite o
    * endere�o eletr�nico ou envie-nos um e-mail:
    *
    * http://www.smileodonto.com.br/gco
    * smile@smileodonto.com.br
    *
    * Ou envie sua carta para o endere�o:
    *
    * Smile Odontol�ogia
    * Rua Laudemira Maria de Jesus, 51 - Lourdes
    * Arcos - MG - CEP 35588-000
    *
    *
    */
	include "../lib/config.inc.php";
	include "../lib/func.inc.php";
	include "../lib/classes.inc.php";
	require_once '../lang/'.$idioma.'.php';
	header("Content-type: text/html; charset=ISO-8859-1", true);
	if(!checklog()) {
		die($frase_log);
	}
	$agenda = new TAgendas();
	$agenda->LoadAgenda($_GET['data'], $_GET['hora'], $_GET['codigo_dentista']);
	if(isset($_GET['descricao'])) {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
            $agenda->SetDados('descricao', $_GET['descricao']);
        } else {
            $agenda->SetDados('descricao', utf8_decode ( htmlspecialchars( utf8_encode($_GET['descricao']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
        }
        //echo '<script>alert("'.$agenda->RetornaDados('descricao').'")</script>';
        if($_GET['codigo_paciente'] == '') {
            $_GET['codigo_paciente'] = 0;
            //echo '<script>alert("'.$agenda->RetornaDados('codigo_paciente').'")</script>';
        }
        $agenda->SetDados('codigo_paciente', $_GET['codigo_paciente']);
	} elseif(isset($_GET['procedimento'])) {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
            $agenda->SetDados('procedimento', $_GET['procedimento']);
        } else {
            $agenda->SetDados('procedimento', utf8_decode($_GET['procedimento']));
        }
	} elseif(isset($_GET['faltou'])) {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
            $agenda->SetDados('faltou', $_GET['faltou']);
        } else {
            $agenda->SetDados('faltou', utf8_decode($_GET['faltou']));
        }
        //echo '<script>alert("'.$agenda->RetornaDados('faltou').'")</script>';
	}
	$agenda->Salvar();
?>
