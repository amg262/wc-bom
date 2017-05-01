/*
 * Copyright (c) 2017  |  Netraa, LLC
 * netraa414@gmail.com  |  https://netraa.us
 *
 * Andrew Gunn  |  Owner
 * https://andrewgunn.org
 */

/**
 * Created by andy on 2/24/17.
 */
/**
 * Created by andy on 2/9/17.
 */
jQuery(document).ready(function ($) {


    //$("#commentForm").validate();
  //var ProgressBar = require('progressbar.js');
//yesdsfs
// Assuming we have an empty <div id="container"></div> in
// HTML
  //var bar = new ProgressBar.Line('#container', {easing: 'easeInOut'});
  //bar.animate(1);  // Value from 0.0 to 1.0


  $('#yeahbtn').click(function (e) {
    var data = {
      'url':ajax_object.ajax_url,
      'action':'wco_ajax',
      'security':ajax_object.nonce,
      'whatever':ajax_object.whatever,
      //'data':ajax_object     // We pass php values differently!
      //'security':ajax_object.nonce
    };

    console.log(data);

    sweetAlert({
        title:"Ajax request example",
        text:"Submit to run ajax request",
        type:"info",
        showCancelButton:true,
        closeOnConfirm:false,
        showLoaderOnConfirm:true,
      },
      function () {

        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        jQuery.post(ajax_object.ajax_url, data, function (response) {

          $('#feedme').html(response);

          setTimeout(function () {
            swal("Ajax request: " + response);
          });
          //alert('seRespon ' + response);
        });

      });

  });

  /*
   swal({
   title: "Are you sure?",
   text: "You will not be able to recover this imaginary file!",
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: "Yes, delete it!",
   cancelButtonText: "No, cancel plx!",
   closeOnConfirm: false,
   closeOnCancel: false
   },
   function(isConfirm){
   if (isConfirm) {
   swal("Deleted!", "Your imaginary file has been deleted.", "success");
   } else {
   swal("Cancelled", "Your imaginary file is safe :)", "error");
   }
   });

   swal({
   title: "Ajax request example",
   text: "Submit to run ajax request",
   type: "info",
   showCancelButton: true,
   closeOnConfirm: false,
   showLoaderOnConfirm: true,
   },
   function(){
   setTimeout(function(){
   swal("Ajax request finished!");
   }, 2000);
   });
   */

});

jQuery(function ($) {


});

/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load event on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load event after posts have been inserted via Ajax:
 */
//jQuery(document.body).trigger('post-load');

/*
 *JavaScript listening to the post-load event:
 */
jQuery(document.body).trigger('post-load');
jQuery(document.body).on('post-load', function () {
  // New posts have been added to the page.
  console.log('posts');
});