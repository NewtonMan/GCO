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
		mysql_query("DELETE FROM `caixa` WHERE `codigo` = '".$_GET['codigo']."'") or die(mysql_error());
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
      <td width="35%">&nbsp;&nbsp;&nbsp;<img src="caixa/img/caixa.png" alt="<?php echo $LANG['cash_flow']['clinic_cash_flow']?>"> <span class="h3"><?php echo $LANG['cash_flow']['clinic_cash_flow']?></span></td>
      <td width="63%" colspan="2" valign="bottom" align="right"><br />
        <table border="0" cellpadding="0" cellspacing="0" width="93%" align="right">
          <tr>
            <td width="26%" align="left">
              <input type="hidden" name="peri" id="peri" value="">
              <input type="radio" name="pesq" id="pesqdia" value="dia" onclick="document.getElementById('peri').value='dia'"><label for="pesqdia"> <?php echo $LANG['cash_flow']['day_month_year']?></label>
            </td>
            <td width="20%" align="left">
              <input type="radio" name="pesq" id="pesqmes" value="mes" onclick="document.getElementById('peri').value='mes'"><label for="pesqmes"> <?php echo $LANG['cash_flow']['month_year']?></label>
            </td>
            <td width="14%" align="left">
              <input type="radio" name="pesq" id="pesqano" value="ano" onclick="document.getElementById('peri').value='ano'"><label for="pesqano"> <?php echo $LANG['cash_flow']['year']?></label>
            </td>
            <td width="40%" align="left">
        	  <?php echo $LANG['cash_flow']['search_for']?> <input name="procurar" id="procurar" type="text" class="forms" size="20" maxlength="40" onkeyup="javascript:Ajax('caixa/pesquisa', 'pesquisa', 'pesquisa='%2Bthis.value%2B'&peri='%2Bdocument.getElementById('peri').value)" onKeypress="return Ajusta_DMA(this, event, document.getElementById('peri').value);"
              onclick="if(document.getElementById('pesqdia').checked) {abreCalendario(this);}">
            </td>
          </tr>
          <tr>
            <td align="left">
              <input type="radio" name="pesq" id="pesqmesatual" value="mesatual" onclick="javascript:Ajax('caixa/pesquisa', 'pesquisa', 'peri=mesatual')"><label for="pesqmesatual"> <?php echo $LANG['cash_flow']['current_month']?></label>
            </td>
            <td colspan="3" align="right">
            </td>
          </tr>
        </table>
      </td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table><br />
<?php
    if(verifica_nivel('caixa', 'I')) {
?>
  <form id="form2" name="form2" method="POST" action="caixa/inicial_ajax.php" onsubmit="formSender(this, 'pesquisa'); this.reset(); return false;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="4%">
      </td>
      <td width="12%"><?php echo $LANG['cash_flow']['date']?> <br />
        <input type="text" size="13" value="<?php echo converte_data(hoje(), 2)?>" name="data" id="data" class="forms" onKeypress="return Ajusta_Data(this, event);">
      </td>
      <td width="53%"><?php echo $LANG['cash_flow']['description']?> <br />
        <input type="text" size="77" name="descricao" id="descricao" class="forms">
      </td>
      <td width="7%"><?php echo $LANG['cash_flow']['d_c']?> <br />
        <select name="dc" class="forms" id="dc">
<?php
	$estados = array('%2B', '-');
	foreach($estados as $uf) {
		if($row['sexo'] == $uf) {
			echo '<option value="'.$uf.'" selected>'.$uf.'</option>';
		} else {
			echo '<option value="'.$uf.'">'.$uf.'</option>';
		}
	}
?>       
			 </select>
      </td>
      <td width="11%"><?php echo $LANG['cash_flow']['value']?> <br />
        <input type="text" size="12" name="valor" id="valor" class="forms" onKeypress="return Ajusta_Valor(this, event);">
      </td>
      <td width="10%"> <br />
        <input type="submit" name="Salvar" id="Salvar" value="<?php echo $LANG['cash_flow']['save']?>" class="forms">
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
      <td bgcolor="#009BE6" colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="23" align="left"><?php echo $LANG['cash_flow']['date']?></td>
      <td width="41%" align="left"><?php echo $LANG['cash_flow']['description']?></td>
      <td width="13%" align="center"><?php echo $LANG['cash_flow']['debit']?></td>
      <td width="13%" align="center"><?php echo $LANG['cash_flow']['credit']?></td>
      <td width="13%" align="center"><?php echo $LANG['cash_flow']['total']?></td>
      <td width="10%" align="center"><?php echo $LANG['patients']['delete']?></td>
    </tr>
  </table>
  <div id="pesquisa"></div>
  <script>
  Ajax('caixa/inicial', 'pesquisa', 'pesquisa=');
  </script>
</div>
