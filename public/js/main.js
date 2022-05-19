$(document).ready(function() {

  $('.nav-link').click(function (e) { 
      $('.nav-link').removeClass('active');
      $(this).addClass('active');    
  });

  $('.nav-red').click(function (e) { 
      e.preventDefault();
      var targetPage = $(this).attr('target');
      if (targetPage == "home") {
          location.reload();
      }
      loadpage(targetPage);
 });

 

function loadpage(_target){
      $('.main-layout').html("");
    $.ajax({
      method: "GET",
      url: _target,
      success: function(response){
        $('.main-layout').html(response);
        $('.cur-page').val(_target);
      }
    });
}

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

});