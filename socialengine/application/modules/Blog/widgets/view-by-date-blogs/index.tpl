<?php
$this->headLink()
        ->prependStylesheet($this->baseUrl().'/application/css.php?request=application/modules/Blog/widgets/view-by-date-blogs/styles.css');

?>
<h3><?php echo $this->translate('View By Date');?></h3>
<ul class= "global_form_box" style="padding: 0 0 10px; margin-bottom: 15px;">
       
            <div style="">
            <body  onload="DrawCalendar()">
            <div  id = "dpCalendar"/>
            </body>
            </div>
      
    
</div> 
 </ul>

<script language="JavaScript" type="text/javascript">
// User Changeable Vars
var HighlightToday  = true;    // use true or false to have the current day highlighted
var DisablePast    = true;    // use true or false to allow past dates to be selectable
// The month names in your native language can be substituted below
var MonthNames = new Array("January","February","March","April","May","June","July","August","September","October","November","December");

// Global Vars
var now = new Date();
var dest = null;
var ny = now.getFullYear(); // Today's Date
var nm = now.getMonth();
var nd = now.getDate();
var sy = 0; // currently Selected date
var sm = 0;
var sd = 0;
var y = now.getFullYear(); // Working Date
var m = now.getMonth();
var d = now.getDate();
var l = 0;
var t = 0;
var MonthLengths = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
function DestroyCalendar() {
  var cal = document.getElementById("dpCalendar");
  if(cal != null) {
    cal.innerHTML = null;
    cal.style.display = "none";
  }
  return
}

function DrawCalendar() {
  DestroyCalendar();
  cal = document.getElementById("dpCalendar");
  var sCal = "<table><tr class ='layout_core_menu_main' style=\"height: 23px;\"><td class=\"cellButton1\"><a href=\"javascript: PrevMonth();\" title=\"Previous Month\" style=\"text-align: center;\";>&lt&lt</a></td>"+
    "<td class=\"cellMonth\" width=\"90%\" colspan=\"5\">"+MonthNames[m]+" "+"<span class=\"cellYear\">" + y + "</span>" +"</td>"+
    "<td class=\"cellButton2\"><a href=\"javascript: NextMonth();\" title=\"Next Month\" style=\"text-align: center;\">&gt&gt</a></td></tr>"+
    "<tr class=\"cellThu\"><td style=\"text-align:center;font-size:8pt;\">Su</td><td style=\"text-align:center; font-size:8pt;\">Mo</td><td style=\"text-align:center; font-size:8pt;\">Tu</td><td style=\"text-align:center; font-size:8pt;\">We</td><td style=\"text-align:center; font-size:8pt;\">Th</td><td style=\"text-align:center;font-size:8pt;\">Fr</td><td style=\"text-align:center; font-size:8pt;\">Sa</td></tr>";
  var wDay = 1;
  var wDate = new Date(y,m,wDay);
  if(isLeapYear(wDate)) {
    MonthLengths[1] = 29;
  } else {
    MonthLengths[1] = 28;
  }
  var dayclass = "";
  var isToday = false;
  for(var r=1; r<7; r++) {
    sCal = sCal + "<tr>";
    for(var c=0; c<7; c++) {
      var wDate = new Date(y,m,wDay);
      if(wDate.getDay() == c && wDay<=MonthLengths[m]) {
        if(wDate.getDate()==sd && wDate.getMonth()==sm && wDate.getFullYear()==sy) {
          dayclass = "cellSelected";
          isToday = true;  // only matters if the selected day IS today, otherwise ignored.
        } else if(wDate.getDate()==nd && wDate.getMonth()==nm && wDate.getFullYear()==ny && HighlightToday) {
          dayclass = "cellToday";
          isToday = true;
        } else {
          dayclass = "cellDay";
          isToday = false;
        }
          // user wants past dates selectable
          sCal = sCal + "<td class=\""+dayclass+"\"><a href=\"javascript: ReturnDay("+wDay+");\">"+wDay+"</a></td>";
        wDay++;
      } else {
        sCal = sCal + "<td class=\"unused\"></td>";
      }
    }
    sCal = sCal + "</tr>";
  }
  sCal = sCal + "</table>"
  cal.innerHTML = sCal; // works in FireFox, opera
  cal.style.display = "block";
}

function PrevMonth() {
  m--;
  if(m==-1) {
    m = 11;
    y--;
  }
  DrawCalendar();
}

function NextMonth() {
  m++;
  if(m==12) {
    m = 0;
    y++;
  }
  DrawCalendar();
}
<?php 
function selfURL() {
     $server_array = explode("/", $_SERVER['PHP_SELF']);
      $server_array_mod = array_pop($server_array);
      if($server_array[count($server_array)-1] == "admin") { $server_array_mod = array_pop($server_array); }
      $server_info = implode("/", $server_array);
      return "http://".$_SERVER['HTTP_HOST'].$server_info."/";
 }  
?>
function ReturnDay(day) {
  var date = y +"-"+ (m+1)+"-"+day;
  var url = "<?php echo  selfURL()?>";
  window.location  =  url + "blogs/listing/date/" + date;
}

function EnsureCalendarExists() {
  if(document.getElementById("dpCalendar") == null) {
    var eCalendar = document.createElement("div");
    eCalendar.setAttribute("id", "dpCalendar");
    document.body.appendChild(eCalendar);
  }
}

function isLeapYear(dTest) {
  var y = dTest.getYear();
  var bReturn = false;
  
  if(y % 4 == 0) {
    if(y % 100 != 0) {
      bReturn = true;
    } else {
      if (y % 400 == 0) {
        bReturn = true;
      }
    }
  }
  
  return bReturn;
}  
  
  </script>
  <style type="text/css">

/* The containing DIV element for the Calendar */
#dpCalendar {
  display: none;          
  font-size: 8pt;
  
}
/* The table of the Calendar */
#dpCalendar table {
  margin: 0;
  padding: 0;
  font-size: 8pt;
  width: 100%;
  border-collapse: collapse;
}
#dpCalendar table td,#dpCalendar table th
{
	margin: 0;
	padding: 0;
}
/* The Next/Previous buttons */
#dpCalendar .cellButton1 {
text-align: center;
}
#dpCalendar .cellButton2 {
text-align: center;
}
/* The Month/Year title cell */
#dpCalendar .cellMonth {
  text-align: center;
  padding:1px;
}
.cellYear
{
     font-weight:bold; 
}
/* Any regular day of the month cell */
#dpCalendar .cellDay {
  text-align: center;
  width: 14%;
  *padding-top:5px;  
}
#dpCalendar .cellButton1,#dpCalendar .cellButton2{

}
/* The day of the month cell that is Today */
#dpCalendar .cellToday {
  text-align: center;
  font-size:7pt;
  font-weight:bold;
  padding:2px;
}
/* Any cell in a month that is unused (ie: Not a Day in that month) */
#dpCalendar .unused {
  background-color: transparent;
  color: black;
}

.cellThu
{
	background-color:transparent;
	height: 17px;
}
/* The clickable text inside the calendar */
#dpCalendar a {
background-color:transparent;
font-size:7pt;
font-weight:bold;
text-decoration:none;
} 
  </style>
