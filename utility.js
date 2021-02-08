var check1 = true;
var check2 = true;
var check3 = true;
function togglePasswordDisplay(input, eye) {
    if(input == 'input1' && check1) {
        document.getElementById(input).setAttribute('type', 'text');
        document.getElementById(input).setAttribute('style', 'position:relative; left:13px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye-slash');
        check1 = false;
    } else if(input == 'input2' && check2) {
        document.getElementById(input).setAttribute('type', 'text');
        document.getElementById(input).setAttribute('style', 'position:relative; left:13px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye-slash');
        check2 = false;
    } else if(input == 'input3' && check3) {
        document.getElementById(input).setAttribute('type', 'text');
        document.getElementById(input).setAttribute('style', 'position:relative; left:13px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye-slash');
        check3 = false;
    } else if(input == 'input1' && !check1) {
        document.getElementById(input).setAttribute('type', 'password');
        document.getElementById(input).setAttribute('style', 'position:relative; left:12px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye');
        check1 = true;
    } else if(input == 'input2' && !check2) {
        document.getElementById(input).setAttribute('type', 'password');
        document.getElementById(input).setAttribute('style', 'position:relative; left:12px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye');
        check2 = true;
    } else {
        document.getElementById(input).setAttribute('type', 'password');
        document.getElementById(input).setAttribute('style', 'position:relative; left:12px;');
        document.getElementById(eye).setAttribute('class', 'fas fa-eye');
        check3 = true;
    }
    
}



function removeElement(elementId) {
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

function addElement(parentId, elementTag, elementId, elementClass, innerHtml) {
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.setAttribute('class', elementClass);
    newElement.innerHTML = innerHtml;
    p.appendChild(newElement);
}

//For admin authKey controls
function regenerateKey(perm, key) {
    document.getElementById('alertHolder').innerHTML = "";
    addElement('alertHolder', 'div', 'alert', 'alert alert-warning', `Are you sure you want to regenerate ${key} for ${perm}?`);
    document.getElementById('alert').setAttribute('role', 'alert');
    addElement('alertHolder', 'button', 'confirmBtn', 'btn btn-warning', 'Confirm');
    document.getElementById('confirmBtn').setAttribute('onclick', '../server/regenerateKey.php');
}

function deleteKey(perm, key) {
    document.getElementById('alertHolder').innerHTML = "";
    addElement('alertHolder', 'div', 'alert', 'alert alert-danger', `Are you sure you want to delelt ${key} for ${perm}?`);
    document.getElementById('alert').setAttribute('role', 'alert');
    addElement('alertHolder', 'button', 'confirmBtn', 'btn btn-danger', 'Confirm');
    document.getElementById('confirmBtn').setAttribute('onclick', '../server/deleteKey.php');
}