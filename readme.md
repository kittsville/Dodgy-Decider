# Dodgy Decider

*"It works, for the most part" - An optimistic contributor*

A small PHP tool for consistently making decisions based off of a given hexadecimal seed.

Created for procedurally generating the world of the text adventure game [10 Minutes to Meston](https://github.com/kittsville/10-Minutes-to-Meston/).

## Usage

```php
use Kittsville\DodgyDecider\Decider;

$decider = new Decider();

$decider->seed('ffffffffff');

echo $decider->choose(['a', 'b', 'c'], 'example choice');
```

## Contributing

As per the name I am fully aware how terrible this is. Feel free contribute with suggestions, pull requests or a completely new decider you've built yourself.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).