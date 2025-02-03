//  Đóng mở menu
function closeMenuOnOutsideClick(event, menu, menuButton) {
    if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
        menu.classList.add('hidden');
        document.removeEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
    }
}

function toggleMenu(menu, menuButton) {
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        document.addEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
    } else {
        menu.classList.add('hidden');
        document.removeEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
    }
}

// function toggleMenu(menu, menuButton) {
//     if (menu.classList.contains('hidden')) {
//         menu.classList.remove('hidden');
//         document.addEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
//     } else {
//         menu.classList.add('hidden');
//         document.removeEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
//     }
// }

// function closeMenuOnOutsideClick(event, menu, menuButton) {
//     // Lấy phần tử được ấn
//     let target = event.target;
//     // Kiểm tra xem phần tử có phải là menu hay menuButton hay không
//     if (target !== menu && target !== menuButton) {
//         // Nếu không, ẩn menu và gỡ bỏ sự kiện
//         menu.classList.add('hidden');
//         document.removeEventListener('click', (event) => closeMenuOnOutsideClick(event, menu, menuButton));
//     }
// }

function showMenu(menu) {
    menu.classList.remove('hidden');
}


function hideMenu(menu) {
    menu.classList.add('hidden');
}


// Đống mở sidebar menu
function toggleSide(menuId) {
    var menu = document.querySelectorAll("#"+menuId)
    menu.forEach(element => {
        if (element.style.display === 'none' || element.style.display === '') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    });
    
}
