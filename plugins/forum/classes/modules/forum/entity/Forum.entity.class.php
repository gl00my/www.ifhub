<?php
/*---------------------------------------------------------------------------
* @Module Name: Forum
* @Description: Forum for LiveStreet
* @Version: 1.0
* @Author: Chiffa
* @LiveStreet Version: 1.0
* @File Name: Forum.entity.class.php
* @License: CC BY-NC, http://creativecommons.org/licenses/by-nc/3.0/
*----------------------------------------------------------------------------
*/

class PluginForum_ModuleForum_EntityForum extends EntityORM {
	protected $_aDataMore = array();

	protected $aRelations = array(
		self::RELATION_TYPE_TREE,
		'user'=>array(self::RELATION_TYPE_BELONGS_TO,'ModuleUser_EntityUser','last_user_id'),
		'topic'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityTopic','last_topic_id'),
		'post'=>array(self::RELATION_TYPE_BELONGS_TO,'PluginForum_ModuleForum_EntityPost','last_post_id'),
		'moderators'=>array(self::RELATION_TYPE_MANY_TO_MANY,'PluginForum_ModuleForum_EntityModerator','moderator_id','db.table.forum_moderator_rel','forum_id')
	);

	/**
	 * Список запрещенных URL
	 */
	protected $aBadUrl = array('admin','topic','findpost');

	protected function _getDataMore($sKey) {
		if (isset($this->_aDataMore[$sKey])) {
			return $this->_aDataMore[$sKey];
		}
		return null;
	}

	/**
	 * Определяем правила валидации
	 */
	public function Init() {
		parent::Init();
		$this->aValidateRules[]=array('forum_title','string','min'=>2,'max'=>100,'allowEmpty'=>false,'label'=>$this->Lang_Get('plugin.forum.create_title'));
		$this->aValidateRules[]=array('forum_url','url','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_url','url_unique','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_url','url_bad','label'=>$this->Lang_Get('plugin.forum.create_url'));
		$this->aValidateRules[]=array('forum_sort','number','label'=>$this->Lang_Get('plugin.forum.create_sort'));
		$this->aValidateRules[]=array('forum_limit_rating_topic','number','label'=>$this->Lang_Get('plugin.forum.create_rating'));
	}

	/**
	 * Проверка URL форума
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrl($sValue,$aParams) {
		if (!$sValue || func_check($sValue,'login',2,50)) {
			return true;
		}
		return $this->Lang_Get('plugin.forum.create_url_error',array('min'=>2,'max'=>50));
	}

	/**
	 * Проверка URL на уникальность
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrlUnique($sValue,$aParams) {
		if ($sValue && $oForumExists=$this->PluginForum_Forum_GetForumByUrl($sValue)) {
			if ($iId=$this->getId() and $oForumExists->getId()==$iId) {
				return true;
			}
			return $this->Lang_Get('plugin.forum.create_url_error_used');
		}
		return true;
	}

	/**
	 * Проверка на счет плохих URL'ов
	 *
	 * @param $sValue
	 * @param $aParams
	 * @return bool | string
	 */
	public function ValidateUrlBad($sValue,$aParams) {
		if (in_array($sValue,$this->aBadUrl)) {
			return $this->Lang_Get('plugin.forum.create_url_error_badword').' '.implode(', ',$this->aBadUrl);
		}
		return true;
	}

	public function getUrlFull() {
		return Router::GetPath('forum').($this->getUrl() ? $this->getUrl() : $this->getId()).'/';
	}

	public function getSubscribeNewTopic() {
		if (!($oUserCurrent=$this->User_GetUserCurrent())) {
			return null;
		}
		return $this->Subscribe_GetSubscribeByTargetAndMail('forum_new_topic',$this->getId(),$oUserCurrent->getMail());
	}

	public function isModerator() {
		return $this->_getDataMore('moderator');
	}
	public function getModViewIP() {
		return $this->_getDataMore('mod_viewip');
	}
	public function getModDeletePost() {
		return $this->_getDataMore('mod_deletepost');
	}
	public function getModDeleteTopic() {
		return $this->_getDataMore('mod_deletetopic');
	}
	public function getModMoveTopic() {
		return $this->_getDataMore('mod_movetopic');
	}
	public function getModOpencloseTopic() {
		return $this->_getDataMore('mod_openclosetopic');
	}
	public function getModPinTopic() {
		return $this->_getDataMore('mod_pintopic');
	}
	public function getAllowShow() {
		return $this->_aDataMore['allow_show'];
	}
	public function getAllowRead() {
		return $this->_aDataMore['allow_read'];
	}
	public function getAllowReply() {
		return $this->_aDataMore['allow_reply'];
	}
	public function getAllowStart() {
		return $this->_aDataMore['allow_start'];
	}
	public function getAutorization() {
		return $this->_aDataMore['autorization'];
	}

	public function setIsModerator($data) {
		$this->_aDataMore['moderator']=$data;
	}
	public function setModViewIP($data) {
		$this->_aDataMore['mod_viewip']=$data;
	}
	public function setModDeletePost($data) {
		$this->_aDataMore['mod_deletepost']=$data;
	}
	public function setModDeleteTopic($data) {
		$this->_aDataMore['mod_deletetopic']=$data;
	}
	public function setModMoveTopic($data) {
		$this->_aDataMore['mod_movetopic']=$data;
	}
	public function setModOpencloseTopic($data) {
		$this->_aDataMore['mod_openclosetopic']=$data;
	}
	public function setModPinTopic($data) {
		$this->_aDataMore['mod_pintopic']=$data;
	}
	public function setAllowShow($data) {
		$this->_aDataMore['allow_show']=$data;
	}
	public function setAllowRead($data) {
		$this->_aDataMore['allow_read']=$data;
	}
	public function setAllowReply($data) {
		$this->_aDataMore['allow_reply']=$data;
	}
	public function setAllowStart($data) {
		$this->_aDataMore['allow_start']=$data;
	}
	public function setAutorization($data) {
		$this->_aDataMore['autorization']=$data;
	}
}

?>