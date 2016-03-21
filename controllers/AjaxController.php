<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\RouterTable;
use app\models\cacti\HostTable;

class AjaxController extends Controller{

	private $serverCacti = 'http://103.11.222.221/cacti';

	private $username = 'admin';
	private $password = 'detaminx07';

	public function actionFetchInterface($host){
		$model = RouterTable::findOne($host);

		$graphs = explode(',',$model['rra_graph']);


		return $this->renderPartial('fetch-interface',['graphs' => $graphs]);
	}

	public function actionRenderGraph($graph,$time)
	{

        $fromTime = strtotime("00:00:00");
        $endTime = strtotime("23:59:59");


		$graph_url = $this->serverCacti . "/graph_image.php?action=zoom&local_graph_id=" . $graph . "&graph_start=" . $fromTime . "&graph_end=" . $endTime;

		$domClass = new \DOMDocument();
        $domClass->loadHTMLFile($this->serverCacti);

        $csrf_value = $domClass->getElementById('csrf-dtn')->getAttribute('value');
        $post_data = "__csrf_magic=" . $csrf_value . "&" . "action=login" . "&" . "login_username=" . $this->username . "&" . "login_password=" . $this->password;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->serverCacti . "/index.php");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_REFERER, $this->serverCacti . "/index.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, '../runtime/cacti_cookies_jar');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '../runtime/cacti_cookies_file');
        curl_exec($ch);

        /** Get Graph * */
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        $graph = curl_exec($ch);

        curl_close($ch);

        $response = \Yii::$app->getResponse();
		$response->headers->set('Content-Type', 'image/png');
		$response->format = \yii\web\Response::FORMAT_RAW;

		echo $graph;

		return $response->send();

	}

}