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
	if(($_GET['codigo'] != '' && !verifica_nivel('laboratorios', 'E')) || ($_GET['codigo'] == '' && !verifica_nivel('laboratorios', 'I'))) {
        $disable = 'disabled';
    }
	$laboratorio = new TLaboratorio();
	if(isset($_POST['Salvar'])) {
		$obrigatorios[1] = 'nomefantasia';
		$i = $j = 0;
		foreach($_POST as $post => $valor) {
			$i++;
			if(array_search($post, $obrigatorios) && $valor == "") {
			    $j++;
				$r[$j] = '<font color="#FF0000">';
			}
		}
		if($j == 0) {
			if($_GET['acao'] == "editar") {
				$laboratorio->LoadLaboratorio($_GET['codigo']);
				$strScrp = "Ajax('laboratorio/gerenciar', 'conteudo', '');";
			}
			$laboratorio->SetDados('nomefantasia', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nomefantasia']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ) );
			$laboratorio->SetDados('cpf', $_POST['cpf']);
			$laboratorio->SetDados('razaosocial', utf8_decode ( htmlspecialchars( utf8_encode($_POST['razaosocial']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('atuacao', utf8_decode ( htmlspecialchars( utf8_encode($_POST['atuacao']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('endereco', utf8_decode ( htmlspecialchars( utf8_encode($_POST['endereco']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('bairro', utf8_decode ( htmlspecialchars( utf8_encode($_POST['bairro']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('cidade', utf8_decode ( htmlspecialchars( utf8_encode($_POST['cidade']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('estado', $_POST['estado']);
			$laboratorio->SetDados('pais', $_POST['pais']);
			$laboratorio->SetDados('cep', $_POST['cep']);
			$laboratorio->SetDados('celular', $_POST['celular']);
			$laboratorio->SetDados('telefone1', $_POST[telefone1]);
			$laboratorio->SetDados('telefone2', $_POST[telefone2]);
			$laboratorio->SetDados('inscricaoestadual', $_POST['inscricaoestadual']);
			$laboratorio->SetDados('website', $_POST['website']);
			$laboratorio->SetDados('email', $_POST['email']);
			$laboratorio->SetDados('nomerepresentante', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nomerepresentante']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('apelidorepresentante', utf8_decode ( htmlspecialchars( utf8_encode($_POST['apelidorepresentante']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$laboratorio->SetDados('emailrepresentante', $_POST['emailrepresentante']);
			$laboratorio->SetDados('celularrepresentante', $_POST['celularrepresentante']);
			$laboratorio->SetDados('telefone1representante', $_POST[telefone1representante]);
			$laboratorio->SetDados('telefone2representante', $_POST[telefone2representante]);
			$laboratorio->SetDados('banco', $_POST['banco']);
			$laboratorio->SetDados('agencia', $_POST['agencia']);
			$laboratorio->SetDados('conta', $_POST['conta']);
			$laboratorio->SetDados('favorecido', $_POST['favorecido']);
			if($_GET['acao'] != "editar") {
				$laboratorio->SalvarNovo();
			}
			$laboratorio->Salvar();
    		$strScrp = "Ajax('laboratorio/gerenciar', 'conteudo', '');";
		}
	}
	if($_GET['acao'] == "editar") {
		$strLoCase = $LANG['laboratory']['editing'];
		$frmActEdt = "?acao=editar&codigo=".$_GET['codigo'];
		$laboratorio->LoadLaboratorio($_GET['codigo']);
		$row = $laboratorio->RetornaTodosDados();
	} else {
		if($j == 0) {
			$row = "";
		} else {
			$row = $_POST;
		}
		$strLoCase = $LANG['laboratory']['including'];
	}
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
?>
<div class="conteudo" id="conteudo_central">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="56%">&nbsp;&nbsp;&nbsp;<img src="laboratorio/img/laboratorio.png" alt="<?php echo $LANG['laboratory']['manage_laboratories']?>"> <span class="h3"><?php echo $LANG['laboratory']['manage_laboratories']?> [<?php echo $strLoCase?>] </span></td>
      <td width="6%" valign="bottom"><a href="#"></a></td>
      <td width="36%" valign="bottom" align="right">&nbsp;</td>
      <td width="2%" valign="bottom">&nbsp;</td>
    </tr>
  </table>
<div class="conteudo" id="table dados"><br>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    <tr>
      <td width="243" height="26"><?php echo $strLoCase.' '.$LANG['laboratory']['laboratory']?> </td>
      <td width="381">&nbsp;</td>
    </tr>
  </table>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form2" name="form2" method="POST" action="laboratorio/incluir_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;"><fieldset>
        <legend><span class="style1"><?php echo $LANG['laboratory']['laboratory_information']?> </span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $r[1]?>* <?php echo $LANG['laboratory']['company']?> <br />
                <label>
                  <input name="nomefantasia" value="<?php echo $row['nomefantasia']?>" <?php echo $disable?> type="text" class="forms" id="nomefantasia" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><?php echo $LANG['laboratory']['document1']?><br />
              <input name="cpf" value="<?php echo $row['cpf']?>" <?php echo $disable?> type="text" class="forms" id="cpf" size="30" maxlength="18" onKeypress="return Ajusta_CPFCNPJ(this, event, document.getElementById('cpf_cnpj').value);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['legal_name']?><br />
              <input name="razaosocial" value="<?php echo $row['razaosocial']?>" <?php echo $disable?> type="text" class="forms" id="razaosocial" size="50" /></td>
            <td><?php echo $LANG['laboratory']['operation_area']?><br />
              <input name="atuacao" value="<?php echo $row['atuacao']?>" <?php echo $disable?> type="text" class="forms" id="atuacao" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['address1']?><br />
              <input name="endereco" value="<?php echo $row['endereco']?>" <?php echo $disable?> type="text" class="forms" id="endereco" size="50" maxlength="150" /></td>
            <td><?php echo $LANG['laboratory']['address2']?><br />
              <input name="bairro" value="<?php echo $row['bairro']?>" <?php echo $disable?> type="text" class="forms" id="bairro" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['city']?><br />
                <input name="cidade" value="<?php echo $row['cidade']?>" <?php echo $disable?> type="text" class="forms" id="cidade" size="30" maxlength="50" />
              <br /></td>
            <td><?php echo $LANG['laboratory']['state']?><br />
                <input name="estado" value="<?php echo $row['estado']?>" <?php echo $disable?> type="text" class="forms" id="estado" maxlength="50" />
            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['country']?><br />
                <input name="pais" value="<?php echo $row['pais']?>" <?php echo $disable?> type="text" class="forms" id="pais" size="30" maxlength="50" />
              <br /></td>
            <td>&nbsp;
            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['zip']?><br />
              <input name="cep" value="<?php echo $row['cep']?>" <?php echo $disable?> type="text" class="forms" id="cep" size="10" maxlength="9" onKeypress="return Ajusta_CEP(this, event);" /></td>
            <td><?php echo $LANG['laboratory']['cellphone']?><br />
              <input name="celular" value="<?php echo $row['celular']?>" <?php echo $disable?> type="text" class="forms" id="celular" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['phone1']?><br />
              <input name="telefone1" value="<?php echo $row[telefone1]?>" <?php echo $disable?> type="text" class="forms" id="telefone1" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
            <td><?php echo $LANG['laboratory']['phone2']?><br />
              <input name="telefone2" value="<?php echo $row[telefone2]?>" <?php echo $disable?> type="text" class="forms" id="telefone2" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['document2']?><br />
              <input name="inscricaoestadual" value="<?php echo $row['inscricaoestadual']?>" <?php echo $disable?> type="text" class="forms" id="ie" size="25" /></td>
            <td><?php echo $LANG['laboratory']['website']?><br />
              <input name="website" value="<?php echo $row['website']?>" <?php echo $disable?> type="text" class="forms" id="site" size="40" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['email']?><br />
              <input name="email" value="<?php echo $row['email']?>" <?php echo $disable?> type="text" class="forms" id="email" size="40" /></td>
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
        <legend><span class="style1"><?php echo $LANG['laboratory']['representative_information_contact_person']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['representative_name_contact_person']?><br />
                <label>
                  <input name="nomerepresentante" value="<?php echo $row['nomerepresentante']?>" <?php echo $disable?> type="text" class="forms" id="nome" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><?php echo $LANG['laboratory']['nickname']?><br />
              <input name="apelidorepresentante" value="<?php echo $row['apelidorepresentante']?>" <?php echo $disable?> type="text" class="forms" id="apelido" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['email']?><br />
                <input name="emailrepresentante" value="<?php echo $row['emailrepresentante']?>" <?php echo $disable?> type="text" class="forms" id="email" size="50" maxlength="100" /></td>
            <td><?php echo $LANG['laboratory']['cellphone']?><br />
                <input name="celularrepresentante" value="<?php echo $row['celularrepresentante']?>" <?php echo $disable?> type="text" class="forms" id="celularrep" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['phone1']?><br />
                <input name="telefone1representante" value="<?php echo $row[telefone1representante]?>" <?php echo $disable?> type="text" class="forms" id="telefonerep" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
            <td><?php echo $LANG['laboratory']['phone2']?><br />
                <input name="telefone2representante" value="<?php echo $row[telefone2representante]?>" <?php echo $disable?> type="text" class="forms" id="telefone1rep" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br />
		<fieldset>
        <legend><span class="style1"><?php echo $LANG['laboratory']['bank_information']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['bank']?> <br />
                <label>
                  <input name="banco1" value="<?php echo $row['banco1']?>" <?php echo $disable?> type="text" class="forms" id="banco1" size="50" maxlength="50" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['agency']?><br />
                <input name="agencia1" value="<?php echo $row['agencia1']?>" <?php echo $disable?> type="text" class="forms" id="agencia1" size="50" maxlength="15" /></td>
            <td><?php echo $LANG['laboratory']['account']?><br />
                <input name="conta1" value="<?php echo $row['conta1']?>" <?php echo $disable?> type="text" class="forms" id="conta1" maxlength="15" /></td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['account_holder']?><br />
                <label>
                  <input name="favorecido1" value="<?php echo $row['favorecido1']?>" <?php echo $disable?> type="text" class="forms" id="favorecido1" size="50" maxlength="50" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['bank']?> <br />
                <label>
                  <input name="banco2" value="<?php echo $row['banco2']?>" <?php echo $disable?> type="text" class="forms" id="banco2" size="50" maxlength="50" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>
          <tr>
            <td><?php echo $LANG['laboratory']['agency']?><br />
                <input name="agencia2" value="<?php echo $row['agencia2']?>" <?php echo $disable?> type="text" class="forms" id="agencia2" size="50" maxlength="15" /></td>
            <td><?php echo $LANG['laboratory']['account']?><br />
                <input name="conta2" value="<?php echo $row['conta2']?>" <?php echo $disable?> type="text" class="forms" id="conta2" maxlength="15" /></td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['account_holder']?><br />
                <label>
                  <input name="favorecido2" value="<?php echo $row['favorecido2']?>" <?php echo $disable?> type="text" class="forms" id="favorecido2" size="50" maxlength="50" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br />
		<fieldset>
        <legend><span class="style1"><?php echo $LANG['laboratory']['comments']?></span></legend>
        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['laboratory']['comments']?> <br />
                  <textarea name="observacoes" <?php echo $disable?> class="forms" id="observacoes" cols="50" rows="8"><?php echo $row['observacoes']?></textarea>
                <br />
                <label></label></td>
            <td width="210"><br />
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
		<br />
        <div align="center"><br />
          <input name="Salvar" type="submit" <?php echo $disable?> class="forms" id="Salvar" value="<?php echo $LANG['laboratory']['save']?>" />
        </div>
      </form>      </td>
    </tr>
  </table>
</div>
<script>
  document.getElementById('nomefantasia').focus();
</script>
