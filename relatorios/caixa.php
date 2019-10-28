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
	include "../timbre_head.php";
?>
<p align="center"><font size="3"><b><?php echo $LANG['reports']['cash_flow']?></b></font></p><br />
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <th width="15%" align="center"><?php echo $LANG['reports']['date']?></th>
    <th width="40%" align="left"><?php echo $LANG['reports']['description']?></th>
    <th width="15%" align="center"><?php echo $LANG['reports']['debit']?></th>
    <th width="15%" align="center"><?php echo $LANG['reports']['credit']?></th>
    <th width="15%" align="center"><?php echo $LANG['reports']['total']?></th>
  </tr>
<?php
    $i = $saldo = 0;
    $saldoc = $saldod = 0;
	$sql = stripslashes($_GET['sql']);
	$query = mysql_query($sql) or die('Line 57: '.mysql_error());
    while($row = mysql_fetch_array($query)) {
        if($i % 2 === 0) {
            $td_class = 'td_even';
        } else {
            $td_class = 'td_odd';
        }
        if($row['dc'] == "-") {
            $debito = $LANG['general']['currency'].' '.number_format($row['valor'], 2, ',', '.');
            $credito = '';
        } else {
            $debito = '';
            $credito = $LANG['general']['currency'].' '.number_format($row['valor'], 2, ',', '.');
        }
        if($row['dc'] == '-') {
            $saldo -= $row['valor'];
            $saldod += $row['valor'];
        } else {
            $saldo += $row['valor'];
            $saldoc += $row['valor'];
        }
        if($saldo < 0) {
            $cor = "FF0000";
        } else {
            $cor = "000000";
        }
?>
  <tr class="<?php echo $td_class?>" style="font-size: 12px">
    <td align="center"><?php echo converte_data($row['data'], 2)?></td>
    <td><?php echo $row['descricao']?></td>
    <td align="right"><font color="#FF0000"><?php echo $debito?></font></td>
    <td align="right"><font color="#000000"><?php echo $credito?></font></td>
    <td align="right"><font color="#<?php echo $cor?>"><?php echo $LANG['general']['currency'].' '.number_format($saldo, 2, ',', '.')?></font></td>
  </tr>
<?php
        $i++;
    }
?>
  <tr height="7">
    <td colspan="5"></td>
  </tr>
  <tr class="<?php echo $td_class?>" style="font-size: 12px">
    <td align="center" colspan="2"><b><?php echo $LANG['reports']['total']?></b></td>
    <td align="right"><font color="#FF0000"><b><?php echo $LANG['general']['currency'].' '.number_format($saldod, 2, ',', '.')?></b></font></td>
    <td align="right"><font color="#000000"><b><?php echo $LANG['general']['currency'].' '.number_format($saldoc, 2, ',', '.')?></b></font></td>
    <td align="right"><font color="#<?php echo $cor?>"><b><?php echo $LANG['general']['currency'].' '.number_format($saldo, 2, ',', '.')?></b></font></td>
  </tr>
</table>
<?php
    include "../timbre_foot.php";
?>
<script>
window.print();
</script>
