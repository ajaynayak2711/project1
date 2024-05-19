$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});		

function toastmsg(msg,is_error=false)
{
	$("#toast_msg").html(msg);
	$("#toast_box").addClass("show");
	if(is_error)
		$("#toast_box").addClass("bg-danger");
	else
		$("#toast_box").addClass("bg-success");				
	setTimeout(function () {
		$("#toast_msg").html("");
		$("#toast_box").removeClass("show");
		if(is_error)
			$("#toast_box").removeClass("bg-danger");
		else
			$("#toast_box").removeClass("bg-success");
	}, 3000);
}

function formValidation(errors){
	$(".error-msg").remove();
	 $.each(errors, function(index, el) {
		 
		var str 		= (el.constructor === Array) ? el[0] : el;
		var _replace 	= index;	
		var array_name 	= index.split(".");
		if(typeof array_name[1] !== 'undefined'){				
			var selector = $('[name="'+array_name[0]+'[]"]');
			var ckeditor = selector.attr("data-init-plugin");//ck-editor
			selector.each(function(index) {
				if(index == array_name[1]){
					var label 	= $(this).closest('div').find('label').html();
					str 		= str.replaceAll(_replace, label);
					str 		= str.replaceAll(':', '');
					if(typeof ckeditor !== 'undefined' && ckeditor !== false && ckeditor == 'ckeditor') {
						$(this).closest('div').find('.ck-editor').after('<span class="m-form__help text-danger">'+str+'</span>');
					}else{
						$(this).after('<span class="m-form__help text-danger error-msg">'+str+'</span>');
					}
				}
			});
		}else{				
			var selector = ($("[name="+index+"]").length == 1) ? $("[name="+index+"]") : $('[name="'+index+'[]"]');
			var ckeditor = selector.attr("data-init-plugin");//ck-editor
			var select2  = selector.attr("data-select2-id");//ck-editor
			var label 	 = selector.closest('div').find('label').html();	
			_replace 	 = _replace.replaceAll('_', ' ');
			str 		 = str.replaceAll(_replace, label);
			str 		 = str.replaceAll(':', '');
			if(typeof ckeditor !== 'undefined' && ckeditor !== false && ckeditor == 'ckeditor') {
				selector.closest('div').find('.ck-editor').after('<span class="m-form__help text-danger">'+str+'</span>');
			}else if(typeof select2 !== 'undefined' && select2 !== false && select2 == index) {
				selector.closest('div').find('.select2-container').after('<span class="m-form__help text-danger">'+str+'</span>');
			}else{
				if($(selector).hasClass('form-check-input')) {
					selector.closest('div').after('<span class="m-form__help text-danger">'+str+'</span>');
				} else {
					selector.after('<span class="m-form__help text-danger error-msg">'+str+'</span>');
				}

			}
		}
	});
}

function send_ajax_request(ajaxUrl, sendData, method, fileUpload, type) {
	if(!ajaxUrl) { return; }
	sendData = sendData || {};
	method = method || 'POST';
	type = type || 'JSON';
	var ajaxOption = {
		type : method,
		url : ajaxUrl,
		dataType : type,
		data : sendData
	};
	(fileUpload) && ($.extend(ajaxOption, { processData: false, contentType: false }));
	return $.ajax(ajaxOption);
}

$(document).on('click', '.delete-item', function(event) {
	event.preventDefault();
	var _this = $(this);				
	if (confirm("Are you sure delete this record ?")) {
		send_ajax_request(_this.data('url'), {}, 'DELETE').done(function(data) {
			if(data.status) {
				table.ajax.reload(null, false);
				toastmsg(data.message);
			}
		});
	}
});

$(document).on('click', '.delete-file', function(event) {
	event.preventDefault();
	var _this 		= $(this);
	var meta_key 	= _this.attr('data-meta_key');
	var meta_table 	= _this.attr('data-meta_table');
	var meta_id 	= _this.attr('data-meta_id');
	var url 		= $('meta[name="baseurl"]').attr('content')+'/deleteFile';				
	if (confirm("Are you sure delete this resume ?")) {
		send_ajax_request(url,{meta_table:meta_table,meta_key:meta_key,meta_id:meta_id}).done(function(data){
			if(data.status) {
				_this.closest(".file-box").html("");
				toastmsg(data.message);
			}
		});
	}				
});