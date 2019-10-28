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
	if(!checklog()) {
        echo '<script>Ajax("wallpapers/index", "conteudo", "");</script>';
        die();
	}
	if(!verifica_nivel('manuais', 'L')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="46%">&nbsp;&nbsp;&nbsp;<img src="arquivos/img/arquivos.png" alt="Arquivos"> <span class="h3"><?php echo $LANG['manuals_and_codes']['manuals_and_codes']?></span></td>
      <td width="2%" valign="bottom">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td width="300" bgcolor="#009BE6">&nbsp;</td>
      <td width="29" bgcolor="#009BE6">&nbsp;</td>
      <td width="189" bgcolor="#009BE6">&nbsp;</td>
      <td width="230" bgcolor="#009BE6">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" height="23" align="left"><?php echo $LANG['manuals_and_codes']['file']?></td>
      <td width="230" align="center"><?php echo $LANG['manuals_and_codes']['view']?></td>
    </tr>
  </table>  
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr class="td_odd" onmouseout="style.background='#F0F0F0'" onmouseover="style.background='#DDE1E6'">
      <td width="518" height="23" align="left">Codigo Internacional de Doen&ccedil;as Odontol&oacute;gicas<br /></td>
      <td width="230" align="center"><a href="arquivos/manuais_codigos/files/cid.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
    <tr class="td_even" onmouseout="style.background='#F8F8F8'" onmouseover="style.background='#DDE1E6'">
      <td height="23" align="left">C&oacute;digo de &Eacute;tica Odontol&oacute;gico - CFO<br /></td>
      <td align="center"><a href="arquivos/manuais_codigos/files/codigo_etica.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
    <tr class="td_odd" onmouseout="style.background='#F0F0F0'" onmouseover="style.background='#DDE1E6'">
      <td height="23" align="left">C&oacute;digo de Processo &Eacute;tico - CFO<br /></td>
      <td align="center"><a href="arquivos/manuais_codigos/files/codigo_proc_etico.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
    <tr class="td_even" onmouseout="style.background='#F8F8F8'" onmouseover="style.background='#DDE1E6'">
      <td height="23" align="left">Manual de Biosseguran&ccedil;a - CFO<br /></td>
      <td align="center"><a href="arquivos/manuais_codigos/files/manual_biosseguranca.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
    <tr class="td_odd" onmouseout="style.background='#F0F0F0'" onmouseover="style.background='#DDE1E6'">
      <td height="23" align="left">Manual de Gerenciamento de Res&iacute;duos - ANVISA<br /></td>
      <td align="center"><a href="arquivos/manuais_codigos/files/manual_gerenciamento_residuos_anvisa.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
    <tr class="td_even" onmouseout="style.background='#F8F8F8'" onmouseover="style.background='#DDE1E6'">
      <td height="23" align="left">Manual da Odontologia - ANVISA</td>
      <td align="center"><a href="arquivos/manuais_codigos/files/manual_odonto_anvisa.pdf" target="_blank"><img src="imagens/icones/visualizar.gif" alt="Ver arquivo" width="16" height="20" border="0" /></a></td>
    </tr>
  </table>
</div>
