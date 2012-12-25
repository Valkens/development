<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');

$db = connectDb();

$stmt = $db->prepare('SELECT * FROM deals WHERE id=:id');
$stmt->execute(array('id' => (int) $_GET['id']));
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $deal = $row;
}

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != ''
        || (int) $_POST['category'] > 0
        || trim($_POST['description']) != ''
        || trim($_POST['original_price']) != ''
        || trim($_POST['group_buy_price']) != ''
        || trim($_POST['saving']) != ''
        || trim($_POST['conditions']) != ''
        || trim($_POST['expired-time']) != ''
    ) {
        $query = 'UPDATE deals SET
                                name=:name,id_category=:id_category,
                                description=:description,original_price=:original_price,
                                group_buy_price=:group_buy_price,saving=:saving,
                                buyers=:buyers,maximum_buyers_allowed=:maximum_buyers_allowed,
                                expired_time=:expired_time,status=:status,conditions=:conditions';

        $data = array(
            'name' => trim($_POST['name']),
            'id_category' => (int) $_POST['category'],
            'description' => $_POST['description'],
            'original_price' => (double) $_POST['original_price'],
            'group_buy_price' => (double) $_POST['group_buy_price'],
            'saving' => (int) $_POST['saving'],
            'buyers' => (int) $_POST['buyers'],
            'maximum_buyers_allowed' => ($_POST['maximum_buyers_allowed'] == '') ? null : (int) $_POST['maximum_buyers_allowed'],
            'expired_time' => $_POST['expired_time'],
            'status' => $_POST['status'],
            'conditions' => $_POST['conditions']
        );

        if ($_FILES['image']['name'] != '') {
            $dir = '../../public/images/deal';

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newName = uniqid('deal_', true);
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $newName . ".{$ext}");

            $query .= ",image=:image";
            $data['image'] = 'public/images/deal/' . $newName . ".{$ext}";

            // Remove old image
            if (file_exists('../../' . $deal['image'])) {
                unlink('../../' . $deal['image']);
            }
        }

        $query .= ' WHERE id=:id';
        $data['id'] = $_GET['id'];

        $stmt = $db->prepare($query);
        $stmt->execute($data);

        header('location: ./');
    }
} else {
    // Get categories
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    $categories = $stmt->fetchAll();
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Edit deal</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="control-group">
                <label>Name (*)</label>
                <div class="controls">
                    <input type="text" id="deal-name" name="name" value="<?php echo $deal['name'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Category (*)</label>
                <div class="controls">
                    <select id="category" name="category">
                        <option value="-1">Select category</option>
                        <?php
                        if ($categories) {
                            foreach ($categories as $category) {
                                $selected = ($category['id'] == $deal['id_category']) ? " selected='selected'" : '';
                                echo "<option value='{$category['id']}'$selected>{$category['categoryname']}</option>";
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
                    <input type="text" id="original-price" name="original_price" style="width:80px" value="<?php echo $deal['original_price'];?>" />
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Group buy price (*)</label>
                <div class="controls">
                    <input type="text" id="group-buy-price" name="group_buy_price" style="width:80px" value="<?php echo $deal['group_buy_price'];?>" />
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
                    <input type="text" name="buyers" style="width:80px" value="<?php echo $deal['buyers'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Maximum buyers allowed</label>
                <div class="controls">
                    <input type="text" name="maximum_buyers_allowed" style="width:80px" value="<?php echo $deal['maximum_buyers_allowed'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label>Expired time (*)</label>
                <div class="controls">
                    <input type="text" id="expired-time" name="expired_time" style="width:100px" class="datepicker" value="<?php echo $deal['expired_time'];?>" />
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
                    <textarea id="conditions" name="conditions" cols="42" rows="7"><?php echo $deal['conditions'];?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Image</label>
                <div class="controls">
                    <input type="file" name="image" />
                    <?php echo '<image src="../../' . (($deal['image']) ? $deal['image'] : '') . '" width="80" height="80" align="left" style="margin-right:10px" />';?>
                    <br class="clear" />
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" value="Submit" />
                | <a href="./">Cancel</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>

<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-timepicker/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="../../public/js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../../public/js/jquery-timepicker/jquery-ui-sliderAccess.js"></script>
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