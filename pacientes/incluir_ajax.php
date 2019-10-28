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
	$paciente = new TPacientes();
	if(isset($_POST['Salvar'])) {
        $_POST['tratamento'] = @implode(',', $_POST['tratamento']);
		$obrigatorios[1] = 'codigo';
		$obrigatorios[] = 'nom';
		$i = $j = 0;
		foreach($_POST as $post => $valor) {
			$i++;
			if(array_search($post, $obrigatorios) && $valor == "") {
				$r[$i] = '<font color="#FF0000">';
			    $j++;
			}
		}
		if(!is_valid_codigo($_POST['codigo']) && $_GET['acao'] != "editar") {
			$j++;
			$r[1] = '<font color="#FF0000">';
        }
		if($j === 0) {
			if($_GET['acao'] == "editar") {
				$paciente->LoadPaciente($_POST['codigo']);
				$strScrp = "Ajax('pacientes/gerenciar', 'conteudo', '')";
			}
			$paciente->SetDados('codigo', $_POST['codigo']);
			$paciente->SetDados('nome', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nom']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('cpf', $_POST['cpf']);
			$paciente->SetDados('rg', $_POST['rg']);
			$paciente->SetDados('estadocivil', utf8_decode ( htmlspecialchars( utf8_encode($_POST['estadocivil']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('sexo', $_POST['sexo']);
			$paciente->SetDados('etnia', $_POST['etnia']);
			$paciente->SetDados('profissao', utf8_decode ( htmlspecialchars( utf8_encode($_POST['profissao']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('naturalidade', utf8_decode ( htmlspecialchars( utf8_encode($_POST['naturalidade']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('nacionalidade', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nacionalidade']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('nascimento', converte_data($_POST['nascimento'], 1));
			$paciente->SetDados('endereco', utf8_decode ( htmlspecialchars( utf8_encode($_POST['endereco']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('bairro', utf8_decode ( htmlspecialchars( utf8_encode($_POST['bairro']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('cidade', utf8_decode ( htmlspecialchars( utf8_encode($_POST['cidade']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('estado', $_POST['estado']);
			$paciente->SetDados('pais', utf8_decode ( htmlspecialchars( utf8_encode($_POST['pais']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('falecido', $_POST['falecido']);
			$paciente->SetDados('cep', $_POST['cep']);
			$paciente->SetDados('celular', $_POST['celular']);
			$paciente->SetDados('telefone1', $_POST[telefone1]);
			$paciente->SetDados('telefone2', $_POST[telefone2]);
			$paciente->SetDados('hobby', utf8_decode ( htmlspecialchars( utf8_encode($_POST['hobby']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('indicadopor', utf8_decode ( htmlspecialchars( utf8_encode($_POST['indicadopor']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('email', $_POST['email']);
			$paciente->SetDados('obs_etiqueta', utf8_decode ( htmlspecialchars( utf8_encode($_POST['obs_etiqueta']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('tratamento', $_POST['tratamento']);
			$paciente->SetDados('codigo_dentistaprocurado', $_POST['codigo_dentistaprocurado']);
			$paciente->SetDados('codigo_dentistaatendido', $_POST['codigo_dentistaatendido']);
			$paciente->SetDados('codigo_dentistaencaminhado', $_POST['codigo_dentistaencaminhado']);
			$paciente->SetDados('nomemae', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nomemae']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('nascimentomae', converte_data($_POST['nascimentomae'], 1));
			$paciente->SetDados('profissaomae', utf8_decode ( htmlspecialchars( utf8_encode($_POST['profissaomae']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('nomepai', utf8_decode ( htmlspecialchars( utf8_encode($_POST['nomepai']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('nascimentopai', converte_data($_POST['nascimentopai'], 1));
			$paciente->SetDados('profissaopai', utf8_decode ( htmlspecialchars( utf8_encode($_POST['profissaopai']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('telefone1pais', $_POST[telefone1pais]);
			$paciente->SetDados('telefone2pais', $_POST[telefone2pais]);
			$paciente->SetDados('enderecofamiliar', $_POST['enderecofamiliar']);
			$paciente->SetDados('datacadastro', converte_data($_POST['datacadastro'], 1));
			$paciente->SetDados('dataatualizacao', date(Y.'-'.m.'-'.d));
			$paciente->SetDados('status', $_POST['status']);
			$paciente->SetDados('objetivo', utf8_decode ( htmlspecialchars( utf8_encode($_POST['objetivo']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('observacoes', utf8_decode ( htmlspecialchars( utf8_encode($_POST['observacoes']) , ENT_QUOTES | ENT_COMPAT, 'utf-8') ));
			$paciente->SetDados('codigo_convenio', $_POST['convenio']);
			$paciente->SetDados('outros', $_POST['outros']);
			$paciente->SetDados('matricula', $_POST['matricula']);
			$paciente->SetDados('titular', $_POST['titular']);
			$paciente->SetDados('validadeconvenio', $_POST['validadeconvenio']);
			if($_GET['acao'] != "editar") {
                $paciente->SalvarNovo();
				$objetivo = new TExObjetivo();
				$objetivo->SetDados('codigo_paciente', $_POST['codigo']);
				$objetivo->SalvarNovo();
				$objetivo = new TInquerito();
				$objetivo->SetDados('codigo_paciente', $_POST['codigo']);
				$objetivo->SalvarNovo();
				$objetivo = new TAtestado();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$objetivo = new TReceita();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$objetivo = new TExame();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$objetivo = new TEncaminhamento();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$objetivo = new TLaudo();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$objetivo = new TAgradecimento();
				$objetivo->Codigo_Paciente = $_POST['codigo'];
				$objetivo->SalvarNovo();
				$strScrp = "Ajax('pacientes/gerenciar', 'conteudo', 'codigo=".$_POST['codigo']."&acao=editar')";
			}
			$paciente->Salvar();
		}
	}
	if($_GET['acao'] == "editar") {
		$frmActEdt = "?acao=editar&codigo=".$_GET['codigo'];
		$paciente->LoadPaciente($_GET['codigo']);
		$row = $paciente->RetornaTodosDados();
		$row['nascimento'] = converte_data($row['nascimento'], 2);
		$row['nascimentomae'] = converte_data($row['nascimentomae'], 2);
		$row['nascimentopai'] = converte_data($row['nascimentopai'], 2);
		$row['datacadastro'] = converte_data($row['datacadastro'], 2);
		$strCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
		$strLoCase = $LANG['patients']['editing'];
		$acao = '&acao=editar';
	} else {
		$strCase = $LANG['patients']['including'];
		$strLoCase = $LANG['patients']['including'];
		$row = $_POST;
		$row['nome'] = $_POST['nom'];
		if(!isset($_POST['codigo']) || $j == 0) {
			$row = "";
			$row['codigo'] = $paciente->ProximoCodigo();
		} else {
			$row['codigo'] = $_POST['codigo'];
		}
	}
	if(isset($strScrp)) {
		echo '<scr'.'ipt>'.$strScrp.'</scr'.'ipt>';
		die();	
	}
?>
<link href="../css/smile.css" rel="stylesheet" type="text/css" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> &nbsp;[<?php echo $strCase?>] </span></td>
    </tr>
  </table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    
    <tr>
      <td height="26"><?php echo $strLoCase.' '.$LANG['patients']['patient']?> </td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td width="602">
      <form id="form2" name="form2" method="POST" action="pacientes/incluir_ajax.php<?php echo $frmActEdt?>" onsubmit="formSender(this, 'conteudo'); return false;"><fieldset>
        <legend><?php echo $LANG['patients']['personal_information']?></legend>
        <table width="570" border="0" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $r[1]?>* <?php echo $LANG['patients']['clinical_sheet']?><br />
<?php
	if($_GET['acao'] == "editar") {
?>
              <input disabled value="<?php echo $row['codigo']?>" type="text" class="forms" id="codigo"<?php/* onblur="javascript:foto_frame.location.href='pacientes/fotos.php?codigo='%2Bthis.value"*/?> />
              <input name="codigo" value="<?php echo $row['codigo']?>" type="hidden" class="forms" <?php echo $disable?> id="codigo"<?php/* onblur="javascript:foto_frame.location.href='pacientes/fotos.php?codigo='%2Bthis.value"*/?> />
<?php
    } else {
?>
              <input name="codigo" value="<?php echo $row['codigo']?>" type="text" class="forms" <?php echo $disable?> id="codigo"<?php/* onblur="javascript:foto_frame.location.href='pacientes/fotos.php?codigo='%2Bthis.value"*/?> />
<?php
    }
?>
            </td>
            <td>&nbsp;</td>
            <td width="150" rowspan="13" valign="top"><br />
            <iframe height="300" scrolling="No" width="150" name="foto_frame" id="foto_frame" src="pacientes/fotos.php?codigo=<?php echo $row['codigo']?><?php echo (($_GET['acao'] != "editar")?'&disabled=yes':'')?>" frameborder="0"></iframe>
            </td>
          </tr>
          <tr>
            <td width="290"><?php echo $r[2]?>* <?php echo $LANG['patients']['name']?><br />
                <label>
                  <input name="nom" value="<?php echo $row['nome']?>" type="text" class="forms" <?php echo $disable?> id="nom" size="50" maxlength="80" />
                </label>
                <br />
            <label></label></td>
            <td width="130"><?php echo $r[3]?><?php echo $LANG['patients']['document1']?><br />
              <input name="cpf" value="<?php echo $row['cpf']?>" type="text" class="forms" <?php echo $disable?> id="cpf" maxlength="50" />
            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['document2']?><br />
              <input name="rg" value="<?php echo $row['rg']?>" type="text" class="forms" <?php echo $disable?> id="rg" /></td>
            <td><?php echo $LANG['patients']['relationship_status']?><br /><select name="estadocivil" class="forms" <?php echo $disable?> id="estadocivil">
<?php
	$valores = array('solteiro' => $LANG['patients']['single'], 'casado' => $LANG['patients']['married'], 'divorciado' => $LANG['patients']['divorced'], 'viuvo' => $LANG['patients']['widowed']);
	foreach($valores as $chave => $valor) {
		if($row['estadocivil'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>       
			 </select>            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['gender']?><br />
                <select name="sexo" class="forms" <?php echo $disable?> id="sexo">
<?php
	$valores = array('Masculino' => $LANG['patients']['male'], 'Feminino' => $LANG['patients']['female']);
	foreach($valores as $chave => $valor) {
		if($row['sexo'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>       
			 </select> </td>
            <td><?php echo $LANG['patients']['ethnicity']?><br /><select name="etnia" class="forms" <?php echo $disable?> id="etnia">
<?php
	$valores = array('africano' => $LANG['patients']['african'], 'asiatico' => $LANG['patients']['asian'], 'caucasiano' => $LANG['patients']['caucasian'], 'latino' => $LANG['patients']['latin'], 'orientemedio' => $LANG['patients']['middle_eastern'], 'multietnico' => $LANG['patients']['multi_ethnic']);
	foreach($valores as $chave => $valor) {
		if($row['etnia'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>       
			 </select>            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['profession']?><br />
              <input name="profissao" value="<?php echo $row['profissao']?>" type="text" class="forms" <?php echo $disable?> id="profissao" /></td>
            <td><?php echo $LANG['patients']['naturality']?><br />
              <input name="naturalidade" value="<?php echo $row['naturalidade']?>" type="text" class="forms" <?php echo $disable?> id="naturalidade" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['nationality']?><br />
              <input name="nacionalidade" value="<?php echo $row['nacionalidade']?>" type="text" class="forms" <?php echo $disable?> id="nacionalidade" /></td>
            <td><?php echo $LANG['patients']['birthdate']?><br />
              <input name="nascimento" value="<?php echo $row['nascimento']?>" type="text" class="forms" <?php echo $disable?> id="nascimento" maxlength="10" onKeypress="return Ajusta_Data(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['address1']?><br />
              <input name="endereco" value="<?php echo $row['endereco']?>" type="text" class="forms" <?php echo $disable?> id="endereco" size="50" maxlength="150" /></td>
            <td><?php echo $LANG['patients']['address2']?><br />
              <input name="bairro" value="<?php echo $row['bairro']?>" type="text" class="forms" <?php echo $disable?> id="bairro" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['city']?><br />
                <input name="cidade" value="<?php echo $row['cidade']?>" <?php echo $disable?> type="text" class="forms" <?php echo $disable?> id="cidade" size="30" maxlength="50" />
              <br /></td>
            <td><?php echo $LANG['patients']['state']?><br />
                <input name="estado" value="<?php echo $row['estado']?>" <?php echo $disable?> type="text" class="forms" <?php echo $disable?> id="estado" maxlength="50" />
            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['country']?><br />
                <input name="pais" value="<?php echo $row['pais']?>" <?php echo $disable?> type="text" class="forms" <?php echo $disable?> id="pais" size="30" maxlength="50" />
              <br /></td>
            <td><?php echo $LANG['patients']['dead']?><br /><select name="falecido" class="forms" <?php echo $disable?> id="falecido">
<?php
	$valores = array('N�o' => $LANG['patients']['no'], 'Sim' => $LANG['patients']['yes']);
	foreach($valores as $chave => $valor) {
		if($row['falecido'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>
			 </select>            </td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['zip']?><br />
              <input name="cep" value="<?php echo $row['cep']?>" type="text" class="forms" <?php echo $disable?> id="cep" size="10" maxlength="9" onKeypress="return Ajusta_CEP(this, event);" /></td>
            <td><?php echo $LANG['patients']['cellphone']?><br />
              <input name="celular" value="<?php echo $row['celular']?>" type="text" class="forms" <?php echo $disable?> id="celular" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['residential_phone']?><br />
              <input name="telefone1" value="<?php echo $row[telefone1]?>" type="text" class="forms" <?php echo $disable?> id="telefone1" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
            <td><?php echo $LANG['patients']['comercial_phone']?><br />
              <input name="telefone2" value="<?php echo $row[telefone2]?>" type="text" class="forms" <?php echo $disable?> id="telefone2" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['hobby']?><br />
              <input name="hobby" value="<?php echo $row['hobby']?>" type="text" class="forms" <?php echo $disable?> id="hobby" size="50" /></td>
            <td><?php echo $LANG['patients']['indicated_by']?><br />
              <input name="indicadopor" value="<?php echo $row['indicadopor']?>" type="text" class="forms" <?php echo $disable?> id="indicacao" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['email']?><br />
              <input name="email" value="<?php echo $row['email']?>" type="text" class="forms" <?php echo $disable?> id="email" size="50" /></td>
            <td><?php echo $LANG['patients']['comments_for_label']?> <br />
              <input name="obs_etiqueta" value="<?php echo $row['obs_etiqueta']?>" type="text" class="forms" <?php echo $disable?> id="obs_etiqueta" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br />�<fieldset>
        <legend><span class="style1"><?php echo $LANG['patients']['treatments_to_do']?></span></legend>

        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="tratamento[]" value="Ortodontia" <?php echo ((strpos($row['tratamento'], 'Ortodontia')!== false)?'checked':'')?> type="checkbox" id="tra1" /><label for="tra1"> <?php echo $LANG['patients']['orthodonty']?></label></td>
            <td><input name="tratamento[]" value="Implantodontia" <?php echo ((strpos($row['tratamento'], 'Implantodontia')!== false)?'checked':'')?> type="checkbox" id="tra2" /><label for="tra2"> <?php echo $LANG['patients']['implantodonty']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Dent�stica" <?php echo ((strpos($row['tratamento'], 'Dent�stica')!== false)?'checked':'')?> type="checkbox" id="tra3" /><label for="tra3"> <?php echo $LANG['patients']['dentistic']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Pr�tese" <?php echo ((strpos($row['tratamento'], 'Pr�tese')!== false)?'checked':'')?> type="checkbox" id="tra4" /><label for="tra4"> <?php echo $LANG['patients']['prosthesis']?></label><br /></td>
          </tr>
          <tr>
            <td><input name="tratamento[]" value="Odontopediatria" <?php echo ((strpos($row['tratamento'], 'Odontopediatria')!== false)?'checked':'')?> type="checkbox" id="tra5" /><label for="tra5"> <?php echo $LANG['patients']['odontopediatry']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Cirurgia" <?php echo ((strpos($row['tratamento'], 'Cirurgia')!== false)?'checked':'')?> type="checkbox" id="tra6" /><label for="tra6"> <?php echo $LANG['patients']['surgery']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Endodontia" <?php echo ((strpos($row['tratamento'], 'Endodontia')!== false)?'checked':'')?> type="checkbox" id="tra7" /><label for="tra7"> <?php echo $LANG['patients']['endodonty']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Periodontia" <?php echo ((strpos($row['tratamento'], 'Periodontia')!== false)?'checked':'')?> type="checkbox" id="tra8" /><label for="tra8"> <?php echo $LANG['patients']['periodonty']?></label>&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td><input name="tratamento[]" value="Radiologia" <?php echo ((strpos($row['tratamento'], 'Radiologia')!== false)?'checked':'')?> type="checkbox" id="tra9" /><label for="tra9"> <?php echo $LANG['patients']['radiology']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="DTM" <?php echo ((strpos($row['tratamento'], 'DTM')!== false)?'checked':'')?> type="checkbox" id="tra10" /><label for="tra10"> <?php echo $LANG['patients']['dtm']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Odontogeriatria" <?php echo ((strpos($row['tratamento'], 'Odontogeriatria')!== false)?'checked':'')?> type="checkbox" id="tra11" /><label for="tra11"> <?php echo $LANG['patients']['odontogeriatry']?></label>&nbsp;&nbsp;</td>
            <td><input name="tratamento[]" value="Ortopedia" <?php echo ((strpos($row['tratamento'], 'Ortopedia')!== false)?'checked':'')?> type="checkbox" id="tra12" /><label for="tra12"> <?php echo $LANG['patients']['orthopedy']?></label>&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        �<br />
        <fieldset>
        <legend><span class="style1"><?php echo $LANG['patients']['professional_informations']?></span></legend>

        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="486"><?php echo $LANG['patients']['professional_searched']?><br />
                <label><select name="codigo_dentistaprocurado" class="forms" <?php echo $disable?> id="codigo_dentistaprocurado">
                <option></option>
<?php
	$dentista = new TDentistas();
	$lista = $dentista->ListDentistas();
	for($i = 0; $i < count($lista); $i++) {
		if($row['codigo_dentistaprocurado'] == $lista[$i][codigo]) {
			echo '<option value="'.$lista[$i][codigo].'" selected>'.$lista[$i][titulo].' '.$lista[$i][nome].')</option>';
		} else {
			echo '<option value="'.$lista[$i][codigo].'">'.$lista[$i][titulo].' '.$lista[$i][nome].'</option>';
		}
	}
?>
			 </select>
                </label>
                <br />
                <br />
                <?php echo $LANG['patients']['answered_by']?><br />
                <label><select name="codigo_dentistaatendido" class="forms" <?php echo $disable?> id="codigo_dentistaatendido">
                <option></option>
<?php
	$dentista = new TDentistas();
	$lista = $dentista->ListDentistas();
	for($i = 0; $i < count($lista); $i++) {
		if($row['codigo_dentistaatendido'] == $lista[$i][codigo]) {
			echo '<option value="'.$lista[$i][codigo].'" selected>'.$lista[$i][titulo].' '.$lista[$i][nome].'</option>';
		} else {
			echo '<option value="'.$lista[$i][codigo].'">'.$lista[$i][titulo].' '.$lista[$i][nome].'</option>';
		}
	}
?>
			 </select>
                </label>
                <br />
                <br />
                <?php echo $LANG['patients']['forwarded_to']?><br />
                <label><select name="codigo_dentistaencaminhado" class="forms" <?php echo $disable?> id="codigo_dentistaencaminhado">
                <option></option>
<?php
	$dentista = new TDentistas();
	$lista = $dentista->ListDentistas();
	for($i = 0; $i < count($lista); $i++) {
		if($row['codigo_dentistaencaminhado'] == $lista[$i][codigo]) {
			echo '<option value="'.$lista[$i][codigo].'" selected>'.$lista[$i][titulo].' '.$lista[$i][nome].'</option>';
		} else {
			echo '<option value="'.$lista[$i][codigo].'">'.$lista[$i][titulo].' '.$lista[$i][nome].'</option>';
		}
	}
?>
			 </select>
                </label>
                <br />
            <label></label></td>
            <td width="11">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><br /></td>
          </tr>
        </table>
        </fieldset>
        �<br />
        <fieldset>
        <legend><span class="style1"><?php echo $LANG['patients']['familiar_information']?></span></legend>

        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['father_name']?> <br />
                <input name="nomepai" value="<?php echo $row['nomepai']?>" type="text" class="forms" <?php echo $disable?> id="nomepai" size="50" maxlength="80" /></td>
            <td><?php echo $LANG['patients']['birthdate']?><br />
                <input name="nascimentopai" value="<?php echo $row['nascimentopai']?>" type="text" class="forms" <?php echo $disable?> id="nascimentopai" size="20" maxlength="10" onKeypress="return Ajusta_Data(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['father_profession']?> <br />
                <input name="profissaopai" value="<?php echo $row['profissaopai']?>" type="text" class="forms" <?php echo $disable?> id="profissaopai" size="50" maxlength="80" /></td>
            <td><?php echo $LANG['patients']['telephone']?><br />
                <input name="telefone1pais" value="<?php echo $row[telefone1pais]?>" type="text" class="forms" <?php echo $disable?> id="telefone1pais" size="20" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td width="287"><br /><?php echo $LANG['patients']['mother_name']?><br />
                <label>
                <input name="nomemae" value="<?php echo $row['nomemae']?>" type="text" class="forms" <?php echo $disable?> id="nomemae" size="50" maxlength="80" />
                </label>
                <br />
                <label></label></td>
            <td width="210"><br /><?php echo $LANG['patients']['birthdate']?><br />
                <input name="nascimentomae" value="<?php echo $row['nascimentomae']?>" type="text" class="forms" <?php echo $disable?> id="nascimentomae" size="20" maxlength="10" onKeypress="return Ajusta_Data(this, event);" /></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['mother_profession']?> <br />
                <input name="profissaomae" value="<?php echo $row['profissaomae']?>" type="text" class="forms" <?php echo $disable?> id="profissaomae" size="50" maxlength="80" /></td>
            <td><?php echo $LANG['patients']['telephone']?><br />
                <input name="telefone2pais" value="<?php echo $row[telefone2pais]?>" type="text" class="forms" <?php echo $disable?> id="telefone2pais" size="20" maxlength="13" onKeypress="return Ajusta_Telefone(this, event);" /></td>
          </tr>
          <tr>
            <td colspan="2"><br /><?php echo $LANG['patients']['complete_address_in_case_of_be_different_from_personal']?><br />
                <input name="enderecofamiliar" value="<?php echo $row['enderecofamiliar']?>" type="text" class="forms" <?php echo $disable?> id="endereco_familiar" size="78" maxlength="220" />                <br /></td>
          </tr>
        </table>
        </fieldset>
        <br />
        <fieldset>
        <legend><span class="style1"><?php echo $LANG['patients']['extra_information']?> </span></legend>

        <table width="497" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td width="287"><?php echo $LANG['patients']['record_date']?>  <br />
                <label></label>
<?php
	if($_GET['acao'] == "editar") {
?>
                <input name="datacad" disabled value="<?php echo $row['datacadastro']?>" type="text" class="forms" <?php echo $disable?> id="datacad" size="20" maxlength="10" />
                <input name="datacadastro" value="<?php echo $row['datacadastro']?>" type="hidden" id="datacadastro" />
<?php
	} else {
?>
                <input name="datacadastro" value="<?php echo date(d.'/'.m.'/'.Y)?>" type="text" class="forms" <?php echo $disable?> id="datacadastro" size="20" maxlength="10" onKeypress="return Ajusta_Data(this, event);" />
                <input name="datacad" value="" type="hidden" id="datacad" />
<?php
	}
?>
                <br />
                <br />
                <label></label></td>
            <td width="210"><?php echo $LANG['patients']['last_update']?>  <br />
                <label></label>
                <input name="dataatua" disabled value="<?php echo converte_data($row['dataatualizacao'], 2)?>" type="text" class="forms" <?php echo $disable?> id="dataatua" size="20" />
                <input name="dataatualizacao" value="<?php echo converte_data($row['dataatualizacao'], 2)?>" type="hidden" id="dataatualizacao" />
                <br />
                <br />
                <label></label></td>
          </tr>
          <tr>
            <td width="287"><?php echo $LANG['patients']['patient_status']?> <br />
              <label><select name="status" class="forms" <?php echo $disable?> id="status">
<?php
	$valores = array('1' => $LANG['patients']['evaluation'], '2' => $LANG['patients']['in_treatment'], '3' => $LANG['patients']['in_revision'], '4' => $LANG['patients']['closed']);
	foreach($valores as $chave => $valor) {
		if($row['status'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>       
			 </select> 
              <br />
              <br />
              </label></td>
            <td width="210"></td>
          </tr>
          <tr>
            <td><?php echo $LANG['patients']['main_objective_of_the_consultation']?><br />
              <label>
              <textarea name="objetivo" cols="25" rows="4"><?php echo $row['objetivo']?></textarea>
              </label></td>
            <td><?php echo $LANG['patients']['comments']?><br />
              <label>
              <textarea name="observacoes" cols="25" rows="4"><?php echo $row['observacoes']?></textarea>
              </label></td>
          </tr>
          <tr>
            <td><label></label></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>

        �<fieldset>
        <legend><span class="style1"><?php echo $LANG['patients']['plan_information']?></span></legend>

        <table width="519" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="264"><?php echo $LANG['patients']['select_plan']?><br />
                <select name="convenio" class="forms" <?php echo $disable?> id="convenio">
<?php
	$query1 = mysql_query("SELECT * FROM convenios ORDER BY nomefantasia");
	while($row1 = mysql_fetch_assoc($query1)) {
		if($row['codigo_convenio'] == $row1['codigo']) {
			echo '<option value="'.$row1['codigo'].'" selected>'.$row1['nomefantasia'].'</option>';
		} else {
			echo '<option value="'.$row1['codigo'].'">'.$row1['nomefantasia'].'</option>';
		}
	}
?>       
			 </select> 
              <label><br />
              <br />
              </label></td>
            <td width="255"></td>
          </tr>
          <tr>
            <td><label><?php echo $LANG['patients']['card_number']?><br />
                <input name="matricula" value="<?php echo $row['matricula']?>" type="text" class="forms" <?php echo $disable?> id="matricula" size="20" />
                <br />
              </label></td>
            <td><?php echo $LANG['patients']['holder_name']?><br />
              <input name="titular" value="<?php echo $row['titular']?>" type="text" class="forms" <?php echo $disable?> id="titular" size="40" /></td>
          </tr>
          <tr>
            <td><br /><?php echo $LANG['patients']['good_thru']?> <br />
                <input name="validadeconvenio" value="<?php echo $row['validadeconvenio']?>" type="text" class="forms" <?php echo $disable?> id="validadeconvenio" size="20" />
                <br /></td>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset>	
	
        <div align="center"><br />
          <input name="Salvar" type="submit" class="forms" <?php echo $disable?> id="Salvar" value="<?php echo $LANG['patients']['save']?>" />
        </div>
      </form>      </td>
    </tr>
    <tr>
      <td align="right">
        <img src="imagens/icones/imprimir.gif"> <a href="relatorios/paciente.php?codigo=<?php echo $row['codigo']?>" target="_blank"><?php echo $LANG['patients']['print_sheet']?></a>&nbsp;
      </td>
    </tr>
  </table>
<script>
document.getElementById('nom').focus();
</script>
