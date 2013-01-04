<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/top-bloggers/styles.css')
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/externals/styles/tooltip.css');

?>
<ul>
            
    <div><div>
                <div class="vertmenu"> 
                    <div>
                        <table cellpadding="0" cellspacing="0" border="0px">
                    <?php if(count($this->bloggers) <= 0): ?>              
       <div class="tip" style="clear: inherit;">
      <span>
           <?php echo $this->translate('There is not blogger.');?>
      </span>
           <div style="clear: both;"/>
    </div> 
 <?php else: ?>
                           <tr> 
                               <?php  
                   $i = 0;  
                   $item = $this->bloggers[0];
                  
                  foreach ($this->bloggers as $item):  ?>
                    
                   <?php if($i < 9):?>
            <td style="padding :5px;;vertical-align:top">
         <a class="thumbs_photo" href="blogs/<?php echo $item->owner_id; ?>" >
          <?php echo  $this->itemPhoto($item->getOwner(), 'thumb.icon'); ?>
         
        <div style="text-align: center;" >
        <?php if(strlen($item->getOwner()->getTitle()) > '10'):
                        echo $this->string()->chunk(substr($item->getOwner()->getTitle(), 0, 8), 10); echo  "..";   
                     else:
                        echo $item->getOwner()->getTitle();
                     endif; ?></div>
                      <span class="tooltip"><span class="top"></span><span class="middle"><strong><?php echo $item->getOwner()->getTitle(); ?>&nbsp;</strong><br /></span><span class="bottom"></span></span>      
          </a> 
            </td>  <?php endif; ?>
             <?php if($i >= 9 && $i < 18): if($i == 9):?> </tr><tr> <?php endif;?>
             <td style="padding :5px;;vertical-align:top">
         <a class="thumbs_photo" href="blogs/<?php echo $item->owner_id; ?>" >
          <?php echo  $this->itemPhoto($item->getOwner(), 'thumb.icon'); ?>
          
        <div style="text-align: center;" >  <?php if(strlen($item->getOwner()->getTitle()) > '10'):
                        echo $this->string()->chunk(substr($item->getOwner()->getTitle(), 0, 8), 10); echo  "..";   
                     else:
                        echo $item->getOwner()->getTitle();
                     endif; ?> </div>  
            <span class="tooltip"><span class="top"></span><span class="middle"><strong><?php echo $item->getOwner()->getTitle(); ?>&nbsp;</strong><br /></span><span class="bottom"></span></span>    
          </a> 
            </td>  <?php endif; ?>
                <?php  $i++ ; endforeach; ?>   
                  </tr>          
                        <?php endif; ?>
         </table>
                    </div>             
                </div>
</div></div>
 </ul>

