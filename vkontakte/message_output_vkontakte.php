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
 * Contains the definiton of the VKontakte message processor
 *
 * @package message_vkontakte
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/message/output/lib.php');

/**
 * The VKontakte message processor class
 *
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_output_vkontakte extends message_output
{

	private $manager;
	private $notconfiguredbyadmin;

	// Инициализация.
	public function __construct()
	{
		global $CFG;
		$this->notconfiguredbyadmin = (trim($CFG->vkgroupid) == '') || (trim($CFG->vkgrouptoken) == '');
		$this->manager = new message_vkontakte_manager();
	}

	// Вызывается при посылке сообщения в системе Moodle.
	function send_message($eventdata)
	{
		global $CFG;

		// Администратор заполнил не все поля в форме настройки плагина.
		if ($this->notconfiguredbyadmin) {
			return true;
		}

		// Не отправляем сообщение приостановленным и удаленным пользователям.
		if ($eventdata->userto->suspended || $eventdata->userto->auth === 'nologin' || $eventdata->userto->deleted) {
			return true;
		}

		// Не отправляем сообщение, если установлен флаг $CFG->noemailever
		if (!empty($CFG->noemailever)) {
			return true;
		}

		// Берем user_id во ВКонтакте для адресата, если этот user_id у нас сохранен.
		$to_vk_userid = get_user_preferences('message_processor_vkontakte_vkuserid', '', $eventdata->userto->id);

		// Адресат не настроил у себя плагин, поэтому мы не знаем его user_id во ВКонтакте.
		if (empty($to_vk_userid)) {
			return true;
		}

		// Отправляем сообщение адресату с помощью API VK.
		return $this->manager->send_message(
			fullname($eventdata->userfrom) .	// От кого (Имя Фамилия)
			': ' .								// :
			$eventdata->smallmessage,			// Текст сообщения
			$to_vk_userid,						// Кому (used_id адресата во ВКонтакте)
			trim($CFG->vkgrouptoken)			// От группы во ВКонтакте с токеном vkgrouptoken
		);
	}

	// Наполнение формы настройки плагина для пользователя.
	function config_form($preferences)
	{
		global $CFG, $USER;

		// Администратор заполнил не все поля в форме настройки плагина.
		if ($this->notconfiguredbyadmin) {
			return get_string('notconfiguredbyadmin', 'message_vkontakte');
		}

		// Возвращаем html+js код, в котором загружается виджет VK,
		// позволяющий пользователю включать и отключать разрешение получения им сообщений
		// от сообщества VK c id vkgroupid.
		return str_replace(
			[
				'_vk_messages_allowed_text_',
				'_vk_messages_not_allowed_text_',
				'_vk_group_id_',
				'_vk_user_id_'
			],
			[
				get_string('vkmessagesallowed', 'message_vkontakte'),
				get_string('vkmessagesnotallowed', 'message_vkontakte'),
				trim($CFG->vkgroupid),
				get_user_preferences('message_processor_vkontakte_vkuserid', '', $USER->id)
			],
			get_string('vkwidgetform', 'message_vkontakte')
		);
	}

	// Вызывается после нажатия кнопки Сохранить в форме.
	function process_form($form, &$preferences)
	{
		global $USER;

		// Администратор заполнил не все поля в форме настройки плагина.
		if ($this->notconfiguredbyadmin) {
			return false;
		}

		// Сохраням идентификатор пользователя во ВКонтакте.
		// Он нам нужен для того, чтобы мы имели возможность отправлять ему сообщения.
		// Если пользователь в виджете включил получение уведомлений от сообщества,
		// то в $form->vk_user_id будет его идентификатор во ВКонтакте.
		// Если пользователь в виджете отключил получение уведомлений от сообщества,
		// то в $form->vk_user_id будет пустая строка.
		set_user_preference('message_processor_vkontakte_vkuserid', $form->vk_user_id, $USER->id);

		return true;
	}

	// Не используем.
	function load_data(&$preferences, $userid)
	{
		return true;
	}
}
