<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: PluginForum.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginForum extends Plugin {
	protected $aInherits=array(
		'action' => array(
			'ActionProfile' => 'PluginForum_ActionProfile'
		),
		'module' => array(
			'ModuleACL' => 'PluginForum_ModuleACL',
			'ModuleStream' => 'PluginForum_ModuleStream',
			'ModuleSubscribe' => 'PluginForum_ModuleSubscribe',
			'ModuleText' => 'PluginForum_ModuleText'
		)
	);

	/**
	 * Активация плагина
	 */
	public function Activate() {
		if (!$this->isTableExists('prefix_forum')) {
			$this->ExportSQL(dirname(__FILE__).'/sql/install.sql');
		}
		if (!$this->isTableExists('prefix_forum_topic_view')) {
			$this->ExportSQL(dirname(__FILE__).'/sql/update_to_1.0.3.sql');
		}
		return true;
	}

	/**
	 * Деактивация плагина
	 */
	public function Deactivate() {
		if (Config::Get('plugin.forum.deactivate.delete')) {
			$this->ExportSQL(dirname(__FILE__).'/sql/deinstall.sql');
		}
		return true;
	}

	/**
	 * Инициализация плагина
	 */
	public function Init() {
		/**
		 * Подключаем CSS
		 */
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__).'css/forum.css');
		/**
		 * Подключаем JS
		 */
		$this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__).'js/forum.js');
		/**
		 * Добавляем в подписку новые типы
		 */
		$this->Subscribe_AddTargetType('forum_new_topic',array());
		$this->Subscribe_AddTargetType('topic_new_post',array());
		/**
		 * Добавляем в ленту новые типы событий
		 */
		$this->Stream_AddEventType('add_forum_topic', array('related' => 'forumTopic','unique'=>true));
		$this->Stream_AddEventType('add_forum_post', array('related' => 'forumPost','unique'=>true));
		/**
		 * Добавляем в ленту текстовки новых типов событий
		 */
		$this->Lang_AddMessage('stream_event_type_add_forum_topic', $this->Lang_Get('plugin.forum.event_type_add_topic'));
		$this->Lang_AddMessage('stream_event_type_add_forum_post', $this->Lang_Get('plugin.forum.event_type_add_post'));
		/**
		 * Загружаем в шаблон
		 */
		$this->Viewer_Assign('aLang',$this->Lang_GetLangMsg());
		/**
		 * Подключаем нашу директорию плагинов для Smarty
		 */
		$oSmarty = $this->Viewer_GetSmartyObject();
		$oSmarty->addPluginsDir(Config::Get('plugin.forum.path_smarty_plug'));

		return true;
	}
}

?>