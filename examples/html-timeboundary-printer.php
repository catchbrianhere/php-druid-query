<?php
/**
 * DruidFamiliar HTML TimeBoundary Printer Example
 *
 * Point your browser at this through a web server and you should see nicely formatted time boundary data. :)
 */

use DruidFamiliar\Response\TimeBoundaryResponse;

require_once('../vendor/autoload.php');
$examplesDir = dirname(__FILE__);
$examplesConfig = require_once($examplesDir . '/_examples-config.php');

$druidHost = $examplesConfig['druid-host'];
$druidPort = $examplesConfig['druid-port'];
$druidDataSource = $examplesConfig['druid-dataSource'];

date_default_timezone_set('America/Denver');

$c = new \DruidFamiliar\DruidNodeDruidQueryExecutor($druidHost, $druidPort);

$q = new \DruidFamiliar\QueryGenerator\TimeBoundaryDruidQueryGenerator($druidDataSource);
$p = new \DruidFamiliar\QueryParameters\TimeBoundaryQueryParameters($druidDataSource);
/**
 * @var TimeBoundaryResponse $r
 */
$r = $c->executeQuery($q, $p, new DruidFamiliar\ResponseHandler\TimeBoundaryResponseHandler());

$startTime = new DateTime( $r->minTime );
$endTime = new DateTime( $r->maxTime );

$formattedStartTime = $startTime->format("F m, Y h:i:s A");
$formattedEndTime = $endTime->format("F m, Y h:i:s A");

echo <<<HTML_BODY
<!doctype html>
<html>
    <head>
        <style>
            .basic-table--table {
                border-collapse: collapse;
                width: 100%;

            }

            .basic-table--table,
             .basic-table--table th,
             .basic-table--table td {
                border: 1px solid #C36182;
            }


             .basic-table--table th {
                background-color: #C36182;
                color: white;
                padding: .5em 1em;
             }

             .basic-table--table td {
                padding: .25em 1em;
             }

             .basic-table--table th:first-child,
             .basic-table--table td:first-child {
                text-align: right;
             }
        </style>
    </head>
    <body>
        <h1>TimeBoundary data for DataSource "<b>$druidDataSource</b>": </h1>
        <table class="basic-table--table">
            <thead>
                <tr>
                    <th>DataSource</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>$druidDataSource</td>
                    <td>$formattedStartTime</td>
                    <td>$formattedEndTime</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>

HTML_BODY;
