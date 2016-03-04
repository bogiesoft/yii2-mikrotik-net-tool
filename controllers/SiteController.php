<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\base\ErrorException;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\RouterTable;
use app\models\ActionForm;
use PEAR2\Net\RouterOS as Mikrotik;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'execute' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $model = new ActionForm();

        return $this->render('index', ['model' => $model]);
    }

    public function actionLogin()
    {
        
    }

    public function actionLogout() {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionExecute() {

        $model = new ActionForm();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $stats = [];

            $router_model = new RouterTable();
            $router_server = $router_model->getData($model->router);
            $connect = new Mikrotik\Client($router_server['host'], $router_server['user'], $router_server['pass'], $router_server['port'], false, 10);

            if ($model->action == "traceroute") {
                $tracerouteRequest = new Mikrotik\Request('/tool traceroute duration=6 address=' . $model->host . ' src-address=' . $router_server['src_address']);
                $responses = $connect->sendSync($tracerouteRequest);

                if ($responses->getType() === Mikrotik\Response::TYPE_ERROR) {
                    echo '<pre>' . $responses->getProperty('message') . '</pre>';
                } else {
                    echo '<pre>';
                    echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-borderless\">";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<td>#</td>";
                    echo "<td>ADDRESS</td>";
                    echo "<td>LOSS</td>";
                    //echo "<td>SENT</td>";
                    echo "<td>LAST</td>";
                    echo "<td>AVG</td>";
                    echo "<td>BEST</td>";
                    echo "<td>WORST</td>";
                    echo "<td>STD-DEV</td>";
                    echo "<td>STATUS</td>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";

                    $no = 1;

                    foreach ($responses as $response) {
                        if ($response->getType() === Mikrotik\Response::TYPE_DATA) {

                            if ($response->getProperty('.section') == 5) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $response->getProperty('address') . "</td>";
                                echo "<td>" . $response->getProperty('loss') . "%</td>";
                                //echo "<td>".$response->getProperty('sent')."</td>";
                                echo "<td>" . $response->getProperty('last') . "</td>";
                                echo "<td>" . $response->getProperty('avg') . "</td>";
                                echo "<td>" . $response->getProperty('best') . "</td>";
                                echo "<td>" . $response->getProperty('worst') . "</td>";
                                echo "<td>" . $response->getProperty('std-dev') . "</td>";
                                echo "<td>" . $response->getProperty('status') . "</td>";
                                echo "</tr>";
                            }
                        }
                    }

                    echo "</tbody>";

                    echo "</table>";
                    echo "</div>";
                    echo "Request done.";
                    echo '</pre>';
                }
            } elseif ($model->action == "ping") {


                $pingRequest = new Mikrotik\Request('/ping address=' . $model->host . ' count=5 src-address=' . $router_server['src_address']);

                $responses = $connect->sendSync($pingRequest);

                if ($responses->getType() === Mikrotik\Response::TYPE_ERROR) {
                    echo '<pre>' . $responses->getProperty('message') . '</pre>';
                } else {
                    echo '<pre>';
                    echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-borderless\">";
                    echo "<thead>";
                    echo "<tr>";
                    //echo "<td>SEQ</td>";
                    echo "<td>HOST</td>";
                    echo "<td>SIZE</td>";
                    echo "<td>TTL</td>";
                    echo "<td>TIME</td>";
                    echo "<td>STATUS</td>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";
                    foreach ($responses as $response) {
                        if ($response->getType() === Mikrotik\Response::TYPE_DATA) {
                            echo "<tr>";
                            //echo "<td>".$response->getProperty('seq')."</td>";
                            echo "<td>" . $response->getProperty('host') . "</td>";
                            echo "<td>" . $response->getProperty('size') . "</td>";
                            echo "<td>" . $response->getProperty('ttl') . "</td>";
                            echo "<td>" . $response->getProperty('time') . "</td>";
                            echo "<td>" . $response->getProperty('status') . "</td>";
                            echo "</tr>";

                            // stats response
                            $sent = $response->getProperty('sent') != null ? 'sent=' . $response->getProperty('sent') : '';
                            $received = $response->getProperty('received') != null ? 'received=' . $response->getProperty('received') : '';
                            $packet_loss = $response->getProperty('packet-loss') != null ? 'packet-loss=' . $response->getProperty('packet-loss') . '%' : '';
                            $min_rtt = $response->getProperty('min-rtt') != null ? 'min-rtt=' . $response->getProperty('min-rtt') : '';
                            $avg_rtt = $response->getProperty('avg-rtt') != null ? 'avg-rtt=' . $response->getProperty('avg-rtt') : '';
                            $max_rtt = $response->getProperty('max-rtt') != null ? 'max-rtt=' . $response->getProperty('max-rtt') : '';

                            $stats['response'] = "<strong>" . $sent . " " . $received . " " . $packet_loss . " " . $min_rtt . " " . $avg_rtt . " " . $max_rtt . "</strong>";
                        }
                    }

                    echo "<tr><td colspan=\"6\">" . $stats['response'] . "</td></tr>";

                    echo "</tbody>";

                    echo "</table>";
                    echo "</div>";
                    echo "Request done.";
                    echo '</pre>';
                }
            } elseif ($model->action == "bt") {

                $bt_username = $model->bt_username != null ? " user=" . $model->bt_username : '';
                $bt_password = $model->bt_password != null ? " password=" . $model->bt_password : '';
                $bt_duration = $model->bt_duration != null ? $model->bt_duration : 10;

                // 1s for connecting
                $bwRequest = new Mikrotik\Request('/tool bandwidth-test address=' . $model->host . ' duration=' . $bt_duration . ' protocol=' . $model->bt_protocol . ' direction=' . $model->bt_direction . $bt_username . $bt_password);

                $responses = $connect->sendSync($bwRequest);

                if ($responses->getType() === Mikrotik\Response::TYPE_ERROR) {
                    echo '<pre>' . $responses->getProperty('message') . '</pre>';
                } else {
                    $response_series_tx = [];
                    $response_series_rx = [];
                    $response_series = [];
                    $response_labels = [];

                    foreach ($responses as $extract_response) {
                        if ($extract_response->getType() === Mikrotik\Response::TYPE_DATA) {

                            if ($responses->getProperty('status') == "can not connect") {
                                die('<pre>' . $responses->getProperty('status') . '</pre>');
                            } elseif ($responses->getProperty('status') == "authentication failed") {
                                die('<pre>' . $responses->getProperty('status') . '</pre>');
                            } else {
                                //1s for connecting
                                if ($extract_response->getProperty('duration') != '0s') {
                                    $response_labels[] = $extract_response->getProperty('duration');
                                    if ($model->bt_direction == "transmit") {
                                        if ($extract_response->getProperty('duration') == $bt_duration . 's') {
                                            $tx_current = $extract_response->getProperty('tx-current');
                                            $tx_10_second_average = $extract_response->getProperty('tx-10-second-average');
                                            $tx_total_average = $extract_response->getProperty('tx-total-average');
                                        }

                                        $response_series[] = \Yii::$app->tools->formatMbps($extract_response->getProperty('tx-current'));
                                    } elseif ($model->bt_direction == "receive") {
                                        if ($extract_response->getProperty('duration') == $bt_duration . 's') {
                                            $rx_current = $extract_response->getProperty('rx-current');
                                            $rx_10_second_average = $extract_response->getProperty('rx-10-second-average');
                                            $rx_total_average = $extract_response->getProperty('rx-total-average');
                                        }

                                        $response_series[] = \Yii::$app->tools->formatMbps($extract_response->getProperty('rx-current'));
                                    } else {
                                        if ($extract_response->getProperty('duration') == $bt_duration . 's') {

                                            $tx_current = $extract_response->getProperty('tx-current');
                                            $tx_10_second_average = $extract_response->getProperty('tx-10-second-average');
                                            $tx_total_average = $extract_response->getProperty('tx-total-average');

                                            $rx_current = $extract_response->getProperty('rx-current');
                                            $rx_10_second_average = $extract_response->getProperty('rx-10-second-average');
                                            $rx_total_average = $extract_response->getProperty('rx-total-average');
                                        }

                                        $response_series_tx[] = \Yii::$app->tools->formatMbps($extract_response->getProperty('tx-current'));
                                        $response_series_rx[] = \Yii::$app->tools->formatMbps($extract_response->getProperty('rx-current'));
                                    }
                                }
                            }
                        }
                    }

                    if ($model->bt_direction == "transmit") {

                        $json_res_labels = json_encode($response_labels);
                        $json_res_series = json_encode($response_series);

                        $bt_desc = "<div class\"bt-desc\">";
                        $bt_desc .= "<ul class=\"list-inline\">";
                        $bt_desc .= "<li><div style=\"width:10px;height:10px;background:blue;display:inline-block;\"></div></li>";
                        $bt_desc .= "<li><strong>Transmit</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-current : " . \Yii::$app->tools->formatSpeed($tx_current) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-10-second-average : " . \Yii::$app->tools->formatSpeed($tx_10_second_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-total-average : " . \Yii::$app->tools->formatSpeed($tx_total_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>duration : {$bt_duration}s</strong></li>";
                        $bt_desc .= "</ul>";
                        $bt_desc .= "</ul>";
                        $bt_desc .= "</div>";

                        $style = "<style>
                        .ct-series-a .ct-line {
                            stroke: blue;
                            stroke-width: 4px;
                        }

                        .ct-series-a .ct-point {
                            stroke: blue;
                        }

                        .ct-series-a .ct-area {
                            fill:blue;
                        }
                        </style>";


                        $JS = "<script>
                        var optChart = {
                          low :0,
                          fullWidth: true,
                          showArea: true,
                          height: 300
                        };
                        var dataChart = {

                          labels: " . $json_res_labels . ",

                          series: [
                          " . $json_res_series . "
                          ]
                        };

                        new Chartist.Line('#result', dataChart, optChart);</script>";

                        echo $style . $bt_desc . $JS;
                    } elseif ($model->bt_direction == "receive") {
                        $json_res_labels = json_encode($response_labels);
                        $json_res_series = json_encode($response_series);

                        $bt_desc = "<div class\"bt-desc\">";
                        $bt_desc .= "<ul class=\"list-inline\">";
                        $bt_desc .= "<li><div style=\"width:10px;height:10px;background:red;display:inline-block;\"></div></li>";
                        $bt_desc .= "<li><strong>Receive</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-current : " . \Yii::$app->tools->formatSpeed($rx_current) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-10-second-average : " . \Yii::$app->tools->formatSpeed($rx_10_second_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-total-average : " . \Yii::$app->tools->formatSpeed($rx_total_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>duration : {$bt_duration}s</strong></li>";
                        $bt_desc .= "</ul>";
                        $bt_desc .= "</div>";

                        $JS = "<script>
                        var optChart = {
                          low :0,
                          fullWidth: true,
                          showArea: true,
                          height: 300
                        };
                        var dataChart = {

                          labels: " . $json_res_labels . ",

                          series: [
                          " . $json_res_series . ",
                          ]
                        };

                        new Chartist.Line('#result', dataChart, optChart);

                        </script>";

                        echo $bt_desc . $JS;
                    } else {
                        $json_res_labels = json_encode($response_labels);
                        $json_res_series = json_encode([$response_series_rx, $response_series_tx]);

                        $bt_desc = "<div class\"bt-desc-rx\">";
                        $bt_desc .= "<ul class=\"list-inline\">";
                        $bt_desc .= "<li><div style=\"width:10px;height:10px;background:red;display:inline-block;\"></div></li>";
                        $bt_desc .= "<li><strong>Receive</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-current : " . \Yii::$app->tools->formatSpeed($rx_current) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-10-second-average : " . \Yii::$app->tools->formatSpeed($rx_10_second_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>rx-total-average : " . \Yii::$app->tools->formatSpeed($rx_total_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>duration : {$bt_duration}s</strong></li>";
                        $bt_desc .= "</ul>";
                        $bt_desc .= "</div>";

                        $bt_desc .= "<div class\"bt-desc-tx\">";
                        $bt_desc .= "<ul class=\"list-inline\">";
                        $bt_desc .= "<li><div style=\"width:10px;height:10px;background:blue;display:inline-block;\"></div></li>";
                        $bt_desc .= "<li><strong>Transmit</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-current : " . \Yii::$app->tools->formatSpeed($tx_current) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-10-second-average : " . \Yii::$app->tools->formatSpeed($tx_10_second_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>tx-total-average : " . \Yii::$app->tools->formatSpeed($tx_total_average) . "</strong></li>";
                        $bt_desc .= "<li class=\"bt-li-desc\"><strong>duration : {$bt_duration}s</strong></li>";
                        $bt_desc .= "</ul>";
                        $bt_desc .= "</div>";


                        $JS = "<script>
                        var optChart = {
                          low :0,
                          fullWidth: true,
                          showArea: true,
                          height: 300,
                        };
                        var dataChart = {

                          labels: " . $json_res_labels . ",

                          series: " . $json_res_series . ",
                        };

                        new Chartist.Line('#result', dataChart, optChart);</script>";

                        echo $bt_desc . $JS;
                    }
                }
            }
        }
    }

}
