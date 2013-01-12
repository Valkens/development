[[ $this->inherit('@_theme_/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]
<div id="wrapper">
    <h1 id="pageTitle">
        List category
        <a href="{{$adminUrl}}/category/add" class="buttonS bDefault btnAction fright">Add</a>
    </h1>
    <div class="widget">
        <table width="100%" cellspacing="0" cellpadding="0" class="tDefault checkAll check dTable">
            <thead>
            <tr>
                <td><input type="checkbox" id="titleCheck" name="titleCheck" /></td>
                <td>Column name</td>
                <td>Column name</td>
                <td>Column name</td>
                <td>Column name</td>
                <td>Column name</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr class="rowFilter">
                <td>&nbsp;</td>
                <td><input type="text" /></td>
                <td><input type="text" /></td>
                <td>
                    <select id="select1">
                        <option>Quan ao</option>
                        <option>Giay dep</option>
                        <option>Trang suc</option>
                    </select>
                </td>
                <td><input type="text" /></td>
                <td><input type="text" /></td>
                <td><button class="buttonS bDefault mb10 mt5">Tim</button></td>
            </tr>
            <tr>
                <td><input type="checkbox" id="titleCheck2" name="checkRow" /></td>
                <td>Row 1 <span class="arrow"></span></td>
                <td>Row 2</td>
                <td>Row 3</td>
                <td>Row 4</td>
                <td>Row 5</td>
            </tr>
            <tr>
                <td class="expand" colspan="7">
                    <p>+ Số lượng : 5</p>
                    <p>+ Bán : 4</p>
                    <p>+ Còn : 1</p>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" id="titleCheck3" name="checkRow" /></td>
                <td>Row 1</td>
                <td>Row 2</td>
                <td>Row 3</td>
                <td>Row 4</td>
                <td>Row 5</td>
            </tr>
            <tr>
                <td><input type="checkbox" id="titleCheck4" name="checkRow" /></td>
                <td>Row 1</td>
                <td>Row 2</td>
                <td>Row 3</td>
                <td>Row 4</td>
                <td>Row 5</td>
            </tr>
            <tr>
                <td><input type="checkbox" id="titleCheck5" name="checkRow" /></td>
                <td><strong class="stSuccess">[Hiện]</strong></td>
                <td><strong class="stError">[Ẩn]</strong></td>
                <td>Row 3</td>
                <td>Row 4</td>
                <td>Row 5</td>
            </tr>
            <tr>
                <td><input type="checkbox" id="titleCheck6" name="checkRow" /></td>
                <td>Row 1</td>
                <td>Row 2</td>
                <td>Row 3</td>
                <td>Row 4</td>
                <td>Row 5</td>
            </tr>
            </tbody>
        </table>
        <div class="tableFooter">
            <div class="dataTables_info">
                Showing 1 to 10 of 57 entries
            </div>
            <div class="dataTables_paginate paging_full_numbers">
                <a class="first paginate_button paginate_button_disabled" tabindex="0" id="DataTables_Table_0_first">First</a>
                <a class="previous paginate_button paginate_button_disabled" tabindex="0" id="DataTables_Table_0_previous">Previous</a>
                    <span>
                        <a class="paginate_active">1</a>
                        <a class="paginate_button">2</a>
                        <a class="paginate_button">3</a>
                        <a class="paginate_button">4</a>
                        <a class="paginate_button">5</a>
                    </span>
                <a class="next paginate_button">Next</a>
                <a class="last paginate_button">Last</a>
            </div>
        </div>
    </div>
</div>
[: endblock :]