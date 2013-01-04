<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/externals/styles/main.css')
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/top-blogs/styles.css');
?> 
<ul>

    <div><div>
                <div class="vertmenu"> 
                    <div>
                        <table cellpadding="0" cellspacing="0" border="0px">
<?php if(count($this->blogs) <= 0): ?> 
<tr><td>
       <div class="tip" style="clear:inherit;">
      <span>
           <?php echo $this->translate('There is not top blog.');?>
      </span>
           <div style="clear: both;"/>
    </div> 
 <?php else: ?>
           <?php $index = 0;
           foreach($this->blogs as $blog): if($blog->getCountLikes() > 0): $index++; if($index <= $this->limit): ?>
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
                    <div class="blog_entrylist_entry_body" style="color:#707070; word-wrap:break-word; width:200px; ">
                     <?php echo substr(strip_tags($blog->body), 0, 120); if (strlen($blog->body)>119) echo "..."; ?>
                     </div>
                  </td>
                  </tr>
            </table>
            </td> 
           
         <?php if($index%2 == 0 && $index < $this->limit -1): echo '</tr><tr><td class="b" style="height:1px; "></td><td class="b" style="height:1px;"></td></tr> <tr>'; endif;?>
           <?php endif; endif; endforeach; endif;?>
        </td></tr>             
        </table>
         <?php if(count($this->blogs) >= $this->limit): ?> 
                  <br style="clear: inherit;"/>
         <div class="more">
                <a href="blogs/listing/sort/recent" ><img src='./application/modules/Blog/externals/images/next.png'/> View more</a>
         </div>
         <?php endif; ?>
                    </div>             
                </div>
            </div></div>
         
 </ul> <br style="clear: inherit;"/>
 <style type="text/css">
a ,a:link, a:visited {

}
 .more
 {
    background-color:#E9F4FA;
    font-size:8pt !important;
    padding:6px;
 }
</style>