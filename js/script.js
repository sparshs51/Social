function main(){
	$('.all').hide();
	$('.all').fadeIn(1000);


/*function send_post() 
{
	var hr = new XMLHttpRequest();
	var url = "send_post.php";
	fn = document.getElementById("post").value;
   	var vars = "post="+fn;
	hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    hr.send(vars);
    document.getElementById("status").innerHTML = "processing...";
}*/

// $("#submit_post").click( function(){
// 	var data = $("#post_form :input").serializeArray();
// 	$.post( $("#post_form").attr("action"), data, function(info){
// 		$("#post_submit_info").html(info); 
// 	} );
// });
// $("#post_form").submit( function(){
// 	return false;
// }); 


  var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  })
}
$(document).ready(main);
