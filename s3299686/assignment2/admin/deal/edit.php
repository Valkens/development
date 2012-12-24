<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

$stmt = $pdo->prepare('SELECT * FROM deal WHERE dealid=:id ORDER BY dealid DESC');
$stmt->execute(array('id' => (int) $_GET['id']));
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $deal = $row;
}

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != ''
        || (int) $_POST['category'] > 0
        || trim($_POST['description']) != ''
        || trim($_POST['olprice']) != ''
        || trim($_POST['price']) != ''
        || trim($_POST['saving']) != ''
        || trim($_POST['conditions']) != ''
        || trim($_POST['expired_time']) != ''
    ) {
        $query = 'UPDATE deal SET
                                dealname=:name,categoryid=:id_category,
                                description=:description,olprice=:olprice,
                                price=:price,saving=:saving,
                                currentbuyer=:currentbuyer,maxbuyer=:maxbuyer,
                                exptime=:exptime,status=:status,conditiondescript=:conditions';

        $data = array(
            'name' => trim($_POST['name']),
            'id_category' => (int) $_POST['category'],
            'description' => $_POST['description'],
            'olprice' => (double) $_POST['olprice'],
            'price' => (double) $_POST['price'],
            'saving' => (int) $_POST['saving'],
            'currentbuyer' => (int) $_POST['currentbuyer'],
            'maxbuyer' => ($_POST['maxbuyer'] == '') ? null : (int) $_POST['maxbuyer'],
            'exptime' => $_POST['exptime'],
            'status' => $_POST['status'],
            'conditions' => $_POST['conditiondescript']
        );

        // Update image
        if ($_FILES['image']['name'] != '') {
            $dir = '../../pics';

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newName = uniqid('deal_', true);
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $newName . ".{$ext}");

            $query .= ",img=:image";
            $data['image'] = 'pics/' . $newName . ".{$ext}";

            // Remove old image
            if (file_exists('../../' . $deal['img'])) {
                unlink('../../' . $deal['img']);
            }
        }

        $query .= ' WHERE dealid=:id';
        $data['id'] = $_GET['id'];

        $stmt = $pdo->prepare($query);
        $stmt->execute($data);

        header('location: ./');
    }
} else {
    $stmt = $pdo->prepare('SELECT * FROM category');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    $list_category = $stmt->fetchAll();
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit deal</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="control-group">
                <label>Name (*)</label>
                <div class="controls">
                    <input type="text" id="deal-name" name="name" value="<?php echo $deal['dealname'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Category (*)</label>
                <div class="controls">
                    <select id="category" name="category">
                        <option value="-1">Select category</option>
                        <?php
                        if ($list_category) {
                            foreach ($list_category as $category) {
                                $selected = ($category['id'] == $deal['categoryid']) ? " selected='selected'" : '';
                                echo "<option value='{$category['id']}'$selected>{$category['category']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label>Description (*)</label>
                <div class="controls">
                    <textarea id="description" name="description" cols="42" rows="7"><?php echo $deal['description'];?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Original price (*)</label>
                <div class="controls">
                    <input type="text" id="original-price" name="olprice" style="width:80px" value="<?php echo $deal['olprice'];?>" />
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Group buy price (*)</label>
                <div class="controls">
                    <input type="text" id="group-buy-price" name="price" style="width:80px" value="<?php echo $deal['price'];?>" />
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Saving percent (*)</label>
                <div class="controls">
                    <input type="text" id="saving-percent" name="saving" style="width:80px" value="<?php echo $deal['saving'];?>" />
                    %
                </div>
            </div>
            <div class="control-group">
                <label>Number of current buyers</label>
                <div class="controls">
                    <input type="text" name="currentbuyer" style="width:80px" value="<?php echo $deal['currentbuyer'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Maximum buyers allowed</label>
                <div class="controls">
                    <input type="text" name="maxbuyer" style="width:80px" value="<?php echo $deal['maxbuyer'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Expired time (*)</label>
                <div class="controls">
                    <input type="text" id="expired-time" name="exptime" style="width:100px" class="datepicker" value="<?php echo $deal['exptime'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Status</label>
                <div class="controls">
                    <select name="status">
                        <option value="0"<?php echo ($deal['status'] == 0) ? ' selected="selected"' : '';?>>Inactive</option>
                        <option value="1"<?php echo ($deal['status'] == 1) ? ' selected="selected"' : '';?>>Active</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label>Description of conditions  (*)</label>
                <div class="controls">
                    <textarea id="conditions" name="conditiondescript" cols="42" rows="7"><?php echo $deal['conditiondescript'];?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Image</label>
                <div class="controls">
                    <input type="file" name="image" />
                    <?php echo '<image src="../../' . (($deal['img']) ? $deal['img'] : '') . '" width="80" height="80" align="left" style="margin-right:10px" />';?>
                    <br class="clear" />
                </div>
            </div>
            <br style="clear" />
            <div class="form-actions">
                <input type="submit" name="submit" value="Submit" />
                | <a href="./">Cancel</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>

<link rel="stylesheet" media="all" type="text/css" href="../../js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" media="all" type="text/css" href="../../js/jquery-timepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="../../js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery-timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../../js/jquery-timepicker/jquery-ui-sliderAccess.js"></script>
<style>
    .ui-datepicker {font-size:12px;}
</style>

<script type="text/javascript">
    $(function(){
        $('form').submit(function(){
            if ($.trim($('#deal-name').val()) == ''
                    || $('#category').val() == -1
                    || $.trim($('#description').val()) == ''
                    || $.trim($('#original-price').val()) == ''
                    || $.trim($('#group-buy-price').val()) == ''
                    || $.trim($('#saving-percent').val()) == ''
                    || $.trim($('#conditions').val()) == ''
                    || $.trim($('#expired-time').val()) === ''
                    ) {
                alert('Please complete all of the required fields');
                return false;
            }
        });

        $('.datepicker').datetimepicker({dateFormat: 'yy-mm-dd'});
    });
</script>

<?php include('../footer.php'); ?>