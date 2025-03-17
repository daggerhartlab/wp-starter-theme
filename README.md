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

We use ACF Flexible Content Layouts w/ a field group named "Page Content Sections" to provide a mechanism for building content with components.

An example component is provided - Content HTML, which is a basic WYSIWYG field. This illustrates the way components are typically put together while also serving as a practical component that most sites will end up using.

#### Creating components

To make a new component, follow these steps:

* Navigate to ACF > Field Groups in the WP Admin
* If no field groups show up, click the "Sync Available" link and Sync the "Page Content Sections" field
* Edit the Page Content Sections field group
* Under the "Sections" field, click the "Add Layout" button
* Give the Layout/Component a "Label" and take note of the auto-populated "Name".  and add any fields that it will need then Save
* Note that the above step makes changes to an ACF JSON file which should be committed so other developers can sync their fieldset
* When editing a page, in the "Page Content Sections" field, add a new row and select your component
* Fill out the fields as needed and Save
* In the theme's `templates/page-content-sections` directory, create a file called `component_name.twig` where `component_name` is the auto-populated "Name" of the component noted above. This is where the component markup will go.
    * The variables passed in (via `page.twig`) are `fields`, which has the ACF field values, and `component_key`, which is the row number beginning with `1`
* Styles are typically placed in `assets/scss/content-sections/{component_name}.scss` and imported in the "Flexible Content Sections" portion of `assets/styles.scss`
* JavaScripts are typically placed in `assets/js/{component_name.es6.js}`. Note that files with the `.js` extension without the `.es6` prefix are ignored since these represent build artifacts. There is also a `scripts.es6.js` file where globally applicable JS code can go if needed.
* At this point, you can view the page where you added the component and see the result

#### Using components for specific post types

By default, the "Page" post type uses the ACF components, but other post types do not. To add components to other content types, follow these steps:

* Edit the "Page Content Sections" field group
* In the "Settings" section, add a new rule underneath "Post type is equal to Page" and select your post type
* In the `single.php` template (or `single-{post-type}.php` for your post type), add the `page_content_sections` field to the Twig template context (see `page.php` for an example)
* In the Twig template for your content type single view, you can now include the partial that handles components. See `page.twig` for an example.

### Directory Structure

Here are the common folders and where files are expected.

| Directory                         | Description                                            |
|-----------------------------------|--------------------------------------------------------|
| `assets/scss/common`              | Global styles, such as typography, header, footer, etc |
| `assets/scss/content-sections`    | Styles for the `page-content-sections` templates       |
| `assets/scss/layouts`             | Styles for the global HTML layout structures           |
| `assets/js/*.es6.js`              | Scripts that are transpiled during build               |
| `templates`                       | Global layout and structural templates                 |
| `templates/page-content-sections` | Twig templates for the ACF Layouts (components)        |
| `templates/partial`               | Twig templates for arbitrary partial layouts           |
| `templates/static-content`        | Twig templates for "Static" ACF Layout                 |
| `src`                             | PSR-4 PHP entrypoint. Namespace: `DagLabTheme`         |

