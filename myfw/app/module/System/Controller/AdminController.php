<?php
class System_Controller_AdminController extends Base_Controller_AdminController
{
	public function clearCacheAction()
	{
		// Cache types
		$caches = array(
			array('type' => 'all', 'name' => 'All'),
			array('type' => 'css', 'name' => 'Css'),
			array('type' => 'js', 'name' => 'Js'),
			array('type' => 'template', 'name' => 'Templates'),
			array('type' => 'system', 'name' => 'System'),
			array('type' => 'db', 'name' => 'Database'),
			array('type' => 'log', 'name' => 'Logs')
		);

		if ($this->isPost()) {
			$params = $this->_request['params'];

			switch ($params['type']) {
				case 'all':
					Core_Helper_File::deleteAllFile(BASE_PATH . '/public/cache');
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/template');
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/system');
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/db');
					Core_Helper_File::deleteAllFile(APPLICATION_PATH . '/log');
					break;

				case 'css':
					Core_Helper_File::deleteAllFile(BASE_PATH . '/public/cache', 'css');
					break;
				
				case 'js':
					Core_Helper_File::deleteAllFile(BASE_PATH . '/public/cache', 'js');
					break;

				case 'template':
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/template');
					break;

				case 'system':
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/system');
					break;

				case 'db':
					Core_Helper_File::deleteAllFile(CACHE_PATH . '/db');
					break;

				case 'log':
					Core_Helper_File::deleteAllFile(APPLICATION_PATH . '/log');
					break;

				default:
					$this->_data['error'] = 'Please choose another Cache Type.';
					break;
			}

			if (!isset($this->_data['error'])) {
				$this->_data['success'] = 'Clear cache successfully.';
			}

			$this->_data['type'] = $params['type'];
		}

		$this->_data['caches'] = $caches; 
	}

	public function viewLogAction()
	{
		if ($this->isPost()) {
			file_put_contents(ini_get('error_log'), '');
		}

		$this->_data['errorLogs'] = (file_exists(ini_get('error_log'))) ? file_get_contents(ini_get('error_log')) : '';
	}

	public function settingAction()
	{
		$settingModel = new System_Model_Setting();
		$options = array();

		if (!$options = $this->_cache['db']->load('db_settings')) {
			$settings = $settingModel->fetchAll();
			foreach ($settings as $setting) {
				$options[$setting->name] = trim($setting->value);
			}
			$this->_cache['db']->save($options, 'db_settings');
		}
		

		if ($this->isPost()) {
			$settingModel->updateAll(array_keys($options), $this->_request['params']);
			$options = array_merge($options, $this->_request['params']);

			// Write cache
			$this->_cache['db']->save($options, 'db_settings');

			$this->_data['success'] = 'Change settings successfully';
		}

		$this->_data['options'] = $options;
	}

}