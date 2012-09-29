<?php
/**
 * phpDTAUS helps you creating so-called DTAUS (Datenaustauschverfahren) files. This file format
 * was devised by the German ZKA or Zentraler Kreditausschuss (Central Credit Committee) in the
 * mid-seventies. It is used for the automated processing of wire transfers and direct debits in
 * Germany. The files created with this class are either sent to the bank (via email or any other
 * means) or imported into online banking software for processing.
 * 
 * To check the validity of the file you may visit http://www.xpecto.de/content/dtauschecker. There
 * you simply upload the created file. If everything is alright, you should get a message that the
 * file is valid, as well as a list of the transactions that were encoded in the file.
 * 
 * @author Alexander Serbe <alexander.serbe@progressive-dt.com>
 * @version 1.0
 * @copyright Copyright 2012 by progressive design and technology
 * @license http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public License
 * 
 * ------------------------------------------------------------------------------------------------
 * 
 * phpDTAUS 1.0
 * Copyright (c) 2010 by progressive design and technology
 * 
 * This program is free software: you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public License along with this
 * program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'phpDTAUS.php';

$originator_name		= 'Mustermann AG';
$originator_bankcode	= 10000000;
$originator_account 	= 123456789;
$type			        = 'L';
$typeDetailed	      = '05';

$dtaus = new phpDTAUS($originator_name, $originator_bankcode, $originator_account);

$mapping = array(
	'name' => 2,
	'bankCode' => 3,
	'account' => 4,
	'amount' => 5,
	'ref' => 6,
	'type' => 7,
	'customerId' => 1
);

try {
    $dtaus->readCsv('test.csv', $mapping, 'Produkt XY');
} catch (Exception $e) {
    echo 'Error reading CSV file: ' . $e->getMessage();
    echo PHP_EOL . PHP_EOL;
    echo $e->getTraceAsString();
}

if( !empty($_GET['file']) && $_GET['file'] == '1' ) {
	header('Content-Disposition:attachment; filename=dtaus0.txt');
	header('Content-type:text/plain' );
	header('Cache-control:public' );
}

try {
    print $dtaus->createDtaus($type, '784535', '');
} catch (Exception $e) {
    echo 'Error creating DTAUS file: ' . $e->getMessage();
    echo PHP_EOL . PHP_EOL;
    echo $e->getTraceAsString();
}
?>