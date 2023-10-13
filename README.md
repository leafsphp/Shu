<!-- markdownlint-disable no-inline-html -->
<p align="center">
  <br><br>
  <img src="https://leafphp.dev/logo-circle.png" height="100"/>
  <br>
</p>

<h1 align="center">Shū</h1>

<p align="center">
  <a href="https://packagist.org/packages/leafs/shu"
    ><img
      src="https://poser.pugx.org/leafs/shu/v/stable"
      alt="Latest Stable Version"
  /></a>
  <a href="https://packagist.org/packages/leafs/shu"
    ><img
      src="https://poser.pugx.org/leafs/shu/downloads"
      alt="Total Downloads"
  /></a>
  <a href="https://packagist.org/packages/leafs/shu"
    ><img
      src="https://poser.pugx.org/leafs/shu/license"
      alt="License"
  /></a>
</p>
<br />
<br />

Shū is an event-driven state (aka state machine) library for PHP. It is designed to be lightweight, easy to use and easy to extend. Unlike other state libraries, Shū is not bound to any framework and can be used in any PHP project.

## 🗂 Basic Usage

There are many ways to use Shū. The easiest way is to define your states and events in a state file and then load it into Shū.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$machine = createMachine([
    'initial' => 'pending',
    'states' => [
        'pending',
        'approved',
        'rejected',
    ],
    'transitions' => [
        'approve' => [
            'from' => 'pending',
            'to' => 'approved',
        ],
        'reject' => [
            'from' => 'pending',
            'to' => 'rejected',
            'action' => function () {
                // perform an action and return true if successful
                return true;
            },
        ],
    ],
]);
```

## 💬 Stay In Touch

- [Twitter](https://twitter.com/leafphp)
- [Join the forum](https://github.com/leafsphp/leaf/discussions/37)
- [Chat on discord](https://discord.com/invite/Pkrm9NJPE3)

## 📓 Learning Leaf 3

-   Leaf has a very easy to understand [documentation](https://leafphp.dev) which contains information on all operations in Leaf.
-   You can also check out our [youtube channel](https://www.youtube.com/channel/UCllE-GsYy10RkxBUK0HIffw) which has video tutorials on different topics
-   You can also learn from [codelabs](https://codelabs.leafphp.dev) and contribute as well.

## 😇 Contributing

We are glad to have you. All contributions are welcome! To get started, familiarize yourself with our [contribution guide](https://leafphp.dev/community/contributing.html) and you'll be ready to make your first pull request 🚀.

To report a security vulnerability, you can reach out to [@mychidarko](https://twitter.com/mychidarko) or [@leafphp](https://twitter.com/leafphp) on twitter. We will coordinate the fix and eventually commit the solution in this project.

## 🤩 Sponsoring Leaf

Your cash contributions go a long way to help us make Leaf even better for you. You can sponsor Leaf and any of our packages on [open collective](https://opencollective.com/leaf) or check the [contribution page](https://leafphp.dev/support/) for a list of ways to contribute.

And to all our [existing cash/code contributors](https://leafphp.dev#sponsors), we love you all ❤️

## 🤯 Links/Projects

- [Leaf Docs](https://leafphp.dev)
- [Leaf MVC](https://mvc.leafphp.dev)
- [Leaf API](https://api.leafphp.dev)
- [Leaf CLI](https://cli.leafphp.dev)
- [Aloe CLI](https://leafphp.dev/aloe-cli/)
