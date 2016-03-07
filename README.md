# Boilerplate

### Get Started

Clone or download this repo.

If you're using Composer to manage dependencies, install them:
```
composer install
```


### Troubleshooting

If you're having trouble getting setup, read through the list below.

#### General
- __Server Error 500__ This is most likely missing Composer dependencies. Try running `composer install`.
- __Required file: [filename] either does not exist or is not readable.__ A core include is missing or unreadable. Check file permissions and make sure no core files have been moved or deleted.

#### Controller
- __Default Controller: [filename] is missing or unreadable.__ There must be at least an `index.php` file present in the `_controller` directory. Even if it is empty, the Controller class will fallback to this if no path-specific controller is found.

### Developing with Boilerplate

Boilerplate was designed to be a quick-start base for PHP based websites and simple apps. The following are just guidelines but if you're going to share your creations I recommend you try to follow them.

#### Includes

The `_includes` directory is home to the core includes as well as composer dependencies. For using third party packages, I recommend using Composer as it can be a real time saver with updates etc. When adding your own code, create a seperate directory within the `_includes` directory, something like `project` or `app` works well. This just ensures that any future updates to Boilerplate won't break your code!

#### Theming

Theming is supported in Boilerplate and you can enable Twig support by changing a value in `.config.yml`. The default `_templates` directory is where Boilerplate will look for theme files by default. You can change this using the `$_theme->use_theme()` method. This accepts a directory location and will then look in that directory for template files. _This can be particularly useful for plugins which may need to use a custom theme for specific paths._
