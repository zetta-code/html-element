# HtmlElement

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/:package_name.svg?style=flat-square)](https://packagist.org/packages/spatie/:package_name)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/:package_name/master.svg?style=flat-square)](https://travis-ci.org/spatie/:package_name)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/:package_name.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/:package_name.svg?style=flat-square)](https://packagist.org/packages/spatie/:package_name)

> WORK IN PROGRESS

## Examples

I recommend adding an `el` function to your application to improve readability over the static method.

```php
function el(string $tag, $attributes = null, $content = null) : string
{
    return \Spatie\HtmlElement\Html::el(...func_get_args());
}
```

A plain tag with text contents:

```php
el('p', 'Hello world!');
```
```html
<p>Hello world!</p>
```

A tag with an ID:

```php
el('p', ['id' => 'introduction'], 'Hello world!');
```
```html
<p id="introduction">Hello world!</p>
```

A tag with an ID set emmet-style:

```php
el('p#introduction', 'Hello world!');
```
```html
<p id="introduction">Hello world!</p>
```

A tag with an ID and a class:

```php
el('p#introduction.red', 'Hello world!');
```
```html
<p id="introduction" class="red">Hello world!</p>
```

A more complex emmet-style abbreviation:

```php
el('div.container>div.row>div.col-md-6', 'Hello world!'));
```
```html
<div class="container">
  <div class="row">
    <div class="col-md-6">
      Hello world!
    </div>
  </div>
</div>
```

Manually nested tags:

```php
el('div', ['class' => 'container'],
    el('nav', ['aria-role' => 'navigation'], '...')
);
```
```html
<div>
  <nav aria-role="navigation">...</nav>
</div>
```

Multiple children:

```php
el('ul', [el('li'), el('li')]);
```
```html
<ul>
  <li></li>
  <li></li>
</ul>
```

Self-closing tags:

```php
el('img', ['src' => '/background.jpg']);
```
```html
<img src="background.jpg">
```

## Arguments

The `el` function behaves differently depending on how many arguments are passed in.

#### `el(string $tag) : string`

When one argument is passed, only a tag will be rendered.

```php
el('p');
```
```html
<p></p>
```

---

#### `el(string $tag, string|array $contents) : string`

When two arguments are passed, these generally are a tag and it's contents.

String example:

```php
el('p', 'Hello world!');
```
```html
<p>Hello world!</p>
```

Array example:

```php
el('ul', [el('li'), el('li')]);
```
```html
<ul>
  <li></li>
  <li></li>
</ul>
```

---

#### `el(string $tag, array $attributes) : string`

When two arguments are passed, and the tag is a self closing tag, the second argument contains attributes.

```php
el('img', ['src' => '/background.jpg']);
```
```html
<img src="background.jpg">
```

---

#### `el(string $tag, array $attributes, string|array $contents) : string`

When three arguments are passed, the first will be the tag name, the second an array of attributes, and the third a string or an array of contents.

```php
el('div', ['class' => 'container'],
    el('nav', ['aria-role' => 'navigation'], '...')
);
```
```html
<div>
  <nav aria-role="navigation">...</nav>
</div>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
