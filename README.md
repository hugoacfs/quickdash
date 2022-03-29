# quickdash
Newest QuickDash version. Combines the API and Client repositories.

## Requirements
- PHP version 7.4 - https://www.php.net/
- Composer - https://getcomposer.org/
- Bootstrap 5 (CSS only) - https://getbootstrap.com/
- Bootstrap Icons - https://icons.getbootstrap.com/

## Configuration and Setup:
1. To install packages: `$ composer install` or `$ php composer.phar install`
2. Copy `config-dist.php` to `config.php`.
3. Copy `data-dist.json` to `data.json`.

### config.php
This file holds configuration variables:
- `publicpath`- used to create URL's to the API folder of quickdash public (local development example: `http://localhost/quickdash_api/public/`).
- `apipath` - used to create URL's to the API folder of quickdash api (local development example: `http://localhost/quickdash/api/`).
- `jspath` - used to create URL's to the public/dash.js folder of quickdash_client (local development example: `http://localhost/quickdash/public/dash.js`).
- `bootstrapcss` - the CDN used for `bootstrap.min.css` file, jQuery is not used by QuickDash.
- `corereferrer`- the name given to your quickdash_client, you can choose.
- `standardtags` - the standard tags that show in your index, you can choose.
- `faviconurl` - the favicon URL, can be hosted anywhere you want.
- `logourl` - the logo URL, can be hosted anywhere you want.
- `logohref` - the URL to take users to when they click on the logo.
- `logoalt` - the logo alt text.
- `debug` - is used to display error messages, if set to `true`.
