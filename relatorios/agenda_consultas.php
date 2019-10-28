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
    $nome_dentista = encontra_valor('dentistas', 'codigo', $_GET['codigo_dentista'], 'nome');
    $sexo_dentista = encontra_valor('dentistas', 'codigo', $_GET['codigo_dentista'], 'sexo');
?>
<font size="3"><?php echo $LANG['reports']['schedule_of'].' '.(($sexo_dentista == 'Masculino')?'<b>Dr.':'<b>Dra.').' '.$nome_dentista?></b> <?php echo $LANG['reports']['for_the_date']?> <b><?php echo converte_data($_GET['data'], 2).' ('.ucwords(nome_semana($_GET['data'])).')'?></font><br /><br />
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr style="font-size: 11px">
      <th width="8%" align="left" style="font-size: 11px">&nbsp;<?php echo $LANG['reports']['time']?></th>
      <th width="30%" align="left" style="font-size: 11px"><?php echo $LANG['reports']['patient']?></th>
      <th width="12%" align="left" style="font-size: 11px; border-right: 1px; border-right-color=: #000000; border-right-style: solid"><?php echo $LANG['reports']['procedure']?></th>
      <th width="8%" align="left" style="font-size: 11px; border-left: 1px; border-left-color=: #000000; border-left-style: solid">&nbsp;<?php echo $LANG['reports']['time']?></th>
      <th width="30%" align="left" style="font-size: 11px"><?php echo $LANG['reports']['patient']?></th>
      <th width="12%" align="left" style="font-size: 11px"><?php echo $LANG['reports']['procedure']?></th>
    </tr>
    <tr class="td_even">
<?php
	if(is_date($_GET['data']) && $_GET['codigo_dentista'] != "") {
        //$sql = "SELECT * FROM agenda_obs WHERE data = '" . $_GET['data'] . "' codigo_dentista = " . $_GET['codigo_dentista'];
        //$obs = mysql_fetch_assoc ( mysql_query ( $sql ) );
		$agenda = new TAgendas();
		for($i = 7; $i <= 22; $i++) {
			if(strlen($i) < 2) {
				$horas[] = "0".$i.":";
			} else {
				$horas[] = $i.":";
			}
		}
		$minutos = array('00', '15', '30', '45');
		foreach($horas as $hora) {
			foreach($minutos as $minuto) {
				$horario[] = $hora.$minuto;
			}
		}
		$j = 0;
		for($i = 0; $i < count($horario); $i++) {
			if($j % 2 == 0) {
				$td_class = 'td_even';
			} else {
				$td_class = 'td_odd';
			}
			if($i % 2 == 0) {
				if($i !== 0) {
					echo '</tr> <tr class="'.$td_class.'">';
				}
				$j++;
                $styles = 'style="border-right: 1px; border-right-color=: #CCCCCC; border-right-style: solid"';
			} else {
                $styles = '';
			}
			$agenda->LoadAgenda($_GET['data'], $horario[$i], $_GET['codigo_dentista']);
			if(!$agenda->ExistHorario()) {
				$agenda->SalvarNovo();
			}
?>
      <td align="center" height="23">&nbsp;<?php echo $horario[$i]?></td>
      <td align="left"><?php echo $agenda->RetornaDados('descricao')?>&nbsp;</td>
      <td align="left" <?php echo $styles?>><?php echo $agenda->RetornaDados('procedimento')?>&nbsp;</td>
<?php
            $j++;
		}
	}
?>
  </tr>
</table>
<?php/*<div align="justify">
    <strong><?php echo $LANG['calendar']['comments_of_day']?></strong>:<br />
    <?php echo $obs['obs']?>
</div>*/?>
<script>
window.print();
</script>
<?php
    include "../timbre_foot.php";
?>
