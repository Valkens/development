 
<h2>Blogs &#187; <?php echo $this->category_name; ?></h2>

       
<?php //<div style="border: #DDDDDD solid 1px; -moz-border-radius:10px 10px 10px 10px; padding: 25px 5px 25px 25px; " > ?> 
          
                     <table cellpadding="0" cellspacing="0" border="0px">
        <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
      <?php $index = 0; foreach( $this->paginator as $blog ): $index++;  ?>
                         <td>
           <table>
                  <tr>
                  <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
                     <?php echo $this->htmlLink($blog->getOwner()->getHref(), $this->itemPhoto($blog->getOwner(), 'thumb.normal')) ?>
                  </td>
                  <td valign='top' class="contentbox">
                    <strong style=""><?php echo $this->htmlLink($blog->getHref(), $blog->getTitle()) ?> </strong>
                     <div class="blog_entrylist_entry_date" style="margin: 4px 4px 4px 0px; color:#7F7F7F;font-size:8pt;">
                     <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($blog->getOwner()->getHref(), $blog->getOwner()->getTitle()) ?>
        <?php echo $this->timestamp($blog->creation_date) ?>  <?php //echo $blog->getCountLikes(); ?>
                    </div>
                    <div class="blog_entrylist_entry_body" style="color:#707070; word-wrap:break-word; width:200px;">
                     <?php echo substr(strip_tags($blog->body), 0, 120); if (strlen($blog->body)>119) echo "..."; ?>
                     </div>
                  </td>
                  </tr>
            </table>
            </td> 
           
         <?php if($index%2 == 0 ): echo '</tr><tr>'; endif;?>
          <?php  if($index < $this->items_per_page &&  $index%2 == 0 && $index < $this->paginator->getTotalItemCount()-1): echo ' <tr><td class="b" style="height:10px; "></td><td class="b" style="height:10px;"></td></tr> '; endif;?>
        
      <?php endforeach; ?>
 </table>
  
  <?php elseif( $this->category || $this->show == 2 || $this->search ):?>
  <tr>
  <td>
    <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has written a blog entry with that criteria.');?>
        <?php if (TRUE): ?>
          <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
        <?php endif; ?>
      </span>

    </div>
    </td>
    </tr>
    </table>
  <?php else:?>
  <tr><td>
    <div class="tip">
      <span>
        <?php echo $this->translate('Nobody has written a blog entry yet.'); ?>
        <?php if( $this->canCreate ): ?>
          <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
    </td>
    </tr>
    </table>
  <?php endif; ?> <br/>
  <?php echo $this->paginationControl($this->paginator, null, array("pagination/blogpagination1.tpl","blog")); ?>
  <?php //</div>  ?>          
                </div>
    </div></div>
</div>
<style type="text/css">
.contentbox {
padding:2px 10px 6px 5px;
width:240px;
}
img.thumb_normal
{
    width:110px !important;
    height:90px !important;
}
</style>