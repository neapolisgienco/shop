# Интернет-магазин API на Symfony

Этот проект представляет собой API для оформления заказов
в интернет-магазине.
Он позволяет пользователям оформлять заказы на товары,
проверяя наличие товара на складе.

## Стек технологий

- PHP 8.0+
- Symfony 5.x или 6.x
- MySQL или PostgreSQL
- Composer

## Установка

### 1. Клонирование репозитория

Сначала клонируйте репозиторий:

```bash
git clone https://github.com/neapolisgienco/shop.git
cd shop
```

### 2. Установка зависимостей

Убедитесь, что у вас установлен Composer.
Затем выполните команду:

```bash
composer install
```

### Архитектура

1. **Сущности**:
    - **Goods**: представляет товары с полями `id`, `name`, `price`, `count`.
    - **Users**: представляет пользователей с полями `id`, `name`.
    - **Orders**: представляет заказы с полями `id`, `user_id`, `created_at`.
    - **OrderItems**: представляет элементы заказа с полями `id`, `order_id`, `good_id`, `count`.

### 3. Настройка базы данных

Создайте базу данных для вашего проекта.
Затем настройте параметры подключения к базе данных в файле
.env:
dotenv
DATABASEURL="mysql://username:password@127.0.0.1:3306/dbname"
dotenv
DATABASEURL="mysql://username:password@127.0.0.1:3306/dbname"

Замените username, password и db_name на ваши данные.

### 4. Создание таблиц

Сгенерируйте миграции и примените их к базе данных:

```bash

```

php bin/console make:migration
php bin/console doctrine:migrations:migrate

### 5. Заполнение базы данных (необязательно)

Вы можете заполнить базу данных тестовыми данными с помощью фикстур. Для этого создайте фикстуры и выполните команду:

```bash
php bin/console doctrine:fixtures:load
```

### 6. Запуск сервера

Запустите встроенный сервер Symfony:

```bash
symfony server:start
```

Теперь ваше API доступно по адресу http://localhost:8000/api/orders.

## API

### Оформление заказа/Тестирование

Для тестирования API вы можете использовать Postman или cURL.

```POST 
/api/order
``` 

**Тело запроса (JSON)**:

``` json
{
"userId": 123,
"goods": [
{
"id": 111,
"count": 2
},
{
"id": 112,
"count": 3
}
]
}
```

**Ответы**:

- Успешный ответ (все товары в наличии):

```json
{
  "orderId": 456
}
```

- Ошибка (товаров не хватает на складе):

```json
{
  "message": "Товаров не хватает на складе, заказ не будет оформлен."
}
```

Пример запроса с использованием cURL:

```bash
curl -X POST http://localhost:8000/api/orders \
-H "Content-Type: application/json" \
-d '{
"userId": 123,
"goods": [
{
"id": 111,
"count": 2
},
{
"id": 112,
"count": 3
}
]
}'
```

### Тестирование API

Используйте Postman или curl для тестирования API.
Пример запроса для оформления заказа:

```bash
curl -X POST http://localhost:3000/api/order
-H "Content-Type: application/json"
-d '{
"userId": 123,
"goods": [
{
"id": 111,
"count": 2
},
{
"id": 112,
"count": 3
}
]
}'
 ```  

## Зависимости

Убедитесь, что у вас установлены следующие расширения PHP:

- pdo_mysql или pdo_pgsql (в зависимости от используемой базы данных)
- mbstring
- xml
- json

### Пример для заполнения полей

Заполнено для тестировани
```sql
INSERT INTO public.goods (id, name, price, count)
VALUES (1, 'карандаш', 12.51, 1);
INSERT INTO public.goods (id, name, price, count)
VALUES (2, 'перчатки', 100.55, 3);


INSERT INTO public.users (id, name)
VALUES (1, 'петров');
```

 Результат запросов
```sql
INSERT INTO public.orders (id, created_at, user_id)
VALUES (1, '2025-03-28 14:33:52', null);
INSERT INTO public.orders (id, created_at, user_id)
VALUES (2, '2025-03-28 15:29:06', null);
INSERT INTO public.orders (id, created_at, user_id)
VALUES (3, '2025-03-28 13:21:25', 1);
INSERT INTO public.orders (id, created_at, user_id)
VALUES (4, '2025-03-28 13:58:21', 1);
INSERT INTO public.orders (id, created_at, user_id)
VALUES (5, '2025-03-28 13:59:49', 1);
INSERT INTO public.orders (id, created_at, user_id)
VALUES (6, '2025-03-29 12:54:18', 1);
```


## Автор

[Владислав Гиенко](mailto:neapolis@inbox.ru)