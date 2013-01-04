<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Music
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: index.tpl 9382 2011-10-14 00:41:45Z john $
 * @author     John Boehr <john@socialengine.com>
 */
?>

<?php if( count($this->quickNavigation) > 0 ): ?>
  <div class="quicklinks">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->quickNavigation)
        ->render();
    ?>
  </div>
<?php endif; ?>
