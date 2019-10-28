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
?><html>
<head></head>
<body topmargin="0" leftmargin="0" bgcolor="#F0F0F0" style="font-family: Verdana">
<?php
	$sql = stripslashes($_GET['sql']);
	$query = mysql_query($sql) or die('Erro: '.mysql_error());
	while($row = mysql_fetch_array($query)) {
		$nome = $row['nome'];
		if($nome == '') {
            $nome = $row['nomefantasia'];
		}
		$end = $row['endereco'];
		$bairro = $row['bairro'];
		$cidade = $row['cidade'];
		$estado = $row['estado'];
		$cep = $row['cep'];
		$obs = $row['obs_etiqueta'];
?>
			  <font size="2" face="Roman 17cpi"><?php echo $nome?> <?php echo isset($_GET['nasc']) ? '(' .converte_data($row['nascimento'],2). ')' : ''?><br>
              <font size="1" face="Roman 17cpi"><?php echo $end?> - <?php echo $bairro?><br>
              <font size="1" face="Roman 17cpi"><?php echo $cidade?> - <?php echo $estado?> - <?php echo $LANG['reports']['zip']?>: <?php echo $cep?><br>
              <font size="2" face="Roman 17cpi"><?php echo $obs?><br>
              <font size="1" face="Roman 17cpi"><br><br><br>


<?php
	}
?>
<script>
window.print();
</script>
</body>
</html>
