<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');

$db = connectDb();

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
        $stmt = $db->prepare('INSERT INTO deals(name,id_category,description,original_price,
                                                  group_buy_price,saving,buyers,
                                                  maximum_buyers_allowed, expired_time,
                                                  status,conditions)
                                       VALUES(:name,:id_category,:description,
                                              :original_price,:group_buy_price,:saving,
                                              :buyers,:maximum_buyers_allowed,:expired_time,:status,:conditions)');
        $stmt->execute(array(
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
        ));
        if ($stmt->rowCount()) {
            if ($_FILES['image']['name'] != '') {
                $dir = '../../public/images/deal';

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = uniqid('deal_', true);

                move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $newName . ".{$ext}");
                $dataImage['image'] = 'public/images/deal/' . $newName . ".{$ext}";
            } else {
                $dataImage['image'] = null;
            }

            // Update image
            $stmt = $db->prepare('UPDATE deals SET image=:image WHERE id=:id');
            $dataImage['id'] = $db->lastInsertId();
            $stmt->execute($dataImage);

            header('location: ./');
        }
    }
} else {
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    $categories = $stmt->fetchAll();
}
?>

<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" media="all" type="text/css" href="../../public/js/jquery-timepicker/jquery-ui-timepicker-addon.css" />
<style>
    .ui-datepicker {font-size:12px;}
</style>
<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">Add new deal</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="control-group">
                <label>Name (*)</label>
                <div class="controls">
                    <input type="text" id="deal-name" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label>Category (*)</label>
                <div class="controls">
                    <select id="category" name="category">
                        <option value="-1">Select category</option>
                        <?php
                            if ($categories) {
                                foreach ($categories as $val) {
                                    echo "<option value='{$val['id']}'>{$val['categoryname']}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label>Description (*)</label>
                <div class="controls">
                    <textarea id="description" name="description" cols="42" rows="7"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Original price (*)</label>
                <div class="controls">
                    <input type="text" id="original-price" name="original_price" style="width:80px"/>
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Group buy price (*)</label>
                <div class="controls">
                    <input type="text" id="group-buy-price" name="group_buy_price" style="width:80px"/>
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Saving percent (*)</label>
                <div class="controls">
                    <input type="text" id="saving-percent" name="saving" style="width:80px"/>
                    %
                </div>
            </div>
            <div class="control-group">
                <label>Number of current buyers</label>
                <div class="controls">
                    <input type="text" name="buyers" style="width:80px"/>
                </div>
            </div>
            <div class="control-group">
                <label>Maximum buyers allowed</label>
                <div class="controls">
                    <input type="text" name="maximum_buyers_allowed" style="width:80px"/>
                </div>
            </div>
            <div class="control-group">
                <label>Expired time (*)</label>
                <div class="controls">
                    <input type="text" id="expired-time" name="expired_time" style="width:100px" class="datepicker" />
                </div>
            </div>
            <div class="control-group">
                <label>Status</label>
                <div class="controls">
                    <select name="status">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label>Description of conditions  (*)</label>
                <div class="controls">
                    <textarea id="conditions" name="conditions" cols="42" rows="7"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label>Image</label>
                <div class="controls">
                    <input type="file" name="image" />
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
