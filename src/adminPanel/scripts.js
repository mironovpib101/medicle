function setCookie(name, value, options) {
	options = options || {};

	var expires = options.expires;

	if (typeof expires == "number" && expires) {
		var d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	}
	if (expires && expires.toUTCString) {
		options.expires = expires.toUTCString();
	}

	value = encodeURIComponent(value);

	var updatedCookie = name + "=" + value;

	for (var propName in options) {
		updatedCookie += "; " + propName;
		var propValue = options[propName];
		if (propValue !== true) {
			updatedCookie += "=" + propValue;
		}
	}

	document.cookie = updatedCookie;
}

function deleteCookie(name) {
	document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/;';
}

$(document).ready(function(){
	var $body = $('body');

	//загрузка картинок
	$body.on('change', 'input[type="file"].custom-file-input', function () {
		var data = new FormData(),
			$input = $(this),
			$field = $input.parents('.form-group'),
			$hiddenInput =$('input[type="hidden"]', $field),
			$img = $('img', $field);

		if( !$input[0].files[0] ) return;

		data.append("upload", $input[0].files[0]);
		console.log('$field[0].files[0]: ', $input[0].files[0]);
		$.ajax({
			method: 'POST',
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			url: '/admin/upload/'+$input.data('folder')+'/',
			data: data,
			success: function (result) {
				if(result.uploaded){
					$img.attr('src', result.url);
					$hiddenInput.val(result.url);
				}else{
					alert('Ошибка загрузки изображения');
				}
			},
			error: function () {
				alert('Ошибка загрузки изображения');
			}
		});
	});

	//отправка форм
	$body.on('submit', 'form.ajax', function (event) {
		event.preventDefault();
		var data = {},
			$form = $(this),
			param = {
				url: $form.attr('action'),
				type: $form.attr('method'),
				data: $(this).serializeArray(),
				success: function (result) {
					console.log('result: ', result);
					if(result.status){
						alert("Сохранено");
						location.reload();
					}else{
						alert("Ошибка отправки формы");
					}
				},
				error: function (err) {
					console.error('err: ', err);
					alert("Ошибка отправки формы");
				}
			};

		if($form.attr('method').toLocaleLowerCase() === 'put'){
			$(this).serializeArray().forEach(function(field){
				data[field.name] = field.value;
			});
			param.contentType = 'application/json';
			param.data = JSON.stringify(data);
		}

		$.ajax(param);
	});

	$body.on('click', '.loginOut', function (e) {
		e.preventDefault();
		deleteCookie('token');
		location.href = '/admin/login/';
	})
});