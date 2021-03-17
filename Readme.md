Пример использования пагинации на примере doctrine/orm

```php
    $perPage     = 20;
    $currentPage = (int) $request->query->get('page', 1);

    $qb         = $this->repository->paginationQuery();
    $pagination = new Paginator($perPage, $currentPage, new DoctrineOrmDataProvider($qb));

    return [
        'list'        => $pagination->result(),
        'currentPage' => $currentPage,
        'pages'       => $pagination->pages(),
        'totalResult' => $pagination->countResult(),
    ];
```

Подключение twig шаблона

```yaml
   # app/config/config.yml
   twig:
       # ...
       paths:
           '%kernel.project_dir%/vendor/ardiakov/simple-pagination/src/resources/templates': simple-pagination
```

Вывести шаблон в нужном месте

```twig
    {% include '@simple-pagination/_pagination.html.twig' with {
        'routeName': 'worki_vacancy_list',
        'routeParameters': {}
    } %}
```