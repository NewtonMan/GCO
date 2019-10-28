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
	if(!checklog()) {
        echo '<script>Ajax("wallpapers/index", "conteudo", "");</script>';
        die();
	}
    define('DB_DATABASE', $bd);
    define('DB_SERVER', $server);
    define('DB_DATE', date('Y-m-d_H-i-s'));
    $backup_file = 'db_' . DB_DATABASE . '_' . DB_DATE . '.sql';
    header('Content-type: application/x-octet-stream');
    header('Content-disposition: attachment; filename=' . $backup_file);
        $schema = '# Gerenciador Odontologico' . "\n" .
                  '# http://www.smileodonto.com.br/gco/' . "\n" .
                  '#' . "\n" .
                  '# Backup do Banco de dados ' . "\n" .
                  '# Copyright (c) ' . date('Y') . "\n" .
                  '#' . "\n" .
                  '# Banco de dados: ' . DB_DATABASE . "\n" .
                  '# Servidor: ' . DB_SERVER . "\n" .
                  '#' . "\n" .
                  '# Data de Backup: ' . DB_DATE . "\n\n";
        $tables_query = mysql_query('show tables');
        while ($tables = mysql_fetch_array($tables_query)) {
          list(,$table) = each($tables);
          $schema .= 'drop table if exists `' . $table . '`;' . "\n" .
                     'create table `' . $table . '` (' . "\n";
          $table_list = array();
          $fields_query = mysql_query("show fields from " . $table);
          while ($fields = mysql_fetch_array($fields_query)) {
            $table_list[] = $fields['Field'];
            $schema .= '  `' . $fields['Field'] . '` ' . $fields['Type'];
            if (strlen($fields['Default']) > 0) $schema .= ' default \'' . $fields['Default'] . '\'';
            if ($fields['Null'] != 'YES') $schema .= ' not null';
            if (isset($fields['Extra'])) $schema .= ' ' . $fields['Extra'];
            $schema .= ',' . "\n";
          }
          $schema = ereg_replace(",\n$", '', $schema);

          // Add the keys
          $index = array();
          $keys_query = mysql_query("show keys from `" . $table . "`");
          while ($keys = mysql_fetch_array($keys_query)) {
            $kname = $keys['Key_name'];
            if (!isset($index[$kname])) {
              $index[$kname] = array('unique' => !$keys['Non_unique'],
                                     'columns' => array());
            }
            $index[$kname]['columns'][] = $keys['Column_name'];
          }
          while (list($kname, $info) = each($index)) {
            $schema .= ',' . "\n";
            $columns = implode($info['columns'], ', ');
            if ($kname == 'PRIMARY') {
              $schema .= '  PRIMARY KEY (' . $columns . ')';
            } elseif ($info['unique']) {
              $schema .= '  UNIQUE ' . $kname . ' (' . $columns . ')';
            } else {
              $schema .= '  KEY ' . $kname . ' (' . $columns . ')';
            }
          }
          $schema .= "\n" . ');' . "\n\n";
          /*
          echo implode('`, `', $table_list);
          */
          $rows_query = mysql_query("select `" . implode('`, `', $table_list) . "` from " . $table);
          while ($rows = mysql_fetch_array($rows_query)) {
            $schema_insert = 'insert into `' . $table . '` (`' . implode('`, `', $table_list) . '`) values (';
            reset($table_list);
            while (list(,$i) = each($table_list)) {
              if (!isset($rows[$i])) {
                $schema_insert .= 'NULL, ';
              } elseif ($rows[$i] != '') {
                $row = addslashes($rows[$i]);
                $row = ereg_replace("\n#", "\n".'\#', $row);
                $schema_insert .= '\'' . $row . '\', ';
              } else {
                $schema_insert .= '\'\', ';
              }
            }
            $schema_insert = ereg_replace(', $', '', $schema_insert) . ');' . "\n";
            $schema .= $schema_insert;
          }
          $schema .= "\n";
          echo $schema;
          $schema = '';
        }
?>
