<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Text.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleText extends PluginForum_Inherit_ModuleText {
	/**
	 * Обработка тега ls в тексте
	 * <pre>
	 * <ls user="admin" />
	 * </pre>
	 *
	 * @param string $sTag	Тег на ктором сработал колбэк
	 * @param array $aParams Список параметров тега
	 * @return string
	 */
	public function CallbackTagLs($sTag,$aParams) {
		$sText='';
		if (isset($aParams['user'])) {
			if ($oUser=$this->User_getUserByLogin($aParams['user'])) {
				$sText.="<a href=\"{$oUser->getUserWebPath()}\" class=\"ls-user\">{$oUser->getLogin()}</a> ";
			}
		} else if (isset($aParams['reply'])) {
			if ($oPost=$this->PluginForum_Forum_GetPostById($aParams['reply'])) {
				$sUserLogin=$oPost->getUser() ? "<a href=\"{$oPost->getUser()->getUserWebPath()}\" class=\"ls-user\">{$oPost->getUser()->getLogin()}</a>" : $this->Lang_Get('plugin.forum.guest_prefix').$oPost->getGuestName();
				$sHeadQuote="<div class='quote-head'><a class='icon-share-alt' href='{$oPost->getUrlFull()}' title='{$this->Lang_Get('plugin.forum.post_view')}'></a> {$sUserLogin} ({$oPost->getDateAdd()}):</div>";
				$sTextQuote="<div class='quote-text'>{$oPost->getText()}</div>";
				$sFullQuote="<blockquote>{$sHeadQuote}{$sTextQuote}</blockquote> ";
				$sText.=$sFullQuote;
			}
		}
		return $sText;
	}
}
?>