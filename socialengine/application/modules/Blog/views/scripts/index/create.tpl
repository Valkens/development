<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: create.tpl 7244 2010-09-01 01:49:53Z john $
 * @author     Jung
 */
?>

<?php
  $this->headScript()
    ->appendFile($this->baseUrl().'/externals/autocompleter/Observer.js')
    ->appendFile($this->baseUrl().'/externals/autocompleter/Autocompleter.js')
    ->appendFile($this->baseUrl().'/externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($this->baseUrl().'/externals/autocompleter/Autocompleter.Request.js');
?>

<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'customChoices' : true,
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'tag-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });
</script>

<div class="headline">
  <h2>
    <?php echo $this->translate('Blogs');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
    <span style="float: right;">
      <a href="<?php echo $this->url(array('action' => 'rss'), 'blog_general') ?>"><img src="./application/modules/Blog/externals/images/rssBig.png" alt="RSS" title="RSS"></a>
      </span>
  </div>
</div>

<?php    $user = Engine_Api::_()->user()->getViewer();
        $mtable  = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $msselect = $mtable->select()
                    ->where("type = 'blog'")
                    ->where("level_id = ?",$user->level_id)
                    ->where("name = 'max'");
        $mallow = $mtable->fetchRow($msselect);
        $max_blogs =  Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('blog', $user, 'max');
        if($max_blogs == "")
        {
            if (!empty($mallow))
                $max_blogs = $mallow['value'];
        }
        $cout_blog = Blog_Model_Blog::getCountBlog($user);
        if($cout_blog < $max_blogs):
             echo $this->form->render($this);
        else: ?>
           <div style="color: red; padding-left: 300px;">
                <?php echo $this->translate("Sorry! Maximum numbers of allowed blog entries : "); echo $max_blogs; echo " blog entries" ; ?>
           </div>
        <?php endif; ?>
