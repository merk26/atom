window.app = {
	post: function (url, params, callback_success, callback_error) {
		$.post(url+ "?" + $.param(params), null, function (e) {
            if ('error' in e) {
                if (typeof callback_error === "function")
                    callback_error(e);
                else
                    alert(e.error.message);
            } else if (typeof callback_success === "function")
                callback_success(e);
        }, 'json');
	}
};