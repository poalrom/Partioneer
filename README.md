# Partioneer

Маленький хелпер для обработки подстрок, заключенных в какие-либо знаки.

Примером использования может быть использование виджетов в тексте, например все конструкции вида ```{[widget setting alias="email"]}``` могут быть как получены из текста в виде массива, так и обработаны с помощью переданного замыкания.

## Создание экземпляра класса:

```php
$partioneer = new Partioneer('{[', ']}', $text, function($string){
  return strtoupper($string);
});
```
Где:
* первый аргумент - начальные символы конструкции
* второй аргумент - конечные символы конструкции
* третий аргумент - текст для обработки
* четвертый аргумент - функция для обработки, которая применится к каждой найденной конструкции. Необязательный аргумент

## Получение массива выбранных конструкций:
```php
$widgets = $partioneer->getArray();
```

## Получение текста после обработки конструкций
```php
$content = $partioneer->execute();
```
