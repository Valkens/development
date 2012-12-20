[[ $this->inherit('@_layout_/default/layout') ]]
[: block page :]{{$pageTitle}}[: endblock :]

[: block content :]

<form>
    <input  name="current_img" id="current_img" type="hidden"/>
    <input  name="ajax_flag" id="ajax_flag" type="hidden"/>
</form>
<div class="post-wrap">
    <ul class="action-list clearfix">
        <li>
                <span class="item-wrap">
                    <span class="uiIconText selected">
                        <i class="img sp_10lbq6 sx_7460b3"></i>
                        <strong class="attachmentName">Post<i class="nub"></i></strong>
                    </span>
                </span>
        </li>
    </ul>

    <div class="uiComposerMetaContainer">
        <div class="innerWrap">
            <textarea placeholder="Write something..."></textarea>
        </div>
        <div style="border:solid 1px #B4BBCD;">
            <div id="fetched_data" style="display: none">
                <div id="loader"> </div>
                <div id="ajax_content"></div>
            </div>
        </div>
        <div class="uiComposerMessageBoxControls clearfix">
            <div class="category lfloat">
                <select>
                    <option>Select post to</option>
                    <option>Facebook</option>
                    <option>Only website</option>
                </select>
            </div>
            <ul class="clearfix rfloat">
                <li class="uiListItem">
                    <label class="submitBtn uiButton uiButtonConfirm">
                        <input type="submit" id="usvo6iy23" value="Share" />
                    </label>
                </li>
            </ul>
        </div>
    </div>
</div>

[: endblock :]