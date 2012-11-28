    <div id="footer">
        <div class="background">
            <div id="connect">
                <h5>Get Social With us!</h5>
                <ul>
                    <li>
                        <a href="#" target="_blank" class="facebook"></a>
                    </li>
                    <li>
                        <a href="#" target="_blank" class="twitter"></a>
                    </li>
                    <li>
                        <a href="#" target="_blank" class="linkin"></a>
                    </li>
                </ul>
            </div>
            <ul class="navigation">
                <?php
                foreach ($categories as $category) {
                    echo "<li><a href='./?m=category&cid={$category['id']}'>{$category['name']}</a></li>";
                }
                ?>
            </ul>
            <p class="footnote">
                &copy; Copyirght &copy; 2012. Company name all rights reserved.
            </p>
        </div>
    </div>
</body>
</html>