function showAlert(type,title,text){
    Swal.fire({
        title: title,
        text: text,
        icon: type,
        showCancelButton: true, 
        showConfirmButton: false       

      })
}

function showToast(){

}