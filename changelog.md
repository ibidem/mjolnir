Changelog
=========

With the exception of stable/solid versions a lot of versions is internal and
may not have direct branch or tag.

   solid = has complete tests and docs, is/was used in production and no
           changes or issues were required, reported or otherwise signaled on
           it for several months

  stable = has complete tests and potentially incomplete but usable docs

  liquid = incomplete tests and docs

unstable = former stable/solid branch which has had bugs reported on it

  future = changes planned but not yet implemented (ie. heads up!) or
           implemented in legacy (ie. if you don't have the legacy module
           enabled, you are technically working with the future version today)

future/3.x
----------

 - bower support removed; use of bower discouraged

 - mjolnir\base\Controller removed

 - mjolnir\foundation\Puppet::modelclass removed; nothing particularly wrong
   with it, design consideration because Puppet is used and may be used with
   various non-model related classes

 - devlog task alias removed

 - removed Schematic-based migration system

 - removed Layer_HTML legacy support for underscore version of keys and
   headscript support

liquid/2.6
----------

 *core*

   - Layer_HTML will not prioritize channel settings over configuration
     settings; all properties are now compatible with channel settings, the
     channel version of the keys has the "html:" prefix unless it's a
     common key—currently assuming no backwards compatibility issues exist due
     to previous code requiring retrieval of "layer:html" which won't break
     under the new system

   - all underscore keys have been converted to dash keys (legacy module now
	 will convert all underscores to dashes)

   - Layer_HTML "headscript" is now "startup-script" (legacy module now merge
     "headscript" into "startup-script," unique values only)

   - Layer_HTML now accepts "js-loader-handler," will default to "yepnope" if
     not specified

   - The Pdx class now has a t($model, $temptable = null) method for dealing
     with tables that have been permanently DROPed from a project.

liquid/2.5
----------

*core*

  - theme:packager introduced; theme packager converts current compiled copy
    into a package based on detectable version; .gitignore files are removed
    when the compiled version is turned into a package; enable
	theme -> packaging in mjolnir/base (ie. preferably www.config) to have the
	system switch to using packages on a production server. Server compiling
	is still ideal (especially in development), packages are an alternative
	simplified method. Packaging is particularly useful when very complicated
	compiling is required since it bypasses complicated the server setup at the
	expense of source tree pollution.

  - the constant APPVERSION and VERSION are now MJ_APP_VERSION to ensure
    compatibility; library version remains unchanged due to these constants (a)
    being partially an error when used, and (b) not used for anything critical
	in the library--the constant EXT remain global

  - log:cache, log:cache:get, log:queries are now available; appropriate
    development settings and mjolnir/profile module required

  - as long as you have the profiling module loaded and logging -> devlogs
    enabled in your configuration you can view the status of access checks with
    the new command order log:access; this is useful when writing or
    refactoring since almost everything goes though the access system and it
    can be confusing if something failed because of a protocol or bad code
    somewhere else

  - order devlog is now order log:short, new --erase (-e) flag has been added;
    short.log is no longer erased when using the command on its own

  - deprecated console commands are now moved to a "legacy" category; allowing
    scripts that might rely on them, such as crons, to continue to work as
	expected

  - the Layer interface now also uses the Meta interface by default

  - task categories now must be mentioned in task-categories configuration to
    be valid and are ordered based on a given priority in said configuration

  - licenses task has been added

  - Schematic-based migration system deprecated

  - Paradox migration system introduced; should not be used in tandem with
    schematic system

  - base configuration now has a db:lock option; when active migration systems
    will ignore data damaging operations (install-overs, resets, uninstalls,
    etc). ON by default. Does not apply to deprecated Schematic system, for
	legacy compatibility reasons.

  - base configuration now controls which migration system is use though
    db:migrations; this is meant to prevent accidental use of the wrong
    migration system, potentially causing a full database wipe

  - overlord script introduced; script is intended to provide access to tasks on
    systems where ssh access is not available; script is located in www.overlord
    draft and requires configuration in www.path/config.php before it will allow
    access

  - honeypot task now contains a prefix flag which allows you to generate based
    on a partial namespace pattern

*template*

  - template theme has been tweaked slightly to account for new theme:packager

liquid/2.4
----------

*core*

 - new "raw" layer stack included

 - HTMLFormField_Hidden no longer can be autocompletes by default; this change
   has been made to avoid hard to spot errors occuring on POST operations with
   out redirects

 - bower support is now deprecated and scheduled for removal in 3.x

 - convention: all default base classes are abstract classes with the Base
   suffix; these are shorthands, they are convenient but using traits and
   interfaces directly is recommended since it allows for trait method rewrite

 - class \mjolnir\base\Controller deprecated (see convention above)

 - better logging for Sphinx api calls

 - script loader can be turned off

 - Puppet::modelclass is now deprecated and part of legacy module

 - Puppet iterface/trait now provides codename and codegroup which are at the
   library level implemented as underscore version of the singular and plural
   names, but obviously like other Puppet interface methods may/should be
   customized to take advantage of class usage circumstances

 - Validator has been moved to the mjolnir\base namespace

 - added \mjolnir\base\Auditor which implements \mjolnir\types\Validator, unlike
   \mjolnir\base\Validator, the Auditor class is designed to validate partial
   data and also validate multiple field sets with the same object

 - theme drivers now support some basic browser caching

*bugs*

 - script loader block no longer appears if there are no javascripts to load

liquid/2.3
----------

*core*

 - re-included footerinclude and headinclude shorthands in ThemeView

liquid/2.2
----------

*core*

 - improved display of file permissions system

 - several new display helpers for permissions have been added to the
   `Filesystem` class

 - when `development` in `mjolnir/base` (ie. `www.path/config`) is set to true
   the javascript loader will inject the script sources directly into the page

 - style source handler implemented

*template*

 - `README.md` updated with basic information on new backend panels

 - `bin/vendor/install` now only installs core dependencies using
   `/composer.json` in addition the installation will run with `--prefer-dist`,
   which is more reliable

 - `bin/vendor/development` now installs development dependencies
   using `/etc/composer.json`, unlike `bin/vendor/install` this script uses
   `--prefer-source`

*bugs*

 - file permission errors are now correctly reported on directories

 - fix'ed a bug where theme loader priority wasn't respected

liquid/2.1
----------

*core*

 - the `cfs` module now provides a File Permissions backend which checks file
   permissions to ensure permissions weren't accidentally butchered

 - backend now contains a signout button on the admin panels page

 - `satisfied` is now the correct passed state in `require.php` tests; the old
   `available` state is still supported

 - status is now available in the application admin backend; the list should
   be more user friendly and also guaranteed to reflect server status;
   whereas the command version (which is still available) is highly prone to
   errors such as using different CLI configuration for a lot of tests

*bugs*

 - images will now be re-orientated to guarantee compatibility with systems
   that do not read exif data before processing (eg. thumbnail systems); the
   class `\mjolnir\base\Image` has been introduced for this purpose and may be
   used outside of image uploads

 - fix'ed video rotation bug

 - fix'ed theme exception system

liquid/2.0
----------

*core*

 - the use of `\defined` and `\defined` is now considered bad practice and has
   been removed; its use has been replaced by the `\app\Env` class, calling the
   static methods of `\app\Env` is equivalent to calling the methods on
   `\app\Env::instance('main')`, for direct/include interoperability with
   another mjolnir application an application must support non-main environment
   execution—interoperability with non-mjolnir applications should be clean even
   when using main; note that some constants such as `VERSION` and `EXT` have
   remained

 - `PUBDIR` is now `\app\Env::key('www.path')`

 - `DOCROOT` is now `\app\Env::key('sys.path')`

 - `ETCPATH` is now `\app\Env::key('etc.path')`

 - `VDRPATH` is now `\app\Env::key('vendor.path')`

 - other paths should follow the changes above

 - the expected location for any system errors is
   `\app\Env::key('www.path').'<errorcode>'.EXT`; implementations should
   check for file existance and handle the case where the error code is not
   supported; this includes predefined template files such as 404, 500, etc

 - `mjolnir/base -> system.info` is now `mjolnir/base -> system`

 - `mjolnir/base -> system.info -> contact.email` is now
   `mjolnir/base -> system -> email`

 - `mjolnir/base -> site:title` is now `mjolnir/base -> system -> title`

 - `mjolnir/base -> site:quote` is now `mjolnir/base -> system -> quote`

 - new property `error-reporting` for adjusting error reporting level when
   the current application needs to directly interface with some garbage
   code, default -1

 - the status for upload limit check is now a failed condition, was previously
   an error condition

 - fix'ed Shell::cmd_exists not handling fail state


*template*

 - `changelog.md` is now included; changelog has been trimmed to `liquid/1.0`
    and up

 - the main template has been reorganized slightly; `mjolnir.php` and
   `environement.php` are now correctly located in `etc/` instead of the root

 - the `order` utility will now clear the screen on non-windows OSes before
   running the specified task

 - `config.php` in `drafts/www` has been reorganized; `system.dir` is now
   `sys.path`, `private.files` is now `key.path`, `logging -> short.log` is
   now `logging -> devlogs`, `static-theme` is now `static-assets`

 - `error.php` in the public directory is now `500.php`

 - maintanence mode is now false by default; was previously on by default

 - system paths are now located at the top, followed by the development mode
   switch

 - 404 errors are no longer excluded by default

 - various comment hints in `config.php` have been shortened to the smallest
   possible explanation, for usability purposes

 - fix'ed typo in `drafts/www/downtime.php`

 - `project.private` is now `keys.draft`, while any project specific information
   such should still be placed here, some settings have been stripped out for
   usability

 - in `keys.draft` the file driver is now the default email driver for
   easier time in development (and because there is no real usable alternative
   to smtp, which requires configuration, so might as well make dev work easier)

 - in `keys.draft` the default pdo dns is now
   'mysql:host=127.0.0.1;dbname=YOURPROJECT', instead of
   'mysql:host=localhost;dbname=mjolnir', this should give better performance on
   windows machines, and is easier to debug when the `key.path` is malformed

 - the nginx configuration has been simplified to the bare minimum; should be
   usable by your grandma now

 - bin/vendor/install and bin/vendor/update are now have improved verbose output

 - cleaned up .gitignore

 - logging and error reporting includes moved to default.mjolnir

 - etc/environment.php now uses temporary globals instead of constants

 - composer.json has been moved to etc

 - mjolnir top configs for access, auth, relays, schematics and server have now
   been moved to etc instead of demo

 - config/routes is now located in etc

 - main language configuration has been moved to etc

 - the demo now uses the indexed language system instead of the key system

*bugs*

 - a cache bug with resetpwd has been fixed

liquid/1.1 (dev)
----------------

*core*

 - new instance based Lang system introduced, the system requires libraries to
   be loaded before use allowing for lower overhead and simple unnamespaced
   `$lang->idx('something')` syntax

 - imageuploader and videouploader for forms along with general purpose video
   converting (ffmpeg driver) are now available

 - improved status/require system

*template*

 - `DOCROOT/+App` is now `DOCROOT/etc`


liquid/1.0
----------

*core*

 - refactored all interfaces to reuse each other as much as possible

 - refactoring of classes to use type/trait conventions, see documentation

 - refactored theme system (now standardized and driver based)

 - refactored application system to use new foundation interface

 - refactored language system

 - refactored html & form system

 - cleaned up access system

*template*

 - drafts is not back to being outside of the application dir
