
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Register</title>
<link rel="stylesheet" href="css/style4.css" type="text/css" />
<script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
<script src="js/jquery.flow.1.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $("div#controller").jFlow({
            slides: "#slides",
            width: "623px",
            height: "350px"
        });
    });
</script>


<script type="text/javascript">
function slideSwitch() {
    var $active = $('#review IMG.active');

    if ( $active.length == 0 ) $active = $('#review IMG:last');
    var $next =  $active.next().length ? $active.next()
        : $('#review IMG:first');
    $active.addClass('last-active');
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 4000 );
    $('#form-register').submit(function(){
        if ($.trim($('#username').val()) == ''
            || $.trim($('#email').val()) == ''
            || $.trim($('#password').val()) == '') {
            alert('Please enter all required field');
            return false;
        } else {
            var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!email_filter.test($('#email').val())) {
                alert('Please provide a valid email address');
                return false;
            }
            if ($('#password').val() != $('#re-password').val()) {
                alert('Two passwords do not match');
                return false;
            }
        }
    })
});
</script>
</head>

<body>
<div id="wrapper">
    	
        <div id="top">
        
        	<div id="head">            	
                	<div id="header">
                    <div id="login">
                    <form action="login.php" method="post">
                    Username <input type="text" name="username"/>
                    Password <input type="password" name="password"/>
                    <input type="submit" value="Log in"/>
                    <br/>
                    Not a member?
                    <br/>
                    <a href="signup.php">Sign up</a>
                    </form>
                    
                    </div>
                    </div>

                    <ul id='navigation'>
                        <li><a href="./" target="_self">HOME</a></li>
                        <?php
                            require 'pdo.php';
                            $sql = "SELECT * FROM category";
                            $result = $pdo->query($sql);
                                $list_category = $result->fetchAll();
                                foreach ($list_category as $category) {
                                echo "<li><a href='category.php?id={$category['id']}' target='_self'>{$category['category']}</a></li>";
                                }
                        ?>
                    </ul>
                    <div id="gallery">
                        <form id="form-register" method="post" action="register.php">
                            <table>
                                <tr>
                                    <th>Username(*)</th>
                                    <td><input id="username" type="text" name="username"/></td>
                                </tr>
                                <tr>
                                    <th>Email(*)</th>
                                    <td><input id="email" type="text" name="email"/><td/>
                                </tr>
                                <tr>
                                    <th>Enter your Password(*)</th>
                                    <td><input id="password" type="password" name="password"/><td/>
                                </tr>
                                <tr>
                                    <th>Re-Enter your Password(*)</th>
                                    <td><input id="re-password" type="password" /><td/>
                                </tr>
                                <tr>
                                    <th> </th>
                                    <td><input type="submit" value="Register"/></td>
                                </tr>
                            </table>
                        </form>
                    </div>                           
			</div>
        </div>
         <div id="abouttitle">
                ABOUT AGB (Advance Group Buy)
                </div>
                     <div id="about">
               Launched in November 2008, Advance Group Buy (AGB) features a daily deal on the best stuff to do, see, eat, and buy in 48 countries, and soon beyond (read: Space). We have about 10,000 employees working across our Vietnam headquarters, a growing office in Hanoi, Hai Phong, local markets throughout Asia and regional offices in Da Nang, Hoi An, Ha Tien and around the world.

 
                	</div>
                    <div id="bottom">
                        <div id="box1">
                        <li><a href="link.html" target="_self">News</a></li><br/>
                        <li><a href="link.html" target="_self">About AGB</a></li><br/>
                        <li><a href="link.html" target="_self">Forum</a></li><br/>
                        <li><a href="link.html" target="_self">Blog</a></li><br/>
                        <br/>
                        <br/>
                        <b>AGB. All Rights Reserved</b>
                        </div>
                        <div id="box2">
                        <li><a href="link.html" target="_self">FAQ</a></li><br/>
                        <li><a href="link.html" target="_self">Customer Support</a></li><br/>
                        <li><a href="link.html" target="_self">Return Policy</a></li><br/>
                        <li><a href="link.html" target="_self">Terms of Use</a></li><br/>
                        </div>
                        <div id="box3">
                        <li><a href="link.html" target="_self">More...</a></li><br/>
                        <li><a href="link.html" target="_self">Gift Cards</a></li><br/>
                        <li><a href="link.html" target="_self">Mobile</a></li><br/>
                        <li><a href="link.html" target="_self">Live off AGD</a></li><br/>
                        <br/>
                        <br/>
                        <b>2012</b>
                        </div>
                        <div id="box4">
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <li><a href="link.html" target="_self"><b>Facebook</b></a></li><br/>      
                        </div>
       			 </div>

</div>
</div>
</div>
</body>
</html>