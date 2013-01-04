<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Level.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("BOOK_FORM_ADMIN_LEVEL_DESCRIPTION");

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Books?',
        'description' => 'Do you want to let members create books? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view books, but only want certain levels to be able to create books.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of books.',
          0 => 'No, do not allow books to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Book?',
        'description' => 'Do you want to let members edit books? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all books.',
          1 => 'Yes, allow members to edit their own books.',
          0 => 'No, do not allow members to edit their books.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Books?',
        'description' => 'Do you want to let members delete books? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all books.',
          1 => 'Yes, allow members to delete their own books.',
          0 => 'No, do not allow members to delete their books.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Books?',
        'description' => 'Do you want to let members of this level comment on books?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all books, including private ones.',
          1 => 'Yes, allow members to comment on books.',
          0 => 'No, do not allow members to comment on books.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }

      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Book Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their books. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, everyone will be allowed to view books.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
        'label' => 'Book Comment Options',
        'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries. If you do not check any options, everyone will be allowed to post comments on entries.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));

      // Element: style
      $this->addElement('Radio', 'style', array(
        'label' => 'Allow Custom CSS Styles?',
        'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their books by altering their CSS styles.',
        'multiOptions' => array(
          1 => 'Yes, enable custom CSS styles.',
          0 => 'No, disable custom CSS styles.',
        ),
        'value' => 1,
      ));

      // Element: auth_html
      $this->addElement('Text', 'auth_html', array(
        'label' => 'HTML in Books?',
        'description' => 'If you want to allow specific HTML tags, you can enter them below (separated by commas). Example: b, img, a, embed, font',
        'value' => 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr'
      ));

      // Element: max
        $this->addElement('Text', 'max', array(
            'label' => 'Maximum Allowed Books?',
            'description' => 'Enter the maximum number of allowed books. The field must contain an integer between 1 and 999, or empty for unlimited.',
            'validators' => array(
                array('Int', true),
                new Engine_Validate_AtLeast(0),
            ),
        ));
    }
  }
}