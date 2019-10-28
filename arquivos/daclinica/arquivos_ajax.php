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
	include "../../lib/config.inc.php";
	include "../../lib/func.inc.php";
	include "../../lib/classes.inc.php";
	require_once '../../lang/'.$idioma.'.php';
	header("Content-type: text/html; charset=ISO-8859-1", true);
	if(!checklog()) {
        echo '<script>Ajax("wallpapers/index", "conteudo", "");</script>';
        die();
	}
	if(!verifica_nivel('agenda', 'L')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
	if($_GET['confirm_del'] == "delete") {
		mysql_query("DELETE FROM `arquivos` WHERE `nome` = '".$_GET['codigo']."'") or die(mysql_error());
	}
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="35%">&nbsp;&nbsp;&nbsp;<img src="arquivos/img/arquivos.png" alt="Arquivos da Cl�nica"> <span class="h3"><?php echo $LANG['clinic_files']['clinic_files']?></span></td>
      <td width="63%" colspan="2" valign="bottom" align="center"></td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table><br />
<?php
    if(verifica_nivel('arquivos_clinica', 'I')) {
?>
  <form id="form2" name="form2" method="POST" action="arquivos/daclinica/incluir_ajax.php" enctype="multipart/form-data" target="iframe_upload"> <?php/*onsubmit="Ajax('arquivos/daclinica/arquivos', 'conteudo', '');">*/?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="4%">
      </td>
      <td width="37%"><?php echo $LANG['clinic_files']['file']?> <br />
        <input type="file" size="20" name="arquivo" id="arquivo" class="forms" onchange="getElementById('filename').value=this.value">
        <input type="hidden" value="" name="filename" id="filename">
      </td>
      <td width="43%"><?php echo $LANG['clinic_files']['description']?> <br />
        <input type="text" size="50" name="descricao" id="descricao" class="forms">
      </td>
      <td width="10%"> <br />
        <input type="submit" name="Salvar" id="Salvar" value="<?php echo $LANG['clinic_files']['save']?>" class="forms">
      </td>
      <td width="3%">
      </td>
    </tr>
  </table>
  </form>
  <iframe name="iframe_upload" width="1" height="1" frameborder="0" scrolling="No"></iframe>
<?php
    }
?>
<div class="conteudo" id="table dados"><br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td bgcolor="#009BE6" colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td width="52%" height="23" align="left"><?php echo $LANG['clinic_files']['description']?></td>
      <td width="11%" align="center"><?php echo $LANG['clinic_files']['type']?></td>
      <td width="13%" align="center"><?php echo $LANG['clinic_files']['size']?></td>
      <td width="13%" align="center"><?php echo $LANG['clinic_files']['view']?></td>
      <td width="11%" align="center"><?php echo $LANG['clinic_files']['delete']?></td>
    </tr>
  </table>  
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
	$query = mysql_query("SELECT * FROM `arquivos` ORDER BY `descricao` ASC");
	$i = 0;
	$par = "F0F0F0";
	$impar = "F8F8F8";
	while($row = mysql_fetch_array($query)) {
		if($i % 2 == 0) {
			$odev = $par;
		} else {
			$odev = $impar;
		}
?>
    <tr bgcolor="#<?php echo $odev?>" onmouseout="style.background='#<?php echo $odev?>'" onmouseover="style.background='#DDE1E6'">
      <td width="52%" height="23" align="left"><?php echo $row['descricao']?></td>
      <td width="11%" align="center"><?php echo pega_tipo($row['nome'])?></td>
      <td width="13%" align="center"><?php echo format_size($row['tamanho'])?></td>
      <td width="13%" align="center"><?php echo ((verifica_nivel('arquivos_clinica', 'V'))?'<a href="arquivos/daclinica/files/'.$row['nome'].'" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a>':'')?></td>
      <td width="11%" align="center"><?php echo ((verifica_nivel('arquivos_clinica', 'E'))?'<a href="javascript:Ajax(\'arquivos/daclinica/arquivos\', \'conteudo\', \'codigo='.$row['nome'].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" alt="Excluir" width="19" height="19" border="0"></a>':'')?></td>
    </tr>
<?php
		$i++;
	}
?>
  </table>
  <div id="pesquisa"></div>
</div>
