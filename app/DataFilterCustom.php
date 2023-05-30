<?php
namespace App;

use Zofe\Rapyd\DataFilter\DataFilter;

class DataFilterCustom extends DataFilter {
	public function setProcessUrl($url) {
		$this->process_url = $url;
	}
	
	public function setResetUrl($url) {
		$this->reset_url = $url;
	}
	
	protected function process(){
		parent::process();
        $this->method = 'POST';
    }
}