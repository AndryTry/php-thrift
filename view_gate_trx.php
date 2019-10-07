<?php
error_reporting( E_ALL );
ini_set('display_errors', 1);
/**
 * Modified from /opt/hbase/src/examples/thrift/DemoClient.php.
 */
 
/**
 * Copyright 2008 The Apache Software Foundation
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
 
# Instructions:
# 1. Run Thrift to generate the php module HBase
#    thrift -php 
#        ../../../src/main/resources/org/apache/hadoop/hbase/thrift/Hbase.thrift
# 2. Modify the import string below to point to {$THRIFT_HOME}/lib/php/src.
# 3. Execute {php DemoClient.php}.  Note that you must use php5 or higher.
# 4. See {$THRIFT_HOME}/lib/php/README for additional help.
 
# Change this to match your thrift root
# e.g. Thrift 0.8.0:
# /opt/thrift-0.9.0/lib/php/lib/Thrift/Transport/TSocket.php
# e.g. Thrift 0.9.0:
# /opt/thrift-0.8.0/lib/php/src/transport/TSocket.php

//$GLOBALS['THRIFT_ROOT'] = '/opt/thrift/lib/php/lib/Thrift';
$GLOBALS['THRIFT_ROOT'] = '/var/www/html/pockcj/Thrift_lib';
 
require_once( $GLOBALS['THRIFT_ROOT'].'/Thrift.php' );

require_once( $GLOBALS['THRIFT_ROOT'].'/Transport/TSocket.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/Transport/TBufferedTransport.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/Protocol/TBinaryProtocol.php' );
 
# According to the thrift documentation, compiled PHP thrift libraries should
# reside under the THRIFT_ROOT/packages directory. If these compiled libraries 
# are not present in this directory, move them there from gen-php/.  
require_once( $GLOBALS['THRIFT_ROOT'].'/Hbase/Hbase.php' );
require_once( $GLOBALS['THRIFT_ROOT'].'/Hbase/Types.php' );

use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;
use Thrift\Protocol\TBinaryProtocol;
use HBase\HbaseClient;
 
$debug = false;
try {
	$socket = new TSocket ('172.100.100.191', 9090); 
	$socket->setSendTimeout (2000);
	$socket->setRecvTimeout (4000);
	$transport = new TBufferedTransport ($socket);
	$protocol = new TBinaryProtocol ($transport);
	$client = new HbaseClient ($protocol);

	$transport->open ();

	$mytable = 'ctm_t_d_gate_out';
    $tscan = new \Hbase\TScan();
    /* $tscan->startRow = $ID_OBJECT.$start_date.'00000000';
    $tscan->stopRow = $ID_OBJECT.$end_date.'23595999';

    $str_add = "";
    if ($transaction_type != "") {
        $str_add = " AND SingleColumnValueFilter('cf','c4',=,'binary:".$transaction_type."')";
    }

    $tscan->filterString = "(PrefixFilter ('".$I_TRX."')".$str_add; */
    
    //$tscan->filterString = "SingleColumnValueFilter('cf','ACCTNO',=,'binary:349501010031110')";
    $result = $client->scannerOpenWithScan($mytable, $tscan , array());
?>
<html>
<head>
<title>pockcj - HBase - Move Object History Table</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/site.css">
<script type="text/javascript" language="javascript" src="js/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.fixedColumns.min.js"></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable({
        "scrollY": 500,
        "scrollX": true,
        fixedColumns:   {
            leftColumns: 1
        }
    });
});
</script>
</head>
<body>
<h3>LNMAST Table</h3>
<table id="myTable" class="display nowrap dataTable dtr-inline">
    <thead>
        <tr>
			<th> I_TRX </th>
			<th> I_GATE_OUT </th>
			<th> C_STATION_IN </th>
			<th> C_PLATFORM_IN </th>
			<th> C_GATE_IN </th>
			<th> D_GATE_IN </th>
			<th> C_STATION_OUT </th>
			<th> C_PLATFORM_OUT </th>
			<th> C_GATE_OUT </th>
			<th> D_GATE_OUT </th>
			<th> C_READER </th>
			<th> I_CLASS_TAP </th>
			<th> I_TRAIN </th>
			<th> I_ISSUER </th>
			<th> I_CARD_TYPE </th>
			<th> C_CARD </th>
			<th> D_EXPIRED </th>
			<th> M_BALANCE_BEFORE </th>
			<th> M_DEDUCT </th>
			<th> M_BALANCE </th>
			<th> D_SALES </th>
			<th> C_STATION_FROM </th>
			<th> C_STATION_TO </th>
			<th> I_CLASS </th>
			<th> C_TRANS </th>
			<th> C_STATUS </th>
			<th> C_DESC </th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ( $rows = $client->scannerGet( $result ) ) {
            echo '
            <tr>
				<td>'.$rows[0]->{'columns'}['f4:I_TRX']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_GATE_OUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_STATION_IN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_PLATFORM_IN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_GATE_IN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:D_GATE_IN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_STATION_OUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_PLATFORM_OUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_GATE_OUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:D_GATE_OUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_READER']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_CLASS_TAP']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_TRAIN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_ISSUER']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_CARD_TYPE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_CARD']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:D_EXPIRED']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:M_BALANCE_BEFORE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:M_DEDUCT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:M_BALANCE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:D_SALES']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_STATION_FROM']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_STATION_TO']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:I_CLASS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_TRANS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_STATUS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f4:C_DESC']->{'value'}.'</td>
            </tr>
            ';
        } ?>
    </tbody>
</table>
</body>
</html>
<?php
	if ($debug) {
		//echo "JOB_ID from the php row:<br>";
	}

	//echo $result[0]->{'columns'}['f4:IDMOHistory']->{'value'};

	$transport->close();
	$socket->close();

} catch (TException $tx) {
	if ($debug) {
		print 'TException: '.$tx->__toString(). ' Error: '.$tx->getMessage() . "\n";
	} else {
		print 'Error connecting PHP with HBase. Maybe the thrift server is not up?';
	}
}
?>
