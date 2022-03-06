$(window).on("load", function(){
	$('#load_page').show();
});

$(document).ready(function(){
	$('#load_page').fadeOut(2000);
	theme();

	if(Cookies.get('theme') == 'dark')
		$('#dark-mode').prop('checked', true);
	$('#dark-mode').on('change', function(){
		if($(this).prop('checked'))
			Cookies.set('theme', 'dark');
		else
			Cookies.set('theme', 'off');

		theme();
	});

  	var hash = window.location.hash;
  	if(hash == '#berhasil_disimpan'){
  		toastr.success('Data berhasil disimpan');
  	}
  	else if(hash == '#gagal_disimpan'){
  		toastr.error('Data gagal disimpan');
  	}
  	else if(hash == '#berhasil_dihapus'){
  		toastr.success('Data berhasil dihapus');
  	}
  	else if(hash == '#gagal_dihapus'){
  		toastr.error('Data gagal dihapus');
  	}
});

var changeTheme = "dark-bg";
function theme(){
	var mode = Cookies.get('theme');
	var waktu = new Date();

	if(!mode){
		Cookies.set('theme', 'default');
		$('#dark-mode').prop('checked', false);
	}

	waktu = waktu.toLocaleString('id-ID', { hour: 'numeric', hour12: false });
	if(((waktu < 7 || waktu > 17) || mode == 'dark') && mode != 'off'){
		darkTime('on');
	}
	else {
		darkTime('off');
	}
}

function darkTime(set){
	if(set == 'on'){
		// $(".nav").addClass(changeTheme);
		$("#layoutSidenav_content").addClass(changeTheme);
		$(".modal-content").addClass(changeTheme);
		$('footer').addClass(changeTheme);
		$('.select2-container--open').addClass(changeTheme);
	}
	else {
		// $(".nav").removeClass(changeTheme);
		$("#layoutSidenav_content").removeClass(changeTheme);
		$(".modal-content").removeClass(changeTheme);
		$('footer').removeClass(changeTheme);
		$('.select2-container--open').removeClass(changeTheme);
	}
}

function getPing(){
	setInterval(function(){
		var time_stamp = new Date;
		$.ajax({ 
			type: "GET",
		    url: "/ping",
		    success: function(output){ 
		        ping = new Date - time_stamp;
		        console.log('-- Ping: ' + ping);
		    }
		});
	}, 1000);
}
