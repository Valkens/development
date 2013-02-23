<?php
class System_Controller_AdminController extends Base_Controller_AdminController
{
	public function cacheAction()
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
					$this->view->error = 'Please choose another Cache Type.';
					break;
			}

			if (!isset($this->view->error)) {
				$this->view->success = 'Clear cache successfully.';
			}

			$this->view->type = $params['type'];
		}

		$this->view->caches = $caches;
	}

	public function logAction()
	{
		if ($this->isPost()) {
			file_put_contents(ini_get('error_log'), '');
		}

		$this->view->errorLogs = (file_exists(ini_get('error_log'))) ? file_get_contents(ini_get('error_log')) : '';
	}

	public function settingAction()
	{
		$settingModel = Core_Model::factory('System_Model_Setting');
		$options = array();

        $settings = $settingModel->find_many();

        foreach ($settings as $setting) {
            $options[$setting->name] = trim($setting->value);
        }

		if ($this->isPost()) {
            $sql = array();
            $params = array();
            $options = array_merge($options, $this->_request['params']);

            // Update settings
            $sql[] = 'UPDATE ' . $settingModel->getTableName() . ' SET value = CASE';
            foreach (array_keys($options) as $key) {
                $sql[] = " WHEN name='{$key}' THEN :{$key}";
                $params["$key"] = trim($this->_request['params'][$key]);
            }
            $sql[] = ' END';

            $settingModel->raw_execute(implode('', $sql), $params);

			// Write cache
			$this->_cache['db']->save($options, 'db_settings');

			$this->view->success = 'Change settings successfully';
		}

		$this->view->options = $options;
	}

}