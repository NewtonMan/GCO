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
	if(!verifica_nivel('patrimonio', 'L')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
	if($_GET['confirm_del'] == "delete") {
		mysql_query("DELETE FROM `patrimonio` WHERE `codigo` = '".$_GET['codigo']."'") or die(mysql_error());
	}
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="46%">&nbsp;&nbsp;&nbsp;<img src="patrimonio/img/patrimonio.png" alt="<?php echo $LANG['patrimony']['manage_patrimony']?>"> <span class="h3"><?php echo $LANG['patrimony']['manage_patrimony']?></span></td>
      <td width="27%" valign="bottom">
<?php echo $LANG['patrimony']['search_for']?>
  <input name="procurar" id="procurar" type="text" class="forms" size="20" maxlength="40" onkeyup="javascript:Ajax('patrimonio/pesquisa', 'pesquisa', 'pesquisa='%2Bthis.value)">
</td>
      <td width="23%" align="right" valign="bottom"><?php echo ((verifica_nivel('patrimonio', 'I'))?'<img src="imagens/icones/novo.gif" alt="Incluir" width="19" height="22" border="0"><a href="javascript:Ajax(\'patrimonio/incluir\', \'conteudo\', \'\')">'.$LANG['patrimony']['include_new_item'].'</a>':'')?></td>
      <td width="2%" valign="bottom">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr bgcolor="#009BE6">
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td width="50" height="23" align="left"><?php echo $LANG['patrimony']['code']?></td>
      <td width="338" align="left"><?php echo $LANG['patrimony']['description']?> </td>
      <td width="130" align="left"><?php echo $LANG['patrimony']['sector']?></td>
      <td width="107" align="center"><?php echo $LANG['patrimony']['value']?></td>
      <td width="59" align="center"><?php echo $LANG['patrimony']['edit_view']?></td>
      <td width="66" align="center"><?php echo $LANG['patrimony']['delete']?></td>
    </tr>
  </table>  
  <div id="pesquisa"></div>
  <script>
  Ajax('patrimonio/pesquisa', 'pesquisa', 'pesquisa=');
  </script>
</div>
