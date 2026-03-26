



function deleteElement(id) {
    goods.models =  goods.models.filter(el=>{
        return Object.entries(el)[0][0]!==id
    })
    show()
}

setTimeout(()=>console.log('000 goods.models = ', goods.models))
function doubleElement(id) {
    let guid = Math.random().toString(36).substring(2)
    let index = goods.models.findIndex(el=>Object.entries(el)[0][0]===id)
    let body = goods.models.find(el=>Object.entries(el)[0][0]===id)[id]
    let node = {}
    node[`${id.slice(0,-2)}_${guid}`] = body
    goods.models.splice(index, 0, node)
    show()
}

function editElement(self) {
    // console.log('self = ', self)
    let div =  self.target.parentNode.parentNode
    let cat_nameDiv = div.querySelector('.showtovar p')
    let nameDiv = div.querySelector('.showtovar h4')
    let priceDiv =div.querySelector('.tovar_info span')
    // let model_descr = div.querySelector('.tovar_info .model-descr')
    // console.log('model_descr = ', model_descr)

    cat_nameDiv.style.textShadow = '0 0 7px red'
    cat_nameDiv.contentEditable = true


    nameDiv.style.textShadow = '0 0 7px red'
    nameDiv.contentEditable = true

    priceDiv.style.textShadow = '0 0 4px black'
    priceDiv.contentEditable = true
    // model_descr.style.textShadow = '0 0 7px red'
    // model_descr.contentEditable = true

    console.log('self.target.parentNode.parentNode = ', self.target.parentNode.parentNode)
    // text-shadow: 0 0 4px black;
    // self.target.parentNode.parentNode.contentEditable = true;
    // self.target.parentNode.parentNode.style.border='1px solid red'
}

function createFile() {
    console.log('goods.models = ', goods.models)

    let text = `var goods = {};goods.colors = {darkBlue: 'Синий'};
    goods.models = ${JSON.stringify(goods.models)}`;
    downloadAsFile(text);

    function downloadAsFile(data) {
        let a = document.createElement("a");
        let file = new Blob([data], {type: 'application/json'});
        a.href = URL.createObjectURL(file);
        a.download = "listTovar.js";
        a.click();
    }
}


