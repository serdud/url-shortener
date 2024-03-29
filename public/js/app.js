document.getElementById('url_form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    fetch('shorten', {
        method: 'post',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }).then((response) => {
        status = response.status;
        return response.json();
    }).then((data) => {
        switch (status) {
            case '200':
                prompt('Shortened URL', data.url);
                break;
            case '422':
                alert(formatAjaxErrors(data.errors));
                break;
            default:
                alert('Something went wrong');
        }
    });
})
