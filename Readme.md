Схематичный пример использования пагинации на примере doctrine/dbal

```php
    $pagination = new Pagination($this->perPage, $this->currentPage, $countTotalApplications);

    $list = $this->queryBuilderByConditions($this->conditions())
                ->setMaxResults($pagination->maxResults())
                ->setFirstResult($pagination->offset())
                ->execute()
                ->fetchAll();

    return [
        'list'         => $list,
        'currentPage'  => $this->currentPage,
        'perPage'      => $this->perPage,
        'pages'        => $pagination->pages(),
        'totalResults' => $countTotalApplications,
    ]; 
```
