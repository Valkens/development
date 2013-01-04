<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/externals/styles/main.css')
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/featured-blogs/styles.css');
?>
<ul>
  
      
 <div><div>
                <div class="vertmenu"> 
                    <div>
<?php if(count($this->blogs) <= 0): ?>              
       <div class="tip" style="clear: inherit;">
      <span>
           <?php echo $this->translate('There is not featured blog.');?>
      </span>
           <div style="clear: both;"/>
    </div> 
    </div>
    </div></div></div>
</div>   

 <?php else: $items =  $this->blogs; $blog = $items[0]?>
 <div id="featured">
 <table >
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
               </div>
</div></div>
</div>   
  
 <?php endif; ?>
   
<?php if(count($this->blogs) > 1): $i = 0;?>
 <div id="fearuedsmall" style="padding: 10px 10px 10px 18px;">
<table class="fearuedsmall"><tr>
<?php foreach($items as $item): if($item->blog_id != $blog->blog_id): $i ++;?>
    <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
    <a  class="imgfe" onclick="featured(this)" id="<?php echo $item->blog_id; ?>"  href="javascript:void(0);"> <?php echo $this->itemPhoto($item->getOwner(),'thumb.profile'); ?></a>
   <div style="width: 160px;"> <strong><a class ="titlesmall" onclick="featured(this)" id="<?php echo $item->blog_id; ?>" href="javascript:void(0);"> <?php echo $item->getTitle();?> </a></strong> </div>
                     <div class="blog_entrylist_entry_date" style="margin: 4px 4px 4px 0px; color:#7F7F7F;font-size:8pt; width: 160px;">
                     <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
        <?php echo $this->timestamp($item->creation_date) ?>
                    </div>
    </td>
      <?php if($i < count($this->blogs) - 1): ?> 
      <td style="padding-left: 32px; padding-right: 32px;">
      <div class="l" style= "height : 210px; width: 1px;"></div>
      </td> 
      <?php endif; ?>
<?php endif; endforeach; ?>
</tr>
</table>
</div>
<?php endif;?> 
 </ul><br style="clear: inherit;"/>
<script type="text/javascript">
function featured(item)
{
    
    var makeRequest = new Request(
            {
                url: "blogs/featured-ajax/blog_id/"+item.id,
                onComplete: function (respone){
                   document.getElementById('featured').innerHTML = respone; 
                }
            }
            )
            makeRequest.send();
            var makeRequest = new Request(
            {
                url: "blogs/featured-old-ajax/blog_id/"+item.id,
                onComplete: function (respone){
                   document.getElementById('fearuedsmall').innerHTML = respone; 
                }
            }
            )
            makeRequest.send();
}
</script>
<style type="text/css">
.imgfe img.thumb_profile
{
    width :170px !important;
    height :130px !important;
}
img.thumb_profile {
max-height:200px !important;
max-width:200px !important;
}
</style>