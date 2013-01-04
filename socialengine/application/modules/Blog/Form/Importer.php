<?php

class Blog_Form_Importer extends Engine_Form
{
  public $_error = array();

  public function init()
  {   
    $this->setTitle('Import Blogs')
      ->setDescription('If you have posts in another system, You can import those into this site.')
	  ->setAttrib('enctype', 'multipart/form-data')  
      ->setAttrib('name', 'blogs_import');
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    $this->addElement('Select', 'system', array(
      'label' => 'System',
      'multiOptions' => array("0"=>"","1"=>"WordPress", "2"=>"Blogger","3"=>"Tumblr"),
	  'onchange' => "updateTextFields()",
      'description' => 'Choose a system to import .'
    ));
    $this->system->getDecorator('Description')->setOption('placement', 'append');
	
	// Init path
    $this->addElement('File', 'filexml', array(
      'label' => 'Choose a file XML',
    ));
    $this->filexml->addValidator('Extension', false, 'xml');
	
	// Init url
    $this->addElement('Text', 'username', array(
      'label' => 'Username',
      'description' => 'Original Tumblr blog name [Username.tumblr.com, not your email address or custom domain]',
    ));
    $this->username->getDecorator("Description")->setOption("placement", "append");
	
    $this->addElement('Button', 'submit', array(
      'label' => 'Import Blogs',
      'type' => 'submit',
    ));
  } 

}
