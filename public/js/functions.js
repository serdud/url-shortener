function formatAjaxErrors(errors) {
    let errorsArr = [];
    Object.keys(errors).map(function(objectKey, index) {
        errorsArr.push(errors[objectKey]);
    });

    return errorsArr.join('\n');
}
