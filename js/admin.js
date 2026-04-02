if (window.location == 'http://xn----htbeijemffg.xn--p1ai/#goodsend') thanksShow()
if (window.location == 'http://xn----htbeijemffg.xn--p1ai/#badsend') errShow()

function show() {
    // $('.goods-boots-info');
    let c1 = document.querySelector('#c1')
    if (c1) c1.innerHTML = ''
    let c6 = document.querySelector('#c6')
    if (c6) c6.innerHTML = ''
    let div1 = document.querySelector('.goods-boots-info')
    if (div1) document.querySelector('.goods-boots-info').innerHTML = ''


    for (var g of goods.models) {
        let elem = Object.entries(g)[0][0]
        let item = Object.entries(g)[0][1]

        var i = $('<div class="col-lg-4 col-md-4 col-xs-6 box" >' +
            '<div class=" goods-boots-info model-box ' + (item.isEdited ? 'is-edited' : '') + '" data-id="' + elem + '">' +
            '<div class="buttons">' +
            '<a onmousedown="editElement(\'' + elem + '\',event); "  title="Редактирование">✎</a> ' +
            '<a onclick="doubleElement(\'' + elem + '\')" title="Дублировать">❒</a> ' +
            '<a onclick="deleteElement(\'' + elem + '\')" title="Удаление">✖</a></div>' +

            '<a ><p>' + item.cat_name + '</p>' +
            '<h4>' + item.name + '</h4></a>' +
            '<a href="#tovar" data-toggle="modal" class="showtovar readmore" style="position: relative">' +
            '<img onclick="editModal(\'' + elem + '\', event)" style="aspect-ratio: 292/190;"  src="' + item.img + '" width="100%" alt="' + item.name + '" title=""/>' +
            '<div class="photobuttons">' +
            '<a onclick="showBig(event)" title="На весь экран">☐</a>' +
            '&nbsp;<a onclick="makeActive(event);changePhoto(\'' + elem + '\')" title="Смена фото">✎</a>' +
            '</div>' +
            '</a>' +
            '<div class="tovar_info">' + '<div title="Указанная цена действует на крупные оптовые заказы" class="price price-txt">от <span>' + item.price + '</span> руб.*</div>' + '<div class="readmore">' +
            '<a href="#tovar" onclick="editModal(\'' + elem + '\', event)" class="showtovar readmore" data-toggle="modal">Подробнее</a></div>' + '</div>' + '</div>');
        var cat = Object.keys(g)[0].split('_');
        $("#" + cat[0]).append(i)
    }


    $('.showtovar').click(function (e) {
        e.preventDefault();
        var i = $(this).closest('.goods-boots-info');
        goods.showTovar(i.data('id'))
    });
    $('.modal-body').each(function (e) {
        var t = $(this),
            s = t.find('.gal-slider'),
            sel_index;
        s.find('a').eq(0).addClass('act');
        var update_gal_image = function () {
            t.find('.gal-image img').fadeOut(100, function () {
                $(this).remove();
                t.find('.gal-image').append('<img style="opacity:0;" src="' + s.find('a').eq(s.find('a').index(s.find('a.act'))).attr('href') + '" />');
                t.find('.gal-image img').animate({
                    opacity: 1
                }, 100)
            })
        };
        $(document).on('click', '.gal-slider a', function (e) {
            e.preventDefault();
            s.find('a').removeClass('act');
            $(this).addClass('act');
            update_gal_image()
        });
        t.find('.left-arrow').click(function (e) {
            e.preventDefault();
            sel_index = s.find('a').index(s.find('a.act'));
            if (sel_index > 0) {
                if (sel_index - 1 + s.position().left / s.find('a').outerWidth(true) < 0) {
                    s.animate({
                        left: (s.position().left + s.find('a').outerWidth(true)) + 'px'
                    }, 100)
                }
                s.find('a').removeClass('act').eq(sel_index - 1).addClass('act');
                update_gal_image()
            } else {
                sel_index = 0;
                s.find('a').removeClass('act').eq(sel_index).addClass('act');
                update_gal_image()
            }
        });
        t.find('.right-arrow').click(function (e) {
            e.preventDefault();
            sel_index = s.find('a').index(s.find('a.act'));
            if (sel_index + 1 < s.find('a').length) {
                if (sel_index + 1 + s.position().left / s.find('a').outerWidth(true) >= 4) {
                    s.animate({
                        left: (s.position().left - s.find('a').outerWidth(true)) + 'px'
                    }, 100)
                }
                s.find('a').removeClass('act').eq(sel_index + 1).addClass('act');
                update_gal_image()
            } else {
                sel_index = 0;
                s.find('a').removeClass('act').eq(sel_index).addClass('act');
                update_gal_image()
            }
        })
    })
}

show()





goods.showTovar = function (id) {
    let item = this.models.find(el => {
        return el[id]
    })


    var m = $('.modal-dialog');
    m.find('h4.modal-title').html(item[id].cat_name + item[id].name);
    m.find('.model-descr').html(item[id].description);
    m.find('.price').html(item[id].price);
    m.find('.gal-slider').empty();
    var img_i = 0;
    for (var gal_img in item[id].photos['all']) {
        let photo = item[id].photos['all'][gal_img]
        if (img_i === 0) m.find('.gal-image img').prop('src', photo);

        m.find('.gal-slider').append(
            '<span style="position: relative;">' +
            '<span class="mod_photo" ' +
            'onclick="changePhoto(\'' + id + '\', event, \`'+photo+'\`, '+gal_img+')" title="Смена фото">✎</span>' +
            '<span class="mod_photo" style="margin-left: 20px" ' +
            'onclick="deleteModalPhoto(\'' + id + '\', '+gal_img+')" title="Удаление фото">✖</span>' +
            '<span class="mod_photo" style="margin-left: 40px"' +
            'onclick="doubleModalPhoto(\'' + id + '\', event, \`'+photo+'\`, '+gal_img+')" title="Дублирование фото">❒</span>' +
            '<a href="' + photo + '" class="' + (img_i === 0 ? 'act' : '') + '">' +
            '<img src="' + photo + '" alt="" title=""></a></span>');
        img_i++
    }

    let skidFields = document.querySelector('.skid-fields')
    let idSkid = document.querySelector('#idSkid')
    if (item[id].noSkid === true && skidFields) {
        skidFields.style.opacity = .1
        idSkid.checked = true
    } else {
        skidFields.style.opacity = 1
        idSkid.checked = false
    }


};


function thanksShow() {
    $("#thanks").modal('show')
};

function errShow() {
    $("#errors").modal('show')
};

// function callBack() {
//     $("#call-back").modal('show')
// }

// $('#cart').mouseover(function () {
//     $('#cart').removeClass('animated zoomIn');
//     $('#cart').addClass('animated pulse');
//     $('.bcart').removeClass('hidden')
// });
// $('#cart').mouseout(function () {
//     $('#cart').removeClass('animated pulse');
//     $('.bcart').addClass('animated fadeInRight')
// });
// $('#lead').mouseover(function () {
//     $('#lead').removeClass('animated zoomIn');
//     $('#lead').addClass('animated pulse');
//     $('.blead').removeClass('hidden')
// });
// $('#lead').mouseout(function () {
//     $('#lead').removeClass('animated pulse');
//     $('.blead').addClass('animated fadeInLeft')
// });


