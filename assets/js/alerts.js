function showAlert(status){
    if(status === STATUS_OK){
        successAlert.classList.remove('hidden');
    }else{
        failureAlert.classList.remove('hidden');
    }
    setTimeout(hideAlert, 2000, status);
}

function hideAlert(status){
    if(status === STATUS_OK){
        successAlert.classList.add('hidden');
    }else{
        failureAlert.classList.add('hidden');
    }
}