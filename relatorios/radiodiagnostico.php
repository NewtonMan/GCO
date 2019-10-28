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
	$row = mysql_fetch_assoc(mysql_query("SELECT * FROM radiografias WHERE codigo = ".$_GET['codigo']));
?>
<p align="center"><font size="3"><b><?php echo $LANG['patients']['radio_diagnosis']?></b></font></p>
<br />
<div align="center"><img src="../pacientes/verfoto_r.php?codigo=<?php echo $_GET['codigo']?>&tamanho=a4"  /></div>
<br />
<table width="650" align="center">
  <tr height="30" valign="top">
    <td width="15%"><b><?php echo $LANG['patients']['patient']?>:</b></td>
    <td width="85%"><?php echo encontra_valor('pacientes', 'codigo', $row['codigo_paciente'], 'nome')?></td>
  </tr>
  <tr height="30" valign="top">
    <td><b><?php echo $LANG['patients']['date']?>:</b></td>
    <td><?php echo converte_data($row['data'], 2)?></td>
  </tr>
  <tr height="30" valign="top">
    <td><b><?php echo $LANG['patients']['legend']?>:</b></td>
    <td><?php echo $row['legenda']?></td>
  </tr>
  <tr height="30" valign="top">
    <td colspan="2"><b><?php echo $LANG['patients']['radio_diagnosis']?>:</b><br />
      <?php echo nl2br($row['diagnostico'])?></td>
  </tr>
</table>
<?php
    include "../timbre_foot.php";
?>
<script>
window.print();
</script>
