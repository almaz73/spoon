document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('body').style.background = '#3d3d3d'
    document.querySelector('body').style.opacity = 0
    document.querySelector('[href="#tovar"]').click()
    setTimeout(() => {
        document.querySelector('[data-dismiss="modal"]').click()
        setTimeout(() => {
            document.querySelector('body').style.opacity = 1
        }, 350)
    })
})

function deleteElement(id) {
    goods.models = goods.models.filter(el => Object.entries(el)[0][0] !== id)
    show()
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
        goodsChanged(id, 'one_price', priceDiv.innerText)
    })
}

function goodsChanged(id, type, value) {
    let elem = goods.models.find(el => Object.entries(el)[0][0] === id)
    elem[id][type] = value
}

function editModal(id) {
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
    console.log('goods.models = ', goods.models)

    let text = `var goods = {};goods.colors = {darkBlue: 'Синий'};
    goods.models = ${JSON.stringify(goods.models)}`;
    downloadAsFile(text);

    console.log('text = ', text)

    function downloadAsFile(data) {
        let a = document.createElement("a");
        let file = new Blob([data], {type: 'application/json'});
        a.href = URL.createObjectURL(file);
        a.download = "listTovar.js";
        a.click();
    }
}


