# WP Starter Theme

Resources:

* [Timber Docs](https://timber.github.io/docs/getting-started/theming/)
* [Timber ACF](https://timber.github.io/docs/guides/acf-cookbook/)
* [Timber Images](https://timber.github.io/docs/guides/cookbook-images/)
* [General Twig - Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)
* [Laravel Mix](https://laravel-mix.com/docs/6.0/what-is-mix)

### Getting started

1. `composer install`
2. `npm ci`
3. `npm run build` - Build production-ready assets.

## Theme Development

1. `npm run watch` - Start watching theme assets for changes.
2. `CTRL + C` - Stop watching the theme for changes.

## Concepts & Structure

### ACF Components

Uses ACF Layouts w/ a field named "Page Content Sections" to provide a mechanism for building content with components.

To make a new component, you'll first add a new Layout to this field.

### Directory Structure

Here are the common folders and where files are expected.

| Directory                         | Description                                            |
|-----------------------------------|--------------------------------------------------------|
| `assets/scss/common`              | Global styles, such as typography, header, footer, etc |
| `assets/scss/content-sections`    | Styles for the `page-content-sections` templates       |
| `assets/layouts`                  | Styles for the global HTML layout structures           |
| `assets/js/*.es6.js`              | Scripts that are transpiled during build               |
| `templates`                       | Global layout and structural templates                 |
| `templates/page-content-sections` | Twig templates for the ACF Layouts                     |
| `templates/partial`               | Twig templates for arbitrary components                |
| `templates/static-content`        | Twig templates for "Static" ACF Layout                 |
| `src`                             | PSR-4 PHP entrypoint. Namespace: `DagLabTheme`         |

