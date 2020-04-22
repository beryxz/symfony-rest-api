# PHP REST Api - Symfony Demo

> Example of a Simple REST Api using `Symfony Framework`

This project uses Symfony 4.4 with FOSRestBundle

## Set-up

- Install [Symfony CLI](https://symfony.com/doc/current/setup.html)
- Run `composer install`

### DB

By default the project is set to use sqlite (`.env`)

- Run `php bin/console doctrine:database:create` # Create databse
- Run `php bin/console doctrine:schema:update --force` # Updates schema

To change the database

- Set `DATABASE_URL` in `.env.local`

## Test

### Development

`symfony server:start`

### Production

`APP_ENV=prod symfony server:start`

To compile for production `composer dump-env prod`

## Available APIs

|name|method|path|
|-|-|-|
|app_classroom_cget     |GET    |/api/classrooms        |
|app_classroom_get      |GET    |/api/classrooms/{id}   |
|app_classroom_post     |POST   |/api/classrooms        |
|app_classroom_delete   |DELETE |/api/classrooms/{id}   |
|app_classroom_patch    |PATCH  |/api/classrooms/{id}   |
|app_student_cget       |GET    |/api/students          |
|app_student_get        |GET    |/api/students/{id}     |
|app_student_post       |POST   |/api/students          |
|app_student_delete     |DELETE |/api/students/{id}     |
|app_student_patch      |PATCH  |/api/students/{id}     |
|app_student_put        |PUT    |/api/students/{id}     |

## Students

> Student json format

```jsonc
{
    'id': x, // Auto incremental
    'name': 'xxxx', // Nullable
    'surname': 'xxxxx', // Nullable
    'tax_code': 'xxxxx', // Unique field, not nullable
    'sidi_code': 'xxxxx' // Nullable
}
```

`GET /students`

return json with all students

`GET /students/:id`

return student by id

`POST /students`

insert student and returns the inserted entity

`DELETE /students/:id`

delete student by id

`PATCH /students/:id`

update student by id. Only fields passed

`PUT /students/:id`

update student by id. All fields, unset field are set to null

## Classrooms

> Classroom json format

```jsonc
{
    'id': x, // Auto incremental
    'year': xxxx, // Not nullable
    'section': 'xxxxx', // Not nullable
}
```

`GET /classrooms`

return json with all classrooms

`GET /classrooms/:id`

return classroom by id

`POST /classrooms`

insert classroom and returns the inserted entity

`DELETE /classrooms/:id`

delete classroom by id

`PATCH /classrooms/:id`

update classroom by id. Only fields passed
