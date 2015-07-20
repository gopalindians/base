# Setup

1. Download the latest *base* version.
2. Copy the *base* directory to any location into your project you like.
3. Copy the .htaccess file into your projects root directory (and remove the underscore).
4. Setup *base* in your index.php.
5. And you're ready to use *base*!

Setup *base* in your index.php:

```PHP
define('BASE_ROOT', 'path/to/base');
require_once 'path/to/base/base.php'; // this will include all required classes via autoload
```

Constants are used for settings. See docs/Constants.md for all available constants.
