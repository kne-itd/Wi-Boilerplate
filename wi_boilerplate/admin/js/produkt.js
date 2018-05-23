var del_btns = document.querySelectorAll('.fa-trash');
var count = del_btns.length;
for ( var i = 0; i < count; i++) {
    del_btns[i].addEventListener('click', function(event){
        if (!confirm('Er du sikker på, at du vil slette dette produkt?')) {
            event.preventDefault();
        } 
        return true;
    })
}

function fileSelect(event) {
    if ( window.File && window.FileReader && window.FileList && window.Blob ) {
        var files = event.target.files;
        var file;
        for ( var i = 0; file = files[i]; i++) {
            if (!file.type.match('image')) {
                continue;
            }
            reader = new FileReader();
            reader.onload = ( function (theFile) {
                return function(event) {
                    var img_element = document.querySelector('.col-6 img');
                    img_element.src = event.target.result;
                };
            }(file));
            reader.readAsDataURL(file);
        }
    } else {
        alert('The File APIs are not supported in this browser');
    }
}
document.getElementById('car_img').addEventListener('change', fileSelect, false);

