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
	if(!verifica_nivel('laboratorios', 'L')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
	if($_GET['confirm_del'] == "delete") {
		mysql_query("DELETE FROM `laboratorios` WHERE `codigo` = '".$_GET['codigo']."'") or die(mysql_error());
	}
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="48%">&nbsp;&nbsp;&nbsp;<img src="laboratorio/img/laboratorio.png" alt="<?php echo $LANG['laboratory']['manage_laboratories']?>"> <span class="h3"><?php echo $LANG['laboratory']['manage_laboratories']?> </span></td>
      <td width="21%" valign="bottom">
        <table width="100%" border="0">
      	  <tr>
      	    <td colspan="2">
             <?php echo $LANG['laboratory']['search_for']?>
            </td>
          </tr>
          <tr>
            <td>
      	      <select name="campo" id="campo" class="forms">
      	        <option value="nomefantasia"><?php echo $LANG['laboratory']['name']?></option>
      	        <option value="cidade"><?php echo $LANG['laboratory']['city']?></option>
      	      </select>
      	    </td>
      	    <td>
      	      <input name="procurar" id="procurar" type="text" class="forms" size="20" maxlength="40" onkeyup="javascript:Ajax('laboratorio/pesquisa', 'pesquisa', 'pesquisa='%2Bthis.value%2B'&campo='%2BgetElementById('campo').options[getElementById('campo').selectedIndex].value)">
      	    </td>
      	  </tr>
      	</table>
      </td>
      <td width="27%" align="right" valign="bottom"><?php echo ((verifica_nivel('laboratorios', 'I'))?'<img src="imagens/icones/novo.gif" alt="Incluir" width="19" height="22" border="0"><a href="javascript:Ajax(\'laboratorio/incluir\', \'conteudo\', \'\')">'.$LANG['laboratory']['include_new_laboratory'].'</a>':'')?></td>
      <td width="2%" valign="bottom">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td bgcolor="#009BE6" colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td width="360" align="left"><?php echo $LANG['laboratory']['company']?></td>
      <td width="160" align="left"><?php echo $LANG['laboratory']['city_state']?></td>
      <td width="105" align="left"><?php echo $LANG['laboratory']['telephone']?></td>
      <td width="59" align="center"><?php echo $LANG['laboratory']['edit_view']?></td>
      <td width="66" align="center"><?php echo $LANG['laboratory']['delete']?></td>
    </tr>
  </table>  
  <div id="pesquisa"></div>
  <script>
  document.getElementById('procurar').focus();
  Ajax('laboratorio/pesquisa', 'pesquisa', 'pesquisa=&campo=nomefantasia');
  </script>
</div>
