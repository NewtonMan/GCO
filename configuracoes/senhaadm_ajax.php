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
	if(!verifica_nivel('senha_adm', 'V')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
	if(isset($_POST['login'])) {
		$funcionario = new TFuncionarios();
		if($_POST['senha'] != '') {
			if($_POST['senha'] != $_POST['confsenha']) {
				$j++;
				$r[2] = '<font color="#FF0000">';
				$r[3] = '<font color="#FF0000">';
			}
			$senha = mysql_fetch_array(mysql_query("SELECT * FROM `funcionarios` WHERE `codigo` = '1'"));
			if(md5($_POST['senhaatual']) != $senha['senha']) {
				$j++;
				$r[1] = '<font color="#FF0000">';
			}
			if($j == 0) {
				$funcionario->LoadFuncionario('1');
				$strScrp = "alert('".$LANG['admin_password']['password_successfully_changed']."'); Ajax('wallpapers/index', 'conteudo', '');";
				if($_POST['senha'] != "") {
					$funcionario->SetDados('senha', md5($_POST['senha']));
				}
				$funcionario->Salvar();
			}
		}
	}
?>
<script>
<?php echo $strScrp?>
</script>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="56%">&nbsp;&nbsp;&nbsp;<img src="wallpapers/img/login.png" alt="<?php echo $LANG['admin_password']['change_admin_password']?>"> <span class="h3"><?php echo $LANG['admin_password']['change_admin_password']?></span></td>
      <td width="6%" valign="bottom"><a href="#"></a></td>
      <td width="36%" valign="bottom" align="right">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td height="23"><?php echo $LANG['admin_password']['change_admin_password']?></td>
    </tr>
  </table>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form2" name="form2" method="POST" action="configuracoes/senhaadm_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;">
        <fieldset>
        <legend><span class="style1"><?php echo $LANG['admin_password']['personal_access_information']?></span></legend>
        <table width="287" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $r[1]?><?php echo $LANG['admin_password']['current_password']?>:<br />
              <input name="senhaatual" value="" type="password" class="forms" id="senhaatual" maxlength="11" />
              <br />
              <br /></td>
          </tr>
          <tr>
            <td><?php echo $r[2]?><?php echo $LANG['admin_password']['new_password']?><br />
              <input name="senha" value="" type="password" class="forms" id="senha" maxlength="32" />
              <br />
              <br /></td>
          </tr>
          <tr>
            <td><?php echo $r[3]?><?php echo $LANG['admin_password']['retype_new_password']?><br />
              <input name="confsenha" value="" type="password" class="forms" id="confsenha" maxlength="32" />
              <br />
              <br /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <div align="center"><br>
          <input name="login" type="submit" class="forms" id="login" value="<?php echo $LANG['admin_password']['save']?>" />
        </div>
      </form>
      </td>
    </tr>
  </table>
<script>
document.getElementById('senhaatual').focus();
</script>
