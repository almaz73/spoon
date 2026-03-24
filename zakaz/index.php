<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Заказ онлайн</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <style>
        body {
            padding-top: 0px;
        }
		#footer{
			padding: 10px 10px;
			margin-top: 30px;
			border-top: 2px solid #ddd;
		}
		  button > span > div > div > img {
			  display:none;
		  }
		  .imaket{
			  width:250px;
			  margin: auto;
		  }
		  .selType {width: 100% !important;}
		  .hidepc{
			  display:none;
		  }
		  .hidemobile{
		    display:block;
		  }
		  .cont{
			  background-color: #ddd; 
			  border-radius: 10px;
			  padding: 0px 20px 20px 20px;
		  }
		  .rblock{
			  border-right: 1px solid #fff;
		  }
			#tovar-skidka{
				text-align:center;
				font-size: medium;
			}
			#tovar-itog {
				text-align:center;
				font-size: medium;
			}
			#tovar-skidkaf {
				text-align:center;
				width: 100%;
				font-size: medium;
			}
			#tovar-itogf {
				text-align:center;
				width: 100%;
				font-size: medium;
			}
			.htext{
				border-bottom: 2px solid #fff;
				border-top: 2px solid #fff;
				line-height: 2.5;
				margin: 0px;
				font-size: 2em;
				margin-bottom: 10px;
			}
			.tester:after{
				content: "Тестирование";
				font-size: 10px;
				font-weight: 600;
				color: #fff600;
				background: green;
				padding: 5px;
				border-radius: 5px;
				vertical-align: middle;
			}
		#delCart{
			background-color: #ff4c4c;
			color: white;
		}
		#delCart:hover{
			background-color: #fff;
			color: #ff4c4c;
		}
		@media screen and (max-width: 990px){
			  .rblock{
				  border-right: none;
			  }
		}
		@media screen and (max-width: 760px){
			.tester:after{
				display:none;
			}
			.text-left, .text-right{
				text-align:center !important;
			}
			.tablemin{
				font-size:10px;
			}
			.hidepc{
				display:block;
			}
			.hidemobile{
				display:none;
			}
			.cont{
				border-radius: 0px;
				padding: 0px 20px 20px 20px;
			}
		}
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>
        <script src="js/tovar.js"></script>
        <script src="js/names.js"></script>
        <script src="js/makets.js"></script>
		
		
		<link rel="stylesheet" href="css/bootstrap-select.min.css">

		
		<script src="js/bootstrap-select.min.js"></script>

		
		<script src="js/i18n/defaults-ru_RU.min.js"></script>

    </head>
    <body>
        
        <div id="orderModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center">Проверка заказа</h4>
              </div>
              
              <div class="modal-body">
				<div id="tlist">
						<table class="table">
							<thead>
								<tr>
									<th class="tablemin">№</th>
									<th class="tablemin">Наименование</th>
									<th class="tablemin">Надпись</th>
									<th class="tablemin">Макет</th>
									<th class="tablemin">Кол-во</th>
									<th class="tablemin">Цена</th>
								</tr>
							</thead>
							<tbody id="tovars">
							</tbody>
						</table> 
				</div>
				<div id="tovar-skidkaf" class="container" style="">
							Скидка:
							<strong id="itogSkidkaf">0%</strong>
				</div>
				<div id="tovar-itogf" class="container" style="">
							ИТОГО:
							<strong id="itogPricef" style="color:green;">0</strong>
				</div>
              </div>
              
              <div class="modal-footer">
                <h4 class="modal-title text-center">Данные заказчика</h4>
                    <form class="form-horizontal">
                        <div class="form-group">
                         <div class="col-sm-12">
                          <input type="text" class="form-control" id="nameN" placeholder="Имя">
                         </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-12">
                          <input type="email" class="form-control" id="emailN" placeholder="Email">
                         </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-12">
                             <input type="tel" class="form-control" id="phoneN" placeholder="Телефон">
                         </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-12">
                          <button id="sendOrder" type="button" class="btn btn-success" >Отправить заказ</button>
                         </div>
                        </div>
                   </form>
				   
					<div id="resultErr" class="text-center" style="color:red;"></div>
					<div id="resultGood" class="text-center" style="color:green;"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="errModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ошибка</h4>
              </div>
              
              <div class="modal-body">
                  <div id="err"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="thModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" style="text-align:center;">Заказ успешно отправлен</h4>
              </div>
              
              <div class="modal-body">
                  <div id="thanks" style="text-align:center;"></div>
              </div>
            </div>
          </div>
        </div>
		
		
        <div class="container cont">
		<div class="row htext">
			<div class="col-md-3 col-sm-12">
				<div class="row text-center">
					<a href="/" title="Вернуться на сайт"><img width="200px" src="images/logo-green.png" /></a>
				</div>
			</div>
			<div class="col-md-7 col-sm-12"> 
				<h1 class="text-center">Форма оптового заказа</h1>   
			</div>
			<div class="col-md-2 col-sm-12">
			<h1 class="text-center tester" title="При приблемах с оформлением заказа и ошибках, сообщайте менеджеру, чтобы сделать сервис лучше."></h1>   
			</div>
		</div>
           <div class="row">
                <div class="col-md-5 rblock">
                 <form>
                    <div class="form-group">
                        <select id="selectSerie" class="show-tick form-control">
                            <option value="none">Выберите категорию</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="selectType" class="show-tick form-control" disabled>
                            <option value="none">Выберите наименование товара</option>
                        </select>
                    </div>
                     <div class="form-group col-md-12" style="padding-left: 0; padding-right: 0;">
                        <select id="selectNadpis" class="show-tick form-control" disabled>
                            <option value="none">Выберите надпись </option>
                            <option value="other">Другая надпись </option>
                        </select>
                         <input type="text" class="form-control" id="nadpis" placeholder="Надпись">
                    </div> 

                    <div class="form-group col-md-6" style="padding-left: 0; padding-right: 0;">
						<label style="text-align:center;width: 100%;">Макет гравировки</label>
                        <select id="selectMaket" class="selectpicker selType" disabled>
                            <div><div style="text-align: center;"><img style="width:150px;"src="none"/></div><div style="text-align:center;"></div></div>
                        </select>
                    </div>         
                    <div class="form-group col-md-6" style="padding-left: 0;padding-right: 0;">
						<label style="text-align:center;width: 100%;">Количество</label>
                        <input type="number" class="form-control text-center" style="font-weight:600; font-size: 18px;" id="kol-vo" placeholder="Количество" value="0" disabled>
                    </div>           
					<div class="form-group col-md-12">
						<label style="text-align:center;width: 100%;" title="Без учета скидки, скидка применяется при подсчете всего заказа.">Стоимость*</label>
                         <p style='text-align: center;'><span style='text-align: center;font-size: 1.7em;color:green' id="currPrice">0</span> </p>
                     </div>
                     <div class="form-group">
                         <button type="button" id="addCart" class="btn btn-primary" style="width: 100%">В заказ</button>
                     </div>
                  </form>
                </div>
				<button type="button" id="tovarInfoView" class="btn btn-info hidepc" style="text-align:center;margin:auto;">Свернуть/Развернуть описание товара</button>
                <div class="col-md-7 hidemobile" id="tovarInfo">
                    <div class="col-md-6 col-md-push-6">
                        <div class="pic text-center"></div>
                    </div>
						<div class="col-md-6 col-md-pull-6">
								<h4 class="naimenovanie text-center"></h4>
								<div class="opisanie text-justify"></div>
						<div class="row" style="text-align: center;">
								<h4 class="text-center priceTitle"></h4>
								<div class="col-md-6 col-xs-6 col-sm-6 deskPrice">
								</div>
								<div class="col-md-6 col-xs-6 col-sm-6">
									<div class="price5"></div>
									<div class="price30"></div>
									<div class="price70"></div>
									<div class="price100"></div>
								</div>
						</div>
						</div>
                </div>
            </div>
        </div>
        <div id="tovar-list-head" class="container cont" style="margin-top: 20px">
            <h2 class="text-center">Товары в корзине</h2>
            <div id="noneTovar" class='row' style="border-bottom: 1px solid #fff;">
                <div class='col-md-12 text-center'>
                    <h3 style="color:rosybrown">Корзина пуста</h3>
                </div>
            </div>   
        </div>
        <div id="tovar-list" class="container" style="background-color: #ddd;padding: 0px 3px 20px 3px;"> 
			<div id="tlist">
					<table class="table">
						<thead>
							<tr>
								<th class="tablemin">№</th>
								<th class="tablemin">Наименование</th>
								<th class="tablemin">Надпись</th>
								<th class="tablemin">Макет</th>
								<th class="tablemin">Кол-во</th>
								<th class="tablemin">Цена</th>
							</tr>
						</thead>
						<tbody id="tovarTable">
						</tbody>
					</table>
			</div>
        </div>
        <div id="tovar-skidka" class="container" style="">
                    <strong>Скидка:</strong>
                    <strong id="itogSkidka">0%</strong>
        </div>
        <div id="tovar-itog" class="container" style="">
                    <strong>ИТОГО: </strong>
                    <strong id="itogPrice" style="color:green;">0</strong>
        </div>
        <div id="order" class="container" style="">
            <div class='row' style="">
                <div class='col-md-4 col-md-offset-8 text-center'>
                    <button type="button" id="orderCreate" class="btn btn-default btn-success" style="width: 100%; margin-top: 20px;">Оформить заказ</button>
                </div>
            </div>
        </div>
		
		<section id="footer">
			<div class="container">
				<div class="row center">
					<div class="col-md-6 text-left"><strong>Email: lojkin.dom@mail.ru</strong></div>
					<div class="col-md-6 text-right"><strong>Телефон/WhatsApp/Viber: +7(952)042-56-27</strong></div>
				</div>
			</div>
		</section>
		
        <script>
		eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c+'\\b','g'),k[c])}}return p}('21 35=[];21 14=0;21 37=0;21 47="Выберите макет";21 140=74;$(\'#87\').71();53(21 48 50 115){$(\'#57\').36($("<17></17>").13(115[48]))}53(21 43 50 40){$(\'#46\').36($("<17></17>").23("44",43).13(40[43].48))}$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><29 19=\'75\'69=\'45\'/></6><6 22=\'13-32:26;\'>Выберите макет</6></6>").23("44","Выберите макет"));24 112(107){53(21 43 50 40[107]){11(43!=="48"){$(\'#25\').36($("<17></17>").23("44",43).13(40[107][43].48))}}}$(\'#46\').73(24(){$(\'#28 78.137\').9("");$(\'#28 6.144\').9(\'\');$(\'#28 6.134\').9(\'\');$(\'#25\').63("64",74);$(\'#25\').9($("<17></17>").23("44","45").13("Выберите наименование товара"));112($(\'#46\').8());$(\'#33-31\').8(0);$(\'#62\').9("0")});$(\'#25\').73(24(){11($(\'#25\').8()==="45"){$(\'#28\').9("");$(\'#57\').63("64",91);$(\'#33-31\').63("64",91);$(\'#33-31\').8(1);$(\'#62\').9(0);$(\'#12\').9("");$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><29 19=\'75\'69=\'45\'/></6><6 22=\'13-32:26;\'>Выберите макет</6></6>").23("44","Выберите макет"));$(\'#12\').63("64",91);$("#12").77(\'76\')}$(\'#28 78.137\').9($("#46 17:143").13()+" - "+$("#25 17:143").13());$(\'#28 6.144\').9(\'<29 22="151: 100%;98: 5%;" 69="\'+40[$(\'#46\').8()][$(\'#25\').8()].29+\'"/>\');$(\'#28 6.134\').9(40[$(\'#46\').8()][$(\'#25\').8()].150);$(\'#28 6.152\').9("<6>от 5 тыс.руб.</6><6>от 30 тыс.руб.</6><6>от 70 тыс.руб.</6><6>от 100 тыс.руб.</6>");$(\'#28 78.153\').9("Цены/Скидки:");21 42=$(\'#25\').8();$(\'#12\').9("");11(42==="136"){53(18 50 60){11(18==0){$(\'#12\').9("")}11(60[18].29==="45"){$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><16>"+60[18].39+"</16></6></6>").23("44",18))}20{$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><29 19=\'75\'69=\'"+60[18].29+"\'/></6><6 22=\'13-32:26;\'><16>"+60[18].39+"</16></6></6>").23("44",18))}}$("#12").77(\'76\');47=60[$(\'#12\').8()].39}20 11(42==="135"){53(18 50 54){11(18==0){$(\'#12\').9("")}11(54[18].29==="45"){$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><16>"+54[18].39+"</16></6></6>").23("44",18))}20{$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><29 19=\'75\'69=\'"+54[18].29+"\'/></6><6 22=\'13-32:26;\'><16>"+54[18].39+"</16></6></6>").23("44",18))}}$("#12").77(\'76\');47=54[$(\'#12\').8()].39}20 11(42==="139"||42==="121"||42==="109"){53(18 50 59){11(18==0){$(\'#12\').9("")}11(59[18].29==="45"){$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><16>"+59[18].39+"</16></6></6>").23("44",18))}20{$(\'#12\').36($("<17></17>").23("38-52","<6><6 22=\'13-32:26;\'><29 19=\'75\'69=\'"+59[18].29+"\'/></6><6 22=\'13-32:26;\'><16>"+59[18].39+"</16></6></6>").23("44",18))}}$("#12").77(\'76\');47=59[$(\'#12\').8()].39}65=40[$(\'#46\').8()][$(\'#25\').8()].89;$(\'#28 6.148\').9(65+" руб.");$(\'#28 6.146\').9((65-(65/100*5))+" руб.");$(\'#28 6.154\').9((65-(65/100*10))+" руб.");$(\'#28 6.149\').9("договорная");$(\'#57\').63("64",74);$(\'#33-31\').63("64",74);$(\'#12\').63("64",74);$(\'#33-31\').8(1);$(\'#62\').9(40[$(\'#46\').8()][$(\'#25\').8()].89*$(\'#33-31\').8());$("#12").77(\'76\')});$(\'#12\').73(24(){21 42=$(\'#25\').8();11(42==="136"){47=60[$(\'#12\').8()].39}20 11(42==="135"){47=54[$(\'#12\').8()].39}20 11(42==="139"||42==="121"||42==="109"){47=59[$(\'#12\').8()].39}});$(\'#57\').73(24(){11($(\'#57\').8()==="119"){$(\'#87\').55()}20{$(\'#87\').71()}});$(\'#33-31\').73(24(){11($(\'#33-31\').8()<0){$(\'#33-31\').8(0)}$(\'#62\').9(40[$(\'#46\').8()][$(\'#25\').8()].89*$(\'#33-31\').8()+" руб.")});24 117(96){21 113=35[96].102(\';\');14=14-113[4];11(14>=114&&14<88){$(\'#58\').9(\'<16>5%(\'+14/100*5+\' руб.)</16>\');37=14-(14/100*5)}20 11(14>=88){$(\'#58\').9(\'<16>10%(\'+14/100*10+\' руб.)</16>\');37=14-(14/100*10)}20{$(\'#58\').9(\'<16>0%</16>\');37=14}$(\'#37\').9(37+" руб.");35.155(96,1);104();11(35.80<1){$("#108").55()}}$(\'#111\').82(24(51){51.84();11($(\'#25\').8()==="45"){156("Выберите товар")}20{$(\'#111\').147("#28").162()}});$(\'#184\').82(24(51){51.84();11($(\'#25\').8()==="45"||$(\'#33-31\').8()==="0"||47==="Выберите макет"){$(\'#90\').9("<6>"+"<78 19=\'13-26\' 22=\'86:185; 79: 68\'>Выберите наименование товара , необходимое количество а надпись и макет гравировки</78>"+" </6>");$("#94").61(\'55\')}20{118()}});24 118(){21 99=$(\'#46\').8();21 43=$(\'#25\').8();21 66;21 72=47;21 62=40[$(\'#46\').8()][$(\'#25\').8()].89*$(\'#33-31\').8();14=14+62;11(14>=114&&14<88){$(\'#58\').9(\'<16>5%(\'+14/100*5+\' руб.)</16>\');37=14-(14/100*5)}20 11(14>=88){$(\'#58\').9(\'<16>10%(\'+14/100*10+\' руб.)</16>\');37=14-(14/100*10)}20{$(\'#58\').9(\'<16>0%</16>\');37=14}$(\'#37\').9(131.130(37).129(2)+" руб.");11($(\'#57\').8()==="119"){66=$(\'#87\').8()}20{66=$(\'#57\').8()}11(72==="45"){72="-"}20{72=47}11(66==="45"){66="-"}35.178(40[99].48+" - "+40[99][43].48+";"+66+";"+72+";"+$(\'#33-31\').8()+";"+62);104()}24 104(){$("#116").9("");53(21 49 50 35){21 41=35[49].102(\';\');$("#116").36("<81 105="+49+" 22=\'98-124:68;\'>"+"<15 19=\'34\'>"+(123(49)+1)+"</15>"+"<15 19=\'34\'>"+41[0]+"</15>"+"<15 19=\'34\'>"+41[1]+"</15>"+"<15 19=\'34\'>"+41[2]+"</15>"+"<15 19=\'34\'>"+41[3]+"</15>"+"<15 19=\'34\'>"+41[4]+" руб."+"</15>"+"<15 19=\'34\'>"+"<95 43=\'95\' 105=\'179\' 19=\'180\' 181=\'117("+49+")\'>187</95>"+"</15>"+"</81>")}11(35.80>=1){$("#108").71()}}$(\'#188\').82(24(51){51.84();11(35.80<=0){$(\'#90\').9("<6>"+"<67 19=\'13-26\' 22=\'86:101; 79: 68\'>Заказ пуст</67>"+" </6>");$("#94").61(\'55\')}20 11(14<=138){$(\'#90\').9("<6>"+"<67 19=\'13-26\' 22=\'194-195: 196;86:101; 79: 68\'><16>Минимальная сумма заказа 138 рублей</16><83>По вопросам розничной продажи:<83>Телефон/193/189: +7(157)177-56-27</67>"+" </6>");$("#94").61(\'55\')}20{120();$("#122").61(\'55\')}});$(\'#164\').82(24(51){51.84();11($(\'#141\').8()===""||$(\'#142\').8()===""||$(\'#145\').8()===""){$("#85").9("Заполните все поля формы!")}20{133($(\'#141\').8(),$(\'#142\').8(),$(\'#145\').8(),$(\'#127\').9(),$(\'#132\').9(),35);$("#85").9("")}});24 120(){11(35.80<=0){$(\'#103\').9("<6>"+"<67 19=\'13-26\' 22=\'86:101; 79: 68\'>Заказ пуст</67>"+" </6>")}20{$("#103").9("");53(21 49 50 35){21 41=35[49].102(\';\');$("#103").36("<81 105="+49+" 22=\'98-124:68;\'>"+"<15 19=\'34\'>"+(123(49)+1)+"</15>"+"<15 19=\'34\'>"+41[0]+"</15>"+"<15 19=\'34\'>"+41[1]+"</15>"+"<15 19=\'34\'>"+41[2]+"</15>"+"<15 19=\'34\'>"+41[3]+"</15>"+"<15 19=\'34\'>"+41[4]+" руб."+"</15>"+"</81>")}$(\'#127\').9($(\'#58\').9());$(\'#132\').9(131.130(37).129(2)+\' руб.\')}}24 133(48,97,93,106,92,13){$158({43:\'159\',160:\'166/167.173\',38:{\'48\':48,\'97\':97,\'93\':93,\'106\':106,\'92\':92,\'13\':13},174:\'13\',175:24(38){11(38==="0"){$(\'126\',$(\'126\').125+\'<83 />\'+\'Заявка успешно отправлена\');$("#122").61(\'71\');$(\'#172\').9("Ваш заказ отправлен на обработку менеджеру, а также копия заказа отправлена Вам на электронную почту.");$("#128").61(\'55\')}20{$(\'85\',$(\'85\').125+\'<83 />\'+38)}}})}$(\'#128\').171(\'71.168.61\',24(){169.192()});170.161=24(){11(140){}20{11(37==0){}20{165"163 110 176 110 190 182 183 186 191?"}}}',10,197,'||||||div||val|html||if|selectMaket|text|fullPrice|td|strong|option|maket|class|else|var|style|attr|function|selectType|center||tovarInfo|img||vo|align|kol|tablemin|zakaz|append|itogPrice|data|art|tovar|itemarr|tType|type|value|none|selectSerie|rMaket|name|item|in|e|content|for|maket_noji|show||selectNadpis|itogSkidka|maket_lojki|maket_vilki|modal|currPrice|prop|disabled|t|currNadpis|h3|10px|src||hide|currMaket|change|false|imaket|refresh|selectpicker|h4|margin|length|tr|click|br|preventDefault|resultErr|color|nadpis|70000|price|err|true|itog|phone|errModal|button|delid|email|padding|seria||rosybrown|split|tovars|refreshTovar|id|skidka|serie|noneTovar|chain|you|tovarInfoView|serieView|currIt|30000|names|tovarTable|tovarDel|tovarAdd|other|orderCheck|desert|orderModal|parseInt|top|innerHTML|resultGood|itogSkidkaf|thModal|toFixed|round|Math|itogPricef|SendPostOrder|opisanie|noj|vilka|naimenovanie|5000|stolov|sOrder|nameN|emailN|selected|pic|phoneN|price30|next|price5|price100|desc|width|deskPrice|priceTitle|price70|splice|alert|952|a|post|url|onbeforeunload|toggle|Are|sendOrder|return|js|send|bs|location|window|on|thanks|php|response|success|sure|042|push|delCart|btn|onclick|to|leave|addCart|red|this|X|orderCreate|Viber|want|page|reload|WhatsApp|font|size|16px'.split('|')))
        </script>
    </body>
</html>
