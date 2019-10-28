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
	$senha = mysql_fetch_array(mysql_query("SELECT * FROM `dentistas` WHERE `codigo` = '".$_SESSION['codigo']."'"));
?>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
	$cheque = new TCheques('dentista');
	if($_GET['campo'] == 'nometitular') {
		$where = "`nometitular` LIKE '%".$_GET['pesquisa']."%'";
	} elseif($_GET['campo'] == 'recebidode') {
		$where = "`recebidode` LIKE '%".$_GET['pesquisa']."%'";
	}elseif($_GET['campo'] == 'encaminhadopara') {
		$where = "`encaminhadopara` LIKE '%".$_GET['pesquisa']."%'";
	} elseif($_GET['campo'] == 'compensacao') {
		$where = "`compensacao` = '".converte_data($_GET['pesquisa'], 1)."'";
	}
	if($_GET['pg'] != '') {
		$limit = ($_GET['pg']-1)*PG_MAX;
	} else {
		$limit = 0;
		$_GET['pg'] = 1;
	}
	$sql = "SELECT * FROM `cheques_dent` WHERE `codigo_dentista` = '" . $_SESSION['codigo'] . "' AND $where ORDER BY `" . $_GET['campo'] . "` ASC";
	$lista = $cheque->ListCheque($sql.' LIMIT '.$limit.', '.PG_MAX);
	$total_regs = $cheque->ListCheque($sql);
	$par = "F0F0F0";
	$impar = "F8F8F8";
	for($i = 0; $i < count($lista); $i++) {
		if($i % 2 == 0) {
			$odev = $par;
		} else {
			$odev = $impar;
		}
		$cheque->LoadCheque($lista[$i]['codigo']);
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="123" height="23" align="left""><?php echo $cheque->RetornaDados('nometitular')?></td>
      <td width="123" height="23" align="left"><?php echo $cheque->RetornaDados('recebidode')?></td>
      <td width="123" height="23" align="left"><?php echo $cheque->RetornaDados('encaminhadopara')?></td>
      <td width="123" height="23" align="left"><?php echo converte_data($cheque->RetornaDados('compensacao'), 2)?></td>
      <td width="80" height="23" align="right"><?php echo $LANG['general']['currency'].' '.money_form($cheque->RetornaDados('valor'))?></td>
      <td width="66" align="center"><?php echo ((verifica_nivel('cheques', 'V'))?'<a href="javascript:;" onclick="javascript:Ajax(\'cheques_dent/incluir\', \'conteudo\', \'codigo='.$cheque->RetornaDados('codigo').'&acao=editar\')"><img src="imagens/icones/editar.gif" alt="Editar" width="16" height="18" border="0"></a>':'')?></td>
      <td width="66" align="center"><?php echo ((verifica_nivel('cheques', 'E'))?'<a href="javascript:Ajax(\'cheques_dent/gerenciar\', \'conteudo\', \'codigo='.$cheque->RetornaDados('codigo').'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" alt="Excluir" width="19" height="19" border="0"></a>':'')?></td>
    </tr>
<?php
	}
?>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="100%" align="center">
<?php
	$pg_total = ceil(count($total_regs)/PG_MAX);
	$i = $_GET['pg'] - 5;
	if($i <= 1) {
		$i = 1;
		$reti = '';
	} else {
		$reti = '...&nbsp;&nbsp;';
	}
	$j = $_GET['pg'] + 5;
	if($j >= $pg_total) {
		$j = $pg_total;
		$retf = '';
	} else {
		$retf = '...';
	}
	echo $reti;
	while($i <= $j) {
		if($i == $_GET['pg']) {
			echo $i.'&nbsp;&nbsp;';
		} else {
			echo '<a href="javascript:;" onclick="javascript:Ajax(\'cheques_dent/pesquisa\', \'pesquisa\', \'pesquisa=\'%2BgetElementById(\'procurar\').value%2B\'&campo=\'%2BgetElementById(\'campo\').options[getElementById(\'campo\').selectedIndex].value%2B\'&pg='.$i.'\')">'.$i.'</a>&nbsp;&nbsp;';
		}
		$i++;
	}
	echo $retf;
?>
      </td>
    </tr>
  </table>
