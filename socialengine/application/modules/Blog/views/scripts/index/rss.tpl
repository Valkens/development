    <rss version="2.0">
        <channel>
            <title><?php echo $this->translate('Blogs') ?> &#187; <?php echo $this->pro_type_name ?></title>
            <description>RSS Blogs</description>
            <link><?php echo "http://".$_SERVER['HTTP_HOST'].$this->url(array('action' => 'listing'), 'blog_general')?></link>
             <?php foreach($this->blogs as $row):
            $description = $row->body;
            if (strlen($description)>=300):
                $description = substr($description,0,297).'...';
            endif; ?>
            <item>
                <title><![CDATA[
                <?php echo $row->title ?>
                ]]></title>
                <link>
                <?php echo "http://".$_SERVER['HTTP_HOST'].$row->getHref()?>
                </link>
                <description><![CDATA[
                <?php echo strip_tags($description )?>
                ]]></description>
                <pubDate> <?php echo $row->creation_date ?></pubDate>
            </item>           
   <?php endforeach; ?>   
       </channel>
   </rss>

