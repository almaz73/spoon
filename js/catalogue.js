if (window.location == 'http://xn----htbeijemffg.xn--p1ai/#goodsend') thanksShow()
if (window.location == 'http://xn----htbeijemffg.xn--p1ai/#badsend') errShow()

let countCaurusel = 0
function goCaurusel(number, starter) {
    countCaurusel++
    if(number>countCaurusel) setTimeout(() => {
        starter.click()
        goCaurusel(number, starter)
    }, 5000)
}

function showCaurusel() {
    let carusel = document.querySelector('.carousel-inner')
    let items = carusel.querySelectorAll('.item')
    items.forEach(item => item.classList.remove('active'))
    let placeNumbr  = parseInt(goods.banner.url)
    items[placeNumbr-1].classList.add('active')
    let starter = document.querySelector('.glyphicon-chevron-right')
    goCaurusel(5, starter)
}
function show() {
    showCaurusel()
    for (var g of goods.models) {
        let elem = Object.entries(g)[0][0]
        let item = Object.entries(g)[0][1]

        var i = $('<div class="col-lg-4 col-md-4 col-xs-6">' +
            '<div class="goods-boots-info model-box" data-id="' + elem + '">' +
            '<div class="buttons">' +
            '<a href="#tovar" data-toggle="modal" class="showtovar readmore"><p>' + item.cat_name + '</p>' + '<h4>' + item.name + '</h4></a>' +
            '<a href="#tovar" data-toggle="modal" class="showtovar readmore">' +
            '<img style="aspect-ratio: 292/190" src="' + item.img + '" ' +
            'width="100%" alt="' + item.name + '" title=""/></a>' + '' +
            '<div class="photobuttons online"><a onclick="showBig(event)" title="На весь экран">☐</a></div>' +
            '<div class="tovar_info">' +
            '<div title="Указанная цена действует на крупные оптовые заказы" class="price price-txt">от <span>' +
            item.price + '</span> руб.*</div>' +
            '<div class="readmore"><a href="#tovar" class="showtovar readmore" data-toggle="modal">Подробнее</a></div>' + '</div>' + '</div>');
        var cat = Object.keys(g)[0].split('_');
        $("#" + cat[0]).append(i)
    }
}

show()

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


goods.showTovar = function (id) {
    let item = this.models.find(el => el[id])
    var m = $('.modal-dialog');
    m.find('h4.modal-title').html(item[id].cat_name + item[id].name);
    m.find('.model-descr').html(item[id].description);

    if (item[id].noSkid === true) document.querySelector('.skid-fields').classList.add('noSkid')
    else document.querySelector('.skid-fields').classList.remove('noSkid')

    m.find('.gal-slider').empty();
    var img_i = 0;
    for (var gal_img in item[id].photos['all']) {
        if (img_i === 0)
            m.find('.gal-image img').prop('src', item[id].photos['all'][gal_img]);
        m.find('.gal-slider').append('<a href="' + item[id].photos['all'][gal_img] + '" class="' + (img_i === 0 ? 'act' : '') + '"><img src="' + item[id].photos['all'][gal_img] + '" alt="" title=""></a>');
        img_i++
    }
};


function thanksShow() {
    $("#thanks").modal('show')
};


function errShow() {
    $("#errors").modal('show')
};

function callBack() {
    $("#call-back").modal('show')
}

function hideBlock() {
    var block = $('#hider');
    if ($('body').scrollTop() >= 220) {
        block.show()
    } else {
        block.hide()
    }
}

$(window).scroll(hideBlock);
$('#cart').mouseover(function () {
    $('#cart').removeClass('animated zoomIn');
    $('#cart').addClass('animated pulse');
    $('.bcart').removeClass('hidden')
});
$('#cart').mouseout(function () {
    $('#cart').removeClass('animated pulse');
    $('.bcart').addClass('animated fadeInRight')
});
$('#lead').mouseover(function () {
    $('#lead').removeClass('animated zoomIn');
    $('#lead').addClass('animated pulse');
    $('.blead').removeClass('hidden')
});
$('#lead').mouseout(function () {
    $('#lead').removeClass('animated pulse');
    $('.blead').addClass('animated fadeInLeft')
});
$(window).scroll(function () {
    var winScrollTop = $(this).scrollTop();
    if (winScrollTop >= 1700) {
        $('.blead').removeClass('hidden');
        $('.bcart').removeClass('hidden')
    } else if (winScrollTop <= 350) {
        $('.blead').removeClass('hidden');
        $('.bcart').removeClass('hidden')
    } else {
        $('.blead').addClass('hidden');
        $('.bcart').addClass('hidden')
    }
});


document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") document.querySelector('[data-dismiss="modal"]').click()
})