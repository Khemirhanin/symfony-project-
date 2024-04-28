var form = document.querySelector("form");
var inputs = document.querySelectorAll('input, select, textarea');
var submitButton = document.querySelector('#sub');
var image = document.getElementById('inputGroupFile02');

function errorMessage(inputField,error){
    var divElement = document.createElement('div');
    divElement.innerHTML = error;
    divElement.id ='error12';
    divElement.style.color = 'red';
    divElement.style.fontSize = '0.8em';
    divElement.style.paddingTop = '0px';
    parentElement = inputField.parentNode;

    // Insert the div element after the input field's parent element
    parentElement.insertAdjacentElement('afterend', divElement);
}

function checkInputs(){
    clearErrorMessages();
    var isValid = true;
    inputs.forEach((input) => {
        if(input.type === 'file'){
            isValid = checkImage();
        }
        else if(input.value.trim() === '') {
            isValid = false;
            errorMessage(input,'This field is required.')
        }
    });
    return isValid;
}

function checkImage(){
    if (image && image.files.length > 0) {
        var imageFile = image.files[0];
        var fileName = imageFile.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var fileSize = imageFile.size / (1024 * 1024);

        if (!['png', 'jpg', 'jpeg'].includes(fileExtension)) {
            errorMessage(image, 'Invalid extension.');
            return false;
        } else if (fileSize > 1) {
            errorMessage(image, 'Size is too high.');
            return false;
        } else {
            return true;
        }
    } else {
        errorMessage(image, 'Please select an image.');
        return false;
    }
}

submitButton.addEventListener("click", (e) => {
    e.preventDefault();
    if(checkInputs()){
       form.submit();
    }
});
function clearErrorMessages() {
    // Select all existing error message divs and remove them
    var errorMessages = document.querySelectorAll('#error12');
    errorMessages.forEach((errorMessage) => {
        errorMessage.remove();
    });
}