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
 * VKontakte message plugin settings
 *
 * @package message_vkontakte
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Наполнение формы настройки плагина для администратора.
if ($ADMIN->fulltree) {

	$settings->add(new admin_setting_heading('setuptext', '', get_string('adminsetuptext', 'message_vkontakte')));

	$settings->add(new admin_setting_configtext(
		'vkgroupid',
		get_string('vkgroupid', 'message_vkontakte'),
		get_string('configvkgroupid', 'message_vkontakte'),
		'',
		PARAM_TEXT
	));

	$settings->add(new admin_setting_configtext(
		'vkgrouptoken',
		get_string('vkgrouptoken', 'message_vkontakte'),
		get_string('configvkgrouptoken', 'message_vkontakte'),
		'',
		PARAM_TEXT
	));
}
