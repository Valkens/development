<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

if (isset($_POST['submit'])) {
    if (trim($_POST['name']) != ''
        || (int) $_POST['category'] > 0
        || trim($_POST['description']) != ''
        || trim($_POST['olprice']) != ''
        || trim($_POST['price']) != ''
        || trim($_POST['saving']) != ''
        || trim($_POST['conditiondescript']) != ''
        || trim($_POST['exptime']) != ''
    ) {
        $stmt = $pdo->prepare('INSERT INTO deal(dealname,categoryid,description,olprice,
                                                  price,saving,currentbuyer,
                                                  maxbuyer,exptime,
                                                  status,conditiondescript)
                                       VALUES(:name,:categoryid,:description,
                                              :olprice,:price,:saving,
                                              :currentbuyer,:maxbuyer,:exptime,:status,:conditiondescript)');
        $stmt->execute(array(
            'name' => trim($_POST['name']),
            'categoryid' => (int) $_POST['category'],
            'description' => $_POST['description'],
            'olprice' => (double) $_POST['olprice'],
            'price' => (double) $_POST['price'],
            'saving' => (int) $_POST['saving'],
            'currentbuyer' => (int) $_POST['currentbuyer'],
            'maxbuyer' => ($_POST['maxbuyer'] == '') ? null : (int) $_POST['maxbuyer'],
            'exptime' => $_POST['exptime'],
            'status' => $_POST['status'],
            'conditiondescript' => $_POST['conditions']
        ));

        if ($stmt->rowCount()) {
            if ($_FILES['image']['name'] != '') {
                $dir = '../../pics';

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = uniqid('deal_', true);

                move_uploaded_file($_FILES['image']['tmp_name'], $dir . '/' . $newName . ".{$ext}");
                $dataImage['image'] = 'pics/' . $newName . ".{$ext}";
            } else {
                $dataImage['image'] = null;
            }

            // Update image
            $stmt = $pdo->prepare('UPDATE deal SET img=:image WHERE dealid=:id');
            $dataImage['id'] = $pdo->lastInsertId();
            $stmt->execute($dataImage);

            header('location: ./');
        }
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
                            if ($list_category) {
                                foreach ($list_category as $category) {
                                    echo "<option value='{$category['id']}'>{$category['category']}</option>";
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
                    <input type="text" id="original-price" name="olprice" style="width:80px"/>
                    $
                </div>
            </div>
            <div class="control-group">
                <label>Group buy price (*)</label>
                <div class="controls">
                    <input type="text" id="group-buy-price" name="price" style="width:80px"/>
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
                    <input type="text" name="currentbuyer" style="width:80px"/>
                </div>
            </div>
            <div class="control-group">
                <label>Maximum buyers allowed</label>
                <div class="controls">
                    <input type="text" name="maxbuyer" style="width:80px"/>
                </div>
            </div>
            <div class="control-group">
                <label>Expired time (*)</label>
                <div class="controls">
                    <input type="text" id="expired-time" name="exptime" style="width:100px" class="datepicker" />
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

            <br class="clear"/>

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
