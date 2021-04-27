class ApiHandler {
	call(url, callback, data, extra) {
		const headers = new Headers();
		headers.set('Accept', 'application/json');
		headers.set('Content-Type', 'application/json; charset=utf-8');

		return fetch(url, {
			method: data ? 'POST' : 'GET',
			headers: headers,
			body: data ? JSON.stringify(data) : null
		})
			.then(data => data.json())
			.then(data => {
				if (callback) callback(data, extra);
			});
	}
}

class FormHandler {
	submit(form, callback, extra) {
		const headers = new Headers();
		headers.set('Accept', 'application/json');

		return fetch(form.action, {
			method: form.method,
			headers: headers,
			body: new FormData(form)
		})
			.then(data => data.json())
			.then(data => {
				if (callback) callback(data, extra);
			});
	}
}
