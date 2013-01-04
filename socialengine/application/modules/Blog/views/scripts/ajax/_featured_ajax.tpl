<?php $blog = $this->blog; ?>
 <div id="featured">
<table>
                  <tr>
                  <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
                  <a  href="<?php echo $blog->getOwner()->getHref(); ?>"> <?php echo $this->itemPhoto($blog->getOwner(),'thumb.profile'); ?></a>

                  </td>
                  <td valign='top' class="contentbox" style="width: auto; padding-left: 30px;">
                    <strong id="title"><?php echo $this->htmlLink($blog->getHref(), $blog->getTitle()) ?> </strong>
                     <div id="date" class="blog_entrylist_entry_date" style="margin: 4px 4px 4px 0px; color:#7F7F7F;font-size:8pt;">
                     <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($blog->getOwner()->getHref(), $blog->getOwner()->getTitle()) ?>
        <?php echo $this->timestamp($blog->creation_date) ?>  <?php //echo $blog->getCountLikes(); ?>
                    </div>
                    <div id="body" class="blog_entrylist_entry_body" style="color:#000">
                     <?php echo substr(strip_tags($blog->body), 0, 850); if (strlen($blog->body)>850) echo "..."; ?>
                     </div>
                  </td>
                  </tr>
            </table>
      </div>               