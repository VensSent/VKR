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
 * Strings for component "message_vkontakte"
 *
 * @package message_vkontakte
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'VKontakte';

$string['adminsetuptext'] = '
Для настройки модуля отправки сообщений через "ВКонтакте", вам необходимо указать <b>Идентификатор сообщества</b> во ВКонтакте, от имени которого пользователям будут приходить сообщения, отправленные им в Moodle,
и <b>Токен</b> этого сообщества.
<br>
Если сообщество еще не создано, то, для получения инструкций по его созданию и настройке, посетите <a href="https://pechenek.net/social-networks/vk/api-vk-poluchaem-klyuch-dostupa-token-gruppy/" target="_blank">эту страницу</a>.
';

$string['vkgroupid'] = 'Идентификатор сообщества во ВКонтакте';
$string['configvkgroupid'] = '';

$string['vkgrouptoken'] = 'Токен сообщества во ВКонтакте';
$string['configvkgrouptoken'] = '';

$string['vkmessagesallowed']='<b>Получение сообщений из Moodle во ВКонтакте включено.</b><br>Для отключения получения сообщений нажмите на кнопку \"Запретить уведомления\" ниже, и затем нажмите на кнопку \"Сохранить\".';

$string['vkmessagesnotallowed']='Получение сообщений из Moodle во ВКонтакте отключено.<br>Для включения нажмите на кнопку \"Получать уведомления\" ниже, и затем нажмите на кнопку \"Сохранить\".';

$string['vkwidgetform'] = '
<div id="vk_info"></div>
<br>
<input type="hidden" name="vk_user_id" id="vk_user_id" value="_vk_user_id_">
<div id="vkwidget"></div>
<div id="vk_api_transport"></div>

<script type="text/javascript">
var vkMessagesAllowedText = "_vk_messages_allowed_text_";
var vkMessagesNotAllowedText = "_vk_messages_not_allowed_text_";
var objVKUserId = document.getElementById("vk_user_id");
var objVKInfo = document.getElementById("vk_info");
var openApiScript;
if(openApiScript == undefined){
	setTimeout(function() {
		openApiScript = document.createElement("script");
		openApiScript.type = "text/javascript";
		openApiScript.src = "https://vk.com/js/api/openapi.js?169";
		openApiScript.async = true;
		document.getElementById("vk_api_transport").appendChild(openApiScript);
	}, 0);
} else {
	addVKWidget(false);
}
window.vkAsyncInit = function() {
	addVKWidget(true);
};
var setVKInfo = function() {
	objVKInfo.innerHTML = (objVKUserId.value == "") ? vkMessagesNotAllowedText : vkMessagesAllowedText;
};
var addVKWidget = function(needSubscribe) {

	setVKInfo();

	VK.Widgets.AllowMessagesFromCommunity("vkwidget", {height: 30}, _vk_group_id_);
	if(!needSubscribe){
		return;
	}
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.allowed", function f(userId) {
		objVKUserId.value = userId;
		//setVKInfo();
	});
	VK.Observer.subscribe("widgets.allowMessagesFromCommunity.denied", function f(userId) {
		objVKUserId.value = "";
		//setVKInfo();
	});
};
</script>
';

$string['notconfiguredbyadmin'] = 'Модуль отправки сообщений через "ВКонтакте" не настроен администратором.';
