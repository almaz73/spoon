let currentId
let currentPhoto
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

function changePhoto(id) {
    currentId = id
    let elem = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
    let photo =elem.img.slice(6)

    // Запрос к PHP скрипту
    fetch('get_images.php')
        .then(response => response.json()) // Парсим ответ как JSON [3]
        .then(images => {
            document.getElementById('my-dialog').showModal()
            let html = `<select id="photo" onchange="showPhoto(this.value)">
${images.map(el => '<option value="' + el + '">' + el + '</option>')}</select>`
            document.querySelector('#dialog-content').innerHTML = html
               showPhoto(photo)
               document.querySelector("select").value = photo
        })
        .catch(error => console.error('Ошибка:', error));
}

function showPhoto(photo) {
    console.log('photo = ', photo)
    currentPhoto = photo
    document.querySelector('#dialog-photo').innerHTML = `<img src="tovar/${photo}">`
}

function setPhoto() {
    let photo = document.querySelector("select").value
    document.getElementById('my-dialog').closest('dialog').close()
    let elem = goods.models.find(el => Object.entries(el)[0][0] === currentId)[currentId]
    if(elem) elem.img = 'tovar/'+photo
    show()
}

function uploadPhoto() {
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
        
        // Send the file to the server
        fetch('savePhoto.php', {// Changed from save.php to savePhoto.php
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
            if(data.success) {
                if (currentId) {
                    let elem = goods.models.find(el => Object.entries(el)[0][0] === currentId)[currentId];
                    if (elem) {
                        elem.img = 'tovar/' + data.filename;
                        show();
                        document.getElementById('my-dialog').closest('dialog').close()
                    }
                }
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
    if (confirm("Фото "+currentPhoto+" удалится безвозвратно, продолжать?")) {
        fetch('deletePhoto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'filename=' + encodeURIComponent(currentPhoto)
        })
        .then(response => response.json())
        .then(data=> {
            if (data.success) {
                alert('Фото успешно удалено');
                document.getElementById('my-dialog').closest('dialog').close()
                show();
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
        show()
    }
}

function doubleElement(id) {
    let guid = Math.random().toString(36).substring(2)
    let index = goods.models.findIndex(el => Object.entries(el)[0][0] === id)
    let body = goods.models.find(el => Object.entries(el)[0][0] === id)[id]
    let node = {}
    let key = `${id.slice(0, -2)}_${guid}`
    node[key] = JSON.parse(JSON.stringify(body))
    node[key].isEdited = true
    goods.models.splice(index + 1, 0, node)
    show()
}

function editElement(id) {
    goods.models = goods.models.map(el => {
        if (Object.entries(el)[0][0] === id) el[id].isEdited = true
        return el
    })

    show()
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
}

function editModal(id) {
    currentId = id
    let model_descr = document.querySelector('.model-descr')
    let div = document.querySelector(`[data-id="${id}"]`)
    if (div.classList.contains('is-edited')) {
        model_descr.style.textShadow = '0 0 7px red'
        model_descr.contentEditable = true
        model_descr.addEventListener('keyup', () => {
            goodsChanged(id, 'description', model_descr.innerText)
        })

    } else {
        model_descr.style.textShadow = ''
        model_descr.contentEditable = false
    }
}


function createFile() {


    goods.models.map(el => Object.entries(el)[0][1].isEdited = false)
    // console.log('goods.models = ', goods.models)
    // return false

    let text = `var goods = {};goods.colors = {darkBlue: 'Синий'};
    goods.models = ${JSON.stringify(goods.models)}`;
    downloadAsFile(text);

    function downloadAsFile(data) {
        // let a = document.createElement("a"); // для скачивания на компьютер
        // let file = new Blob([data], {type: 'application/json'});
        // a.href = URL.createObjectURL(file);
        // a.download = "listTovar.js";
        // a.click();

        // 2. Отправляем на сервер
        fetch('save.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'filename=' + encodeURIComponent('listTovar.js') + '&content=' + encodeURIComponent(data)
        })
            .then(response => response.text())
            .then(data => {
                if (confirm("Прежняя версия будет переписана, продолжать?")) {
                    location.reload()
                }
            })
            .catch(error => console.error('Ошибка:', error));
    }
}


