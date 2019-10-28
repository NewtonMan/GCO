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
	$caixa = new TCaixa();
	$data = converte_data($_GET['pesquisa'], 1);
	switch ($_GET['peri']) {
		case 'dia': {
			$sql = "SELECT * FROM `caixa` WHERE `data` = '$data' ORDER BY `data` ASC, `codigo` ASC";
		} break;
		case 'mes': {
			$sql = "SELECT * FROM `caixa` WHERE LEFT(`data`, 7) = '$data' ORDER BY `data` ASC, `codigo` ASC";
		} break;
		case 'ano': {
			$sql = "SELECT * FROM `caixa` WHERE LEFT(`data`, 4) = '$data' ORDER BY `data` ASC, `codigo` ASC";
		} break;
		case 'mesatual': {
			$sql = "SELECT * FROM `caixa` WHERE LEFT(`data`, 7) = '".date('Y-m')."' ORDER BY `data` ASC, `codigo` ASC";
		} break;
	}
	$lista = $caixa->ListCaixa($sql);
	$par = "F0F0F0";
	$impar = "F8F8F8";
	$saldo = 0;
	$saldoc = 0;
	$saldod = 0;
	for($i = 0; $i < count($lista); $i++) {
        if($_GET['cpf_dentista'] != 0) {
            $codigo_parcela = explode(' - ', $lista[$i]['descricao']);
       	    $codigo_parcela = explode(' ', $codigo_parcela[0]);
            $codigo_parcela = ((strpos($lista[$i]['descricao'], 'Pagamento da parcela') !== false)?$codigo_parcela[(count($codigo_parcela)-1)]:'');
            $sql1 = "SELECT tor.cpf_dentista FROM orcamento tor INNER JOIN parcelas_orcamento tpo ON tor.codigo = tpo.codigo_orcamento WHERE tpo.codigo = ".$codigo_parcela;
            $query1 = @mysql_query($sql1);
            $row1 = @mysql_fetch_assoc($query1);
            if($_GET['cpf_dentista'] != $row1['cpf_dentista'] || !is_numeric($codigo_parcela)){
                continue;
            }
        }
        if($lista[$i][dc] != '') {
			if($i % 2 == 0) {
				$odev = $par;
			} else {
				$odev = $impar;
			}
			if($lista[$i][dc] == "-") {
				$debito = $LANG['general']['currency'].' '.money_form($lista[$i][valor]);
				$credito = '';
			} else {
				$debito = '';
				$credito = $LANG['general']['currency'].' '.money_form($lista[$i][valor]);
			}
			if($lista[$i][dc] == '-') {
				$saldo -= $lista[$i][valor];
				$saldod += $lista[$i][valor];
			} else {
				$saldo += $lista[$i][valor];
				$saldoc += $lista[$i][valor];
			}
			if($saldo < 0) {
				$cor = "FF0000";
			} else {
				$cor = "000000";
			}
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="11%" height="23" align="left"><?php echo converte_data($lista[$i][data], 2)?></td>
      <td width="41%" align="left"><?php echo $lista[$i][descricao]?></td>
      <td width="13%" align="right"><?php echo $debito?></td>
      <td width="13%" align="right"><?php echo $credito?></td>
      <td width="13%" align="right"><font color="#<?php echo $cor?>"><?php echo $LANG['general']['currency'].' '.money_form($saldo)?></form></td>
      <td width="10%" align="center"><?php echo ((verifica_nivel('caixa', 'A'))?'<a href="javascript:Ajax(\'caixa/extrato\', \'conteudo\', \'codigo='.$lista[$i]['codigo'].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" border="0" /></a>':'')?></td>
    </tr>
<?php
		}
	}
	if($odev == $impar) {
		$odev = $par;
	} else {
		$odev = $impar;
	}	
?>
    <tr>
      <td height="23" align="left" colspan="5">&nbsp;</td>
    </tr>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="51%" colspan="2" height="23" align="left"><b><?php echo $LANG['cash_flow']['total']?></b></td>
      <td width="13%" align="right"><b><?php echo $LANG['general']['currency'].' '.money_form($saldod)?></b></td>
      <td width="13%" align="right"><b><?php echo $LANG['general']['currency'].' '.money_form($saldoc)?></b></td>
      <td width="13%" align="right"><font color="#<?php echo $cor?>"><b><?php echo $LANG['general']['currency'].' '.money_form($saldo)?></b></form></td>
      <td width="10%" align="center"></td>
    </tr>
  </table><br />
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="20%">
      </td>
      <td width="40%" align="center">
      </td>
      <td width="40%" align="right">
        <img src="imagens/icones/imprimir.gif" border="0" weight="29" height="33"><a href="relatorios/caixa.php?sql=<?php echo ajaxurlencode($sql)?>" target="_blank"><?php echo $LANG['patients']['print_report']?></a>
      </td>
    </tr>
  </table>
