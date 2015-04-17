<?php
class Vqt_Plugins_Tracking extends Zend_Controller_Plugin_Abstract {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {

		$controllerName = $request -> getControllerName();
		$moduleName = $request -> getModuleName();
		$track_targets = array("ytservice", "service");

		if ( in_array($controllerName, $track_targets) || ($moduleName == 'api')) {
			// $request->setModuleName('default');
			// $request->setControllerName('test');
			// $request->setActionName('phpinfo');
			$tracking_model = new Model_Tracking();

			$tracking_data = getallheaders();
			$tracking_data['Request-Params'] = $this->_request->getParams();
			$tracking_data['Timestamp'] = time();
			$tracking_data['IP'] = $_SERVER['REMOTE_ADDR'];

			$tracking_model->insert($tracking_data);
		}
	}

}
