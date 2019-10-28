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
        echo '<script>Ajax("wallpapers/index", "conteudo", "");</script>';
        die();
	}
	if($_GET['confirm_del'] == "delete") {
		mysql_query("DELETE FROM `contaspagar` WHERE `codigo` = '".$_GET['codigo']."'") or die(mysql_error());
	}
	if(isset($_POST['Salvar'])) {
		$obrigatorios[1] = 'datavencimento';
		$obrigatorios[] = 'descricao';
		$obrigatorios[] = 'valor';
		$i = $j = 0;
		foreach($_POST as $post => $valor) {
			$i++;
			if(array_search($post, $obrigatorios) && $valor == "") {
			    $j++;
				$r[$j] = '<font color="#FF0000">';
			}
		}
		if($j == 0) {
			$caixa = new TContas('clinica');
			$caixa->SetDados('datavencimento', converte_data($_POST['datavencimento'], 1));
			$caixa->SetDados('descricao', $_POST['descricao']);
			$caixa->SetDados('valor', $_POST['valor']);
			$caixa->SalvarNovo();
			$caixa->Salvar();
		}
	}
?>
<div id='calendario' name='calendario' style='display:none;position:absolute;'>
<?php
	include "../lib/calendario.inc.php";
?>
</div>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="38%">&nbsp;&nbsp;&nbsp;<img src="contaspagar/img/contas.png" alt="<?php echo $LANG['accounts_payable']['clinic_accounts_payable']?>"> <span class="h3"><?php echo $LANG['accounts_payable']['clinic_accounts_payable']?></span></td>
      <td width="60%" colspan="2" valign="bottom" align="center">
      <input type="hidden" name="peri" id="peri" value="mesatual">
      <input type="radio" name="pesq" id="pesqdia" value="dia" onclick="document.getElementById('peri').value='dia'"><label for="pesqdia"> <?php echo $LANG['accounts_payable']['day_month_year']?></label>&nbsp;&nbsp;&nbsp;
      <input type="radio" name="pesq" id="pesqmes" value="mes" onclick="document.getElementById('peri').value='mes'"><label for="pesqmes"> <?php echo $LANG['accounts_payable']['month_year']?></label>&nbsp;&nbsp;&nbsp;
	  <?php echo $LANG['accounts_payable']['search_for']?> <input name="procurar" id="procurar" type="text" class="forms" size="20" maxlength="40" onkeyup="javascript:Ajax('contaspagar/pesquisa', 'pesquisa', 'pesquisa='%2Bthis.value%2B'&peri='%2Bdocument.getElementById('peri').value)" onKeypress="return Ajusta_DMA(this, event, document.getElementById('peri').value);"
      onclick="if(document.getElementById('pesqdia').checked) {abreCalendario(this);}">
	  <br>
      <input type="radio" name="pesq" id="pesqmesatual" checked='checked" value="mesatual" onclick="javascript:Ajax('contaspagar/pesquisa', 'pesquisa', 'peri=mesatual')"><label for="pesqmesatual"> <?php echo $LANG['accounts_payable']['current_month']?></label>&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table><br />
<?php
	if(verifica_nivel('contas_pagar', 'I')) {
?>
  <form id="form2" name="form2" method="POST" action="contaspagar/extrato_ajax.php" onsubmit="formSender(this, 'conteudo'); this.reset(); return false;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="4%">
      </td>
      <td width="12%"><?php echo $LANG['accounts_payable']['deadline']?> <br />
        <input type="text" size="13" value="<?php echo converte_data(hoje(), 2)?>" name="datavencimento" id="datavencimento" class="forms">
      </td>
      <td width="58%"><?php echo $LANG['accounts_payable']['description']?> <br />
        <input type="text" size="80" name="descricao" id="descricao" class="forms">
      </td>
      <td width="16%"><?php echo $LANG['accounts_payable']['value']?> <br />
        <input type="text" size="20" name="valor" id="valor" class="forms" onKeypress="return Ajusta_Valor(this, event);">
      </td>
      <td width="10%"> <br />
        <input type="submit" name="Salvar" id="Salvar" value="<?php echo $LANG['accounts_receivable']['save']?>" class="forms">
      </td>
      <td width="3%">
      </td>
    </tr>
  </table>
  </form>
<?php
    }
?>
<div class="conteudo" id="table dados"><br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td bgcolor="#009BE6" colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="23" align="left"><?php echo $LANG['accounts_payable']['deadline']?></td>
      <td width="50%" align="left"><?php echo $LANG['accounts_payable']['description']?></td>
      <td width="13%" align="center"><?php echo $LANG['accounts_payable']['value']?></td>
      <td width="21%" align="center"><?php echo $LANG['accounts_payable']['payment']?></td>
      <td width="5%" align="center"><?php echo $LANG['accounts_payable']['delete']?></td>
    </tr>
  </table>
  <div id="pesquisa"></div>
  <script>
  Ajax('contaspagar/pesquisa', 'pesquisa', 'pesquisa=');
  </script>
</div>
