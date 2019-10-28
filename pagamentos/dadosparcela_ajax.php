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
	if($_GET['parcela'] == '') {
        die();
	}
	$_GET['parcela'] = substr($_GET['parcela'], 0, 11);
	$query = mysql_query("SELECT * FROM v_orcamento WHERE codigo_parcela = ".$_GET['parcela']) or die('Line 42: '.mysql_error());
	$row = mysql_fetch_array($query);
?>
<script>
function atualiza_valor() {
    var dc = document.getElementById('dc');
    var dc_valor = document.getElementById('dc_valor');
    var valor_total = document.getElementById('valor_total');
    var valor = document.getElementById('valor');
    if(dc.value== '%2B') {
        valor.value = <?php echo $row['valor']?> %2B parseFloat(dc_valor.value);
    } else {
        valor.value = <?php echo $row['valor']?> - parseFloat(dc_valor.value);
    }
    valor_total.innerHTML = '<?php echo $LANG['general']['currency']?> '%2Bvalor.value;
}
</script>
  <br />
  <table width="58%" border="0" cellpadding="0" cellspacing="0">
    <tr align="left">
      <td width="40%">
        <?php echo $LANG['payment']['patient']?>:
      </td>
      <td width="60%">
        <b><?php echo $row['paciente']?></b>
      </td>
    </tr>
    <tr align="left">
      <td>
        <?php echo $LANG['payment']['professional']?>:
      </td>
      <td>
        <b><?php echo $row['dentista']?></b>
      </td>
    </tr>
    <tr align="left">
      <td>
        <?php echo $LANG['payment']['plot_value']?>:
      </td>
      <td>
        <b><?php echo $LANG['general']['currency'].' '.money_form($row['valor'])?></b>
      </td>
    </tr>
<?php
    if($row['pago'] == '0') {
?>
    <tr align="left">
      <td colspan="2">
        <input type="radio" id="dc_p" name="dcc" value="%2B" checked onclick="document.getElementById('dc').value=this.value; javascript:atualiza_valor();" /> <?php echo $LANG['payment']['increase']?>
        <input type="radio" id="dc_m" name="dcc" value="-" onclick="document.getElementById('dc').value=this.value; javascript:atualiza_valor();" /> <?php echo $LANG['payment']['decrease']?>
        <input type="hidden" id="dc" name="dc" value="%2B" />
        <input type="text" id="dc_valor" name="dc_valor" value="0" class="forms" size="8" onKeypress="return Ajusta_Valor(this, event);"
        onblur="if(this.value=='') { this.value='0' }; javascript:atualiza_valor()" />
      </td>
    </tr>
    <tr align="left">
      <td>
        <?php echo $LANG['payment']['total_to_pay']?>:
      </td>
      <td>
        <b><div id="valor_total"><?php echo $LANG['general']['currency']?> <?php echo money_form($row['valor'])?></div></b>
        <input type="hidden" name="valor" id="valor" value="<?php echo $row['valor']?>">
      </td>
    </tr>
<?php
    }
?>
    <tr align="left">
      <td>
        <?php echo $LANG['payment']['date']?>:
      </td>
      <td>
        <b><?php echo converte_data($row['data'], 2)?></b>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        &nbsp;
      </td>
    </tr>
<?php
    if($row['baixa'] == '1') {
?>
    <tr>
      <td colspan="2" align="center">
        <b><font color="#CC0000"><?php echo $LANG['payment']['canceled_plot']?></font></b>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        &nbsp;
      </td>
    </tr>
<?php
    } elseif($row['confirmado'] == '0') {
?>
    <tr>
      <td colspan="2" align="center">
        <b><font color="#CC0000"><?php echo $LANG['payment']['not_confirmed_budget']?></font></b>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        &nbsp;
      </td>
    </tr>

<?php
    }
?>
    <tr>
      <td colspan="2" align="center">
        <input <?php echo (($row['pago'] == '1' || $row['baixa'] == '1' || $row['confirmado'] == '0')?'disabled':'')?> type="submit" name="Salvar" value="<?php echo $LANG['payment']['confirm_payment']?>" class="forms">
      </td>
    </tr>
<?php
    if($row['pago'] == '1') {
?>
    <tr>
      <td colspan="2" align="center">
        &nbsp;
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <a href="javascript:;" onclick="window.open('relatorios/recibo.php?codigo_parcela=<?php echo $_GET['parcela']?>', 'Recibo', 'height=350,width=320,status=yes,toolbar=no,menubar=no,location=no')"><?php echo $LANG['payment']['reprint_the_receipt']?></a>
      </td>
    </tr>
<?php
    }
?>
  </table>
