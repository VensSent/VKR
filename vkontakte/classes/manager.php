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
 * VKontakte message plugin version information.
 *
 * @package message_vkontakte
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/filelib.php');

/**
 * VKontakte module manager class
 *
 * @author  Ivan Bulavin
 * @copyright 2022 Ivan Bulavin
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_vkontakte_manager
{

	private $curl;

	// Посылаем сообщение $message пользователю $vk_user_id от сообщества с токеном $vk_group_token
	// с помощью запроса к API VKontakte.
	public function send_message($message, $vk_user_id, $vk_group_token)
	{
		if ($this->curl == null) {
			$this->curl = new curl();
		}

		$response = $this->curl->post(
			'https://api.vk.com/method/messages.send',
			[
				'user_id' => $vk_user_id,
				'random_id' => 0,
				'message' => $message,
				'access_token' => $vk_group_token,
				'v' => '5.131'
			]
		);
		$json_result = json_decode($response);
		return !empty($json_result) && isset($json_result->response);
	}
}
