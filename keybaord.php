<div id="keyboard" >
<form action="" method="post" enctype="multipart/form-data" name="searchform" id="searchform">
<input name="search_text" type="text" class="inputbox" id="search_text" placeholder="enter first or last name..." autocomplete="off" /> 
<br />

<div style="line-height:65px; margin-top:20px;  ">
<span class="goldbtn2" onclick="addtoinput('q')">q</span>
<span class="goldbtn2" onclick="addtoinput('w')">w</span>
<span class="goldbtn2" onclick="addtoinput('e')">e</span>
<span class="goldbtn2" onclick="addtoinput('r')">r</span>
<span class="goldbtn2" onclick="addtoinput('t')">t</span>
<span class="goldbtn2" onclick="addtoinput('y')">y</span>
<span class="goldbtn2" onclick="addtoinput('u')">u</span>
<span class="goldbtn2" onclick="addtoinput('i')">i</span>
<span class="goldbtn2" onclick="addtoinput('o')">o</span>
<span class="goldbtn2" onclick="addtoinput('p')">p</span><br />
<span class="goldbtn2" onclick="addtoinput('a')">a</span>
<span class="goldbtn2" onclick="addtoinput('s')">s</span>
<span class="goldbtn2" onclick="addtoinput('d')">d</span>
<span class="goldbtn2" onclick="addtoinput('f')">f</span>
<span class="goldbtn2" onclick="addtoinput('g')">g</span>
<span class="goldbtn2" onclick="addtoinput('h')">h</span>
<span class="goldbtn2" onclick="addtoinput('j')">j</span>
<span class="goldbtn2" onclick="addtoinput('k')">k</span>
<span class="goldbtn2" onclick="addtoinput('l')">l</span>
<span class="goldbtn2" onclick="addtoinput('\'')">'</span>
<br />
<span class="goldbtn2" onclick="addtoinput('z')">z</span>
<span class="goldbtn2" onclick="addtoinput('x')">x</span>
<span class="goldbtn2" onclick="addtoinput('c')">c</span>
<span class="goldbtn2" onclick="addtoinput('v')">v</span>
<span class="goldbtn2" onclick="addtoinput('b')">b</span>
<span class="goldbtn2" onclick="addtoinput('n')">n</span>
<span class="goldbtn2" onclick="addtoinput('m')">m</span>

<span class="goldbtn2" onclick="backspace()"><span 
style=" display:inline-block;  transform: rotate(180deg);"
>&#10151;</span> back</span>

<br />
<span class="goldbtn2" style="padding:5px 100px; width:400px; display:inline-block;" onclick="addtoinput(' ')">space</span>
<p> 
 <input name="search" type="submit" class="goldbtn2" value="search"    />  
	<input name="search" type="button" class="goldbtn2" value="CLOSE"   onclick="keyboardtoggle(); return false;"  />
 </p>
</div>
	</form>
</div>
	<br clear="all">
	&nbsp;
<div id="shaddow"></div>	
<div id="popupbox"></div>
<div id="popupboxsearch"></div>
 <script>
	 
	 $("#searchform").submit(function(){
		 
		 var newval = $("#search_text").val();
		 $("#shaddow").slideDown();  
		$("#popupbox").html("");
		//alert('SEARCH');
		 $.post('searchhere.php',{newval : newval}, function(ret){
			$("#popupboxsearch").html(ret); 
			 $("#popupboxsearch").css({
				 'font-size':'18px',
				 'overflow-y' : 'scroll'
			 });
			 $("#popupboxsearch").show();
			 
  var  kyw = $("#popupbox").width();
var  kyh = $("#popupbox").height();
var wnw = $(window).width();
var wnh = $(window).height();
 
$("#popupbox").css({
"left": 	( wnw/2 ) - ( kyw/2 ),
"top":  ( wnh/2 ) - ( kyh/2 ),  
});
			 
			 
		 });
		
		 
		  return false;
	 });
	 
	 function keyboardtoggle(){
		  $("#shaddow").slideToggle();
		 $('#keyboard').slideToggle();
         
		 if ($('#keyboard').is(':visible')) {
     $("#search_text").focus();
}
	 }
		function hide_add(){
		$("#popupbox").html('');
		$("#popupbox").hide();
		$("#shaddow").slideUp();
			$('#keyboard').hide();
				$("#popupboxsearch").html('');
			 $("#popupboxsearch").hide();
		}	
	hide_add(); 
$("#shaddow").click(function(){hide_add();});	
	 
	 
var  kyw = $("#keyboard").width();
var  kyh = $("#keyboard").height();
var wnw = $(window).width();
var wnh = $(window).height();
 
$("#keyboard").css({
"left": 	( wnw/2 ) - ( kyw/2 ),
"top":  ( wnh/2 ) - ( kyh/2 ),  
});
/*"top": 	( wnh/2 ) - ( kyh/2 ),*/


function addtoinput(letter){
var newval = $("#search_text").val() + letter;
$("#search_text").val(newval)  ;
 $("#search_text").focus();
}

function backspace(){
var newval = $("#search_text").val();
var newlen  =  newval.length *1  - 1;
var newval = newval.substring(0,newlen);
$("#search_text").val(newval);
 $("#search_text").focus();
}
$("body").attr('unselectable', 'on')
                 .css('user-select', 'none')
                 .on('selectstart', false);
$(document).on("contextmenu", function(event) { event.preventDefault(); });
     
function scalebody() {
				var veiwwid = $(window).width() / 1920;
				var veiwwidhh = $(window).height() / 1080;
				if(veiwwidhh < veiwwid){veiwwid = veiwwidhh;}
				$('body').css( {"transform": "scale("+veiwwid+")"});
				var margintop = 	((1080 - $(window).height() )/2) *-1 ;
				var marginleft = 	((1920 - $(window).width() )/2) *-1 ;
				$('body').css( {"margin-top": margintop, "margin-left": marginleft});
		}
	
		$(document).ready(function(){scalebody();});
	    $(window).resize(function() {scalebody();}); 
</script>