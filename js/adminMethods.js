let currentId
let currentPhoto // фото которое меняют
let currentPath // место фото в узлах массива, если нет, корень узла, если есть модалочные фотки
document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('body').style.background = '#3d3d3d'
    document.querySelector('body').style.opacity = 0
    document.querySelector('[href="#tovar"]').click()
    setTimeout(() => {
        document.querySelector('[data-dismiss="modal"]').click()
        setTimeout(() => {
            document.querySelector('body').style.opacity = 1
        }, 350)

        let idSkid = document.querySelector('#idSkid')
        let skidFields = document.querySelector('.skid-fields')
        idSkid.addEventListener('click', () => {
            goods.models = goods.models.map(el => {
                if (Object.entries(el)[0][0] === currentId) el[currentId].noSkid = idSkid.checked
                return el
            })
            skidFields.style.opacity = idSkid.checked ? '0.1' : '1'
        })
    })
})

function showBig(obj) {
    if (window.innerWidth < 600) return false
    let mainPhoto = obj.target.parentNode.parentNode.querySelector('img')

    if (mainPhoto.requestFullscreen) {
        mainPhoto.requestFullscreen(); // Запрашиваем полноэкранный режим
    } else if (mainPhoto.mozRequestFullScreen) { // Firefox
        mainPhoto.mozRequestFullScreen();
    } else if (mainPhoto.webkitRequestFullscreen) { // Chrome, Safari, Opera
        mainPhoto.webkitRequestFullscreen();
    } else if (mainPhoto.msRequestFullscreen) { // IE/Edge
        mainPhoto.msRequestFullscreen();
    }
}

function changePhoto(id, event, photo, gal_img) {
    currentId = id
    if (event) { // фотки из модалки
        event.stopImmediatePropagation()
        currentPath = gal_img // elem.photos.all//[gal_img]
        showPhotoDialod(photo.slice(6))
    } else {
        let elem = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
        let photo = elem.img.slice(6)
        showPhotoDialod(photo)
        currentPath = undefined
    }
}

function doubleModalPhoto(id, event, photo, gal_img) {
    if (confirm('Дублировать фото?')) {
        let elem = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
        elem.photos.all.splice(1, 0, photo)
        document.querySelector('[data-dismiss="modal"]').click()
    }
}


function deleteModalPhoto(id, gal_img) {
    if (confirm('Удалить фото?')) {
        let elem = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
        elem.photos.all.splice(gal_img, 1)
        document.querySelector('[data-dismiss="modal"]').click()
    }
}

function showPhotoDialod(photo) {
    // Запрос к PHP скрипту, который возвращает массив с названиями фоток
    fetch('get_images.php')
        .then(response => response.json()) // Парсим ответ как JSON [3]
        .then(images => {
            document.getElementById('my-dialog').showModal() // открываем диалоговое окно
            let html = `<select id="photo" onchange="showPhoto(this.value)">
${images.map(el => '<option value="' + el + '">' + el + '</option>')}</select>`
            document.querySelector('#dialog-content').innerHTML = html
            showPhoto(photo)
            document.querySelector("select#photo").value = photo
        })
        .catch(error => console.error('Ошибка:', error));
}

function showPhoto(photo) {
    currentPhoto = photo
    document.querySelector('#dialog-photo').innerHTML = `<img src="tovar/${photo}">`
}

function showPhotoDelete(photo) {
    currentPhoto = photo
    document.querySelector('#dialog-photo-delete').innerHTML = `<img src="tovar/${photo}">`
}

function setPhoto() {
    let photo = document.querySelector("select#photo").value
    let elem = goods.models.find(el => Object.entries(el)[0][0] === currentId)[currentId]

    document.getElementById('my-dialog').closest('dialog').close()
    if (currentPath != undefined) {
        elem.photos.all[currentPath] = 'tovar/' + photo
    } else {
        elem.img = 'tovar/' + photo
    }
    document.querySelector('[data-dismiss="modal"]').click()
    document.getElementById('my-dialog').closest('dialog').close()
    redFlameEditState(currentId)
    show()
}

function uploadPhoto(type) {
    // type banner || model
    // Createa hidden file input element
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*'; // Accept only images

    // When a file is selected, upload it
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (!file) return;

        // Create a FormData object to send the file
        const formData = new FormData();
        formData.append('photo', file);

        let path = 'savePhoto.php'
        if (type === 'banner') {
            if (!['01.jpg', '02.jpg', '03.jpg', '04.jpg'].includes(file.name)) return alert('Карусель поддерживает только 4 варианта файла: 01.jpg, 02.jpg, 03.jpg, 04.jpg, Переименуйте если хотите поменять один из них  ')
            console.log('file = ', file)
            path = 'saveBanner.php'
        }
        // Send the file to the server
        fetch(path, {// Changed from save.php to savePhoto.php
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (currentId) {
                        let elem = goods.models.find(el => Object.entries(el)[0][0] === currentId)[currentId];
                        if (elem) {
                            elem.img = 'tovar/' + data.filename;
                            document.getElementById('my-dialog').closest('dialog').close()
                            show();
                        }
                    }
                    if (type === 'banner') location.reload()

                } else {
                    alert('Ошибка при загрузке фото:' + (data.error || 'Неизвестная ошибка'));
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при загрузке фото: ' + error.message);
            });
    });

    // Trigger the file selection dialog
    fileInput.click();
}

function deletePhoto() {
    if (confirm("Фото " + currentPhoto + " удалится безвозвратно, продолжать?")) {
        fetch('deletePhoto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'filename=' + encodeURIComponent(currentPhoto)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Фото успешно удалено');
                    document.getElementById('my-dialog').closest('dialog').close()
                    location.reload()
                } else {
                    alert('Ошибка при удалении фото: ' + (data.error || 'Неизвестная ошибка'));
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при удалении фото');
            });
    }
}

function deleteElement(id) {
    if (confirm("Табличка удалится безвозвратно, продолжать?")) {
        goods.models = goods.models.filter(el => Object.entries(el)[0][0] !== id)
        saveGoods()
    }
}

function doubleElement(id) {
    let guid = Math.random().toString(36).substring(2)
    let index = goods.models.findIndex(el => Object.entries(el)[0][0] === id)
    let body = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
    let node = {}
    let key = `${id.slice(0, -2)}_${guid}`
    node[key] = JSON.parse(JSON.stringify(body))
    redFlameEditState(key)
    goods.models.splice(index + 1, 0, node)
    show()

    let pensil = document.querySelector(`[onmousedown="editElement(\'${key}\',event); "]`)
    makeActive(null, pensil.closest('.goods-boots-info').parentNode)
}

function makeActive(event, targetFrom) {
    const target = targetFrom || event.target.closest('.goods-boots-info').parentNode;
    let id = target.childNodes[0].getAttribute('data-id')

    if (target) {
        const others = document.querySelectorAll('.box');
        others.forEach(div => div.classList.add('blured')); // Блюрим остальны
        target.classList.remove('blured')
    }
    makeDirty()
    redFlameEditState(id)
}

function editElement(id, event) {
    redFlameEditState(id)
    makeActive(event);
}

function redFlameEditState(id) {
    // goods.models = goods.models.map(el => {
    //     if (Object.entries(el)[0][0] === id) el[id].isEdited = true
    //     return el
    // })
    setTimeout(() => editFields(id))
}

function editFields(id) {
    let div = document.querySelector('[data-id="' + id + '"]')
    let cat_nameDiv = div.querySelector('.goods-boots-info p')
    let nameDiv = div.querySelector('.goods-boots-info h4')
    let priceDiv = div.querySelector('.tovar_info span')

    cat_nameDiv.style.textShadow = '0 0 7px red'
    cat_nameDiv.contentEditable = true
    cat_nameDiv.addEventListener('keyup', () => {
        goodsChanged(id, 'cat_name', cat_nameDiv.innerText)
    })

    nameDiv.style.textShadow = '0 0 7px red'
    nameDiv.contentEditable = true
    nameDiv.addEventListener('keyup', () => {
        goodsChanged(id, 'name', nameDiv.innerText)
    })

    priceDiv.style.textShadow = '0 0 4px black'
    priceDiv.contentEditable = true
    priceDiv.addEventListener('keyup', () => {
        goodsChanged(id, 'price', priceDiv.innerText)
    })
}

function goodsChanged(id, type, value) {
    let elem = goods.models.find(el => Object.entries(el)[0][0] === id)
    elem[id][type] = value
    if (value.indexOf('\n')) elem[id][type] = value.replace(/\n/g, '<p>')
}

function editModal(id, event) {
    currentId = id
    // showDirtyBlock(id)

    let model_descr = document.querySelector('.model-descr')
    model_descr.style.textShadow = '0 0 7px red'
    model_descr.contentEditable = true
    model_descr.addEventListener('keyup', () => {
        goodsChanged(id, 'description', model_descr.innerText)
    })
    makeActive(event);
}


function saveGoods() { // переписываем
    if (confirm("Прежняя версия товаров будет переписана, продолжать?")) {
        goods.models.map(el => Object.entries(el)[0][1].isEdited = false)


        if (!goods.banner) goods.banner.url = '01.jpg'
        let data = `var goods = {}; goods.banner = {url: "${goods.banner.url}"};goods.colors = {darkBlue: 'Синий'}; goods.models = ${JSON.stringify(goods.models)}`;

        // 1 вариант. Скачиваем на комп пользователя
        // let a = document.createElement("a"); // для скачивания на компьютер
        // let file = new Blob([data], {type: 'application/json'});
        // a.href = URL.createObjectURL(file);
        // a.download = "listTovar.js";
        // a.click();

        // 2 вариант. Отправляем на сервер
        fetch('save.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'filename=' + encodeURIComponent('listTovar.js') + '&content=' + encodeURIComponent(data)
        })
            .then(response => response.text())
            .then(data => location.reload())
            .catch(error => console.error('Ошибка:', error));
    }

    showAllPhoto()
}

showAllPhoto()

function showAllPhoto() {
    // Запрос к PHP скрипту, который возвращает массив с названиями фоток
    fetch('get_images.php')
        .then(response => response.json()) // Парсим ответ как JSON [3]
        .then(images => {
            let html = `<select id="del_photo" onchange="showPhotoDelete(this.value)"><option value="">Выберите фото для удаления</option>
${images.map(el => '<option value="' + el + '">' + el + '</option>')}</select>`
            document.querySelector('#dialog-content-main').innerHTML = html
        })
        .catch(error => console.error('Ошибка:', error));
}

/* баннер */
function getBanner() {
    let guid = Math.random().toString(36).substring(2)
    fetch('get_banners.php')  // Changed from get_banners.php to get_images.php to use existing functionality
        .then(response => response.json())
        .then(images => {
            let html = ''
            images.forEach(image => {
                html += `<label title="Сделать основным" style="cursor: pointer">
<input type="radio" ${goods.banner && goods.banner.url === image ? 'checked' : ''} 
name="pic" value="${image}" ${image === currentPhoto ? 'checked' : ''}> ${image} 
<span style="color: white" title="Осторожно! Удаляется безвозратно." onclick="deleteBanner('${image}')">❌</span></label> 
  <br>`
            })
            document.querySelector('.banner .check').innerHTML = html
            // Add event listener for radio button changes
            document.querySelectorAll('.banner .check input[name="pic"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    document.querySelector('#banner-preview').src = 'banners/' + this.value + '?v=' + guid;
                    goods.banner = {url: this.value}
                    makeDirty()
                });
            });
            if (goods.banner) {
                document.querySelector('#banner-preview').src = 'banners/' + goods.banner.url + '?v=' + guid
            }
        })
        .catch(error => console.error('Ошибка при загрузке изображений:', error));
}

getBanner()

function makeDirty() {
    // console.log('document.querySelector(\'.fixed-div\') = ', document.querySelector('.fixed-div'))
    document.querySelector('.fixed-div').classList.add('dirty')
}

function deleteBanner(currentPhoto) {
    console.log('image = ', currentPhoto)
    if (confirm("Фото " + currentPhoto + " удалится безвозвратно, продолжать?")) {
        fetch('deleteBanner.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'filename=' + encodeURIComponent(currentPhoto)
        })
            .then(response => response.text())
            .then(data => {
                location.reload()
            })
            .catch(error => console.error('Ошибка:', error));
    }

}