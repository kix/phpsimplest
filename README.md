Стек:
* Symfony 3.x
* MySQL
* Doctrine
* Twig

Разработать простой таск-менеджер (а-ля Kanban) без дизайна со следующим функционалом:
- Форма "Add task" с полями "Task" - название и "Status" - состояние
- 4 столбца с тасками: Todo, In progress, Review, Done
- Кнопка "Archived items" открывает список архивных тасков c постраничным выводом по 5 тасков
- При нажатии на таск открывается меню редактирования, в котором можно отредактировать 2 поля (Task и Status) и отправить в архив кнопкой "Archive". Здесь же кнопка возврата в дашборд
- Состояния и переходы между ними должны управляться State Machine.
- При переходе задачи в состояние Done нужно отправить email-оповещение (можно сделать заглушку). Адрес и текст задаются в интерфейсе конфигурации приложения, сделанном с помощью SonataAdminBundle
- Кнопка "Export to json" экспортирует все таски за все время в файл json
