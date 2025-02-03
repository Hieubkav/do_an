// Gỡ link
function removeParamFromCurrentUrl(paramName, currentUrl) {
    let url = new URL(currentUrl);
    url.searchParams.delete(paramName);
    window.location.href = url.href;
}
// Alert 
function customAlert(message) {
    const customAlertDiv = document.getElementById('customAlert');
    const alertBox = customAlertDiv.querySelector('.alert-box');

    document.getElementById('alertMessage').textContent = message;
    customAlertDiv.style.display = 'flex';

    // Nghe sự kiện click trên customAlert
    customAlertDiv.addEventListener('click', function (event) {
        // Kiểm tra xem click có được thực hiện ngoài hộp cảnh báo không
        if (!alertBox.contains(event.target)) {
            closeAlert();
        }
    });
}

function closeAlert() {
    document.getElementById('customAlert').style.display = 'none';
}

    // Khi tải trang xong, đặt lớp 'alert-box' cho hộp cảnh báo
window.onload = function () {
    const customAlertDiv = document.getElementById('customAlert');
    const alertBox = customAlertDiv.querySelector('.bg-white');
    alertBox.classList.add('alert-box');
}

// Gửi form dưới dạng post
function submitData(endpoint, dataObject) {
    var url = endpoint;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(dataObject)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

