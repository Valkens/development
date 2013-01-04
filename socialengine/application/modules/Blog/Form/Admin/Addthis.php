<?php
class Blog_Form_Admin_Addthis extends Engine_Form
{
  public function init()
  {
    
    $this
      ->setTitle('AddThis Settings')
      ->setDescription('These settings affect all members in your community.');
    $this->addElement('Text', 'blog_username', array(
      'label' => 'User name',
      'description' => '',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.username'),
    ));
 $this->addElement('Text', 'blog_password', array(
      'label' => 'Password',
      'description' => '',
      'value' => Engine_Api::_()->getApi('settings', 'core')
                                ->getSetting('blog.password'),
    ));
    $this->addElement('Text', 'blog_pubid', array(
      'label' => '    Profile ID',
      'description' => '',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.pubid'),
    ));
    $this->addElement('Text', 'blog_domain', array(
      'label' => 'Domain',
      'description' => '',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.domain'),
    ));
      $this->addElement('Select', 'blog_period', array(
      'label' => 'Period',
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.period','day'),
      'multiOptions' => array(
        'day' => 'Day',
        'week' => 'Week',
        'month' => 'Month',
      )
    ));
    // Add submit button
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}