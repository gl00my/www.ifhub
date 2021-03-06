Плагин "Views" (версия 1.0.1) для LiveStreet 1.0.3


ОПИСАНИЕ

Плагин осуществляет подсчет количества просмотров топиков и позволяет сортировать
топики по числу просмотров на страницах "/index", "/blog", "/personal_blog" и для
каждого из блогов в отдельности. Поддерживается фильтрация по дате.

Плагин анализирует статистику просмотров 2 видов:
1) Простая статистика по общему числу просмотров.
2) Расширенная статистика - использует данные, собранные плагином «ViewStat».
Данный режим активизируется автоматически при активном плагине «ViewStat».
В данном режиме фильтрация может быть как по времени создания топиков, так и
только по просматриваемым за выбранное время.

Совместим с шаблонами:
— Synio;
— Mobile.

Не совместим с плагином «ViewCount».

Настройка плагина осуществляется редактированием файла "/plugins/views/config/config.php".

Поддерживаемые директивы:
1) $config['only_users'] - Считать просмотры только от авторизованных пользователей.
По умолчанию отключено (false).

2) $config['only_once'] - Считать только первый просмотр топика пользователем (в пределах сессии).
По умолчанию включено (true).

2) $config['use_sort'] - Использовать сортировку топиков по числу просмотров.
По умолчанию включено (true).

3) $config['stat_date_filter'] - Отображаются только топики, которые просматривались в выбранный период,
независимо от времени их создания. Использует данные плагина Viewstat (должен быть установлен). По 
умолчанию отключено (false).

4) $config['show_info'] - Показывать число просмотров в панели информации топика.
По умолчанию включено (true).



УСТАНОВКА

1. Скопировать плагин в каталог /plugins/
2. Через панель управления плагинами (/admin/plugins/) запустить его активацию.



ИЗМЕНЕНИЯ:
1.0.1 (29.05.2014)
Добавлен индекс для поля `topic_count_read` в таблице БД.
Добавлено фиксированное сообщение об ошибке.
Добавлен отдельный файл иконки.
Добавлены параметры конфигурации:
- $config['only_users'] - Считать просмотры только от авторизованных пользователей.
- $config['only_once'] - Считать только первый просмотр топика пользователем (в пределах сессии).



АВТОР
Александр Вереник

САЙТ 
https://github.com/wasja1982/livestreet_views
