<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'message_vkontakte', language 'ru'
 *
 * @package message_vkontakte
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'VKontakte';

$string['linkaccountsinfo'] = '
Для получения сообщений из Moodle в вашем аккаунте во ВКонтакте, вам необходимо...
Для этого выполните следующие шаги:
<ol>
<li>Кликните на линк:<br>[connect_url]</li>
<li>В открывшемся клиенте Telegram нажмите "Начать".</li>
<li>Вернитесь в это окно и нажмите кнопку "Сохранить".</li>
</ol>
При необходимости, после этого вы сможете отвязать свой аккаунт в Moodle от своего аккаунта в Telegram.

<input type="hidden" name="vk_user_id" id="vk_user_id" value="_vk_user_id_">
<div id="vkbutton"></div>
<div id="vk_api_transport"></div>
<script type="text/javascript">
var openApiScript;
console.log("+++0_1:"+(openApiScript == undefined));
if(openApiScript == undefined){
	setTimeout(function() {
		console.log("+++111_2");
		openApiScript = document.createElement("script");
		openApiScript.type = "text/javascript";
		openApiScript.src = "https://vk.com/js/api/openapi.js?169";
		openApiScript.async = true;
		document.getElementById("vk_api_transport").appendChild(openApiScript);
	}, 0);
} else {
	console.log("+++0_2");
	addVkButton(false);
}
window.vkAsyncInit = function() {
	console.log("+++ppp2");
	addVkButton(true);
};
var addVkButton = function(needSubscribe) {
	VK.Widgets.AllowMessagesFromCommunity("vkbutton", {height: 30}, _vk_group_id_);
	if(!needSubscribe){
		return;
	}
	console.log("+++ppp_subs");
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.allowed", function f(userId) {
		console.log(userId);
		document.getElementById("vk_user_id").value = userId;
		console.log("+++allowed");
	});
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.denied", function f(userId) {
		console.log(userId);
		document.getElementById("vk_user_id").value = "";
		console.log("+++denied");
	});
};
</script>



';

/*
<script type="text/javascript">
var script;
var addVkButton = function(){
	VK.Widgets.AllowMessagesFromCommunity("vkbutton", {}, _vk_group_id_);
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.allowed", function f(userId) {
		console.log(userId);
		console.log("+++allowed");
	});
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.denied", function f(userId) {
		console.log(userId);
		console.log("+++denied");
	});
};
console.log("+++111:"+(script == undefined));
if(script == undefined){
	console.log("+++222");
	script = document.createElement("script");
	script.src = "https://vk.com/js/api/openapi.js?168";
	document.head.append(script);
	script.onload = function() {
		console.log("+++ppp");
		addVkButton();
	};
}else{
	addVkButton();
	console.log("+++444");
}
console.log("+++333");
</script>
*/

$string['linkaccountslinktext'] = 'Связать мои аккаунты Moodle и Telegram';
$string['accountislinked'] = 'Связать мои аккаунты Moodle и Telegram';

$string['unlinkaccountsinfo'] = '
<b>Ваши аккаунты в Moodle и Telegram связаны. Сообщения пересылаются в ваш Telegram.</b><br>
Для того, чтобы отвязать ваш аккаунт в Moodle от вашего аккаунта в Telegram, снимите чекбокс и нажмите кнопку "Сохранить".
';

$string['messagefrom'] = 'Moodle. Сообщение от ';

$string['vkgroupid'] = 'Идентификатор сообщества во ВКонтакте';
$string['configvkgroupid'] = '';

$string['vkgrouptoken'] = 'Токен сообщества во ВКонтакте';
$string['configvkgrouptoken'] = '';


$string['pluginnotconfigured'] = 'Модуль отправки сообщений в ВКонтакте не настроен администратором.';

$string['adminsetuptext'] = '
Для настройки модуля отправки сообщений во ВКонтакте, вам необходимо указать <b>Идентификатор сообщества</b> во ВКонтакте. Именно от этого сообщества пользователями будут приходить сообщения.
<br>
Если сообщество еще не создан, то, для его создания, выполните следующие шаги:
<ol>
<li>В клиенте Telegram найдите бота с именем <b>"BotFather"</b>, и нажмите у него кнопку <b>"Начать"</b>.</li>
<li>Отправьте этому боту команду: <b>/newbot</b></li>
<li>Введите и отправьте боту любое имя вашего нового бота.</li>
<li>Введите и отправьте боту username вашего нового бота. Необходимо придумать такой username, который свободен для регистрации.</li>
<li>После того, как BotFather отобразит сообщение об успешном создании вашего бота,
скопируйте линк на вашего бота (он указан после слов <b>"You will find it at"</b>),
и вставьте его в поле <b>"URL Telegram-бота"</b> ниже,
затем скопируйте токен вашего бота (он указан после слов <b>"Use this token to access the HTTP API:"</b>),
и вставьте его в поле <b>"Токен Telegram-бота"</b> ниже.</li>
</ol>
Настройка завершена.<br>Теперь, для сохранения настроек модуля, нажмите кнопку "Сохранить изменения".
<hr>
';
