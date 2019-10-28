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
	$paciente = new TPacientes();

	$strUpCase = "ALTERA��O";
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$frmActEdt = "?acao=editar&codigo=".$_GET['codigo'];
	$paciente->LoadPaciente($_GET['codigo']);
	$row = $paciente->RetornaTodosDados();
	$row['nascimento'] = converte_data($row['nascimento'], 2);
	$row['nascimentomae'] = converte_data($row['nascimentomae'], 2);
	$row['nascimentopai'] = converte_data($row['nascimentopai'], 2);
	$row['datacadastro'] = converte_data($row['datacadastro'], 2);
	$acao = '&acao=editar';
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> &nbsp;[<?php echo $strLoCase?>] </span></td>
    </tr>
  </table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    
    <tr>
      <td height="26">&nbsp;<?php echo $LANG['patients']['others']?></td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form2" name="form2" method="POST" action="pacientes/incluir_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;"><br /><fieldset>
        <p align="left">
          <br />
          <ul>
            <li><a href="relatorios/agenda.php?codigo=<?php echo $_GET['codigo']?>" target="_blank"><?php echo $LANG['patients']['report_of_consultations_scheduled']?></a><br />&nbsp;</li>
<?php
	if(checknivel('Dentista')) {
?>
            <li><a href="relatorios/receita.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_recipe']?></a><br />&nbsp;</li>
            <li><a href="relatorios/atestado.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_certificate']?></a><br />&nbsp;</li>
            <li><a href="relatorios/exame.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_request_for_examination']?></a><br />&nbsp;</li>
            <li><a href="relatorios/encaminhamento.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_routing']?></a><br />&nbsp;</li>
            <li><a href="relatorios/laudo.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_dental_opinion']?></a><br />&nbsp;</li>
            <li><a href="relatorios/agradecimento.php?codigo=<?php echo $_GET['codigo']?>&acao=editar" target="_blank"><?php echo $LANG['patients']['print_thanks_for_routing']?></a><br />&nbsp;</li>
            <li><a href="javascript:Ajax('pacientes/laboratorio', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&acao=editar');"><?php echo $LANG['patients']['laboratory_materials']?></a><br />&nbsp;</li>
<?php
	}
?>
          </ul>
  <br />
        </p>
        </fieldset>
        <br />
        <div align="center"></div>
      </form>      </td>
    </tr>
  </table>
