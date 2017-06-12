var i = 1;

var go = setInterval(function(){
    
$('#slider_'+i).show('slide', { direction: 'left' }, 1000).delay(500).hide('slide', { direction: 'left' }, 500);
    
    i++;
    if (i == 6) { 

    	$('#system_check_result').show();

    	i = 1
    }

 }, 600)