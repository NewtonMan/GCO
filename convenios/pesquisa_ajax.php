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
    $_GET['pesquisa'] = utf8_decode ( htmlspecialchars( utf8_encode($_GET['pesquisa']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
	$where = "`".$_GET['campo']."` LIKE '".$_GET['pesquisa']."%'";
	if($_GET['pg'] != '') {
		$limit = ($_GET['pg']-1)*PG_MAX;
	} else {
		$limit = 0;
		$_GET['pg'] = 1;
	}
	$sql = "SELECT * FROM `convenios` WHERE ".$where." ORDER BY codigo";
	$convenio = new TConvenio();
	$lista = $convenio->ListConvenios($sql.' LIMIT '.$limit.', '.PG_MAX);
	$total_regs = $convenio->ListConvenios($sql);
	$par = "F0F0F0";
	$impar = "F8F8F8";
	for($i = 0; $i < count($lista); $i++) {
		if($i % 2 == 0) {
			$odev = $par;
		} else {
			$odev = $impar;
		}
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="281" align="left"><?php echo $lista[$i]['nome']?></td>
      <td width="160" align="left"><?php echo (($lista[$i]['codigo'] == '1')?'':$lista[$i]['cidade_uf'])?>&nbsp;</td>
      <td width="105" align="left"><?php echo (($lista[$i]['codigo'] == '1')?'':$lista[$i]['telefone'])?>&nbsp;</td>
      <td width="79" align="center"><?php echo ((verifica_nivel('honorarios', 'L'))?'<a href="javascript:Ajax(\'honorarios/honorarios\', \'conteudo\', \'codigo_convenio='.$lista[$i][codigo].'\')"><img src="imagens/icones/honorarios.gif" alt="" width="16" height="18" border="0"></a>':'')?></td>
      <td width="59" align="center"><?php echo (($lista[$i]['codigo'] == '1' || !verifica_nivel('convenios', 'V'))?'':'<a href="javascript:Ajax(\'convenios/incluir\', \'conteudo\', \'codigo='.$lista[$i]['codigo'].'&acao=editar\')"><img src="imagens/icones/editar.gif" alt="" width="16" height="18" border="0"></a>')?>&nbsp;</td>
      <td width="66" align="center"><?php echo (($lista[$i]['codigo'] == '1' || !verifica_nivel('convenios', 'A'))?'':'<a href="javascript:Ajax(\'convenios/gerenciar\', \'conteudo\', \'codigo='.$lista[$i]['codigo'].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" alt="" width="19" height="19" border="0"></a>')?>&nbsp;</td>
    </tr>
<?php
	}
?>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="190">
      <?php echo $LANG['plan']['total_plans']?>: <b><?php echo count($total_regs)?></b>
      </td>
      <td width="420" align="center">
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
			echo '<a href="javascript:;" onclick="javascript:Ajax(\'convenios/pesquisa\', \'pesquisa\', \'pg='.$i.'&campo='.$_GET['campo'].'&pesquisa='.$_GET['pesquisa'].'\')">'.$i.'</a>&nbsp;&nbsp;';
		}
		$i++;
	}
	echo $retf;
?>
      </td>
      <td width="140" align="right"></td>
    </tr>
  </table>
