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
    if($_GET['confirm_baixa'] == "baixa") {
        mysql_query("UPDATE orcamento SET baixa = '1' WHERE codigo = ".$_GET['codigo_orc']) or die('Line 39: '.mysql_error());
        echo '<script>alert("Parcelas restantes do or�amento canceladas com sucesso!")</script>';
    }
	$acao = '&acao=editar';
	$strLoCase = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'nome').' - '.$_GET['codigo'];
	$codigo_orc = $_GET['codigo_orc'];
	if($_GET['subacao'] != 'editar') {
		$codigo_orc = next_autoindex('orcamento');
		mysql_query("INSERT INTO `orcamento` (`codigo_paciente`, `data`) VALUE ('".$_GET['codigo']."', '".date(Y.'-'.m.'-'.d)."')") or die(mysql_error());
	} else {
        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';
		//Altera��o de procedimentos
		if(is_array($_POST['codigoprocedimento'])) {
			foreach($_POST['codigoprocedimento'] as $codigo => $codigoprocedimento) {
				$dente = $_POST['dente'][$codigo];
				$descricao = $_POST['descricao'][$codigo];
				$particular = $_POST['particular'][$codigo];
				$convenio = $_POST['convenio'][$codigo];
				if(empty($codigoprocedimento) && empty($dente) && empty($descricao) && empty($particular) && empty($convenio)) {
					mysql_query("DELETE FROM `procedimentos_orcamento` WHERE `codigo` = '".$codigo."'") or die(mysql_error());
				} else {
					mysql_query("UPDATE `procedimentos_orcamento` SET `codigoprocedimento` = '".$codigoprocedimento."', `dente` = '".$dente."', `descricao` = '".$descricao."', `particular` = '".$particular."', `convenio` = '".$convenio."' WHERE `codigo` = '".$codigo."' ") or die(mysql_error());
				}
			}
		}
		//Novo procedimento
		if(!empty($_POST['descricao_new'])) {
			if(empty($_POST['particular_new']))
				$_POST['particular_new'] = 0;
			if(empty($_POST['convenio_new']))
				$_POST['convenio_new'] = 0;
			mysql_query("INSERT INTO `procedimentos_orcamento` (`codigo_orcamento`, `codigoprocedimento`, `dente`, `descricao`, `particular`, `convenio`) VALUES ('".$codigo_orc."', '".$_POST['codigoprocedimento_new']."', '".$_POST['dente_new']."', '".$_POST['descricao_new']."', '".$_POST['particular_new']."', '".$_POST['convenio_new']."')") or die(mysql_error());
		}
		$row = mysql_fetch_array(mysql_query("SELECT * FROM `orcamento` WHERE `codigo` = '".$codigo_orc."'"));
		//Atualizando os dados gerais do or�amento
		if(isset($_POST['aserpago'])) {
			if(empty($_POST['desconto']))
				$_POST['desconto'] = 0;
			if(empty($_POST['entrada']))
				$_POST['entrada'] = 0;
			mysql_query("UPDATE `orcamento` SET `aserpago` = '".$_POST['aserpago']."', `valortotal` = '".$_POST['valortotal']."', `formapagamento` = '".$_POST['formapagamento']."', `parcelas` = '".$_POST['parcelas']."', `desconto` = '".$_POST['desconto']."', `codigo_dentista` = '".$_POST['codigo_dentista']."', `entrada` = ".$_POST['entrada'].", `entrada_tipo` = '".$_POST['entrada_tipo']."' WHERE `codigo` = '".$codigo_orc."'") or die('Erro UPDATE orcamento: '.mysql_error());
		}
		//Apagando dados de parcelas
		if(isset($_POST['aserpago']) || isset($_POST['Salvar222'])) {
			mysql_query("DELETE FROM `parcelas_orcamento` WHERE `codigo_orcamento` = '".$codigo_orc."'") or die(mysql_error());
		}
		//Inserindo dados de parcelas
		if(is_array($_POST['datavencimento'])) {
			foreach($_POST['datavencimento'] as $chave => $datavencimento) {
				$valor = $_POST['parcela'][$chave];
				mysql_query("INSERT INTO `parcelas_orcamento` (`codigo_orcamento`, `datavencimento`, `valor`) VALUES ('".$codigo_orc."', '".converte_data($datavencimento, 1)."', '".$valor."')") or die(mysql_error());
			}
		}
		//Confirmando or�amento
		if(isset($_POST['Salvar222']) && isset($_POST['confirmed'])) {
            //var_dump($_POST['confirmed']); die();
    	    mysql_query("UPDATE orcamento SET confirmado = '".$_POST['confirmed']."' WHERE `codigo` = '".$codigo_orc."'") or die('Line 91: '.mysql_error());
        }
		//Recuperando os dados da tabela
		$row = mysql_fetch_array(mysql_query("SELECT * FROM `orcamento` WHERE `codigo` = '".$codigo_orc."'"));
		if(isset($_POST['Salvar222'])) {
            echo "<script>Ajax('pacientes/orcamento', 'conteudo', 'codigo=".$_GET['codigo'].$acao."')</script>"; die();
		}
	}
	if($disable == 'disabled' || $row['confirmado'] == '1') {
        $disable = 'disabled';
	}
?>
<style type="text/css">
<!--
.style4 {color: #FFFFFF}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="conteudo">
    <tr>
      <td width="100%">&nbsp;&nbsp;&nbsp;<img src="pacientes/img/pacientes.png" alt="<?php echo $LANG['patients']['manage_patients']?>"> <span class="h3"><?php echo $LANG['patients']['manage_patients']?> &nbsp;[<?php echo $strLoCase?>] </span></td>
    </tr>
</table>
<div class="conteudo" id="table dados">
<br />
<?php include('submenu.php')?>
<br>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela_titulo">
    
    <tr>
      <td height="26">&nbsp;<?php echo $LANG['patients']['budget_of_the_patient']?> </td>
    </tr>
  </table>
  <table width="610" border="0" align="center" cellpadding="0" cellspacing="0" class="tabela">
    <tr>
      <td>
      <form id="form1" name="form1" method="POST" action="pacientes/orcamentofechar_ajax.php?codigo=<?php echo $_GET['codigo']?>&acao=editar&subacao=editar&codigo_orc=<?php echo $codigo_orc?>" onsubmit="formSender(this, 'conteudo'); return false;"><br /><fieldset>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="12%" bgcolor="#0099CC"><div align="left" class="style4"><?php echo $LANG['patients']['code']?></div></td>
            <td width="13%" bgcolor="#0099CC"><div align="left" class="style4"><?php echo $LANG['patients']['tooth']?></div></td>
            <td width="44%" height="20" bgcolor="#0099CC"><div align="left" class="style4"><?php echo $LANG['patients']['procedure']?> </div></td>
            <td width="16%" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['general']['currency'].' '.$LANG['patients']['private']?> </div></td>
            <td width="15%" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['general']['currency'].' '.$LANG['patients']['plan']?></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
<?php
    $codigo_convenio = encontra_valor('pacientes', 'codigo', $_GET['codigo'], 'codigo_convenio');
	$total_convenio = $total_particular = 0;
	$query1 = mysql_query("SELECT * FROM `procedimentos_orcamento` WHERE `codigo_orcamento` = '".$codigo_orc."'");
	while($row1 = mysql_fetch_array($query1)) {
		$total_convenio += $row1['convenio'];
		$total_particular += $row1['particular'];
?>
          <tr>
            <td>
              <input <?php echo $disable?> name="codigoprocedimento[<?php echo $row1['codigo']?>]" id="codigoprocedimento<?php echo $row1['codigo']?>" value="<?php echo $row1['codigoprocedimento']?>" type="text" class="forms" size="10" />
            </div></td>
            <td>
              <input <?php echo $disable?> name="dente[<?php echo $row1['codigo']?>]" value="<?php echo $row1['dente']?>" type="text" class="forms" size="10" />
            </div></td>
            <td>
                <input <?php echo $disable?> name="descricao[<?php echo $row1['codigo']?>]" id="descricao<?php echo $row1['codigo']?>" value="<?php echo $row1['descricao']?>" type="text" class="forms" size="45"
                onkeyup="searchOrcSuggest(this, 'codigoprocedimento<?php echo $row1['codigo']?>', 'particular<?php echo $row1['codigo']?>', 'convenio<?php echo $row1['codigo']?>', 'search<?php echo $row1['codigo']?>', <?php echo $codigo_convenio?>);"
                autocomplete="off" onfocus="esconde_itens()" /><br />
                <div id='search<?php echo $row1['codigo']?>' name="search" style="position: absolute" align="center"></div>
            </td>
            <td><div align="center">
              <input <?php echo $disable?> name="particular[<?php echo $row1['codigo']?>]" id="particular<?php echo $row1['codigo']?>" value="<?php echo money_form($row1['particular'])?>" type="text" class="forms" size="12" maxlength="10" onKeypress="return Ajusta_Valor(this, event);" />
            </td>
            <td><div align="center">
              <input <?php echo $disable?> name="convenio[<?php echo $row1['codigo']?>]" id="convenio<?php echo $row1['codigo']?>" value="<?php echo money_form($row1['convenio'])?>" type="text" class="forms" size="12" maxlength="10" onKeypress="return Ajusta_Valor(this, event);" />
            </td>
          </tr>
<?php
	}
?>
          <tr>
            <td>
              <input <?php echo $disable?> name="codigoprocedimento_new" id="codigoprocedimento_new" type="text" class="forms" size="10" />
            </div></td>
            <td>
              <input <?php echo $disable?> name="dente_new" id="dente_new" type="text" class="forms" size="10" />
            </div></td>
            <td>
              <input <?php echo $disable?> name="descricao_new" id="descricao_new" type="text" class="forms" size="45"
              onkeyup="searchOrcSuggest(this, 'codigoprocedimento_new', 'particular_new', 'convenio_new', 'search99', <?php echo $codigo_convenio?>);"
              autocomplete="off" onfocus="esconde_itens()" /> <br />
              <div id='search99' name="search" style="position: absolute" align="center">
            </td>
            <td><div align="center">
              <input <?php echo $disable?> name="particular_new" id="particular_new" type="text" class="forms" size="12" maxlength="10" onKeypress="return Ajusta_Valor(this, event);" />
            </div></td>
            <td><div align="center">
              <input <?php echo $disable?> name="convenio_new" id="convenio_new" type="text" class="forms" size="12" maxlength="10" onKeypress="return Ajusta_Valor(this, event);" />
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right"><strong><?php echo $LANG['patients']['total_value']?>: </strong></div></td>
            <td><div align="center"><?php echo $LANG['general']['currency'].' '.money_form($total_particular)?>
            	<input type="hidden" id="total_particular" value="<?php echo money_form($total_particular)?>"></div></td>
            <td><div align="center"><?php echo $LANG['general']['currency'].' '.money_form($total_convenio)?>
            	<input type="hidden" id="total_convenio" value="<?php echo money_form($total_convenio)?>"></div></td>
          </tr>
        </table>
        <div align="right">
          <p>
            <input <?php echo $disable?> name="Salvar2" type="submit" class="forms" value="<?php echo $LANG['patients']['add_update_procedure']?>">
          </p>
        </form>
        <form id="form2" name="form2" method="POST" action="pacientes/orcamentofechar_ajax.php?codigo=<?php echo $_GET['codigo']?>&acao=editar&subacao=editar&codigo_orc=<?php echo $codigo_orc?>" onsubmit="formSender(this, 'conteudo'); return false;"><br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['charge']?></div></td>
              <td width="34%" height="20" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['total_value']?> </div></td>
              <td width="33%" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['payment_method']?> </div></td>
            </tr>
            <tr>
              <td colspan="4"><div align="center" class="style4">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="center"></div></td>
              <td>
                <div align="left">
                  <input <?php echo $disable?> name="aserpago" type="radio" value="1" <?php echo $row['aserpago']=='1'?'checked':''?> onclick="document.getElementById('valortotal').value = document.getElementById('total_particular').value; document.getElementById('valor__total').value = document.getElementById('total_particular').value;" />
                <?php echo $LANG['patients']['private']?>
                <input <?php echo $disable?> name="aserpago" type="radio" value="2" <?php echo $row['aserpago']=='2'?'checked':''?> onclick="document.getElementById('valortotal').value = document.getElementById('total_convenio').value; document.getElementById('valor__total').value = document.getElementById('total_convenio').value;" />
              <?php echo $LANG['patients']['plan']?></div></td>
              <td><div align="center">
                <input <?php echo $disable?> name="valor__total" disabled type="text" value="<?php echo money_form($row['valortotal'])?>" class="forms" id="valor__total" size="15" />
                <input <?php echo $disable?> name="valortotal" type="hidden" value="<?php echo money_form($row['valortotal'])?>" class="forms" id="valortotal" size="15" />
              </div></td>
              <td><div align="right">
                <select <?php echo $disable?> name="formapagamento" class="forms" id="formapagamento">
<?php
	$valores = array('1' => $LANG['patients']['at_sight'], '2' => $LANG['patients']['pre_dated_check'], '3' => $LANG['patients']['promissory'], '4' => $LANG['patients']['credit_card']);
	foreach($valores as $chave => $valor) {
		if($row['formapagamento'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>       
			 </select>
                </div>              </td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="5%">&nbsp;</td>
              <td width="28%"><div align="left"><?php echo $LANG['patients']['number_of_plots']?>:&nbsp;&nbsp;
              <select <?php echo $disable?> name="parcelas" class="forms" id="parcelas">
<?php
	$estados = array();
	for($i = 1; $i <= 50; $i++) {
		array_push($estados, $i);
	}
	foreach($estados as $uf) {
		if($row['parcelas'] == $uf) {
			echo '<option value="'.$uf.'" selected>'.$uf.'</option>';
		} else {
			echo '<option value="'.$uf.'">'.$uf.'</option>';
		}
	}
?>
			 </select></div></td>
              <td height="20" align="center">
                <?php echo $LANG['patients']['first_plot']?>:
              <select <?php echo $disable?> name="entrada_tipo" class="forms" id="entrada_tipo">
<?php
	$valores = array('1' => $LANG['general']['currency'], '2' => '%');
	foreach($valores as $chave => $valor) {
		if($row['entrada_tipo'] == $chave) {
			echo '<option value="'.$chave.'" selected>'.$valor.'</option>';
		} else {
			echo '<option value="'.$chave.'">'.$valor.'</option>';
		}
	}
?>
			 </select>
             <input <?php echo $disable?> type="text" name="entrada" value="<?php echo $row['entrada']?>" class="forms" size="10" onkeypress="return Ajusta_Valor(this, event);">
              </td>
              <td><div align="right"><?php echo $LANG['patients']['discount']?>:
                  <input <?php echo $disable?> name="desconto" type="text" value="<?php echo $row['desconto']?>" class="forms" id="desconto" size="5" onkeypress="return Ajusta_Valor(this, event);" />
              %</div></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div align="center"></div></td>
              <td colspan="2"><div align="left"><?php echo $LANG['patients']['professional']?>:
                  <select <?php echo $disable?> name="codigo_dentista" class="forms">
                    <?php
			$dentista = new TDentistas();
			$lista = $dentista->ListDentistas("SELECT * FROM `dentistas` WHERE `ativo` = 'Sim' ORDER BY `nome` ASC");
			for($i = 0; $i < count($lista); $i++) {
				$nome = explode(' ', $lista[$i][nome]);
				$nome = $nome[0].' '.$nome[count($nome) - 1];
				if($row['codigo_dentista'] == $lista[$i][codigo] || ($row['codigo_dentista'] == "" && $_SESSION['codigo'] == $lista[$i][codigo])) {
					echo '<option value="'.$lista[$i][codigo].'" selected>'.$lista[$i][titulo].' '.$nome.'</option>';
				} else {
					echo '<option value="'.$lista[$i][codigo].'">'.$lista[$i][titulo].' '.$nome.'</option>';
				}
			}
?>
                    </select>
              </div></td>
              <td><div align="right">
                <input <?php echo $disable?> name="Salvar22" type="submit" class="forms" id="Salvar22" value="<?php echo $LANG['patients']['calculate']?>" />&nbsp;
              </div></td>
            </tr>
          </table>
		  <br />
        </form>
        <form id="form3" name="form3" method="POST" action="pacientes/orcamentofechar_ajax.php?codigo=<?php echo $_GET['codigo']?>&acao=editar&subacao=editar&codigo_orc=<?php echo $codigo_orc?>" onsubmit="formSender(this, 'conteudo'); return false;"> &nbsp;<br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['plot']?></div></td>
              <td height="20" bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['date']?></div></td>
              <td bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['status']?></div></td>
              <td bgcolor="#0099CC"><div align="center" class="style4"><?php echo $LANG['patients']['value']?></div></td>
            </tr>
            <tr>
              <td colspan="3"><div align="center" class="style4">&nbsp;</td>
            </tr>
         </div>
<?php
	if(empty($row['parcelas'])) {
		$row['parcelas'] = 1;
	}
	$query1 = mysql_query("SELECT * FROM `parcelas_orcamento` WHERE `codigo_orcamento` = '".$codigo_orc."' ORDER BY `codigo`") or die(mysql_error());
    $parc = $row['parcelas'];
    $total = $row['valortotal'];
    $total_final = 0;
	for($i = 1; $i <= $parc; $i++) {
		$row1 = mysql_fetch_array($query1);
        $valor = $row1['valor'];
        if($row['entrada'] != '' && $row['entrada'] != 0 && $i === 1) {
            $row['parcelas']--;
            $row1['datavencimento'] = date('Y-m-d');
            if($row['entrada_tipo'] == '1') {
                $row['valortotal'] -= $row['entrada'];
                $valor = $row['entrada'];
            } elseif($row['entrada_tipo'] == '2') {
                $row['valortotal'] -= ($row['valortotal']*($row['entrada']/100));
                $valor = $total - $row['valortotal'];
            }
        } else {
            if(empty($row1['valor'])) {
    			$valor = ($row['valortotal']-($total*($row['desconto']/100)))/$row['parcelas'];
    		}
    		if(empty($row1['datavencimento'])) {
    			$row1['datavencimento'] = maismes($row['data'], $i-1);
            }
        }
            if($row1['pago'] != 'Sim' && $disable == 'disabled') {
                //$efetuar = '<input type="submit" class="forms" name="efetuar['.$row1['codigo'].']" value="Efetuar pagamento">';
                $efetuar = '<a href="javascript:Ajax(\'pagamentos/parcelas\', \'conteudo\', \'codigo='.$row1['codigo'].'\')">Efetuar pagamento</a> ';
            } elseif($disable == 'disabled') {
                $efetuar = 'Pagamento j� realizado!';
            }
            $total_final += $valor;

        $st = '';
        if(isset($row1['codigo']) && $row['confirmado'] == '1') {
            if($row['baixa'] == '0') {
                if($row1['pago'] == '1') {
                    $st = $LANG['patients']['paid'];
                } else {
                    $st = '<a href="javascript:Ajax(\'pagamentos/parcelas\', \'conteudo\', \'codigo='.completa_zeros($row1['codigo'], ZEROS).'\')">'.$LANG['patients']['open'].'</a>';
                    if ( $row1['datavencimento'] < date('Y-m-d') && $row1['pago'] != '1' ) {
                        $st .= ' ('.$LANG['patients']['overdue'].')';
                    }
                }
            } else {
                if($row1['pago'] == 1) {
                    $st = $LANG['patients']['paid'].' ('.converte_data($row1['datapgto'], 2).')';
                } else {
                    $st = $LANG['patients']['canceled'];
                }
            }
        }
?>
          <tr>
    		  <td><div align="center"><b><?php echo $LANG['patients']['plot']?> <?php echo $i?></b> <?php echo (($row['confirmado'] == '1')?'('.$LANG['patients']['bill_number'].' '.$row1['codigo'].')':'')?></div></td>
    		  <td><div align="center">
      		    <input <?php echo $disable?> name="datavencimento[<?php echo $i?>]" value="<?php echo (($row1['datavencimento'] == '-00-')?'00/00/0000':converte_data($row1['datavencimento'], 2))?>" type="text" class="forms" size="15" />
    		    </div></td>
    		  <td><div align="center"><?php echo $st?></div></td>
    		  <td><div align="center">
      		   <input <?php echo $disable?> name="parcela[<?php echo $i?>]" value="<?php echo money_form($valor)?>" type="text" class="forms" size="15" />
    		  </div></td>
  			</tr>
<?php
	}
?>
			<tr>
			  <td colspan="2">&nbsp;
			    
			  </td>
			</tr>
  			<tr>
              <td align="left"><input <?php echo $disable?> type="checkbox" <?php echo (($row['confirmado'] == '1')?'checked':'')?> name="confirmed" id="confirmed" value="1"><label for="confirmed"> <?php echo $LANG['patients']['confirmed_budget']?></label></td>
    		  <td align="right"><strong><?php echo $LANG['patients']['final_value']?>:</strong></td>
    		  <td><div align="center">
      		    <font size="2"><b><?php echo $LANG['general']['currency'].' '.money_form($total_final)?></b>
    		    </div></td>
  			</tr>
		</table>
        <br />
        <div align="center">
          <p>
            <input <?php echo $disable?> name="Salvar222" type="submit" class="forms" value="<?php echo $LANG['patients']['save_budget']?>" />
          </p>

      </form>
<table width="100%" align="center">
  <tr>
    <td width="33%" align="center">
      <a href="relatorios/orcamento.php?codigo=<?php echo $codigo_orc?>" target="_blank"><?php echo $LANG['patients']['print_budget']?></a>
    </td>
<?php
    if($disable == 'disabled') {
        if($row['baixa'] == '0') {
            if(!checknivel('Dentista')) {
?>
    <td width="33%" align="center">
      <a href="javascript:;" onclick="if(confirm('<?php echo $LANG['patients']['are_you_sure_you_want_to_cancel_this_budget']?>')) { javascript:Ajax('pacientes/orcamentofechar', 'conteudo', 'codigo=<?php echo $_GET['codigo']?>&indice_orc=<?php echo ($i+1)?>&acao=editar&subacao=editar&codigo_orc=<?php echo $row['codigo']?>&confirm_baixa=baixa') }"><?php echo $LANG['patients']['cancel_budget']?></a>
    </td>
<?php
            }
?>
    <td width="34%" align="center">
      <a href="relatorios/boleto.php?codigo=<?php echo $codigo_orc?>" target="_blank"><?php echo $LANG['patients']['print_billing_codes']?></a>
    </td>
<?php
        }
    }
?>
  </tr>
</table>
        </div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
      </fieldset>
<script>
document.getElementById('descricao_new').focus();
</script>
