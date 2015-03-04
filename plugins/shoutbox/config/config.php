<?php
/*
	Shoutbox by Hellcore. 2012

	Settings

	Расположение чата в режиме "HomePage" (см. ниже) можно поменять через хуки
	в файле \plugins\shoutbox\classes\hooks\HookShoutbox.class.php

	Например (перед топиками на главной)
		$this->AddHook('template_content_begin','ViewShoutbox');
	поменять на (после топиков на главной)
		$this->AddHook('template_content_end','ViewShoutbox');

	Также рассматриваю возможность лично адаптировать этот плагин под ваш сайт, 
	в редких случай даже изменить его функционал за доп. плату. (донат)

	Связатся со мной можно через сайт ls 	-> http://livestreet.ru/talk/add/?talk_users=hellcore
	Или по почте 							-> fe3dback@yandex.ru





	### КАК УБРАТЬ КОПИРАЙТ? ###

	Пожертвуйте не менее $15 на дальнейшеие развитие чата, укажите в форме свой ник на сайте livestreet.ru
	либо способ связаться с вами. В течение 1 суток я пришлю ссылку на чат без копирайта. Достаточно будет
	просто скопировать его в папку plugins и согласится на замену файлов.

	http://livestreetcms.com/profile/Hellcore/donate/

	Также по всем вопросам (включая копирайт и пожертвования) можно связатся со мной:

		Skype: Ahelhot
		ICQ: 636-143-790
		jabber: ahelhot@xgm.ru


	Доступные админ команды
	/admin text 						- выводит зеленое сообщение от имени модератора
	/warn text 							- выводит красное сообщение от имени модератора
	/mute %username%					- добавляет юзера %username% в черный лист чата. Пользователь не сможет
										  писать, использовать админ команды (если пользователь модератор).
	/unmute %username%					- убирает юзера %username% из чертного листа чата.

*/


// Настройка плагина

$config['view_module']				= 'HomePage';	//Режимы отображения. (по умолчанию 'HomePage')
													//Режимы отображения вляют на стили, дизайн, и положение чата.
													//HomePage 	- отображать на главной страницы, над/под топиками.
													//Block 	- отображать на сайдбаре, будет видно на всех страницах.

$config['shoutbox_height']   		= '260px';		//высота чата. (по умолчанию 200px).
													//Рекомендовано для типа view_module:
													// HomePage - 200px
													// Block - 360px

$config['view_controlls']   		= 'top';		//Где будут выводится формы управления (по умолчанию top).
													// top - над чатом, bottom - под чатом.
													//Рекомендовано для типа view_module:
													// HomePage - top
													// Block - bottom


$config['sort_reverse']   			= false; 		//Если true, то новые сообщения выводятся внизу. (по умолчанию false)

$config['allow_view_history']		= true; 		//Дает возможность просматривать историю сообщений (по умолчанию true)

$config['colorize_my_messages']		= true; 		//Если в посте используется ник пользователя который смотрит сайт,
													// то сообщение для него окращивается в более яркий цвет

$config['colorize_my_posts']		= true; 		//Изменяет стиль имен, выделяя сообщения принадлежащие пользователю

$config['count_in_chat']			= 10; 			//Количество сообщений в чате (по умолчанию 10)

$config['count_in_history']			= 30; 			//Количество сообщений на одну страницу в истории (по умолчанию 30)

$config['max_chars']				= 1000; 		//Максимальное кол-во символов на одно сообщение. Если лимит привышен,
													// юзер увидит сообщение об ошибке.
$config['min_chars']				= 1; 			//Минимальное кол-во символов на одно сообщение. Если сообщение меньше лимита,
													// юзер увидит сообщение об ошибке.

$config['only_authorized']			= false; 		//Показывать чат только зарегестрированным пользователям.


$config['SkillPerShout']			= 0.01; 		// Сколько юзер получает силы за каждое сообщение. Можно использовать 
													// дробные и отрицательные числа

$config['RatingPerShout']			= 0; 			// Сколько юзер получает рейтинга за каждое сообщение. Можно использовать 
													// дробные и отрицательные числа

// МАССИВЫ МОДЕРАТОРСКИХ ПРИВЕЛЕГИЙ

// все админы сайта имеют полные привилегии, по этому устанавливать их ниже дополнительно не нужно!
// тут нужно прописывать ид обычных юзеров (не админов). В зависимости от нахождения их в ниже приведенных массивах
// формируются их специальные доступы.

//													прописывать нужно ид юзеров так array (3,140,219,63);
// 													это значит что юзеры с ид равным 3 и 140 и 219 и 63
// 													имеют доступ к этой функции

// 													по умолчанию все переменные ниже имеют значение array ();

$config['admins']					= array (); 	// админы чата. Эта переменная отвечает за возможность удалять
													// и восстанавливать все сообщения

// если юзер не входит в список $config['admins'], опции ниже не имеют смысла. ( не считая админов сайта )

$config['super_admins_mute']		= array (); 	// список юзеров которые могут использовать команду /mute.
													// "/mute %username%" - запрещает юзеру с ником %username%
													// писать в чат.

$config['super_admins_unmute']		= array (); 	// список юзеров которые могут использовать команду /unmute.
													// "/unmute %username%" - разрешает юзеру с ником %username%
													// писать в чат. Если до этого пользователь не был забанен, 
													//ничего не произойдеи

$config['super_admins_warning']		= array (); 	// список юзеров которые могут использовать команду /warning и /admin.
													// "/warning %text%" и "/admin %text%" - вывыдит в чат стилизованное
													// сообщение от имени модератора

$config['super_users']				= array (); 	// список юзеров которых нельзя забанить или разбанить.
													// пропишите тут иды админов сайта. Например array (1)
													// если список будет пустым, забанить можно будет кого угодно, даже вас







// Системные настройки (не меняйте ничего, если не уверены)

$config['table']['shout']                = '___db.table.prefix___shout'; 								//BD
$config['table']['shout_bl']             = '___db.table.prefix___shout_blacklist';
Config::Set('router.page.shoutbox', 'PluginShoutbox_ActionShoutbox'); 									//router

Config::Set('block.plugin_shoutbox', array(																//block (sidebar)
	'action' => array(
		'index'
	),
	'blocks' => array(
		'right' => array(
			'shoutbox'=> array('params' => array('plugin' => 'shoutbox'), 'priority' => 101),
		)
	),
	'clear' => false,
));

$aJevix['cfgAllowTags'] = array(array(array('ls','a','i', 'b', 'u', 's', 'strong') ) );					// jevix parser
$aJevix['cfgSetTagShort'] = array(array(array('ls') ) );
$aJevix['cfgAllowTagParams'] = array(
	array('a',
		array('title', 'href', 'rel' => '#text', 'name' => '#text', 'target' => array('_blank'))
	),
	array('ls',
		array('user'=>'#text')
	), 
);
$aJevix['cfgSetTagIsEmpty'] = array(array(array('a') ) );
Config::Set('jevix.shoutbox',$aJevix);

return $config;
?>