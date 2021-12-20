# Довгаль І. КМ-83. Курсова робота
Метою даного проекту є допомога клієнту визначитись з вибором продуктів для догляду за обличчям. Після проходження невеликого тесту, користувачу буде запропоновано відповідні позиції, що будуть підходити конкретно під його випадок. Також, буде надо можливість замовити та отримати обрані товари.

## Постановка цілей
Створити базу даних для збереження інформації про товари, попит на них, інформацію за анкетуванням.
Розробити веб-застосунок з адміністративною і клієнтською частининами

## Використаний стек технологій
- РСКБД - PostgreSQL
- Мова реалізації - PHP
- Веб-фреймворк - Laravel
- ОРМ - Eloquent
- UI-фреймворк - Vuejs
- CSS-фреймворк - MaterializeCSS
- Хмарний хостінг - Heroku

## Деталі реалізації
Розділ системи для кожного з користувачів реалізовані як Simple Page Application з використанням vue router.

Для импорту структури бази - створені [файли міграції](https://github.com/mdovgal/cosmetolog/tree/main/database/migrations). 
Для первинного наповнення даними довідників (бренди, типи продуктів) - [створениі Seeders](https://github.com/mdovgal/cosmetolog/tree/main/database/seeds)


### Ролі користувачів
У застосунку передбачено кілька ролей:
- **Гість** - не авторизований користувач. Може передивалятись каталог товарів
- **Покупець** - авторизований користувач, що може переглядати каталог товарів, формувати корзину замовлень
- **Косметолог** - авторизований користувач, що може переглядати каталог товарів та створювати статті про косметику (розділ цього користувача у розробці)
- **Адміністратор** - авторизований користувач, що може редагувать каталог продуктів, переглядати каталог товарів

Покупець може зареєструватись у системі самостійно в інтерфейсі [Реєстрація](http://kursovik-cosmetics.herokuapp.com/register)
Косметолога може додати в систему тільки Адміністратор.

за замовчуванням в системі одразу існує три користувача з наступними обліковими записами:
- **Покупець**: customer@example.com | demo
- **Косметолог**: cosmetolog@example.com | demo
- **Адміністратор**: admin@example.com | demo

### Валідація
Валідація даних реалізована на різних рівнях: 
- на рівні UI - додання атрибутів до полей форм, теких як required, min, max, а також javascript-валідация перед відправленням форми до серверу
- на рівні Backend - за допомогою валидаторів фреймворка
- на рівні Database - через декларування типів даннх, їх обов'язковості, констрейнтів

### Rest API
У системі реалізоване REAT API level2.
Усі CRUD операції задекларовані у скрипті [api.php](https://github.com/mdovgal/cosmetolog/blob/main/routes/api.php), мають свої окремі URL та розподілені наступним чином:
- для отримання данніх віконуються GET запити
- для створення нових записів - використовуються POST запити
- для редагування - PUT запити
- для выидалення - DELETE запити


## Інструкція по розгортанню

- задопомогою інструкції ["Як розгорнути додаток Laravel на Heroku"](https://ru.hexlet.io/blog/posts/kak-razvernut-prilozhenie-laravel-na-heroku) виконати усі кроки розгортання системи
- після переконатися що на сервері встановлені наступний пакети: heroku/nodejs, heroku/php. А також, що використовується PostgreSQL
- розгорнути структуру бази данніх за допомогою міграції, що пропонує фрйемворк Laravel
- наповнити систему довідниковими даними (типи продуктів, бренди, країни похождення товарів)

Для цього виконати у консолі наступні команди:
```
heroku run bash -a <YOUR_APPLICATION_NAME>
php artisan migrate
php artisan db:seed
```
## Посилання на розгорнуту систему
Система на Heroku доступна за [http://kursovik-cosmetics.herokuapp.com/](http://kursovik-cosmetics.herokuapp.com/)

## Логічна модель даних
![Логічна модель](https://github.com/mdovgal/cosmetolog/blob/main/Logic_model.jpg)


