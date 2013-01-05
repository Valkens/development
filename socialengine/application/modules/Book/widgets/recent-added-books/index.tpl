<ul>
    <div><div>
        <div class="vertmenu">
            <div>
                <table cellpadding="0" cellspacing="0" border="0px">
                    <?php if(count($this->books) <= 0): ?>
                    <tr><td>
                        <div class="tip" style="clear:inherit;">
      <span>
           <?php echo $this->translate('There is not recent added book.');?>
      </span>
                            <div style="clear: both;"/>
                        </div>
                        <?php else: $i = 0;?>
                        <?php foreach($this->books as $book):?>
                        <td>
                            <table>
                                <tr>
                                    <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
                                        <?php echo $this->htmlLink($book->getOwner()->getHref(), $this->itemPhoto($book, 'thumb.icon')) ?>
                                    </td>
                                    <td valign='top' class="contentbox">
                                        <strong style=""><?php echo $this->htmlLink($book->getHref(array('action' => 'view')), $book->getTitle()) ?> </strong>
                                        <div class="book_entrylist_entry_date" style="margin: 4px 4px 4px 0px; color:#7F7F7F;font-size:8pt;">
                                            <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($book->getOwner()->getHref(), $book->getOwner()->getTitle()) ?>
                                            <?php echo $this->timestamp($book->posted_date) ?>  <?php //echo $book->view_count; ?>
                                        </div>
                                        <div class="book_entrylist_entry_body" style="color:#707070; word-wrap:break-word; width:200px;">
                                            <?php echo substr(strip_tags($book->description), 0, 120); if (strlen($book->description)>119) echo "..."; ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <?php if($i%2 == 1 && $i < count($this->books) - 1): echo '</tr><tr><td class="b" style="height:1px; "></td><td class="b" style="height:1px;"></td></tr> <tr>'; endif;?>
                    <?php $i ++; endforeach; endif; ?>
                    </td></tr>
                </table>
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

  