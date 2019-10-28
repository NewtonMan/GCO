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
	if($_GET['acao'] == 'editar') {
		$odontograma = "<a href=\"javascript:Ajax('pacientes/odontograma','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$orcamento = "<a href=\"javascript:Ajax('pacientes/orcamento','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$objetivo = "<a href=\"javascript:Ajax('pacientes/objetivo','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$evolucao = "<a href=\"javascript:Ajax('pacientes/evolucao','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$inquerito = "<a href=\"javascript:Ajax('pacientes/inquerito','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$ortodontia = "<a href=\"javascript:Ajax('pacientes/ortodontia','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$implantodontia = "<a href=\"javascript:Ajax('pacientes/implantodontia','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$fotos = "<a href=\"javascript:Ajax('pacientes/fotos','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$outros = "<a href=\"javascript:Ajax('pacientes/outros','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
		$radio = "<a href=\"javascript:Ajax('pacientes/radio','conteudo','codigo=".$_GET['codigo'].$acao."')\">";
	}
	if(($_GET['codigo'] != '' && !verifica_nivel('pacientes', 'E')) || ($_GET['codigo'] == '' && !verifica_nivel('pacientes', 'I'))) {
        $disable = 'disabled';
	}
?>
<table width="620" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr style="background-image: url('pacientes/img/fundo_submenu_pacientes.jpg')">
    <td align="center" width="20%"><a href="javascript:Ajax('pacientes/incluir','conteudo','codigo=<?php echo $_GET['codigo'].$acao?>')"><span class="link_submenu_pacientes"><?php echo $LANG['patients']['clinical_sheet']?></span></a></td>
    <td align="center" width="15%"><?php echo $odontograma.'<span class="link_submenu_pacientes">'.$LANG['patients']['odontogram']?></span></a></td>
    <td align="center" width="15%"><?php echo $orcamento.'<span class="link_submenu_pacientes">'.$LANG['patients']['budget']?></span></a></td>
    <td align="center" width="25%"><?php echo $objetivo.'<span class="link_submenu_pacientes">'.$LANG['patients']['objective_examination']?></span></a></td>
    <td align="center" width="25%"><?php echo $evolucao.'<span class="link_submenu_pacientes">'.$LANG['patients']['treatment_evolution']?></span></a></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
</table>
<table width="620" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr style="background-image: url('pacientes/img/fundo_submenu_pacientes.jpg')">
    <td align="center" width="20%"><?php echo $inquerito.'<span class="link_submenu_pacientes">'.$LANG['patients']['health_investigation']?></span></a></td>
    <td align="center" width="15%"><?php echo $ortodontia.'<span class="link_submenu_pacientes">'.$LANG['patients']['orthodonty']?></span></a></td>
    <td align="center" width="20%"><?php echo $implantodontia.'<span class="link_submenu_pacientes">'.$LANG['patients']['implantodonty']?></span></a></td>
    <td align="center" width="15%"><?php echo $fotos.'<span class="link_submenu_pacientes">'.$LANG['patients']['photos']?></span></a></td>
    <td align="center" width="15%"><?php echo $radio.'<span class="link_submenu_pacientes">'.$LANG['patients']['radiograph']?></span></a></td>
    <td align="center" width="15%"><?php echo $outros.'<span class="link_submenu_pacientes">'.$LANG['patients']['others']?></span></a></td>
  </tr>
</table>
