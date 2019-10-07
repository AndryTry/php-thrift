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
$GLOBALS['THRIFT_ROOT'] = '/u03/var/www/html/pockcj/Thrift_lib';
 
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
	$socket = new TSocket ('10.1.80.160', 9090); 
	$socket->setSendTimeout (2000);
	$socket->setRecvTimeout (4000);
	$transport = new TBufferedTransport ($socket);
	$protocol = new TBinaryProtocol ($transport);
	$client = new HbaseClient ($protocol);

	$transport->open ();

	$mytable = 'movobject_history';
    $tscan = new \Hbase\TScan();
    /* $tscan->startRow = $ID_OBJECT.$start_date.'00000000';
    $tscan->stopRow = $ID_OBJECT.$end_date.'23595999';

    $str_add = "";
    if ($transaction_type != "") {
        $str_add = " AND SingleColumnValueFilter('cf','c4',=,'binary:".$transaction_type."')";
    }

    $tscan->filterString = "(PrefixFilter ('".$ID_OBJECT."')".$str_add; */
    
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
			<th> ID_OBJECT </th>
			<th> IDDevice </th>
			<th> ka_nomor </th>
			<th> LONGITUDE </th>
			<th> LATITUDE </th>
			<th> NMEA </th>
			<th> SPEED </th>
			<th> SPEEDVAL </th>
			<th> LOG_TIME </th>
			<th> LOG_DATE </th>
			<th> LOG_DAY </th>
			<th> REQUEST_URI </th>
			<th> stasiun_terdekat </th>
			<th> id_station </th>
			<th> radius_terdekat </th>
			<th> status_posisi </th>
			<th> deskripsi_posisi </th>

        </tr>
    </thead>
    <tbody>
        <?php
        while ( $rows = $client->scannerGet( $result ) ) {
            echo '
            <tr>
				<td>'.$rows[0]->{'columns'}['cf:ID_OBJECT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:IDDevice']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:ka_nomor']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:LONGITUDE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:LATITUDE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:NMEA']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:SPEED']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:SPEEDVAL']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:LOG_TIME']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:LOG_DATE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:LOG_DAY']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:REQUEST_URI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:stasiun_terdekat']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:id_station']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:radius_terdekat']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:status_posisi']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['cf:deskripsi_posisi']->{'value'}.'</td>

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

	//echo $result[0]->{'columns'}['cf:IDMOHistory']->{'value'};

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
