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
    $paciente = new TPacientes();
    $paciente->LoadPaciente($_GET['codigo']);
    $query = mysql_query("SELECT * FROM odontograma WHERE codigo_paciente = ".$_GET['codigo']) or die('Line 39: '.mysql_error());
    while($row = mysql_fetch_assoc($query)) {
        $dente[$row['dente']] = $row['descricao'];
    }
?>
<br />
<div align="center"><font size="4"><b><?php echo $LANG['reports']['odontogram']?></b></font></div><br /><br />
<font size="2"><?php echo $LANG['reports']['patient']?>:<br />
<b><?php echo $paciente->RetornaDados('nome').' ['.$paciente->RetornaDados('codigo').']'?></b><br />
<br />
<?php echo $LANG['reports']['print_date']?>:<br />
<b><?php echo date('d/m/Y')?></b></font><br /><br />
<br />
<div align="center">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: url('../pacientes/img/odontograma.gif') center center no-repeat;">
        <tr>
          <td width="38%" align="right">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
<?php
    $height = ((strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))?'21':'23');
    for($i = 18; $i != 49; $i++) {
?>
              <tr>
                <td width="100%" align="right" valign="middle" style="height: <?php echo $height?>px; border: 1px dashed #000000">
                  &nbsp;<?php echo $dente[$i]?>
                </td>
              </tr>
<?php
        if($i == 11) {
            $i = 40;
        }
        if($i < 40) {
            $i -= 2;
        }
    }
?>
            </table>
          </td>
          <td width="24%" align="center">

          </td>
          <td width="38%" align="center">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
<?php
    for($i = 28; $i != 39; $i++) {
?>
              <tr>
                <td width="100%" align="left" valign="middle" style="height: <?php echo $height?>px; border: 1px dashed #000000">
                  <?php echo $dente[$i]?>&nbsp;
                </td>
              </tr>
<?php
        if($i == 21) {
            $i = 30;
        }
        if($i < 30) {
            $i -= 2;
        }
    }
?>
            </table>
          </td>
        </tr>
      </table>
</div>
<script>
window.print();
</script>
<?php
    include "../timbre_foot.php";
?>
