# 1.0
ALTER TABLE `pacientes` ADD `tratamento` SET( 'Ortodontia', 'Implantodontia', 'Dent�stica', 'Pr�tese', 'Odontopediatria', 'Cirurgia', 'Endodontia', 'Periodontia', 'Radiologia', 'DTM', 'Odontogeriatria', 'Ortopedia' ) NULL DEFAULT NULL AFTER `obs_etiqueta` ;
ALTER TABLE `parcelas_orcamento` ADD `datapgto` DATE NULL DEFAULT NULL;
ALTER TABLE `dentistas` CHANGE `cro` `conselho_numero` VARCHAR(30) NULL DEFAULT NULL;
ALTER TABLE `dentistas` ADD `conselho_tipo` ENUM( 'CRO', 'CRM', 'CRFa', 'CREFITO', 'CRP' ) NULL DEFAULT NULL AFTER `codigo_areaatuacao3`;
ALTER TABLE `dentistas` ADD `conselho_estado` ENUM( 'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO' ) NULL DEFAULT NULL AFTER `conselho_tipo`;
ALTER TABLE `orcamento` ADD `baixa` ENUM( 'Sim', 'N�o' ) NOT NULL DEFAULT 'N�o';
ALTER TABLE `pacientes` CHANGE `validadeconvenio` `validadeconvenio` VARCHAR( 25 ) NULL DEFAULT NULL;
ALTER TABLE `pacientes` CHANGE `convenio` `convenio` ENUM( 'Rede SmilePrev', 'Particular', 'Outros' ) NULL DEFAULT NULL;
ALTER TABLE `orcamento` CHANGE `formapagamento` `formapagamento` ENUM( '� vista', 'Cheque pr�-datado', 'Promiss�ria', 'Desconto em folha', 'Cart�o' ) NULL DEFAULT NULL;
UPDATE `pacientes` SET `tratamento` = '' WHERE `tratamento` IS NULL;

DROP VIEW `v_orcamento`;
CREATE VIEW v_orcamento AS (SELECT tpo.codigo_orcamento AS codigo_orcamento, tor.parcelas AS parcelas, tor.confirmado AS confirmado, tor.baixa AS baixa, tpo.codigo AS codigo_parcela, tpo.datavencimento AS data, tpo.valor AS valor, tpo.pago AS pago, tpo.datapgto AS datapgto, tp.codigo AS codigo_paciente, tp.nome AS paciente, td.nome AS dentista, td.sexo AS sexo_dentista FROM parcelas_orcamento tpo INNER JOIN orcamento tor ON tpo.codigo_orcamento = tor.codigo INNER JOIN pacientes tp ON tor.codigo_paciente = tp.codigo JOIN dentistas td ON tor.cpf_dentista = td.cpf );

CREATE TABLE `gerenciador`.`encaminhamentos` (
`encaminhamento` TEXT NULL DEFAULT NULL ,
`codigo_paciente` INT NOT NULL ,
PRIMARY KEY ( `codigo_paciente` )
);
CREATE TABLE `gerenciador`.`laudos` (
`laudo` TEXT NULL DEFAULT NULL ,
`codigo_paciente` INT NOT NULL ,
PRIMARY KEY ( `codigo_paciente` )
);
CREATE TABLE `gerenciador`.`agradecimentos` (
`agradecimento` TEXT NULL DEFAULT NULL ,
`codigo_paciente` INT NOT NULL ,
PRIMARY KEY ( `codigo_paciente` )
);
CREATE TABLE IF NOT EXISTS `ortodontia` (
`codigo_paciente` int(10) NOT NULL,
`tratamento` enum('Sim','N�o') default NULL,
`previsao` varchar(200) default NULL,
`razoes` varchar(200) default NULL,
`motivacao` varchar(200) default NULL,
`perfil` varchar(200) default NULL,
`simetria` varchar(200) default NULL,
`tipologia` varchar(200) default NULL,
`classe` varchar(200) default NULL,
`mordida` varchar(200) default NULL,
`spee` varchar(200) default NULL,
`overbite` varchar(200) default NULL,
`overjet` varchar(200) default NULL,
`media` varchar(200) default NULL,
`atm` varchar(200) default NULL,
`radio` text default NULL,
`modelo` text default NULL,
`observacoes` text default NULL,
PRIMARY KEY  (`codigo_paciente`)
);
CREATE TABLE IF NOT EXISTS `implantodontia` (
`codigo_paciente` int(10) NOT NULL,
`tratamento` enum('Sim','N�o') default NULL,
`regioes` varchar(200) default NULL,
`expectativa` varchar(200) default NULL,
`areas` varchar(200) default NULL,
`marca` varchar(200) default NULL,
`enxerto` enum('Sim','N�o') default NULL,
`tipoenxerto` varchar(200) default NULL,
`observacoes` text default NULL,
PRIMARY KEY  (`codigo_paciente`)
);
CREATE TABLE `honorarios` (
`codigo` varchar(10) NOT NULL default '',
`procedimento` varchar(200) NULL default NULL,
`valor_particular` float NULL default '0',
`valor_convenio` float NULL default '0',
PRIMARY KEY  (`codigo`)
);
CREATE TABLE `odontograma` (
`codigo_paciente` INT NOT NULL ,
`dente` INT(2) NULL DEFAULT NULL ,
`descricao` VARCHAR(100) NULL DEFAULT NULL ,
PRIMARY KEY ( `codigo_paciente` , `dente` )
);

INSERT INTO `honorarios` VALUES('EX001', 'Consulta inicial: exame cl�nico e plano de tratamento', 61, 0);
INSERT INTO `honorarios` VALUES('EX002', 'Urg�ncia: noturna, s�bado, domingos e feriados', 116, 45);
INSERT INTO `honorarios` VALUES('EX003', 'Avalia��o t�cnica: per�cia inicial ou final', 45, 0);
INSERT INTO `honorarios` VALUES('EX004', 'Falta a consulta', 49, 30);
INSERT INTO `honorarios` VALUES('DE001', 'Restaura��o de Am�lgama - 1 Face', 52, 35);
INSERT INTO `honorarios` VALUES('DE002', 'Restaura��o de Am�lgama - 2 Face', 66, 40);
INSERT INTO `honorarios` VALUES('DE003', 'Restaura��o de Am�lgama - 3 Faces', 77, 45);
INSERT INTO `honorarios` VALUES('DE005', 'Restaura��o de Am�lgama - Pim', 100, 60);
INSERT INTO `honorarios` VALUES('DE004', 'Restaura��o  de alm�lgama - 4 Faces', 77.5, 50);
INSERT INTO `honorarios` VALUES('DE006', 'Restaura��o Resina Folopolimeriz�vel - 1 Face', 63, 40);
INSERT INTO `honorarios` VALUES('DE007', 'Restaura��o Resina Fotopolimeriz�vel - 2 Face', 66, 50);
INSERT INTO `honorarios` VALUES('DE009', 'Restaura�ao Resina Fotopolimeriz�vel - 4 Face', 100, 65);
INSERT INTO `honorarios` VALUES('DE010', 'Faceta em Resina Fotopolimeriz�vel', 110, 85);
INSERT INTO `honorarios` VALUES('DE011', 'N�cleo de Preenchimento em Ion�mero de Viddro', 63, 35);
INSERT INTO `honorarios` VALUES('DE012', 'N�cleo de Preenchimento em Resina Folopolimeriz�vel', 80, 40);
INSERT INTO `honorarios` VALUES('DE014', 'N�cleo de Preenchimento em Alm�lgama', 80, 45);
INSERT INTO `honorarios` VALUES('DE016', 'Pino de Reten��o Intradicular', 171, 70);
INSERT INTO `honorarios` VALUES('DE017', 'Clareamento de Dente Vitalizado ( por Elemento )', 40, 35);
INSERT INTO `honorarios` VALUES('DE018', 'Restaura��o Inlay e Onlay (Arglas-Solidex)', 426, 250);
INSERT INTO `honorarios` VALUES('DE019', 'Clareamento  de Dente Vitalizado e Desvitalizado com Moldeiras de Uso Caseiro (por arcada)', 268, 150);
INSERT INTO `honorarios` VALUES('DE020', 'Restaura��o Met�lica Fundida', 219, 140);
INSERT INTO `honorarios` VALUES('DE021', 'Restaura��o Tempor�ria', 46, 35);
INSERT INTO `honorarios` VALUES('EN002', 'Tratamento Endod�ntico Pr�-Molares (n�o inclue radiografias)', 220, 180);
INSERT INTO `honorarios` VALUES('EN003', 'Tratamento Endod�ntico Molar (n�o inclue radiografias)', 350, 260);
INSERT INTO `honorarios` VALUES('EN004', 'Retratamento Endod�ntico Incisivo ou Canino (n�o inclue radiografias)', 203, 160);
INSERT INTO `honorarios` VALUES('EN005', 'Retratamento Endod�ntico Pr�- Molar (n�o inclue radiografias)', 270, 210);
INSERT INTO `honorarios` VALUES('EN001', 'Tratamento Endod�ntico Incisivo ou Canino (n�o inclue radiografias)', 188, 140);
INSERT INTO `honorarios` VALUES('DE022', 'Clareamento Dental em Consult�rio - T�cnica com per�xido de carbamida a 35% - Dente Unit�rio', 189, 110);
INSERT INTO `honorarios` VALUES('OD001', 'Aplica��o T�pica de Fl�or-Verniz ( quatro hemiarcadas )', 35.26, 30);
INSERT INTO `honorarios` VALUES('OD002', 'Aplica��o de Salante ( por elemento)', 35, 30);
INSERT INTO `honorarios` VALUES('OD003', 'Aplica��o de Salante- T�orica Invasiva (por elemento)', 42, 35);
INSERT INTO `honorarios` VALUES('OD004', 'Aplica��o Cariost�tico 1 Sess�o ( quatro hemiarcadas)', 32, 20);
INSERT INTO `honorarios` VALUES('DE015', 'Ajuste Oclusal ( por sess�o )', 64, 45);
INSERT INTO `honorarios` VALUES('DE008', 'Restaura�ao Resina Fotopolimeriz�vel - 3 Face', 94, 55);
INSERT INTO `honorarios` VALUES('DE013', 'Restaura��o Inlay Onlay de Porcelana', 450, 360);
INSERT INTO `honorarios` VALUES('EN006', 'Retratamento do Molar (n�o inclue radiografias)', 470, 320);
INSERT INTO `honorarios` VALUES('EN008', 'Remo��o de N�cleo Intrarradicular (por elemento) (n�o inclue radiografias)', 114, 70);
INSERT INTO `honorarios` VALUES('EN009', 'Capeamento Pulpar (excluindo restaura��o final)', 68, 35);
INSERT INTO `honorarios` VALUES('EN010', 'Pulpotomia', 79, 40);
INSERT INTO `honorarios` VALUES('EN011', 'Clareamento Dental em consult�rio-T�cnica com per�xido de carbamida a 35% por d', 189, 110);
INSERT INTO `honorarios` VALUES('EN012', 'Preparo para N�cleo Intrarradicular', 52, 35);
INSERT INTO `honorarios` VALUES('EN014', 'Urg�ncia Endod�ntico Pulpectoma (Indenpente da sequ�ncia do tratamento)', 83, 35);
INSERT INTO `honorarios` VALUES('EN015', 'Apicectomia de Caninos ou Incisivos (n�o inclue radiografias)', 177, 140);
INSERT INTO `honorarios` VALUES('EN016', 'Apicectomia de Caninos -Incisivos com Obtura��o Retrograda (n�o inclue radiografias)', 202, 180);
INSERT INTO `honorarios` VALUES('EN013', 'Tratamento de Dentes Rizog�nese Incompleta (por sess�o)', 78, 40);
INSERT INTO `honorarios` VALUES('EN007', 'Tratademento de Perfura��o (n�o inclue radiografias)', 130, 70);
INSERT INTO `honorarios` VALUES('EN017', 'Apicectomia Pr�-Molares (n�o inclue radiografias)', 209, 155);
INSERT INTO `honorarios` VALUES('EN018', 'Apicectomia Pr�-Molares com obtura��o retrograda (n�o inclue radiografias)', 236, 170);
INSERT INTO `honorarios` VALUES('EN019', 'Apicectomia de Molares (n�o inclue radiografias)', 242, 190);
INSERT INTO `honorarios` VALUES('EN020', 'Apicectomia de Molares com obtura��o retrogada (n�o inclue radiografias)', 269, 220);
INSERT INTO `honorarios` VALUES('EN021', 'Remo��o de Corpo estranho intracanal por conduto', 89, 40);
INSERT INTO `honorarios` VALUES('EN022', 'Curativo de demora', 102, 40);
INSERT INTO `honorarios` VALUES('EN023', 'Reembasamento provis�rio', 34, 20);
INSERT INTO `honorarios` VALUES('EN024', 'Restaura��o Tempor�ria', 46, 30);
INSERT INTO `honorarios` VALUES('OD005', 'Remineraliza��o- Fluorterapia (quatro sess�es)', 35, 30);
INSERT INTO `honorarios` VALUES('OD006', 'Adequa��o do Meio Bucal com I�nomero de Vidro (por hemiarcada)', 66, 35);
INSERT INTO `honorarios` VALUES('OD007', 'Adequa��o do Meio Bucal com IRM (por hemiarcada)', 65, 30);
INSERT INTO `honorarios` VALUES('OD008', 'Restaura��o a I�nomero de vidro (1 face)', 59, 35);
INSERT INTO `honorarios` VALUES('OD009', 'Restaura�o Preventiva (i�nomero + selante)', 60, 35);
INSERT INTO `honorarios` VALUES('OD011', 'Pulpotomia', 78, 40);
INSERT INTO `honorarios` VALUES('OD012', 'Tratamento Endod�ntico em Decidios (n�o inclue as radiografias)', 142, 90);
INSERT INTO `honorarios` VALUES('OD013', 'Exdontia de Dentes Dec�dios', 44, 30);
INSERT INTO `honorarios` VALUES('OD014', 'Mantenedor de Espa�o', 208, 80);
INSERT INTO `honorarios` VALUES('OD015', 'Placa de Mordida', 174, 70);
INSERT INTO `honorarios` VALUES('OD017', 'Condicionamento Odontopediatria (por sess�o)', 47, 30);
INSERT INTO `honorarios` VALUES('OD018', 'Ulotomia', 72, 35);
INSERT INTO `honorarios` VALUES('OD019', 'Utlectomia', 78, 40);
INSERT INTO `honorarios` VALUES('OD020', 'Restaura��o Tempor�ria', 46, 35);
INSERT INTO `honorarios` VALUES('OD010', 'Coroa de A�o', 125, 60);
INSERT INTO `honorarios` VALUES('OD016', 'Plano Inclinado', 176, 80);
INSERT INTO `honorarios` VALUES('PE001', 'Tratamento N�o Cir�rgico da Periodontite Leve (por segmento) Baixo Risco', 67, 40);
INSERT INTO `honorarios` VALUES('PE002', 'Tratamento N�o Cir�rgico da Periodontite Moderado  (Por Segmento) M�dio Risco', 78, 45);
INSERT INTO `honorarios` VALUES('PE003', 'Tramento N�o Cir�rgico da Periodontite Grave (Por Segmento) Alto Risco', 90, 50);
INSERT INTO `honorarios` VALUES('PE004', 'Tratamento de Processo Agudo (por sess�o)', 80, 40);
INSERT INTO `honorarios` VALUES('PE005', 'Controle de Placa Bacteriana (por sess�o)', 32, 20);
INSERT INTO `honorarios` VALUES('PE006', 'Dessensiliza��o Dent�ria (por segmento)', 40, 25);
INSERT INTO `honorarios` VALUES('PE007', 'Imobiliza��o Dent�ria Com Resina Fotopolimeriz�vel (dentes)', 111, 60);
INSERT INTO `honorarios` VALUES('PE008', 'Ajuste Oclusal ( por sess�o )', 64, 45);
INSERT INTO `honorarios` VALUES('PE010', 'Placa de  Mordida Miorelaxante', 177, 120);
INSERT INTO `honorarios` VALUES('PE011', 'Proserva��o Pr�-Cir�rgia (por segmento)', 61, 30);
INSERT INTO `honorarios` VALUES('PE012', 'Gegivectomia (por segmento)', 140, 70);
INSERT INTO `honorarios` VALUES('PE013', 'Cir�rgia Retalho ( por segmento)', 150, 100);
INSERT INTO `honorarios` VALUES('PE014', 'Sepultamento Radicular (por raiz)', 148, 100);
INSERT INTO `honorarios` VALUES('PE015', 'Cunha distal', 139, 80);
INSERT INTO `honorarios` VALUES('PE016', 'Extens�o de Vest�bulo (por Segmento)', 154, 80);
INSERT INTO `honorarios` VALUES('PE017', 'Enxerto Pediculado (por segmento)', 147, 90);
INSERT INTO `honorarios` VALUES('PE018', 'Enxerto Livre ( por segmento)', 175, 100);
INSERT INTO `honorarios` VALUES('PE019', 'Enxerto Conjuntivo Subepitelial', 175, 100);
INSERT INTO `honorarios` VALUES('PE020', 'Frenectomia ou  Bridectomia', 126, 90);
INSERT INTO `honorarios` VALUES('PE021', 'Odonto-Sess�o ( por elemento)', 143, 80);
INSERT INTO `honorarios` VALUES('PE022', 'Amputa��o Radicular Sem Obtura��o Retrograda- por Raiz', 179, 110);
INSERT INTO `honorarios` VALUES('PE023', 'Amputa��o Radicular Com Obtura��o Retrograda- por Raiz', 205, 140);
INSERT INTO `honorarios` VALUES('PE025', 'Tratamento Periodico de Manuten��o para periodontite leve de 6 em 6 meses', 159, 80);
INSERT INTO `honorarios` VALUES('PE026', 'Tratamento Periodico de Manuten��o para periodontite leve de 4 em 4 meses', 159, 80);
INSERT INTO `honorarios` VALUES('PE027', 'Tratamento Periodico de Manuten��o para periodontite leve de 2 em 2 meses', 159, 80);
INSERT INTO `honorarios` VALUES('PR001', 'Profilaxia: Pol. Coron. (4 hemiarcadas) e Apl. de Jato de Bicarbonato - Tartarec', 56, 40);
INSERT INTO `honorarios` VALUES('PR002', 'Aplica��o de Jato de Bicabornato', 80, 40);
INSERT INTO `honorarios` VALUES('PR003', 'Or. de Higiene Bucal.:c�rie d.,doen. period.,c�ncer b.,manut. de pr�tese.,uso de dentif. e enxaguat.', 40, 30);
INSERT INTO `honorarios` VALUES('PR004', 'Aplica��o T�pica de Fl�or (excluindo profilaxia )', 40, 30);
INSERT INTO `honorarios` VALUES('PR005', 'Controle de Placa Bacteriana ( por sess�o )', 32, 15);
INSERT INTO `honorarios` VALUES('PR006', 'Tratamento de Gengivite-Terap�utica b�sica ( duas hemiarcadas)', 74, 40);
INSERT INTO `honorarios` VALUES('TE001', 'Teste de Risco de C�rie', 40, 30);
INSERT INTO `honorarios` VALUES('TE002', 'Ph', 40, 30);
INSERT INTO `honorarios` VALUES('TE003', 'Capacidade Tamp�o', 40, 30);
INSERT INTO `honorarios` VALUES('TE004', 'Fluxo Salivar', 40, 30);
INSERT INTO `honorarios` VALUES('TE005', 'Bi�psia de Les�es Sugestivas (Acrescentar os Honor�rios do Laborat�rio)', 230, 110);
INSERT INTO `honorarios` VALUES('TE006', 'Citologia Esfoliativa (acrescentar honor�rios do laborat�rio)', 200, 90);
INSERT INTO `honorarios` VALUES('RA001', 'Periapical', 10, 7);
INSERT INTO `honorarios` VALUES('RA002', 'Interproximal ( Bite-Wing )', 10, 7);
INSERT INTO `honorarios` VALUES('RA003', 'Oclusal', 23, 15);
INSERT INTO `honorarios` VALUES('RA004', 'RX Postero Anterior', 51, 30);
INSERT INTO `honorarios` VALUES('RA005', 'RX da ATM S�rie Completa ( tr�s incid�ncias )', 98, 50);
INSERT INTO `honorarios` VALUES('RA006', 'Panor�mica', 46, 30);
INSERT INTO `honorarios` VALUES('RA007', 'Telerradiografia com Tra�ado Computadorizado', 62, 40);
INSERT INTO `honorarios` VALUES('RA008', 'Telerradiografia sem Tra�ados Computadorizado', 51, 30);
INSERT INTO `honorarios` VALUES('RA009', 'RX de M�o ( Carpal )', 56, 30);
INSERT INTO `honorarios` VALUES('RA010', 'Modelos Ortod�nticos (par)', 54, 25);
INSERT INTO `honorarios` VALUES('RA011', 'Slides ( unidade )', 10, 7);
INSERT INTO `honorarios` VALUES('RA012', 'Fotografia ( unidade )', 10, 6);
INSERT INTO `honorarios` VALUES('PO023', 'Pr�tese Fixa Adesiva Direta (por elemento)', 189, 100);
INSERT INTO `honorarios` VALUES('PO001', 'Planejamento em Pr�tese-modelo de est. par. montagem em articul. semi ajust�vel', 85, 40);
INSERT INTO `honorarios` VALUES('PO002', 'Enceramento de Diagn�stico (por elemento)', 92, 50);
INSERT INTO `honorarios` VALUES('PO003', 'Ajuste Oclusal(por sess�o)', 64, 45);
INSERT INTO `honorarios` VALUES('PO004', 'Restaura��o Met�lica Fundida', 219, 140);
INSERT INTO `honorarios` VALUES('PO005', 'Restaura��o Inlay e Onlay de Porcelana', 440, 400);
INSERT INTO `honorarios` VALUES('PO006', 'Remo��o de Restaura��es Met�licas ou Coroas', 39, 20);
INSERT INTO `honorarios` VALUES('PO007', 'Recoloca��o de Restaura��o Met�lica Fundida ou Coras', 50, 35);
INSERT INTO `honorarios` VALUES('PO008', 'N�cleo Met�lico Fundido', 154, 70);
INSERT INTO `honorarios` VALUES('PO009', 'Coroa Provis�ria em Dente de Estoque', 86, 45);
INSERT INTO `honorarios` VALUES('PO010', 'Coroa Provis�ria Prensada em Acr�lico no Laborat�rio', 176, 90);
INSERT INTO `honorarios` VALUES('PO011', 'Reembasamento Provis�rio', 34, 20);
INSERT INTO `honorarios` VALUES('PO012', 'Coroa de Jaqueta Acr�lica', 215, 100);
INSERT INTO `honorarios` VALUES('PO013', 'Coroa de Porcelana  Pura', 508, 410);
INSERT INTO `honorarios` VALUES('PO014', 'Coroa Metalo Cer�mica', 448, 350);
INSERT INTO `honorarios` VALUES('PO016', 'Coroa de Venner', 363, 170);
INSERT INTO `honorarios` VALUES('PO017', 'Coroa Total Met�lica', 256, 150);
INSERT INTO `honorarios` VALUES('PO018', 'Coroa 3/4 ou 4/5', 252, 150);
INSERT INTO `honorarios` VALUES('PO019', 'Faceta Laminada de Porcelana', 441, 400);
INSERT INTO `honorarios` VALUES('PO020', 'Pr�tese Fixa em Metalo Cer�mica(por elemento)', 602, 350);
INSERT INTO `honorarios` VALUES('PO021', 'Pr�tese Fixa em Metalo P�stica(por elemento)', 459, 200);
INSERT INTO `honorarios` VALUES('PO025', 'Pr�tese Fixa Adesiva Indireta em Metalo Pl�stica(3 elementos)', 578, 310);
INSERT INTO `honorarios` VALUES('PO024', 'Pr�tese Fixa  Adesiva Indireta em Metalo Cer�mica(3 elementos)', 808, 630);
INSERT INTO `honorarios` VALUES('PO026', 'Pr�tese Parcial Remov�vel Provis�ria em Acr�lico ou sem Grampos', 427, 180);
INSERT INTO `honorarios` VALUES('PO027', 'Pr�tese Parcial Remov�vel com grampos Bilateral', 751, 360);
INSERT INTO `honorarios` VALUES('PO028', 'Pr�tese Parcial Remov�vel para Encaixes', 1013, 650);
INSERT INTO `honorarios` VALUES('PO029', 'Encaixe F�mea (por elemento)', 432, 290);
INSERT INTO `honorarios` VALUES('PO030', 'Encaixe Macho(por elemento)', 432, 290);
INSERT INTO `honorarios` VALUES('PO031', 'Reembasamento de Pr�tese Total ou Parcial', 221, 110);
INSERT INTO `honorarios` VALUES('PO032', 'Pr�tese Total', 962, 290);
INSERT INTO `honorarios` VALUES('PO033', 'Pr�tese Total Caracterizada', 1205, 350);
INSERT INTO `honorarios` VALUES('PO034', 'Pr�tese Total Imediata', 618, 230);
INSERT INTO `honorarios` VALUES('PO035', 'Casquete de Moldagem', 71, 40);
INSERT INTO `honorarios` VALUES('PO036', 'Ponto de solda', 151, 90);
INSERT INTO `honorarios` VALUES('PO037', 'Guia Cir�rgico para Pr�tese Imediata ou para Cirurgia de Implante', 215, 120);
INSERT INTO `honorarios` VALUES('PO038', 'Placa de Mordida Miorrelaxante', 170, 140);
INSERT INTO `honorarios` VALUES('PO040', 'Jig ou Front Plat�', 84, 50);
INSERT INTO `honorarios` VALUES('PO041', 'Conserto em Pr�tese Total ou Parcial', 127, 45);
INSERT INTO `honorarios` VALUES('PO042', 'Reparo ou substitui��o de dentes em Pr�tese total ou Parcial', 61, 40);
INSERT INTO `honorarios` VALUES('PO043', 'Clareamento Dental consult�rio-T�cnica com Per�xido de carbamida e 35%(Por Elemento)', 189, 110);
INSERT INTO `honorarios` VALUES('PO044', 'Claream. Dent. com Moldeira de uso cas. para Dentes Vital. e Desvit.(por arcada)', 268, 150);
INSERT INTO `honorarios` VALUES('PO045', 'Restaura��o Inlay e Onlay(Artglas/Solidex)', 426, 250);
INSERT INTO `honorarios` VALUES('PO046', 'Pr�tese Fixa em Metalo(Artglas/Solidex)(Por Elemento)', 430, 250);
INSERT INTO `honorarios` VALUES('PO047', 'Pr�tese Fixa Adesiva Indireta em Metalo(Artglas/Solidex)(3 elementos)', 580, 450);
INSERT INTO `honorarios` VALUES('PO048', 'Restaura��o Tempor�ria', 46, 35);
INSERT INTO `honorarios` VALUES('OR001', 'Aparelho Ortod�ntico Fixo Met�lico - 1 arcada', 368, 0);
INSERT INTO `honorarios` VALUES('OR002', 'Aparelho Ortod�ntico Fixo Est�tico (POLICARBOXILATO) :: 1 arcada', 580, 300);
INSERT INTO `honorarios` VALUES('OR003', 'Manuten��o de Ap. Ortod�ntico :: 20% � 30% Sal�rio M�nimo :: Apresenta��o em 22% Sal�rio', 120, 77);
INSERT INTO `honorarios` VALUES('OR004', 'Placa L�bio Ativa', 190, 120);
INSERT INTO `honorarios` VALUES('OR005', 'Aparelho Extra Bucal', 247, 130);
INSERT INTO `honorarios` VALUES('OR006', 'Arco Lingual', 217, 120);
INSERT INTO `honorarios` VALUES('OR007', 'Bot�o de Nance', 225, 120);
INSERT INTO `honorarios` VALUES('OR008', 'Barra Transpalatina Fixa', 223, 120);
INSERT INTO `honorarios` VALUES('OR009', 'Barra Transpalatina Remov�vel', 136, 80);
INSERT INTO `honorarios` VALUES('OR010', 'Quadrih�lice', 225, 120);
INSERT INTO `honorarios` VALUES('OR011', 'Grade Palatina FIxa', 225, 120);
INSERT INTO `honorarios` VALUES('OR012', 'Pendulum de Hilgers com mola de TMA', 254, 120);
INSERT INTO `honorarios` VALUES('OR013', 'Pendex de Hilgers com mola de TMA', 280, 120);
INSERT INTO `honorarios` VALUES('OR014', 'Distalizador de Molar, tipo Jones Jig', 251, 120);
INSERT INTO `honorarios` VALUES('OR015', 'Herbst Encapsulado', 378, 180);
INSERT INTO `honorarios` VALUES('OR016', 'Mascara Facial-Delaire, tra��o reversa( sem o diajuntor )', 209, 120);
INSERT INTO `honorarios` VALUES('OR017', 'Mentoneira', 114, 70);
INSERT INTO `honorarios` VALUES('OR018', 'Disjuntor Palatino tipo Haas, Hirax', 258, 120);
INSERT INTO `honorarios` VALUES('OR019', 'Disjuntor Palatino tipo McNammara, Faltin', 221, 120);
INSERT INTO `honorarios` VALUES('OR020', 'Frankel', 291, 120);
INSERT INTO `honorarios` VALUES('OR021', 'Bimier', 291, 120);
INSERT INTO `honorarios` VALUES('OR022', 'Planas', 291, 120);
INSERT INTO `honorarios` VALUES('OR023', 'Aparelho Remov�vel com Al�a de Binator Invertida', 286, 120);
INSERT INTO `honorarios` VALUES('OR024', 'Aparelho Remov�vel com al�a de Escheler', 237, 120);
INSERT INTO `honorarios` VALUES('OR025', 'Bionator de Baiters', 274, 120);
INSERT INTO `honorarios` VALUES('OR027', 'Aparelho de Thurow', 264, 120);
INSERT INTO `honorarios` VALUES('OR028', 'Placa de Hawley (Aparelho de Conten��o Superior)', 160, 120);
INSERT INTO `honorarios` VALUES('OR029', 'Placa de Hawley com torno expansor', 180, 130);
INSERT INTO `honorarios` VALUES('OR030', 'Grade Palatina Remov�vel', 149, 80);
INSERT INTO `honorarios` VALUES('OR031', 'Planejamento em Ortodontia', 222, 100);
INSERT INTO `honorarios` VALUES('OR026', 'Blaca dupla de Sanders', 286, 120);
INSERT INTO `honorarios` VALUES('CO001', 'Exodontia (por elemento de permanente)', 77, 30);
INSERT INTO `honorarios` VALUES('CO002', 'Exodontia a Retalho', 100, 45);
INSERT INTO `honorarios` VALUES('CO003', 'Exodontia (Raiz Residual)', 78, 35);
INSERT INTO `honorarios` VALUES('CO004', 'Alveoloplastia(por segmento)', 106, 65);
INSERT INTO `honorarios` VALUES('CO006', 'Bi�psia de Les�es Sugestivas  (acrescentar valor cobrado em laborat�rio)', 230, 110);
INSERT INTO `honorarios` VALUES('CO005', 'Ulotomia', 71, 30);
INSERT INTO `honorarios` VALUES('CO007', 'Sulcoplastia ( por arcada )', 117, 60);
INSERT INTO `honorarios` VALUES('CO008', 'Cirurgia para Torus Palatino', 138, 80);
INSERT INTO `honorarios` VALUES('CO009', 'Cirurgia para Torus Mandibular-Unilateral', 111, 100);
INSERT INTO `honorarios` VALUES('CO010', 'Cirurgia para Torus Mandibular-Bilateral', 168, 130);
INSERT INTO `honorarios` VALUES('CO011', 'Apicectomia de Caninos ou Incisivos', 177, 140);
INSERT INTO `honorarios` VALUES('CO012', 'Apcectomia Caninos/Incisivos com Obtura��o Retrograda', 202, 180);
INSERT INTO `honorarios` VALUES('CO013', 'Apcectomia Pr�-Molares', 209, 155);
INSERT INTO `honorarios` VALUES('CO014', 'Apcectomia Pr�-Molares com obtura��o retrograda', 236, 170);
INSERT INTO `honorarios` VALUES('CO015', 'Apcectomia de Molares', 242, 190);
INSERT INTO `honorarios` VALUES('CO017', 'Frenetomia ou Bridectomia', 126, 90);
INSERT INTO `honorarios` VALUES('CO018', 'Remo��o de Dentes Inclusos ou Impactados', 188, 100);
INSERT INTO `honorarios` VALUES('CO019', 'Cirurgia de Tumores Intra-�ssea', 188, 120);
INSERT INTO `honorarios` VALUES('CO020', 'Tratamento de Les�o C�stica(enucalea��o)', 210, 150);
INSERT INTO `honorarios` VALUES('CO021', 'Tratamento de Les�o C�stica(marzupializa��o e enuclea��o final)', 243, 190);
INSERT INTO `honorarios` VALUES('CO022', 'Remo��o de Corpo Estranho no Selo Maxilar', 232, 190);
INSERT INTO `honorarios` VALUES('CO023', 'Tratamento Cir�rgico de F�stula Bu�o-Sinucal ou Buco-Nasal com Retalho', 188, 140);
INSERT INTO `honorarios` VALUES('CO024', 'Excis�o de Gl�ndula Sublingual', 424, 350);
INSERT INTO `honorarios` VALUES('CO025', 'Excis�o de Gl�ndula Submandibular', 688, 510);
INSERT INTO `honorarios` VALUES('CO026', 'Excis�o de Gl�ndula Par�tida', 562.19, 400);
INSERT INTO `honorarios` VALUES('CO027', 'Excis�o de R�nula', 457, 360);
INSERT INTO `honorarios` VALUES('CO028', 'Excis�o de Tumor de Gl�ndula Salivar', 424, 310);
INSERT INTO `honorarios` VALUES('CO029', 'Retirada de C�lculo Salivar', 172, 110);
INSERT INTO `honorarios` VALUES('CO030', 'Excis�o de Mucocele de Desenvolvimento', 117, 90);
INSERT INTO `honorarios` VALUES('CO031', 'Drenagem de Abcesso', 63, 35);
INSERT INTO `honorarios` VALUES('CO032', 'Ulectomia', 78, 35);
INSERT INTO `honorarios` VALUES('CO033', 'Sinusotomia', 193, 180);
INSERT INTO `honorarios` VALUES('CO034', 'Pl�stico do Canal de Stenon', 359, 240);
INSERT INTO `honorarios` VALUES('CO035', 'Palentolabioplastia Bilateral', 433, 310);
INSERT INTO `honorarios` VALUES('CO036', 'Tratamento Cir�rgico do L�bio Leporino', 337, 250);
INSERT INTO `honorarios` VALUES('CO037', 'Recosntru��o Parcial do L�bio Traumatizado', 337, 250);
INSERT INTO `honorarios` VALUES('CO038', 'Reconstru��o Total de L�bio Traumatizado', 484, 400);
INSERT INTO `honorarios` VALUES('CO039', 'Redu��o Cir�rgica de Luxa��o de ATM', 330, 250);
INSERT INTO `honorarios` VALUES('CO040', 'Tratamento Cir�rgico para Aniquilose de ATM(por lado)', 550, 410);
INSERT INTO `honorarios` VALUES('CO041', 'Tratamento Cir�rgico para Osteomelite dos Ossos da Face', 411, 350);
INSERT INTO `honorarios` VALUES('CO042', 'Excis�o de Sutura de Les�o da Boca com Rota��o de Retalho', 448, 300);
INSERT INTO `honorarios` VALUES('CO043', 'Suturas Simples de Face', 73, 45);
INSERT INTO `honorarios` VALUES('CO044', 'Suturas M�ltiplas de Face', 91.2, 60);
INSERT INTO `honorarios` VALUES('CO045', 'Maxilectomia com ou sem Esvaziamento Orbit�rio', 440, 320);
INSERT INTO `honorarios` VALUES('CO047', 'Osteotomia e Osteoplastia de Mand�bula para Micrognatismo', 765, 600);
INSERT INTO `honorarios` VALUES('CO046', 'Osteotomia e Osteoplastia de Mand�bula para Prognatismo', 765, 600);
INSERT INTO `honorarios` VALUES('CO048', 'Osteotomia e Osteoplastia de Mand�bula para Laterognostismo', 765, 600);
INSERT INTO `honorarios` VALUES('CO049', 'Osteotomia e Osteoplastia de Maxila Tipo Le Fort I', 550, 400);
INSERT INTO `honorarios` VALUES('CO050', 'Osteotomia e Osteoplastia de Maxila Tipo Le Fort II', 789, 610);
INSERT INTO `honorarios` VALUES('CO051', 'Osteotomia e Osteplastia de Maxila Tipo Le Fort III', 936, 710);
INSERT INTO `honorarios` VALUES('CO052', 'Reconstru��o Total da Mand�bula com Enxerto �sseo/Pr�tese', 1138, 930);
INSERT INTO `honorarios` VALUES('CO053', 'Reconstru��o Parcial da Mand�bula com Enxerto �sseo/Pr�tese', 716, 545);
INSERT INTO `honorarios` VALUES('CO054', 'Reconstru��o de Sulco Gengivo-Labial', 152, 110);
INSERT INTO `honorarios` VALUES('CO055', 'Excis�o em Cunha de L�bio Sutura', 156, 115);
INSERT INTO `honorarios` VALUES('CO056', 'Cirurgia de Hipertrofia do L�bio', 264, 195);
INSERT INTO `honorarios` VALUES('CO057', 'Cirurgia para Microstomia', 440, 360);
INSERT INTO `honorarios` VALUES('CO058', 'Redu��o de Fratura de Osso Pr�prios do Nariz', 440, 350);
INSERT INTO `honorarios` VALUES('CO059', 'Redu��o Incluenta de Fratura Unilateral de Mandibula', 205, 130);
INSERT INTO `honorarios` VALUES('CO060', 'Redu��o Cruenta de Fratura Unilateral Mand�bula', 477, 340);
INSERT INTO `honorarios` VALUES('CO061', 'Redu��o Incluenta de Fratura Bilateral de Mand�bula', 249, 190);
INSERT INTO `honorarios` VALUES('CO062', 'Redu��o Cruenta de Fratura Bilateral de Mand�bula', 789, 410);
INSERT INTO `honorarios` VALUES('CO063', 'Redu��o Cruenta de Fratura Cominutiva de Mandibula', 703, 520);
INSERT INTO `honorarios` VALUES('CO064', 'Redu��o de Fratura de C�ndido Mand�bula', 455, 320);
INSERT INTO `honorarios` VALUES('CO065', 'Fraturas Alv�olo-Dent�rias-Redu��o Cruenta', 132, 110);
INSERT INTO `honorarios` VALUES('CO066', 'Fraturas Alv�olo-Dent�rias-Redu��o Incruenta', 73, 45);
INSERT INTO `honorarios` VALUES('CO067', 'Reimplante de Dente (por elemento)', 117, 60);
INSERT INTO `honorarios` VALUES('CO068', 'Redu��o Inoruenta de Fratura de Le Fort I', 356, 300);
INSERT INTO `honorarios` VALUES('CO069', 'Redu��o Incruenta de Fratura Le Fort II', 356, 300);
INSERT INTO `honorarios` VALUES('CO070', 'Redu��o Incruenta de Fratura Le Fort III', 411, 310);
INSERT INTO `honorarios` VALUES('CO071', 'Redu��o Cruenta de Fratura Le Fort I', 550, 450);
INSERT INTO `honorarios` VALUES('CO072', 'Redu��o Cruenta de Fratura Le Fort II', 765, 500);
INSERT INTO `honorarios` VALUES('CO074', 'Fraturas Complexas do Segmento Fixo da Face', 411, 300);
INSERT INTO `honorarios` VALUES('CO073', 'Redu��o Cruenta de Fratura Le Fort III', 765, 510);
INSERT INTO `honorarios` VALUES('CO075', 'Fraturas Complexas do Segmento da Face com Fixa��o Pericraniana', 1138, 800);
INSERT INTO `honorarios` VALUES('CO077', 'Fratura do Arco Zigom�tico - Redu��o cir�rgica sem fixa��o', 337, 250);
INSERT INTO `honorarios` VALUES('CO078', 'Fratura do Osso Zigom�tico - Redu��o Cir�rgica e Fixa��o', 440, 320);
INSERT INTO `honorarios` VALUES('CO079', 'Retirada de Fios Intra ou Trans-�sseos', 44, 35);
INSERT INTO `honorarios` VALUES('CO080', 'Retirada de Bloqueio Maxilo-Mandibular', 41, 35);
INSERT INTO `honorarios` VALUES('CO081', 'Retirada de Ancoragem e Cerclagens', 41, 35);
INSERT INTO `honorarios` VALUES('CO082', 'Cirurgia de Cisto', 108, 100);
INSERT INTO `honorarios` VALUES('CO083', 'Artroplastia para Luxa��o Rescidivante da ATM', 752, 550);
INSERT INTO `honorarios` VALUES('CO084', 'Ressec��o Parcial da Mand�bula', 514, 400);
INSERT INTO `honorarios` VALUES('CO085', 'Ressec��o Parcial de Mand�bula com enxerto �sseo', 624, 490);
INSERT INTO `honorarios` VALUES('CO086', 'Hemimandibuloctomia', 587, 430);
INSERT INTO `honorarios` VALUES('CO087', 'Hemimandibulectomia com cola��o de pr�tese', 716, 510);
INSERT INTO `honorarios` VALUES('CO088', 'Hemimandibulectomia com enxerto �sseo', 789, 590);
INSERT INTO `honorarios` VALUES('CO089', 'Mnadibulectomias com Reconstru��o Microcir�rgica', 1138, 900);
INSERT INTO `honorarios` VALUES('CO090', 'Mandibulectomia com Reconstru��o de osteomicutan�a', 936, 705);
INSERT INTO `honorarios` VALUES('CO091', 'Osteoplastia de Etm�ido Orbit�rias', 862, 650);
INSERT INTO `honorarios` VALUES('CO092', 'Osteoplastia de Mand�bula', 789, 600);
INSERT INTO `honorarios` VALUES('CO093', 'Osteoplastia de �rbita', 936, 710);
INSERT INTO `honorarios` VALUES('CO094', 'Ressec��o do Meso Infra Estrutura do Maxila Superior', 466, 300);
INSERT INTO `honorarios` VALUES('CO095', 'Ressec��o Total de Maxila Inclinada Exenter de �rbita', 826, 600);
INSERT INTO `honorarios` VALUES('CO096', 'Ressec��o Maxilar Superior Reconstru��o � custa Retalhos', 991, 735);
INSERT INTO `honorarios` VALUES('IM001', 'Ato Cir�rgico de Inser��o do Pino de Tit�nio', 850, 600);
INSERT INTO `honorarios` VALUES('IM002', 'Planejamento Cir�rgico e Prot�tico com modelos de estudo', 120, 60);
INSERT INTO `honorarios` VALUES('IM003', 'Coroa Total sobre Implante em Metalo Artglas/Solidex', 530, 420);
INSERT INTO `honorarios` VALUES('IM004', 'Coroa Total sobre Implante em Metalo Cer�mica (Porcelana)', 720, 530);
INSERT INTO `honorarios` VALUES('IM005', 'Barra para Pr�tese Total Fixa ou Remov�vel Sobre Implante (Over Dental0', 430, 350);
INSERT INTO `honorarios` VALUES('IM006', 'Interm. e Adapt. para pr�tese sobre implante:Oring. Munh�es,Uclas etc(unit�rios)', 240, 130);
INSERT INTO `honorarios` VALUES('IM007', 'Coroa Total Provis�ria sobre Implante em Acr�lico', 320, 250);
INSERT INTO `honorarios` VALUES('OR032', 'Manuten��o de Ap. Ortod�ntico :: 20% � 30% Sal�rio M�nimo :: Apresenta��o em 30% Sal�rio', 140, 105);
INSERT INTO `honorarios` VALUES('DE023', 'Clareamento Dental em Consult�rio a Layser :: Por Arcada', 490, 300);
INSERT INTO `honorarios` VALUES('EX005', 'Urg�ncia Hor�rio Normal (independente da sequ�ncia do tratamento)', 70, 35);
INSERT INTO `honorarios` VALUES('OR033', 'Aparelho Ortod�ntico Fixo Est�tico (CER�MICA) :: 1 Arcada', 850, 600);
INSERT INTO `honorarios` VALUES('CO097', 'Aumento de Coroa Cl�nica', 132, 80);
INSERT INTO `honorarios` VALUES('CO098', 'Enxerto �sseo Aut�geno em Bloco para Ganho de Volume - Por Segmento', 700, 500);
INSERT INTO `honorarios` VALUES('CO099', 'Enxertos Utilizando Bio-Materiais (Acrescentar o Valor do Bio-Material)', 420, 210);
INSERT INTO `honorarios` VALUES('CO100', 'Exodontia de CISO ''Incluso ou Impactado''', 188, 100);
INSERT INTO `honorarios` VALUES('EN025', 'Tratamento Endod�ntico de Molar acima de 3 condutos (n�o inclue radiografias)', 400, 290);
INSERT INTO `honorarios` VALUES('EN026', 'Retratamento Endod�ntico de Molar acima de 3 condutos (n�o inlcue radiografias)', 450, 350);
INSERT INTO `honorarios` VALUES('IM008', 'Elemento de Porcelana para Ponte Sobre Implante', 600, 430);
INSERT INTO `honorarios` VALUES('CO101', 'Apicectomia de Molares - Com obtura��o retrograda', 269, 220);
INSERT INTO `honorarios` VALUES('CO102', 'Osteoplastia Zigom�tico - Maxilar', 441, 310);
INSERT INTO `honorarios` VALUES('PE009', 'Remo��o  de Fatores de Reten��o', 62, 30);
INSERT INTO `honorarios` VALUES('PE028', 'Manuten��o do Tratamento Cir�rgico', 65, 35);
INSERT INTO `honorarios` VALUES('PE029', 'Aumento de Coroa Cl�nica (por elemento)', 132, 80);
INSERT INTO `honorarios` VALUES('PE030', 'Tratamento Regenerativo com uso de Barreia', 445, 300);
INSERT INTO `honorarios` VALUES('IM009', 'Guia Cir�rgico para Cirurgia de Implante Unit�rio ou M�ltiplos', 215, 120);

# 2.0

# 2.2

CREATE TABLE IF NOT EXISTS convenios (
  codigo int(15) NOT NULL auto_increment,
  nomefantasia varchar(80) default NULL,
  cpf varchar(50) NOT NULL default '',
  razaosocial varchar(80) default NULL,
  atuacao varchar(80) default NULL,
  endereco varchar(150) default NULL,
  bairro varchar(40) default NULL,
  cidade varchar(40) default NULL,
  estado varchar(50) default NULL,
  pais varchar(50) default NULL,
  cep varchar(9) default NULL,
  celular varchar(15) default NULL,
  telefone1 varchar(15) default NULL,
  telefone2 varchar(15) default NULL,
  inscricaoestadual varchar(40) default NULL,
  website varchar(100) default NULL,
  email varchar(100) default NULL,
  nomerepresentante varchar(80) default NULL,
  apelidorepresentante varchar(50) default NULL,
  emailrepresentante varchar(100) default NULL,
  celularrepresentante varchar(15) default NULL,
  telefone1representante varchar(15) default NULL,
  telefone2representante varchar(15) default NULL,
  banco varchar(50) default NULL,
  agencia varchar(15) default NULL,
  conta varchar(15) default NULL,
  favorecido varchar(50) default NULL,
  PRIMARY KEY  (codigo)
) ENGINE=MyISAM;

ALTER TABLE pacientes CHANGE convenio convenio varchar(50) default NULL;
CREATE TABLE IF NOT EXISTS dentistas_temp (
  codigo INT NOT NULL AUTO_INCREMENT,
  nome varchar(80) default NULL,
  cpf varchar(50) default NULL,
  usuario varchar(15) character set latin7 collate latin7_general_cs default NULL,
  senha varchar(32) default NULL,
  endereco varchar(150) default NULL,
  bairro varchar(50) default NULL,
  cidade varchar(50) default NULL,
  estado varchar(50) default NULL,
  pais varchar(50) default NULL,
  cep varchar(9) default NULL,
  nascimento date default NULL,
  telefone1 varchar(15) default NULL,
  celular varchar(15) default NULL,
  telefone2 varchar(15) default NULL,
  sexo enum('Masculino','Feminino') NOT NULL,
  nomemae varchar(80) default NULL,
  rg varchar(50) default NULL,
  email varchar(100) default NULL,
  comissao float default NULL,
  codigo_areaatuacao1 int(5) default NULL,
  codigo_areaatuacao2 int(5) default NULL,
  codigo_areaatuacao3 int(5) default NULL,
  conselho_tipo varchar(30) default NULL,
  conselho_estado varchar(30) default NULL,
  conselho_numero varchar(30) default NULL,
  ativo enum('Sim','N�o') default NULL,
  foto blob,
  PRIMARY KEY  (codigo)
) ENGINE=MyISAM;
INSERT INTO dentistas_temp (nome, cpf, usuario, senha, endereco, bairro, cidade, estado, cep, nascimento, telefone1, celular, telefone2,
  sexo, nomemae, rg, email, comissao, codigo_areaatuacao1, codigo_areaatuacao2, codigo_areaatuacao3, conselho_tipo, conselho_estado,
  conselho_numero, ativo, foto) SELECT * FROM dentistas;
DROP TABLE dentistas;
RENAME TABLE dentistas_temp TO dentistas;
UPDATE agenda SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE agenda_obs SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE caixa_dent SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE cheques_dent SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE contaspagar_dent SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE contasreceber_dent SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE estoque_dent SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE evolucao SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
UPDATE pacientes SET cpf_dentistaprocurado = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentistaprocurado), cpf_dentistaatendido = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentistaatendido), cpf_dentistaencaminhado = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentistaencaminhado), convenio = (SELECT codigo FROM convenios WHERE nome = convenio);
UPDATE orcamento SET cpf_dentista = (SELECT codigo FROM dentistas WHERE cpf = cpf_dentista);
ALTER TABLE agenda CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE agenda_obs CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE caixa_dent CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE cheques_dent CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE contaspagar_dent CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE contasreceber_dent CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE estoque_dent CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE evolucao CHANGE cpf_dentista codigo_dentista INT NOT NULL;
ALTER TABLE pacientes CHANGE cpf_dentistaprocurado codigo_dentistaprocurado INT NOT NULL, CHANGE cpf_dentistaatendido codigo_dentistaatendido INT NOT NULL, CHANGE cpf_dentistaencaminhado codigo_dentistaencaminhado INT NOT NULL, ADD pais varchar(50) default NULL AFTER estado, CHANGE estado estado varchar(50) default NULL, CHANGE convenio codigo_convenio INT NOT NULL;
ALTER TABLE orcamento CHANGE cpf_dentista codigo_dentista INT NOT NULL;

ALTER TABLE dados_clinica CHANGE estado estado varchar(50) default NULL, ADD pais varchar(50) default NULL AFTER estado, ADD idioma varchar(50) default NULL AFTER conta2;
UPDATE dados_clinica SET idioma = 'pt_br';
ALTER TABLE fornecedores CHANGE estado estado varchar(50) default NULL, ADD pais varchar(50) default NULL AFTER estado, ADD observacoes text default NULL AFTER telefone2representante, CHANGE banco banco1 varchar(50) default NULL, CHANGE agencia agencia1 varchar(15) default NULL, CHANGE conta conta1 varchar(15) default NULL, CHANGE favorecido favorecido1 varchar(50) default NULL, ADD banco2 varchar(50) default NULL, ADD agencia2 varchar(15) default NULL, ADD conta2 varchar(15) default NULL, ADD favorecido2 varchar(50) default NULL;
ALTER TABLE telefones CHANGE estado estado varchar(50) default NULL, ADD pais varchar(50) default NULL AFTER estado;

ALTER TABLE pacientes CHANGE estadocivil estadocivil varchar(50) default NULL, CHANGE etnia etnia varchar(50) default NULL;
UPDATE pacientes SET estadocivil = 'solteiro' WHERE estadocivil = 'Solteiro(a)';
UPDATE pacientes SET estadocivil = 'casado' WHERE estadocivil = 'Casado(a)';
UPDATE pacientes SET estadocivil = 'divorciado' WHERE estadocivil = 'Separado(a)';
UPDATE pacientes SET estadocivil = 'divorciado' WHERE estadocivil = 'Divorciado(a)';
UPDATE pacientes SET estadocivil = 'casado' WHERE estadocivil = 'Amasiado(a)';
UPDATE pacientes SET estadocivil = 'viuvo' WHERE estadocivil = 'Vi�vo(a)';
UPDATE pacientes SET etnia = 'caucasiano' WHERE etnia = 'Branco';
UPDATE pacientes SET etnia = 'africano' WHERE etnia = 'Moreno';
UPDATE pacientes SET etnia = 'africano' WHERE etnia = 'Negro';
UPDATE pacientes SET etnia = 'multietnico' WHERE etnia = 'Pardo';
UPDATE pacientes SET etnia = 'asiatico' WHERE etnia = 'Amarelo';
ALTER TABLE pacientes CHANGE estadocivil estadocivil enum('solteiro','casado','divorciado','viuvo') default NULL, CHANGE etnia etnia enum('africano','asiatico','caucasiano','latino','orientemedio','multietnico') default NULL;

ALTER TABLE funcionarios CHANGE estadocivil estadocivil varchar(50) default NULL;
UPDATE funcionarios SET estadocivil = 'solteiro' WHERE estadocivil = 'Solteiro(a)';
UPDATE funcionarios SET estadocivil = 'casado' WHERE estadocivil = 'Casado(a)';
UPDATE funcionarios SET estadocivil = 'divorciado' WHERE estadocivil = 'Separado(a)';
UPDATE funcionarios SET estadocivil = 'divorciado' WHERE estadocivil = 'Divorciado(a)';
UPDATE funcionarios SET estadocivil = 'casado' WHERE estadocivil = 'Amasiado(a)';
UPDATE funcionarios SET estadocivil = 'viuvo' WHERE estadocivil = 'Vi�vo(a)';
ALTER TABLE funcionarios CHANGE estadocivil estadocivil enum('solteiro','casado','divorciado','viuvo') default NULL;

CREATE TABLE IF NOT EXISTS funcionarios_temp (
  codigo INT NOT NULL AUTO_INCREMENT,
  nome varchar(80) default NULL,
  cpf varchar(50) default NULL,
  usuario varchar(15) character set latin7 collate latin7_general_cs default NULL,
  senha varchar(32) default NULL,
  rg varchar(50) default NULL,
  estadocivil enum('Solteiro(a)','Casado(a)','Separado(a)','Divorciado(a)','Amasiado(a)','Vi�vo(a)') default NULL,
  endereco varchar(150) default NULL,
  bairro varchar(50) default NULL,
  cidade varchar(50) default NULL,
  estado varchar(50) default NULL,
  pais varchar(50) default NULL,
  cep varchar(9) default NULL,
  nascimento date default NULL,
  telefone1 varchar(15) default NULL,
  telefone2 varchar(15) default NULL,
  celular varchar(15) default NULL,
  sexo enum('Masculino','Feminino') default NULL,
  email varchar(100) default NULL,
  nomemae varchar(80) default NULL,
  nascimentomae date default NULL,
  nomepai varchar(80) default NULL,
  nascimentopai date default NULL,
  enderecofamiliar varchar(220) default NULL,
  funcao1 varchar(80) default NULL,
  funcao2 varchar(80) default NULL,
  admissao date default NULL,
  demissao date default NULL,
  observacoes text,
  ativo enum('Sim','N�o') default NULL,
  foto blob,
  PRIMARY KEY  (codigo)
) ENGINE=MyISAM;
INSERT INTO funcionarios_temp (nome, cpf, usuario, senha, rg, estadocivil, endereco, bairro, cidade, estado, cep, nascimento,
  telefone1, telefone2, celular, sexo, email, nomemae, nascimentomae, nomepai, nascimentopai, enderecofamiliar, funcao1, funcao2,
  admissao, demissao, observacoes, ativo, foto) SELECT * FROM funcionarios;
DROP TABLE funcionarios;
RENAME TABLE funcionarios_temp TO funcionarios;
DROP VIEW IF EXISTS v_agenda;
CREATE VIEW v_agenda AS ( SELECT tp.codigo AS codigo_paciente, ta.data AS data, ta.hora AS hora, ta.descricao AS descricao, ta.procedimento AS procedimento, ta.faltou AS faltou, td.nome AS nome_dentista, td.sexo AS sexo_dentista FROM agenda ta INNER JOIN pacientes tp ON tp.codigo = ta.codigo_paciente INNER JOIN dentistas td ON td.codigo = ta.codigo_dentista );
DROP VIEW IF EXISTS v_evolucao;
CREATE VIEW v_evolucao AS ( SELECT tp.codigo AS codigo_paciente, tp.nome AS paciente, td.sexo AS sexo_dentista, td.nome AS dentista, te.procexecutado AS executado, te.procprevisto AS previsto, te.data AS data FROM evolucao te INNER JOIN dentistas td ON te.codigo_dentista = td.codigo INNER JOIN pacientes tp ON te.codigo_paciente = tp.codigo );
DROP VIEW IF EXISTS v_orcamento;
CREATE VIEW v_orcamento AS ( SELECT tpo.codigo_orcamento AS codigo_orcamento, tor.parcelas AS parcelas, tor.confirmado AS confirmado, tor.baixa AS baixa, tpo.codigo AS codigo_parcela, tpo.datavencimento AS data, tpo.valor AS valor, tpo.pago AS pago, tpo.datapgto AS datapgto, tp.codigo AS codigo_paciente, tp.nome AS paciente, td.nome AS dentista, td.sexo AS sexo_dentista FROM parcelas_orcamento tpo INNER JOIN orcamento tor ON tpo.codigo_orcamento = tor.codigo INNER JOIN pacientes tp ON tor.codigo_paciente = tp.codigo JOIN dentistas td ON tor.codigo_dentista = td.codigo );

ALTER TABLE cheques ADD agencia VARCHAR( 20 ) NOT NULL AFTER banco;
ALTER TABLE cheques_dent ADD agencia VARCHAR( 20 ) NOT NULL AFTER banco;

ALTER TABLE pacientes CHANGE cpf cpf VARCHAR(50) NOT NULL, CHANGE rg rg VARCHAR(50) NOT NULL;
ALTER TABLE dados_clinica CHANGE cnpj cnpj VARCHAR(50) NOT NULL;
ALTER TABLE fornecedores CHANGE cpf cpf VARCHAR(50) NOT NULL;

CREATE TABLE IF NOT EXISTS laboratorios (
  codigo int(15) NOT NULL auto_increment,
  nomefantasia varchar(80) default NULL,
  cpf varchar(50) NOT NULL default '',
  razaosocial varchar(80) default NULL,
  atuacao varchar(80) default NULL,
  endereco varchar(150) default NULL,
  bairro varchar(40) default NULL,
  cidade varchar(40) default NULL,
  estado varchar(50) default NULL,
  pais varchar(50) default NULL,
  cep varchar(9) default NULL,
  celular varchar(15) default NULL,
  telefone1 varchar(15) default NULL,
  telefone2 varchar(15) default NULL,
  inscricaoestadual varchar(40) default NULL,
  website varchar(100) default NULL,
  email varchar(100) default NULL,
  nomerepresentante varchar(80) default NULL,
  apelidorepresentante varchar(50) default NULL,
  emailrepresentante varchar(100) default NULL,
  celularrepresentante varchar(15) default NULL,
  telefone1representante varchar(15) default NULL,
  telefone2representante varchar(15) default NULL,
  banco varchar(50) default NULL,
  agencia varchar(15) default NULL,
  conta varchar(15) default NULL,
  favorecido varchar(50) default NULL,
  PRIMARY KEY  (codigo)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS laboratorios_procedimentos (
  codigo int NOT NULL auto_increment,
  codigo_paciente int NOT NULL,
  codigo_dentista int NOT NULL,
  procedimento TEXT NOT NULL,
  datahora DATETIME NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS laboratorios_procedimentos_status (
  codigo int NOT NULL auto_increment,
  codigo_procedimento int NOT NULL,
  `status` TEXT NOT NULL,
  datahora DATETIME NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=MyISAM;

# 3.0

ALTER TABLE laboratorios_procedimentos ADD codigo_laboratorio int NOT NULL AFTER codigo;

# 3.5

ALTER TABLE dentistas ADD data_inicio DATE NOT NULL AFTER ativo, ADD data_fim DATE NOT NULL AFTER data_inicio;
ALTER TABLE pacientes ADD falecido ENUM('Sim', 'N�o') NOT NULL DEFAULT 'N�o' AFTER pais;

ALTER TABLE convenios CHANGE codigo codigo INT(15) NOT NULL, DROP PRIMARY KEY;
UPDATE convenios SET codigo = codigo + 2;
UPDATE pacientes SET codigo_convenio = codigo_convenio + 2;
INSERT INTO convenios (codigo, nomefantasia) VALUES (1, 'Particular');
INSERT INTO convenios (codigo, nomefantasia, cidade, estado, pais, cep) VALUES (2, 'Smile', 'Arcos', 'MG', 'Brasil', '35588-000');
ALTER TABLE convenios ADD PRIMARY KEY(`codigo`), CHANGE codigo codigo INT(15) NOT NULL AUTO_INCREMENT;
UPDATE pacientes SET codigo_convenio = 1 WHERE codigo_convenio = 2;

CREATE TABLE honorarios_convenios (
  codigo_convenio INT NOT NULL,
  codigo_procedimento VARCHAR(10) NOT NULL,
  valor FLOAT NOT NULL,
  PRIMARY KEY(codigo_convenio, codigo_procedimento)
);

INSERT INTO honorarios_convenios SELECT 1 codigo_convenio, codigo codigo_procedimento, valor_particular valor FROM honorarios;
INSERT INTO honorarios_convenios SELECT 2 codigo_convenio, codigo codigo_procedimento, valor_convenio valor FROM honorarios;

ALTER TABLE honorarios DROP valor_particular, DROP valor_convenio;

CREATE TABLE radiografias (
  codigo INT NOT NULL AUTO_INCREMENT,
  codigo_paciente INT NOT NULL,
  foto LONGBLOB NOT NULL,
  legenda VARCHAR(100) NOT NULL,
  data DATE NOT NULL,
  modelo ENUM('Panoramica', 'Oclusal', 'Periapical', 'Interproximal', 'ATM', 'PA', 'AP', 'Lateral') NOT NULL,
  diagnostico TEXT NOT NULL,
  PRIMARY KEY(codigo)
);

CREATE TABLE permissoes (
  nivel VARCHAR(30) NOT NULL,
  area ENUM('profissionais',
            'pacientes',
            'funcionarios',
            'fornecedores',
            'agenda',
            'patrimonio',
            'estoque',
            'laboratorios',
            'convenios',
            'honorarios',
            'contas_pagar',
            'contas_receber',
            'caixa',
            'cheques',
            'pagamentos',
            'arquivos_clinica',
            'manuais',
            'contatos',
            'backup_gerar',
            'backup_restaurar',
            'informacoes',
            'idiomas') NOT NULL,
  permissao SET('L', 'V', 'E', 'I', 'A'),
  PRIMARY KEY (nivel, area)
);

INSERT INTO permissoes VALUES
  ('Dentista', 'profissionais', 'L,V'),
  ('Dentista', 'pacientes', 'L,V,E,I,A'),
  ('Dentista', 'funcionarios', 'L,V'),
  ('Dentista', 'fornecedores', 'L,V,I,A'),
  ('Dentista', 'agenda', 'L,E'),
  ('Dentista', 'patrimonio', ''),
  ('Dentista', 'estoque', 'L,V,E,I,A'),
  ('Dentista', 'laboratorios', 'L,V,E,I'),
  ('Dentista', 'convenios', 'L,V'),
  ('Dentista', 'honorarios', 'L,V'),
  ('Dentista', 'contas_pagar', 'L,V,E,I,A'),
  ('Dentista', 'contas_receber', 'L,V,E,I,A'),
  ('Dentista', 'caixa', 'L,V,E,I,A'),
  ('Dentista', 'cheques', 'L,V,E,I,A'),
  ('Dentista', 'pagamentos', 'L'),
  ('Dentista', 'arquivos_clinica', 'L'),
  ('Dentista', 'manuais', 'L'),
  ('Dentista', 'contatos', 'L,V,I'),
  ('Dentista', 'backup_gerar', 'L'),
  ('Dentista', 'backup_restaurar', 'L'),
  ('Dentista', 'informacoes', 'V'),
  ('Dentista', 'idiomas', 'V'),
  ('Funcionario', 'profissionais', 'L,V'),
  ('Funcionario', 'pacientes', 'L,V,E,I,A'),
  ('Funcionario', 'funcionarios', 'L,V'),
  ('Funcionario', 'fornecedores', 'L,V,E,I'),
  ('Funcionario', 'agenda', ''),
  ('Funcionario', 'patrimonio', ''),
  ('Funcionario', 'estoque', 'L,V,E,I,A'),
  ('Funcionario', 'laboratorios', 'L,V,E,I'),
  ('Funcionario', 'convenios', 'L,V'),
  ('Funcionario', 'honorarios', 'L,V'),
  ('Funcionario', 'contas_pagar', ''),
  ('Funcionario', 'contas_receber', ''),
  ('Funcionario', 'caixa', ''),
  ('Funcionario', 'cheques', ''),
  ('Funcionario', 'pagamentos', 'L'),
  ('Funcionario', 'arquivos_clinica', 'L'),
  ('Funcionario', 'manuais', 'L'),
  ('Funcionario', 'contatos', 'L,V,I'),
  ('Funcionario', 'backup_gerar', 'L'),
  ('Funcionario', 'backup_restaurar', ''),
  ('Funcionario', 'informacoes', 'V'),
  ('Funcionario', 'idiomas', 'V');

# 4.0

CREATE TABLE dentista_atendimento (
  codigo_dentista int(11) NOT NULL,
  dia_semana tinyint(1) NOT NULL,
  hora_inicio time NOT NULL,
  hora_fim time NOT NULL,
  ativo tinyint(1) DEFAULT '1',
  PRIMARY KEY (codigo_dentista,dia_semana)
);
