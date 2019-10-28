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
	include "lib/config.inc.php";
    if(!$install) {
        header('Location: ./configurador.php');
    } else {
        //@unlink('./configurador.php');
    }
	include "lib/func.inc.php";
	include "lib/classes.inc.php";
	require_once 'lang/'.$idioma.'.php';
	header("Content-type: text/html; charset=ISO-8859-1", true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerenciador Cl�nico Odontol�gico Smile Odonto - Administra��o Odontol�gica Em Suas M�os</title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<link href="css/smile.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="lib/script.js.php"></script>
<script language="javascript" type="text/javascript" src="lib/ajax_search.js"></script>
</head>
<body onload="MM_preloadImages('imagens/menu/inicio_f2.jpg','imagens/menu/arquivo_f2.jpg','imagens/menu/financeiro_f2.jpg','imagens/menu/atualizacoes_f2.jpg','imagens/menu/utilitarios_f2.jpg','imagens/menu/configuracoes_f2.jpg','imagens/menu/ajuda_f2.jpg','imagens/menu/sair_f2.jpg','imagens/menu/pacientes_f2.jpg','imagens/menu/pagamentos_f2.jpg','imagens/menu/fornecedores_f2.jpg','imagens/menu/caixa_f2.jpg','imagens/menu/agenda_f2.jpg','imagens/menu/estoque_f2.jpg','imagens/menu/telefones_f2.jpg'); javascript:Ajax('wallpapers/index', 'conteudo', '')">
  <input type="hidden" id="ScriptID" value="0" />
  <div class="topo" id="topo"> <img src="imagens/top_gerenciador_smile.jpg" alt="Smile Odonto" width="770" height="40" />
    <?php include "menu.php"; ?>
    <br />
</div>
<div class="conteudo" id="conteudo"></div>
  <div class="rodape" id="rodape"> <br />
      <?php echo $LANG['general']['smile_odontology']?> - <?php echo $LANG['general']['enhancing_your_smile']?> - <a href="http://www.smileodonto.com.br" target="_blank">www.smileodonto.com.br </a><br>
      <br>
      <?php echo $LANG['general']['be_part_of_smile']?>
  </div>
</body>
</html>
