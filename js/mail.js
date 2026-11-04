function sendpriceF1() {
    var url = "js/mail.php";
    var model = document.getElementById("modelF1").innerText;
    var name = document.getElementById("NameF1").value;
    var phone = document.getElementById("PhoneF1").value;
    var email = document.getElementById("EmailF1").value;
    var utm_source = document.getElementById("utm_source").value;
    var utm_medium = document.getElementById("utm_medium").value;
    var utm_campaign = document.getElementById("utm_campaign").value;
    var utm_term = document.getElementById("utm_term").value;
    var utm_content = document.getElementById("utm_content").value;
    var title = "Заказ прайса на Ложки";
    var task = "Отправить прайс по Ложкам";
    var err = 0;
    if (name.length < 1) {
        err = 1;
        document.getElementById('NameF1').placeholder = "Введите ВАШЕ имя";
        document.getElementById("NameF1").className += " formInvalid"
    }
    if (phone.length < 1) {
        err = 1;
        document.getElementById('PhoneF1').placeholder = "Введите ВАШ телефон";
        document.getElementById("PhoneF1").className += " formInvalid"
    }
    if (email.length < 1) {
        err = 1;
        document.getElementById('EmailF1').placeholder = "Введите ВАШ E-mail";
        document.getElementById("EmailF1").className += " formInvalid"
    }
    if (err == 1) {
        return false
    } else {
        $("#tovar").modal("hide");
        thanksShow();
        var posting = $.post(url, {
            model: model,
            name: name,
            phone: phone,
            email: email,
            title: title,
            task: task,
            utm_source: utm_source,
            utm_medium: utm_medium,
            utm_campaign: utm_campaign,
            utm_term: utm_term,
            utm_content: utm_content
        });
        posting.done(function (data) {
            document.getElementById("NameF1").value = "";
            document.getElementById("PhoneF1").value = "";
            document.getElementById("EmailF1").value = "";
            yaCounter44781169.reachGoal('lead')
        })

        // sendTelegram('::: Заказ консультации по телефону. \n Имя ' + name + '\n' +
        //     ' Телефон ' + phone + '\n' +
        //     ' Email ' + email + '\n' +
        //     ' Модель ' + model + '\n' +
        //     ' Задача ' + task + '\n'
        // )

    }
}

function sendToEmail() {
    var url = "js/mail.php";
    var model = document.getElementById("modelCB").innerText;
    var name = document.getElementById("NameCB").value;
    var phone = document.getElementById("PhoneCB").value;
    var email = document.getElementById("EmailCB").value;
    var utm_source = document.getElementById("utm_source").value;
    var utm_medium = document.getElementById("utm_medium").value;
    var utm_campaign = document.getElementById("utm_campaign").value;
    var utm_term = document.getElementById("utm_term").value;
    var utm_content = document.getElementById("utm_content").value;
    var title = "Заказ консультации по телефону";
    var task = "Созвониться с клиентом";
    var err = 0;
    if (name.length < 1) {
        err = 1;
        document.getElementById('NameCB').placeholder = "Введите ВАШЕ имя";
        document.getElementById("NameCB").className += " formInvalid"
    }
    if (phone.length < 1) {
        err = 1;
        document.getElementById('PhoneCB').placeholder = "Введите ВАШ телефон";
        document.getElementById("PhoneCB").className += " formInvalid"
    }
    if (email.length < 1) {
        err = 1;
        document.getElementById('EmailCB').placeholder = "Введите ВАШ E-mail";
        document.getElementById("EmailCB").className += " formInvalid"
    }
    if (err == 1) {
        return false
    } else {
        $("#call-back").modal("hide");
        thanksShow();
        var posting = $.post(url, {
            model: model,
            name: name,
            phone: phone,
            email: email,
            title: title,
            task: task,
            utm_source: utm_source,
            utm_medium: utm_medium,
            utm_campaign: utm_campaign,
            utm_term: utm_term,
            utm_content: utm_content
        });



        // sendTelegram(':: Заказ консультации по телефону. \n Имя ' + name + '\n' +
        //     ' Задача: Созвониться с клиентом\n' +
        //     ' Телефон ' + phone + '\n' +
        //     ' Email ' + email + '\n')

        posting.done(function (data) {
            document.getElementById("NameCB").value = "";
            document.getElementById("PhoneCB").value = "";
            document.getElementById("EmailCB").value = "";
            yaCounter44781169.reachGoal('lead')
        })
    }
}

