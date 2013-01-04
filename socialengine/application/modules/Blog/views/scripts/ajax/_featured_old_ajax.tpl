<?php $blog = $this->blog; ?>
 <div id="fearuedsmall">
<table class="fearuedsmall"><tr>
<?php $i = 0; foreach($this->blogs as $item): if($item->blog_id != $blog->blog_id): $i ++;?>
    <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
    <a  class="imgfe" onclick="featured(this)" id="<?php echo $item->blog_id; ?>"  href="javascript:void(0);"> <?php echo $this->itemPhoto($item->getOwner(),'thumb.profile'); ?></a>
   <div style="width: 160px;"> <strong><a class ="titlesmall" onclick="featured(this)" id="<?php echo $item->blog_id; ?>" href="javascript:void(0);"> <?php echo $item->getTitle();?> </a></strong> </div>
                     <div class="blog_entrylist_entry_date" style="margin: 4px 4px 4px 0px; color:#7F7F7F;font-size:8pt; width: 160px;">
                     <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
        <?php echo $this->timestamp($item->creation_date) ?>
                    </div>
    </td>
      <?php if($i == 1 || $i == 2): ?> 
      <td style="padding-left: 32px; padding-right: 32px;">
      <div class="l" style= "height : 210px; width: 1px;"></div>
      </td> 
      <?php endif; ?>
<?php endif; endforeach; ?>
</tr>
</table>
</div>
