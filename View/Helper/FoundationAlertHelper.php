<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Helper to generate HTML markup complying with ZURB Foundation's alert styles.
 * You will need to include foundation.alerts.js to be able to close an alert.
 * 
 * See Foundation's documentation: http://foundation.zurb.com/docs/components/alert-boxes.html
 */
class FoundationAlertHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	/**
	 * Generate a single alert.
	 * @param string $class to apply to alert
	 * @param array $message to display in alert
	 * @return string alert HTML
	 */
	public function alert($class = '', $message = '') {
		$class .= ' alert-box ';
		$message .= $this->Html->link('&times;', array('#' => '#'), array('escape' => FALSE));
		$alertHtml = $this->Html->div($class, $message, array(
				'escape' => FALSE,
				'data-alert' => ''
		));
		return $alertHtml;
	}
}
