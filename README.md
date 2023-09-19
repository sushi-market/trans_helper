## Installation

Require this package with composer:

```bash
composer req  sushi-market/trans_helper
```

## Basic Usage


Пакет добавляет глобальную хелпер-функцию `___($key, $replace, $locale)`

Данная функция работает аналогично `__()`, но вложенные значения будет искать внутри JSON файла, а не внутри директорий.

Описание хелпера `__()` можно прочитать в [документации Laravel](https://laravel.com/docs/helpers#method-__)

Пример файла перевода можно посмотреть в тестах https://github.com/sushi-market/trans_helper/blob/master/tests/lang/en.json
