const IMAGE_FILTER = ['image/jpg', 'image/jpeg', 'image/png', 'image/bmp', 'image/gif'];
const VIDEO_FILTER = ['video/mp4', 'video/webm', 'video/ogg'];

function mainInit() {
	blockPage();
	initFonts();
	initDatatables();
	initDateTimeRangePickers();
	fixInputColor();
	initMaxlength();
	addFormNotify('form-notify');
	unblockPage();
	displayErrors('error-messages');
	lazyLoadMedia('lazy-load');
}

function confirmAlert() {
	return swal({
		titleText: 'Are you sure?',
		type: 'warning',
		showCancelButton: true,
		showCloseButton: true,
		buttonsStyling: false,
		confirmButtonText: '<i class="la la-check"></i> Ok',
		confirmButtonClass: 'btn m-btn btn-primary',
		cancelButtonText: '<i class="la la-close"></i> Cancel',
		cancelButtonClass: 'btn m-btn btn-secondary'
	});
}

function successAlert() {
	return swal({
		titleText: 'Success!',
		type: 'success',
		timer: 3000,
		showCloseButton: true,
		buttonsStyling: false,
		confirmButtonText: '<i class="la la-check"></i> Ok',
		confirmButtonClass: 'btn m-btn btn-success'
	});
}

function initMaxlength() {
	$('input[maxlength], textarea[maxlength]').maxlength({
		alwaysShow: true,
		warningClass: 'm-badge m-badge--primary m-badge--rounded m-badge--wide',
		limitReachedClass: 'm-badge m-badge--danger m-badge--rounded m-badge--wide'
	});
}

function fixInputColor() {
	$('input[type=color]').css('height', '36px');
}

function initFonts() {
	WebFont.load({
		google: { families: ['Poppins:300,400,500,600,700', 'Roboto:300,400,500,600,700'] },
		active: () => {
			sessionStorage.fonts = true;
		}
	});
}

function initDatatables() {
	$('table.js-datatable').DataTable({
		order: [],
		processing: true,
		colReorder: true,
		pagingType: 'full_numbers',
		pageLength: 50,
		lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'All']],
		dom:
			"<'row'<'col-sm-4 text-left'f><'col-sm-4 text-left dataTables_pager'lp><'col-sm-4 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
		buttons: [
			{
				extend: 'collection',
				text: 'Export',
				autoClose: true,
				buttons: ['copyHtml5', 'print', 'csvHtml5', 'excelHtml5', 'pdfHtml5']
			},
			{
				extend: 'collection',
				text: 'Visibility',
				buttons: ['colvisRestore', 'colvis']
			}
		]
	});
}

function showMedia(elem, galleryDiv) {
	galleryDiv = document.getElementById(galleryDiv);
	galleryDiv.innerHTML = '';

	var path, name, type, size, content;

	for (const file of elem.files) {
		path = window.URL.createObjectURL(file);
		type = file.type;

		if (IMAGE_FILTER.indexOf(type) > -1)
			content =
				'<a target="_blank" href="' + path + '"><img class="img-thumbnail" src="' + path + '"></a>';
		else if (VIDEO_FILTER.indexOf(type) > -1)
			content =
				'<video controls class="img-thumbnail"><source src="' +
				path +
				'" type="' +
				type +
				'"></video>';
		else continue;

		name = file.name.trim();
		size = file.size / (1024 * 1024);
		size = parseFloat(size.toFixed(2));

		galleryDiv.insertAdjacentHTML(
			'beforeend',
			'<div class="col-sm-2">' + content + '<p>' + name + ' (' + size + ' MB)</p></div>'
		);
	}
}

function lazyLoadMedia(class_name) {
	const elems = $('.' + class_name + '[data-src]');
	for (const elem of elems) elem.src = elem.dataset.src.trim();
}

function addFormNotify(class_name) {
	const elems = document.querySelectorAll('form.' + class_name);

	for (const elem of elems) {
		elem.onsubmit = () => {
			fireNotification({
				message: 'Saving data in progress...',
				icon: 'fa fa-spinner fa-spin',
				type: 'success',
				delay: 0
			});

			const buttons = document.querySelectorAll('button[type="submit"][form="' + elem.id + '"]');

			for (const button of buttons) {
				button.disabled = true;
				button.classList.add('m-loader', 'm-loader--light', 'm-loader--right');
			}
		};
	}
}

function blockPage() {
	mApp.blockPage({
		overlayColor: '#000000',
		type: 'loader',
		state: 'success',
		message: 'Please wait...'
	});
}

function unblockPage() {
	mApp.unblockPage();
}

function blockModal(modal) {
	mApp.block('#' + modal + ' .modal-content', {
		overlayColor: '#000000',
		type: 'loader',
		state: 'primary'
	});
}

function unblockModal(modal) {
	mApp.unblock('#' + modal + ' .modal-content');
}

function initDateTimeRangePickers() {
	$('.datetimerangepicker').daterangepicker(
		{
			buttonClasses: 'm-btn btn',
			applyClass: 'btn-primary',
			cancelClass: 'btn-secondary',
			timePicker: true,
			timePicker24Hour: true,
			showWeekNumbers: true,
			autoUpdateInput: true,
			minDate: new Date(),
			locale: { format: 'DD/MM/YYYY HH:mm' }
		},
		function(a, b) {
			const id = $(this)
				.attr('element')
				.attr('id');

			$('#' + id + '-first').val(a.format('YYYY-MM-DD HH:mm:ss'));
			$('#' + id + '-second').val(b.format('YYYY-MM-DD HH:mm:ss'));
		}
	);
}

function fireNotification(data) {
	return $.notify(
		{
			// options
			message: data.message,
			icon: 'icon ' + data.icon
		},
		{
			// settings
			type: data.type,
			delay: data.delay * 1000
		}
	);
}

function localTimestamp(timestamp, format = 'DD/MM/YYYY HH:mm') {
	return moment
		.utc(timestamp)
		.local()
		.format(format);
}

function toggleCheckboxes(state, class_name) {
	const inputs = document.querySelectorAll('input.' + class_name);
	for (const input of inputs) input.checked = state;
}

function gatherFormInputs(form_elem) {
	confirmAlert().then(e => {
		if (!e.value) return;

		fireNotification({
			message: 'Saving data in progress...',
			icon: 'fa fa-spinner fa-spin',
			type: 'success',
			delay: 0
		});

		const inputs = document.querySelectorAll('input.options-form:checked');
		for (const input of inputs) input.setAttribute('form', form_elem.id);

		form_elem.submit();
	});
}

function displayErrors(elem_id) {
	const errors = JSON.parse(document.getElementById(elem_id).innerHTML.trim());

	for (const error of errors) {
		fireNotification({
			message: error,
			icon: 'fa fa-exclamation-triangle',
			type: 'danger',
			delay: 5
		});
	}
}
