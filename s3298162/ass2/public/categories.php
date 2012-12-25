<div class="sidebar_box"><span class="bottom"></span>
    <h3>Categories</h3>
    <div class="content">
        <ul class="sidebar_list">
            <?php
            $sql = 'SELECT * FROM categories';
            $result = $db->query($sql);
            $categories = $result->fetchAll();
            foreach ($categories as $key => $category) {
                if ($key == 0) {
                    echo '<li class="first"><a href="cate.php?id='.$category['id'].'">'.$category['categoryname'].'</a></li>';
                } else if ($key == count($categories) - 1) {
                    echo '<li class="last"><a href="cate.php?id='.$category['id'].'">'.$category['categoryname'].'</a></li>';
                } else {
                    echo '<li><a href="cate.php?id='.$category['id'].'">'.$category['categoryname'].'</a></li>';
                }
            }
            ?>
        </ul>
    </div>
</div>