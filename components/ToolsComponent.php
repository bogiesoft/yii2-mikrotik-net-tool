<?php
namespace app\components;

use yii\base\Component;

class ToolsComponent extends Component {
	public function formatSpeed($bytes, $precision = 1) {

		if ($bytes >= 1000000000){
			$bytes = number_format($bytes / 1000000000, $precision) . ' Gbps';
		}elseif ($bytes >= 1000000){
			$bytes = number_format($bytes / 1000000, $precision) . ' Mbps';
		}elseif ($bytes >= 1000){
			$bytes = number_format($bytes / 1000, $precision) . ' Kbps';
		}elseif ($bytes > 1){
			$bytes = $bytes . ' bps';
		}elseif ($bytes == 1){
			$bytes = $bytes . ' bps';
		}else{
			$bytes = '0 bps';
		}

		return $bytes; 
	}

	public function formatMbps($bytes, $precision = 2) { 
		$bytes = $bytes/1000000;

		return round($bytes,$precision); 
	} 
}