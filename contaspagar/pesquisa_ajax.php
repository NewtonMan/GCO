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
	$conta = new TContas('clinica');
	$data = converte_data($_GET['pesquisa'], 1);
    switch ($_GET['peri']) {
        case 'dia': {
            $where = "`datavencimento` = '$data'";
        } break;
        case 'mes': {
            $where = "LEFT(`datavencimento`, 7) = '$data'";
        } break;
        default:
            //case 'mesatual': {
            $where = "LEFT(`datavencimento`, 7) = '".date(Y.'-'.m)."'";
        //} break;
        //    $where = '';
    }

    $sql = "SELECT * FROM `contaspagar` WHERE " . $where . " ORDER BY `datavencimento` ASC, `codigo` ASC";

    if($_GET['pg'] != '') {
        $limit = ($_GET['pg']-1)*PG_MAX;
    } else {
        $limit = 0;
        $_GET['pg'] = 1;
    }

    $total_regs = $conta->ListConta($sql);
    $lista = $conta->ListConta($sql.' LIMIT '.$limit.', '.PG_MAX);

	$par = "F0F0F0";
	$impar = "F8F8F8";
	$saldo = 0;
	for($i = 0; $i < count($lista); $i++) {
		if($i % 2 == 0) {
			$odev = $par;
		} else {
			$odev = $impar;
		}
		$conta->LoadConta($lista[$i]['codigo']);
		$saldo += $conta->RetornaDados('valor');
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="11%" height="23" align="left"><?php echo converte_data($conta->RetornaDados('datavencimento'), 2)?></td>
      <td width="50%" align="left"><?php echo $conta->RetornaDados('descricao')?></td>
      <td width="13%" align="right"><?php echo $LANG['general']['currency'].' '.money_form($conta->RetornaDados('valor'))?></td>
      <td width="21%" align="right"><input type="text" size="13" name="datapagamento" id="datapagamento" value="<?php echo converte_data($conta->RetornaDados('datapagamento'), 2)?>" onblur="Ajax('contaspagar/atualiza', 'conta_atualiza', 'codigo=<?php echo $conta->RetornaDados('codigo')?>&datapagamento='%2Bthis.value)" onKeypress="return Ajusta_Data(this, event);" <?php echo ((!verifica_nivel('contas_pagar', 'E'))?'disabled':'')?>></td>
      <td width="5%" align="center"><?php echo ((verifica_nivel('contas_pagar', 'A'))?'<a href="javascript:Ajax(\'contaspagar/extrato\', \'conteudo\', \'codigo='.$conta->RetornaDados('codigo').'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" alt="Excluir" width="19" height="19" border="0"></a>':'')?></td>
    </tr>
<?php
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
      <td width="61%" colspan="2" height="23" align="center"><b><?php echo $LANG['accounts_payable']['total']?></b></td></td>
      <td width="13%" align="right"><font color="#<?php echo $cor?>"><b><?php echo $LANG['general']['currency'].' '.money_form($saldo)?></b></font></td>
      <td width="13%" colspan="2" align="right"></td>
    </tr>
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
                    echo '<a href="javascript:;" onclick="javascript:Ajax(\'contaspagar/pesquisa\', \'pesquisa\', \'pesquisa=\'%2BgetElementById(\'procurar\').value%2B\'&peri=\'%2BgetElementById(\'peri\').value%2B\'&pg='.$i.'\')">'.$i.'</a>&nbsp;&nbsp;';
                }
                $i++;
            }
            echo $retf;
            ?>
        </td>
    </tr>
</table>
<div id="conta_atualiza"></div>
