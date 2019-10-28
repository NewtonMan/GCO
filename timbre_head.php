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
	//include "../lib/config.inc.php";
	//include "../lib/func.inc.php";
	//include "../lib/classes.inc.php";
	//header("Content-type: text/html; charset=ISO-8859-1", true);
	//if(!checklog()) {
	//	die($frase_log);
	//}
	$clinica = new TClinica();
	$clinica->LoadInfo();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerenciador Cl�nico Odontol�gico Smile Odonto - <?php echo $LANG['general']['administration_in_your_hands']?></title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<link href="../css/smile.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../lib/script.js"></script>
</head>
<body style="background-color: #FFFFFF">
<table align="center" width="700" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
      <table align="center" width="700" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" colspan="2" style="border-bottom: 2px solid #000000;">
            <?php echo (($clinica->Logomarca != '')?'<img src="../configuracoes/verfoto_p.php" border="0" alt="Logomarca de '.$clinica->Fantasia.'">':'')?>
            <font size="2"><b><?php echo $clinica->Fantasia?></b></font>
          </td>
        </tr>
        <tr>
          <td width="70%">
            <font size="1">
            <?php echo $clinica->Endereco.' :: '.$clinica->Bairro.' :: '.$clinica->Cidade.' :: '.$clinica->Estado.' :: CEP '.$clinica->Cep.' :: '.$clinica->Pais?>
            </font>
          </td>
          <td width="30%" align="right">
            <font size="1">
            <?php echo $clinica->Telefone1?>
            </font>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
    <br />&nbsp;
    </td>
  </tr>
  <tr>
    <td height="760" valign="top" align="left">
