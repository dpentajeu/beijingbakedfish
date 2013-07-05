
// DATE DROPDOWN CONTROL
	
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});

					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text(obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown').removeClass('active');
				});

			});



// DATEPICKER INIT

	$(document).ready(function(){

		$( ".date-start" ).datepicker();
		$( ".date-end" ).datepicker();

// BACK TO TOP BUTTON

		$("a[href='#top']").click(function() {
		  $("html, body").animate({ scrollTop: 0 }, "fast");
		  return false;
		});

// FLEXSLIDER INIT

			// $('.flexslider-1').flexslider({
			// 	controlNav: false,
			// });
			// $('.flexslider-2').flexslider({
			// 	controlNav: false,
			// });
			// $('.flexslider-3').flexslider({
			// 	controlNav: false,
			// });

// FANCYBOX INIT

			$("a[data-fancy=group1]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			$("a[data-fancy=group2]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			$("a[data-fancy=group3]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

// BOOKING FORM VALIDATION

		$(".booking").validate({
			rules: {
				".email": {
					required: true,
					email: true
				},
				".date-start": {
					required: true
				},
				".date-end": {
					required: true
				}
				
			},
			errorPlacement: function(error, element){
				},
			submitHandler: function(form) {
	
			var roomtype = $('.roomselected').text();
			var from = $('.date-start').val();
			var to = $('.date-end').val();
			var email = $('.email').val();
	
			//alert("Bundle created successfuly. Reloading page.");
	
			$.post('php/mailer.php?',{
							roomtype: roomtype,
							from: from,
							to: to,
							email: email
							},
							function(data){
								alert("Thank you for making a reservation! We will get back to you as soon as possible.");
								$('.submit').attr("disabled", "true");
							});
						//waits 2000, then closes the form and fades out
						//setTimeout('parent.$.fn.colorbox.close()', 2500);
						//stay on the page
						return false;
						//location.reload();
					 }
	
			});

	// END DOCUMENT READY MAIN WRAPPER
	});