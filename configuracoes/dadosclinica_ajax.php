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
	if(!verifica_nivel('informacoes', 'L')) {
        echo $LANG['general']['you_tried_to_access_a_restricted_area'];
        die();
    }
	if(!verifica_nivel('informacoes', 'E')) {
		$disable = 'disabled';
	}
	$clinica = new TClinica();
    $clinica->LoadInfo();
	if(isset($_POST['Salvar'])) {
        $_POST['cnpj'] = ajusta_cnpj($_POST['cnpj'], 1);
		$obrigatorios[1] = 'nomefantasia';
		$obrigatorios[] = 'proprietario';
		$i = $j = 0;
		foreach($_POST as $post => $valor) {
			$i++;
			if(array_search($post, $obrigatorios) && $valor == "") {
			    $j++;
				$r[$j] = '<font color="#FF0000">';
			}
		}
		if(strlen($_POST['cnpj']) <= 11) {
			$cpfbool = true;
		}
		if(strlen($_POST['cnpj']) > 11 && strlen($_POST['cnpj']) <= 14) {
			$cpfbool = false;
		}
		if($_POST['cnpj'] != "" && $cpfbool && !is_valid_cpf($_POST['cnpj'])) {
			$j++;
			$r[3] = '<font color="#FF0000">';
		}
		if($$_POST['cnpj'] != "" && !$cpfbool && !is_valid_cnpj($_POST['cnpj'])) {
			$j++;
			$r[3] = '<font color="#FF0000">';
		}
		if($j == 0) {
            $clinica->LoadInfo();
			$clinica->CNPJ = $_POST['cnpj'];
            $clinica->RazaoSocial = utf8_decode ( htmlspecialchars( utf8_encode($_POST['razaosocial']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Fantasia = utf8_decode ( htmlspecialchars( utf8_encode($_POST['fantasia']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Proprietario = utf8_decode ( htmlspecialchars( utf8_encode($_POST['proprietario']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Endereco = utf8_decode ( htmlspecialchars( utf8_encode($_POST['endereco']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Bairro = utf8_decode ( htmlspecialchars( utf8_encode($_POST['bairro']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Cidade = utf8_decode ( htmlspecialchars( utf8_encode($_POST['cidade']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') );
            $clinica->Estado = $_POST['estado'];
            $clinica->Cep = $_POST['cep'];
            $clinica->Pais = $_POST['pais'];
            $clinica->Fundacao = $_POST['fundacao'];
            $clinica->Telefone1 = $_POST['telefone1'];
            $clinica->Telefone2 = $_POST['telefone2'];
            $clinica->Fax = $_POST['fax'];
            $clinica->Email = $_POST['email'];
            $clinica->Web = $_POST['web'];
            $clinica->Banco1 = $_POST['banco1'];
            $clinica->Agencia1 = $_POST['agencia1'];
            $clinica->Conta1 = $_POST['conta1'];
            $clinica->Banco2 = $_POST['banco2'];
            $clinica->Agencia2 = $_POST['agencia2'];
            $clinica->Conta2 = $_POST['conta2'];
			$clinica->Salvar();
			$strScrp = 'Ajax(\'wallpapers/index\', \'conteudo\', \'\')';
		}
    }
    if($j == 0) {
        $row = "";
    } else {
        $row = $_POST;
    }
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="56%">&nbsp;&nbsp;&nbsp;<img src="configuracoes/img/clinica.png" alt="<?php echo $LANG['clinic_information']['clinic_information']?>"> <span class="h3"><?php echo $LANG['clinic_information']['clinic_information']?> </span></td>
      <td width="6%" valign="bottom"></td>
      <td width="36%" valign="bottom" align="right">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td width="243" height="26"><?php echo $LANG['clinic_information']['editing_clinic_information']?> </td>
      <td width="381">&nbsp;</td>
    </tr>
  </table>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form2" name="form2" method="POST" action="configuracoes/dadosclinica_ajax.php" onsubmit="formSender(this, 'conteudo'); return false;"><fieldset>
        <legend><span class="style1"><?php echo $LANG['clinic_information']['clinic_information']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $r[1]?>* <?php echo $LANG['clinic_information']['company_name']?> <br />
                <label>
                  <input name="fantasia" value="<?php echo $clinica->Fantasia?>" <?php echo $disable?> type="text" class="forms" id="fantasia" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><?php echo $r[3]?><?php echo $LANG['clinic_information']['document1']?><br />
              <input name="cnpj" value="<?php echo $clinica->CNPJ?>" <?php echo $disable?> type="text" class="forms" id="cnpj" size="30" maxlength="18" />
            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['legal_name']?><br />
              <input name="razaosocial" value="<?php echo $clinica->RazaoSocial?>" <?php echo $disable?> type="text" class="forms" id="razaosocial" size="50" /></td>
            <td><?php echo $r[2]?>* <?php echo $LANG['clinic_information']['owner']?><br />
              <input name="proprietario" value="<?php echo $clinica->Proprietario?>" <?php echo $disable?> type="text" class="forms" id="proprietario" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['address1']?><br />
              <input name="endereco" value="<?php echo $clinica->Endereco?>" <?php echo $disable?> type="text" class="forms" id="endereco" size="50" maxlength="150" /></td>
            <td><?php echo $LANG['clinic_information']['address2']?><br />
              <input name="bairro" value="<?php echo $clinica->Bairro?>" <?php echo $disable?> type="text" class="forms" id="bairro" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['city']?><br />
                <input name="cidade" value="<?php echo $clinica->Cidade?>" <?php echo $disable?> type="text" class="forms" id="cidade" size="30" maxlength="50" />
              <br /></td>
            <td><?php echo $LANG['clinic_information']['state']?><br />
                <input name="estado" value="<?php echo $clinica->Estado?>" <?php echo $disable?> type="text" class="forms" id="estado" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['country']?><br />
                <input name="pais" value="<?php echo $clinica->Pais?>" <?php echo $disable?> type="text" class="forms" id="pais" size="30" maxlength="50" />
              <br /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['zip']?><br />
              <input name="cep" value="<?php echo $clinica->Cep?>" <?php echo $disable?> type="text" class="forms" id="cep" size="10" maxlength="9" onKeypress="return Ajusta_CEP(this, event);" /></td>
            <td><?php echo $LANG['clinic_information']['year_of_foundation']?><br />
              <input name="fundacao" value="<?php echo $clinica->Fundacao?>" <?php echo $disable?> type="text" class="forms" id="fundacao" maxlength="4" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['phone1']?><br />
              <input name="telefone1" value="<?php echo $clinica->Telefone1?>" <?php echo $disable?> type="text" class="forms" id="telefone1" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
            <td><?php echo $LANG['clinic_information']['phone2']?><br />
              <input name="telefone2" value="<?php echo $clinica->Telefone2?>" <?php echo $disable?> type="text" class="forms" id="telefone2" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['fax']?> <br />
              <input name="fax" value="<?php echo $clinica->Fax?>" <?php echo $disable?> type="text" class="forms" id="fax" size="25" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
            <td><?php echo $LANG['clinic_information']['website']?><br />
              <input name="web" value="<?php echo $clinica->Web?>" <?php echo $disable?> type="text" class="forms" id="web" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['email']?><br />
              <input name="email" value="<?php echo $clinica->Email?>" <?php echo $disable?> type="text" class="forms" id="email" size="40" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br />
		<fieldset>
        <legend><span class="style1"><?php echo $LANG['clinic_information']['bank_information']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['clinic_information']['bank']?> <br />
                <label>
                  <input name="banco1" value="<?php echo $clinica->Banco1?>" <?php echo $disable?> type="text" class="forms" id="banco1" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['agency']?><br />
                <input name="agencia1" value="<?php echo $clinica->Agencia1?>" <?php echo $disable?> type="text" class="forms" id="agencia1" size="50" maxlength="100" /></td>
            <td><?php echo $LANG['clinic_information']['account']?><br />
                <input name="conta1" value="<?php echo $clinica->Conta1?>" <?php echo $disable?> type="text" class="forms" id="conta1" /></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['clinic_information']['bank']?> <br />
                <label>
                  <input name="banco2" value="<?php echo $clinica->Banco2?>" <?php echo $disable?> type="text" class="forms" id="banco2" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>
          <tr>
            <td><?php echo $LANG['clinic_information']['agency']?><br />
                <input name="agencia2" value="<?php echo $clinica->Agencia2?>" <?php echo $disable?> type="text" class="forms" id="agencia2" size="50" maxlength="100" /></td>
            <td><?php echo $LANG['clinic_information']['account']?><br />
                <input name="conta2" value="<?php echo $clinica->Conta2?>" <?php echo $disable?> type="text" class="forms" id="conta2" /></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br />
		<fieldset>
        <legend><span class="style1"><?php echo $LANG['clinic_information']['clinic_logotype']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="497" align="center">
                <iframe height="200" width="150" scrolling="No" name="foto_frame" id="foto_frame" src="configuracoes/logo.php" frameborder="0"></iframe>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
		<br />
        <div align="center"><br />
          <input name="Salvar" type="submit" <?php echo $disable?> class="forms" id="Salvar" value="<?php echo $LANG['clinic_information']['save']?>" />
        </div>
      </form>      </td>
    </tr>
  </table>
</div>
<script>
document.getElementById('fantasia').focus();
</script>
