<?php
class Tag_Controller_AdminController extends Base_Controller_AdminController
{
	public function suggestAction()
	{
		$params = $this->_request['params'];
		$tagModel = new Tag_Model_Tag();

		$tags = $tagModel->fetchAll('name', 'WHERE slug LIKE :slug', array(':slug' =>'%' . 
																			Base_Helper_String::generateSlug($params['term'])
																			. '%'));
		$data = array();

		foreach ($tags as $tag) {
			$data[]['label'] = $tag->name;
		}

        $this->_noRender = true;
		echo json_encode($data);
	}
}