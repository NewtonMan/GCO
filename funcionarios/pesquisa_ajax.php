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
?>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
    $_GET['pesquisa'] = htmlspecialchars($_GET['pesquisa'], ENT_QUOTES);
	$pacientes = new TFuncionarios();
	if($_GET['campo'] == 'nascimento') {
		$where = "MONTH(`nascimento`) = '".$_GET['pesquisa']."' AND ";
	} elseif($_GET['campo'] == 'nome') {
		$where = "`nome` LIKE '%".$_GET['pesquisa']."%' AND";
	}elseif($_GET['campo'] == 'CPF') {
		$where = "`cpf` = '".$_GET['pesquisa']."' AND";
	}
	if($_GET['pg'] != '') {
		$limit = ($_GET['pg']-1)*PG_MAX;
	} else {
		$limit = 0;
		$_GET['pg'] = 1;
	}
	$href = 'href=';
	$onclick = 'onclick=';
	if(checknivel('Dentista') || checknivel('Funcionario')) {
		$href = '';
		$onclick = '';
	}
	$sql = "SELECT * FROM `funcionarios` WHERE ".$where." usuario != 'admin' ORDER BY `nome` ASC";
	$lista = $pacientes->ListFuncionarios($sql.' LIMIT '.$limit.', '.PG_MAX);
	$total_regs = $pacientes->ListFuncionarios($sql);
	$par = $odev = "F0F0F0";
	$impar = "F8F8F8";
	for($i = 0; $i < count($lista); $i++) {
		if($i % 2 == 0) {
			$odev = $par;
		} else {
			$odev = $impar;
		}
		if($lista[$i][ativo] == 'N�o') {
			$ativo = '#C0C0C0';
		} else {
			$ativo = '#000000';
		}
		$pacientes->LoadFuncionario($lista[$i][codigo]);
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="325"><font color="<?php echo $ativo?>"><?php echo $lista[$i][titulo].' '.$lista[$i][nome]?></td>
      <td width="150" align="left"><font color="<?php echo $ativo?>"><?php echo $pacientes->RetornaDados('telefone1')?></td>
      <td width="150"><font color="<?php echo $ativo?>"><?php echo $lista[$i][funcao1]?></td>
      <td width="59" align="center"><?php echo ((verifica_nivel('funcionarios', 'V'))?'<a href="javascript:Ajax(\'funcionarios/incluir\', \'conteudo\', \'codigo='.$lista[$i][codigo].'&acao=editar\')"><img src="imagens/icones/editar.gif" alt="Editar" width="16" height="18" border="0"></a>':'')?></td>
      <td width="66" align="center"><?php echo ((verifica_nivel('funcionarios', 'A'))?'<a href="javascript:Ajax(\'funcionarios/gerenciar\', \'conteudo\', \'codigo='.$lista[$i][codigo].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" alt="Excluir" width="19" height="19" border="0"></a>':'')?></td>
    </tr>
<?php
	}
?>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="160">
      <?php echo $LANG['employee']['total_employees']?>: <b><?php echo count($total_regs)?></b>
      </td>
      <td width="450" align="center">
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
			echo '<a href="javascript:;" onclick="javascript:Ajax(\'funcionarios/pesquisa\', \'pesquisa\', \'pg='.$i.'&campo='.$_GET['campo'].'&pesquisa='.$_GET['pesquisa'].'\')">'.$i.'</a>&nbsp;&nbsp;';
		}
		$i++;
	}
	echo $retf;
?>
      </td>
      <td width="140" align="right"><img src="imagens/icones/etiquetas.gif" border=""> <a href="etiquetas/print_etiqueta.php?sql=<?php echo ajaxurlencode($sql)?>" target="_blank"><?php echo $LANG['employee']['print_labels']?></a></td>
    </tr>
  </table>
