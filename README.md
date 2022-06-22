# CRUD_PHP
CRUD made in PHP and MySQL.

Database dump scripts are in DB_Dump folder.

Server is up using XAMPP Compiled Apr 6th 2021
MySQL is up using MySQL Workbench

Task:

0 – 15 баллов: [DONE]
1.	БД из не менее чем 5-ти таблиц, соответствующим образом связанных внешними ключами. В соответствующих полях имеются: первичные ключи, запрет на нулевые значения (not null), значения по-умолчанию и т.п.
2.	Таблицы заполнены данными (в среднем, не менее 10 строк в каждой таблице). [DONE] 

16 – 40 баллов:
1. В приложении реализована возможность просмотра, изменения, удаления, добавления данных (для всех таблиц). [DONE]
2. При наличии в таблице внешних ключей она отображается максимально удобно для пользователя (например, вместо id-ключа должно быть указано соответствующее этому id значение из родительской таблицы). [DONE]
3. Реализован поиск данных по ключевым полям (по одному или одновременно по нескольким полям). [DONE]
4. Имеется возможность сортировки таблиц по одному и нескольким полям. [DONE]
5. Имеется минимум 1 процедура и 1 триггер. В приложении должна быть предусмотрена возможность вызова процедуры, например, при нажатии на кнопку. Или же процедура может вызываться в коде при наступлении некого события. 

   (Слишком простые процедуры, состоящие из одного-двух select-запросов, процедурами не считаются ). [DONE]
7. Имеется поле для непосредственного ввода запроса к БД (рекомендуется сделать это поле доступным только для администратора вашего приложения). [DONE]
8. При добавлении или изменении данных в таблице значения для полей, которые являются внешними ключами, заполняются не вручную, а выбираются из списка имеющихся значений в соответствующей родительской таблице. [DONE]


41 – 50 баллов:
1.	Авторизация (запрос логина, пароля) при запуске и разграничение полномочий пользователей (например, «гость» может только просматривать данные, не изменяя их, не добавляя новых, не удаляя).[DONE]
2.	При выполнении операций отслеживается их корректность (например, нельзя добавить сотрудника, не указав фамилию). [DONE]
3.	При неправильных действиях пользователя, каких-либо ошибках ввода и т.п., выводятся поясняющие сообщения. [DONE]
4.	Дополнительные усовершенствования приложения.


Кроме того:

При оценивании будет учитываться сложность, удобство и функциональность интерфейса и отображения данных. (То есть, если  у Вас  выполнены все пункты, но интерфейс неудобный или слишком простой, максимальное количество баллов не ставится).

При сдаче необходимо будет показать и объяснить основные части кода, обеспечивающие взаимодействие приложения и базы. Также уметь выполнять различные select-запросы, уметь объяснить код триггеров и процедур.

[APPROVED]

Задания из практики в Интерволге

1. Добавить поле ИНН для клиента (отображается в списке документов) [DONE]
2. Проверять валидность ИНН в базе ФНС. Если ИНН не валидный, то создание клиента прерывается. [DONE]
3. Переделать раздел клиентов на REST+AJAX (для этого можно использовать Silex PHP). Должны быть возможности: просмотра списка клиентов, создания новых, редактирования существующих, удаления клиентов. [DONE]
4. Добавить в сущность Документы поле типа Файл. Если загружают картинку - должна быть возможность кадрирования. Если загружают документ (например .docx), то возможность посмотреть его. [DONE]
