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

	$mytable = 'movobject_client';
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
<h3>Move Object Client Table</h3>
<table id="myTable" class="display nowrap dataTable dtr-inline">
    <thead>
        <tr>
			<th> ID_OBJECT </th>
			<th> OBJECT_NAME </th>
			<th> NO_URUT </th>
			<th> ADDRESS </th>
			<th> IDCOUNTRY </th>
			<th> OWNER </th>
			<th> IDDEVICE </th>
			<th> VERSION </th>
			<th> SUB_VERSION </th>
			<th> SALDOSTATUS </th>
			<th> REQSALDO </th>
			<th> LAST_LATITUDE </th>
			<th> LAST_LONGITUDE </th>
			<th> LAST_TIME </th>
			<th> LAST_SPEED </th>
			<th> LAST_URI </th>
			<th> STATUSAKTIF </th>
			<th> NOMOR_KA </th>
			<th> NOMOR_KA_HW </th>
			<th> INSTALLATION_DATE </th>
			<th> KELAS </th>
			<th> RELASI </th>
			<th> ID_STATION_ORIGIN </th>
			<th> ID_STATION_DESTINATION </th>
			<th> NOMOR_SIM </th>
			<th> LAST_STASIUN_TERDEKAT </th>
			<th> LAST_ID_STATION </th>
			<th> LAST_ID_STATION_BEFORE </th>
			<th> ID_STATION_PAIR </th>
			<th> ID_STATION_PAIR_TEMP </th>
			<th> LAST_TIME_STATION_PAIR </th>
			<th> LAST_TIME_STATION_PAIR_TEMP </th>
			<th> LAST_RADIUS_TERDEKAT </th>
			<th> LAST_STATUS_POSISI </th>
			<th> LAST_DESKRIPSI_POSISI </th>
			<th> LAST_TEMPERATURE </th>
			<th> ID_POSISI </th>
			<th> LINE_ID_STATION1 </th>
			<th> LINE_ID_STATION2 </th>
			<th> DIGITAL_OUT_COUNT_DOWN </th>
			<th> KA_NOMOR </th>
			<th> KA_ASSIGNED_BY </th>
			<th> KA_ASSIGNED_TIME </th>
			<th> KA_NODE_COLOR </th>
			<th> MASINIS_NO </th>
			<th> RSV </th>
			<th> KETERANGAN </th>
			<th> FOTO_CABIN1 </th>
			<th> FOTO_CABIN2 </th>
			<th> FOTO_CABIN3 </th>
			<th> IS_RESERVE </th>
			<th> IS_OWN_PARTNER </th>
			<th> ID_PARTNER </th>
			<th> IS_INVALID </th>
			<th> INVALID_DATE </th>
			<th> ADDITIONAL_INFO1 </th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ( $rows = $client->scannerGet( $result ) ) {
            echo '
            <tr>
				<td>'.$rows[0]->{'columns'}['f1:ID_OBJECT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:OBJECT_NAME']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:NO_URUT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ADDRESS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:IDCOUNTRY']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:OWNER']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:IDDEVICE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:VERSION']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:SUB_VERSION']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:SALDOSTATUS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:REQSALDO']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_LATITUDE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_LONGITUDE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_TIME']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_SPEED']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_URI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:STATUSAKTIF']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:NOMOR_KA']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:NOMOR_KA_HW']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:INSTALLATION_DATE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KELAS']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:RELASI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_STATION_ORIGIN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_STATION_DESTINATION']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:NOMOR_SIM']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_STASIUN_TERDEKAT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_ID_STATION']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_ID_STATION_BEFORE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_STATION_PAIR']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_STATION_PAIR_TEMP']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_TIME_STATION_PAIR']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_TIME_STATION_PAIR_TEMP']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_RADIUS_TERDEKAT']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_STATUS_POSISI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_DESKRIPSI_POSISI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LAST_TEMPERATURE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_POSISI']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LINE_ID_STATION1']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:LINE_ID_STATION2']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:DIGITAL_OUT_COUNT_DOWN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KA_NOMOR']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KA_ASSIGNED_BY']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KA_ASSIGNED_TIME']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KA_NODE_COLOR']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:MASINIS_NO']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:RSV']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:KETERANGAN']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:FOTO_CABIN1']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:FOTO_CABIN2']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:FOTO_CABIN3']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:IS_RESERVE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:IS_OWN_PARTNER']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ID_PARTNER']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:IS_INVALID']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:INVALID_DATE']->{'value'}.'</td>
				<td>'.$rows[0]->{'columns'}['f1:ADDITIONAL_INFO1']->{'value'}.'</td>
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

	//echo $result[0]->{'columns'}['f1:IDMOHistory']->{'value'};

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
