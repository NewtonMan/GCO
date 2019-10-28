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
<p align="center"><font size="3"><b><?php echo $LANG['reports']['fee_table_report']?><br />
  <?php echo encontra_valor('convenios', 'codigo', $_GET['codigo_convenio'], 'nomefantasia')?></b></font></p><br />
<table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr style="font-size: 11px">
    <th width="7%" align="center" style="font-size: 11px"><?php echo $LANG['reports']['code']?>
    </th>
    <th width="45%" align="center" style="font-size: 11px"><?php echo $LANG['reports']['procedure']?>
    </th>
    <th width="12%" align="center" style="font-size: 11px"><?php echo $LANG['reports']['private_value']?>
    </th>
    <th width="12%" align="center" style="font-size: 11px"><?php echo $LANG['reports']['plan_value']?>
    </th>
    <th width="24%" align="center" style="font-size: 11px" colspan="2"><?php echo $LANG['reports']['differences']?>
    </th>
  </tr>
<?php
    $i = 0;
	$sql = stripslashes($_GET['sql']);
	$query = mysql_query($sql) or die('Line 57: '.mysql_error());
    while($row = mysql_fetch_array($query)) {
        if($i % 2 === 0) {
            $td_class = 'td_even';
        } else {
            $td_class = 'td_odd';
        }
		$valor_particular = encontra_valor('honorarios_convenios', 'codigo_convenio = 1 AND codigo_procedimento', $row['codigo'], 'valor');
		$valor_convenio = encontra_valor('honorarios_convenios', 'codigo_convenio = '.$_GET['codigo_convenio'].' AND codigo_procedimento', $row['codigo'], 'valor');
?>
  <tr class="<?php echo $td_class?>" style="font-size: 11px">
    <td><?php echo $row['codigo']?>
    </td>
    <td><?php echo $row['procedimento']?>
    </td>
    <td align="right"><?php echo $LANG['general']['currency'].' '.number_format($valor_particular, 2, ',', '.')?>
    </td>
    <td align="right"><?php echo $LANG['general']['currency'].' '.number_format($valor_convenio, 2, ',', '.')?>
    </td>
    <td align="right"><?php echo $LANG['general']['currency'].' '.number_format(($valor_particular - $valor_convenio), 2, ',', '.')?>
    </td>
    <td align="right"><?php echo @number_format((100 - ($valor_convenio / $valor_particular * 100)), 2, ',', '.')?> %
    </td>
  </tr>
<?php
        $i++;
    }
?>
</table>
<script>
window.print();
</script>
<?php
    include "../timbre_foot.php";
?>
