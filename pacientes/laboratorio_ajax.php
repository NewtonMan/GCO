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
	if($_GET['confirm_del'] == 'delete') {
        mysql_query("DELETE FROM laboratorios_procedimentos_status WHERE codigo_procedimento = ".$_GET['codigo_procedimento']);
        mysql_query("DELETE FROm laboratorios_procedimentos WHERE codigo = ".$_GET['codigo_procedimento']);
	}
	$r = '';
	if(isset($_POST['Salvar'])) {
        if($_POST['procedimento'] != '') {
            mysql_query("INSERT INTO laboratorios_procedimentos (codigo_paciente, codigo_dentista, codigo_laboratorio, procedimento, datahora) VALUES (".$_GET['codigo'].", ".$_SESSION['codigo'].", ".$_POST['codigo_laboratorio'].", '".utf8_decode ( htmlspecialchars( utf8_encode($_POST['procedimento']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') )."', NOW())");
            $strScrp = 'Ajax("pacientes/laboratorio", "conteudo", "codigo='.$_GET['codigo'].'&acao=editar&codigo_procedimento='.mysql_insert_id().'")';
        } else {
            $r = '<font color="#FF0000">';
        }
	}
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$acao = '&acao=editar';
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> &nbsp;[<?php echo $strLoCase?>] </span></td>
    </tr>
  </table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    
    <tr>
      <td height="26">&nbsp;<?php echo $LANG['patients']['laboratory_materials']?></td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
        <form id="form2" name="form2" method="POST" action="pacientes/laboratorio_ajax.php?acao=editar&codigo=<?php echo $_GET['codigo']?>" onsubmit="formSender(this, 'conteudo'); return false;">
          <fieldset>
            <legend><?php echo $LANG['patients']['procedure']?></legend>
            <table width="98%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%"></td>
                <td width="94%">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="85%"><?php echo $LANG['patients']['laboratory']?>:<br />
                      <select class="forms" name="codigo_laboratorio" id="codigo_laboratorio">
<?php
    $query = mysql_query("SELECT * FROM laboratorios ORDER BY nomefantasia");
    while($row = mysql_fetch_assoc($query)) {
        echo '                        <option value="'.$row['codigo'].'" '.(($row['codigo'] == $_POST['codigo_laboratorio'])?'selected':'').'>'.$row['nomefantasia'].'</option>'."\n";
    }
?>
                      </select></td>
                      <td width="15%" valign="bottom">
                      </td>
                    </tr>
                    <tr>
                      <td width="85%"><?php echo $r?> *<?php echo $LANG['patients']['procedure']?>:<br />
                      <input type="text" class="forms" size="80" name="procedimento" id="procedimento" /></td>
                      <td width="15%" valign="bottom"><input type="submit" name="Salvar" value="<?php echo $LANG['patients']['save']?>" class="forms" />
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="3%"></td>
              </tr>
            </table>
          </fieldset><br />
          <table width="98%" border="0" cellpadding="2" cellspacing="0" align="center">
            <tr bgcolor="#009BE6">
              <td width="40%">&nbsp;</td>
              <td width="20%">&nbsp;</td>
              <td width="20%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
              <td width="10%">&nbsp;</td>
            </tr>
            <tr class="tabela_titulo" height="23">
              <td><?php echo $LANG['patients']['procedure']?></td>
              <td><?php echo $LANG['patients']['professional']?></td>
              <td><?php echo $LANG['patients']['laboratory']?></td>
              <td><?php echo $LANG['patients']['view']?></td>
              <td><?php echo $LANG['patients']['delete']?></td>
            </tr>
<?php
    $query = mysql_query("SELECT tlp.*, td.nome dentista, tl.nomefantasia FROM laboratorios_procedimentos tlp INNER JOIN dentistas td ON tlp.codigo_dentista = td.codigo INNER JOIN laboratorios tl ON tlp.codigo_laboratorio = tl.codigo ORDER BY datahora DESC");
    echo mysql_error();
    while($row = mysql_fetch_assoc($query)) {
        if($_SESSION['codigo'] == $row['codigo_dentista']) {
            $delete = '<a href="javascript:Ajax(\'pacientes/laboratorio\', \'conteudo\', \'codigo='.$_GET['codigo'].'&acao=editar&codigo_procedimento='.$row['codigo'].'" onclick="return confirmLink(this)"><img src="imagens/icones/excluir.gif" border="0"></a>';
        }
?>
            <tr>
              <td><input type="text" class="forms" size="40" name="procedimento_novo[]" value="<?php echo $row['procedimento']?>" id="procedimento_novo[]" onblur="Ajax('pacientes/atualiza_procedimento', 'lab_atualiza', 'codigo=<?php echo $row['codigo']?>&procedimento='%2Bthis.value)"></td>
              <td><?php echo $row['dentista']?></td>
              <td><?php echo $row['nomefantasia']?></td>
              <td align="center"><a href="javascript:Ajax('pacientes/laboratorio_status', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&acao=editar&codigo_procedimento=<?php echo $row['codigo']?>');"><img src="imagens/icones/editar.gif" border="0" /></a></td>
              <td align="center"><?php echo $delete?></td>
            </tr>
<?php
    }
?>
          </table><br />
      </form>
      </td>
    </tr>
  </table>
  <div id="lab_atualiza">&nbsp;</div>
