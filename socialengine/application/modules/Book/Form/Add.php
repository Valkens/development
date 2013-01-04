<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Create.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_Form_Add extends Engine_Form
{
    public $error = array();

    /**
     * Init form
     *
     */
    public function init()
    {
        // Set form attributes
        $this->setTitle('Add new book')
             ->setDescription('Add your new book below, then click "Save book" to publish the book to your list book')
             ->setAttrib('name', 'book_add');

        $user = Engine_Api::_()->user()->getViewer();
        $user_level = Engine_Api::_()->user()->getViewer()->level_id;

        /*
         * Add elements into form
         */
        $this->addElement('Text', 'title', array(
            'label'      => 'Title',
            'allowEmpty' => false,
            'required'   => true,
            'filters'     => array(
                new Engine_Filter_Censor(),
                'StripTags',
                new Engine_Filter_StringLength(array('max' => 128))
            ),
        ));

        $this->addElement('Text', 'author', array(
            'label'      => 'Author',
            'allowEmpty' => false,
            'required'   => true,
            'filters'    => array(
                new Engine_Filter_Censor(),
                'StripTags',
                new Engine_Filter_StringLength(array('max' => 128))
            ),
        ));

        $this->addElement('TextArea', 'description', array(
            'label'      => 'Description',
            'allowEmpty' => false,
            'required'   => true,
            'maxlength'   => '300',
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_StringLength(array('max' => '300')),
                new Engine_Filter_EnableLinks(),
            ),
        ));

        $this->addElement('File', 'image', array(
            'label' => 'Image',
        ));
        $this->image->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        $this->addElement('Text', 'price', array(
            'label' => 'Price',
            'value' => 0,
            'validators' => array(
                array('Float', true),
                new Engine_Validate_AtLeast(0),
            ),
        ));

        // Comment
        $availableLabels = array(
            'everyone'       => 'Everyone',
            'owner_network' => 'Friends and Networks',
            'owner_member_member'  => 'Friends of Friends',
            'owner_member'         => 'Friends Only',
            'owner'          => 'Just Me'
        );

        $options =(array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('book', $user, 'auth_comment');
        $options = array_intersect_key($availableLabels, array_flip($options));

        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this book?',
            'multiOptions' => $options,
            'value' => 'everyone',
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');

        $this->addElement('Button', 'submit', array(
            'label' => 'Save book',
            'type' => 'submit',
        ));
    }
}

