# Тестовое задание
Написать микросервис работы с гостями используя язык программирования на выбор PHP или Go, 
можно пользоваться любыми opensource пакетами, также возможно реализовать с использованием фреймворков или без них. 
БД также любая на выбор, использующая SQL в качестве языка запросов. 
Микросервис реализует API для CRUD операций над гостем. 
То есть принимает данные для создания, изменения, получения, удаления записей гостей хранящихся в выбранной базе данных.

Сущность "Гость" Имя, фамилия и телефон – обязательные поля. А поля телефон и email уникальны. 
В итоге у гостя должны быть следующие атрибуты: идентификатор, имя, фамилия, email, телефон, страна. Если страна не указана то доставать страну из номера телефона +7 - Россия и т.д. 
Правила валидации нужно придумать и реализовать самостоятельно. Микросервис должен запускаться в Docker.

Результат опубликовать в Git репозитории, в него же положить README файл с описанием проекта. 
Описание не регламентировано, исполнитель сам решает что нужно написать (техническое задание, документация по коду, инструкция для запуска). 
Также должно быть описание API (как в него делать запросы, какой формат запроса и ответа), можно в любом формате, в том числе в том же README файле.

# Стек

* Laravel 11;
* Laravel Sail;
* Laravel Pint;
* Pest;
* Larastan;
* PostgreSQL;
* PgBouncer;

# База данных

Схема:

![image](https://github.com/user-attachments/assets/a9331eac-6bfc-415a-a89e-035ece2d3b22)

В таблице ```Countries``` находится список стран и их кодов. Загружается в базу данных через сидер.

# API

Каждый запрос должен принимать `Header`, для получения данных в формате json:

```
Accept — application/json
```

## Get guests

```
GET api/v1/guests
```

Возвращает список гостей.

Принимает:
* search[*] - необязательно, массив. Производит поиск по гостям;
* order_by_date - необязательно, bool значение. 1 - с новых записей; 0 - со старых записей. По-умолчанию значенние равно 1;
* page - необязательно, число. Номер страницы для пагинации

Где * принимаются поля, по которым осуществляется поиск.

Список возможных полей для поиска:
* name;
* surname;
* email;
* phone_number;
* country_name;

В случае указания неизвестного поля будет возвращена ошибка.

Пример ответа:
```json
"data": [
    {
      "id": 3,
      "name": "Василий",
      "surname": "Иванович",
      "country": {
          "id": 77,
          "name": "Gambia",
          "code": "+220"
      },
      "phone_number": "+220 777 777 777",
      "email": "test@test.ru",
      "created_at": "2024-08-29T08:46:07.000000Z",
      "updated_at": "2024-08-29T08:46:07.000000Z"
    }
]
```

## Get guest by id

```
GET api/v1/guests/{id}
```

Где id - id гостя.

Возвращает конкретного гостя.

Пример ответа:
```json
{
    "data": {
        "id": 2,
        "name": "шок",
        "surname": "шок",
        "country": {
            "id": 47,
            "name": "Colombia",
            "code": "+57"
        },
        "phone_number": "+57 954",
        "email": "test2@test.ru",
        "created_at": "2024-08-29T08:35:00.000000Z",
        "updated_at": "2024-08-29T08:35:00.000000Z"
    }
}
```

## Store guest

```
POST api/v1/guests
```

Создает новый элемент - гостя.

Принимает:
* name - обязательно, строка, макс. 96 символов;
* surname - обязательно, строка, макс. 96 символов;
* phone_number - обязательно, строка, уникальное, регулярное выражение (```/(?:[\+\d])\s(.*[\d\-\(\)\s])$/```);
* country_id - необязательно, id страны.
* email - необязательно, почта, уникальное.

В случае, если ```country_id``` не указан, то получение произойдет по коду номера телефона.

Возвращает созданный элемент (гость). Например:

Данные запроса:
```json
{
    "phone_number": "+7 999 999 99 99",
    "name": "Густав",
    "surname": "фон Ашенбах",
    "email": "test12@test.ru"
}
```

Ответ:
```json
{
    "data": {
        "id": 4,
        "name": "Густав",
        "surname": "фон Ашенбах",
        "country": {
            "id": 178,
            "name": "Russia",
            "code": "+7"
        },
        "phone_number": "+7 999 999 99 99",
        "email": "test12@test.ru",
        "created_at": "2024-08-29T09:43:49.000000Z",
        "updated_at": "2024-08-29T09:43:49.000000Z"
    }
}
```

## Update guest

```
PUT api/v1/guests/{id}
```

Где id - id гостя.

Обновляет конкретного гостя.

Принимает:
* name - необязательно, строка, макс. 96 символов;
* surname - необязательно, строка, макс. 96 символов;
* phone_number - необязательно, строка, уникальное, регулярное выражение (```/(?:[\+\d])\s(.*[\d\-\(\)\s])$/```);
* country_id - необязательно, id страны;
* email - необязательно, почта, уникальное;

В случае, если ```country_id``` не указан, то получение произойдет по коду номера телефона.


Возвращает обновленный элемент (гость). Например:

Данные запроса:
```json
{
    "surname": "фон Оффенбах"
}
```

Ответ:
```json
{
    "data": {
        "id": 4,
        "name": "Густав",
        "surname": "фон Оффенбах",
        "country": {
            "id": 178,
            "name": "Russia",
            "code": "+7"
        },
        "phone_number": "+7 999 999 99 99",
        "email": "test12@test.ru",
        "created_at": "2024-08-29T09:43:49.000000Z",
        "updated_at": "2024-08-29T09:43:49.000000Z"
    }
}
```

## Delete guest

```
DELETE api/v1/guests/{id}
```

Где id - id гостя.

Удаляет конкретного гостя.

Ничего не возвращает.

## Get all countries

```
GET api/v1/countries
```

Возвращает список всех стран.

Пример:

```json
{
    "data": [
        {
            "id": 1,
            "name": "Afghanistan",
            "code": "+93"
        },
        {
            "id": 2,
            "name": "Aland Islands",
            "code": "+358"
        },
        {
            "id": 3,
            "name": "Albania",
            "code": "+355"
        },
        {
            "id": 4,
            "name": "Algeria",
            "code": "+213"
        }
    ]
}
```

# Установка

* Склонировать проект
* Войти в созданную папку и ввести команду в терминал:
```
docker run --rm --interactive --tty -v $(pwd):/app composer install
```
* Создать .env файл на основе ```.env.example``` и настроить окружение. (Указать наименование бд, пользователя, пароль и т.д);
* Запустить докер контейнер командой:
```
sail up -d
```
* Войти внутрь контейнера:
```
docker exec -it guests-php-1 bash
```
* Ввести команду
```
php artisan key:generate
```
* Запустить миграции
```
php artisan migrate
```
* Запустить сидер
```
php artisan db:seed --class=CountriesSeeder
```
* Опробовать API;

## Дополнительная информация

* В проекте использутеся фреймворк для тестирования (PEST) и написаны несколько тестов;
* Наличие фиксера стилей (Pint);
* Проверка кода (Larastan);

Все вышеперечисленное проверяется в тестах github actions
