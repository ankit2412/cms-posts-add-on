/* global cms_export_posts_admin */

var $ = jQuery.noConflict();

$(document).ready(function( $ ) {

	var posts_screen	= $( '.edit-php.post-type-post' ),
	title_action		= posts_screen.find( '.page-title-action:first' );
	title_action.after('<a href="#" class="page-title-action export-posts" data-export_type="Csv">'+cms_export_posts_admin.labels.export_posts+'</a><a href="#" class="page-title-action export-posts" data-export_type="Xlsx">'+cms_export_posts_admin.labels.export_posts_xlsx+'</a><a href="#" class="page-title-action export-posts" data-export_type="Pdf">'+cms_export_posts_admin.labels.export_posts_tcpdf+'</a>');

	$('.edit-php.post-type-post .export-posts').on('click', function(e){
		e.preventDefault();
		var cur_element = $(this);
		cur_element.addClass('disable');
		if($('.edit-php.post-type-post span.loader').length == 0 ){
			cur_element.after('<span class="loader">&nbsp;</span>');
		}
		var export_type = cur_element.data('export_type');

		var d = new Date($.now());
		var export_time = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear()+'-'+d.getHours()+'-'+d.getMinutes()+'-'+d.getSeconds();

		$.ajax({
			url: cms_export_posts_admin.ajax_url,
			data: {action:'export_file', export: true, export_type: export_type},
			method: 'POST',
			cache: false,
			xhr: function () {
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 2) {
						if (xhr.status == 200) {
							xhr.responseType = "blob";
						} else {
							xhr.responseType = "text";
						}
					}
				};
				return xhr;
			},
			success: function (res) {
				if($('.edit-php.post-type-post span.loader').length > 0){
					$( '.edit-php.post-type-post span.loader' ).remove();
				}

				var blob = new Blob([res], { type: "application/octetstream" });
				var url = window.URL || window.webkitURL;
				link = url.createObjectURL(blob);
				var a = $("<a />");
				a.attr("download", 'posts-'+export_time+'.'+ export_type );
				a.attr("href", link);
				$("body").append(a);
				a[0].click();
				$("body").remove(a);
				cur_element.removeClass('disable');
				
			}
		});
	});
});
