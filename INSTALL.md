Install Guide
=============

## Requirements

 1. **console version** of [git](http://git-scm.com/), you can use the 
 [github install guide](https://help.github.com/articles/set-up-git); 
 reference: [git docs](http://git-scm.com/documentation), or 
 [git ref](http://gitref.org/)
 2. **if you own private repositories**: SSH access to the repos 
 ([SSH guide for github](https://help.github.com/articles/generating-ssh-keys))
 3. a working \*nix compatible console (on windows use `git bash` that comes 
 with git)
 4. a working server (LAMP/WAMP/MAMP are fine for development), a server setup 
 should contain
   - PHP (on windows it's easier to install a separate version for console use)
   - a web server (Apache, nginx, etc)
   - optionally a database (by default support for MySQL is available)

## Steps

To get everything up and running requires a 3 step process.
 
 1. setting up the project files
 2. setting up the key files
 3. setting up the public files

From here on we will consider your https or git protocol repository url as 
`REPO` and your project code name as `PROJECT`. These are placeholders, please
replace them in the example code bellow with your actual repo url and project 
code name.

As an example, for the Mjolnir demo project `REPO` is 
`git@github.com:ibidem/mjolnir-template-app.git` (for SSH access) or 
`https://github.com/ibidem/mjolnir-template-app.git` (for normal HTTPS). And
`PORJECT` can be `demo` or `mjolnir-template-app`, etc. On github you should
see the project repository urls on the project page.

Any other ALLCAPTICALS words bellow are also placeholders and you should not 
take them literally.

### Step 1: Setting up the project files

First we need to retrieve a local copy of the project files... (ie. `git clone`)

	cd /path/to/your/working/directory-or-partition/
	git clone REPO PROJECT
	cd PROJECT/

### Step 1.1: Setting up file permissions (situational)

You should make sure all your files contain appropriate permissions 
(use `ls -l` to check).

The files **should be already setup correctly**, but in case they aren't you 
can use the following commands to ensure the files have appropriate access 
levels.

	chmod +x order
	chmod -R +x bin/
	chmod 770 etc/logs/
	chmod 770 etc/cache/
	chmod 770 etc/tmp

It's also recommended you set up a appropriate user to manage the project. 
Assuming your user is the same as PROJECT and your group is SERVGROUP you would
do configure the project files with the following commands after switching to
a user with administrative access (`root` on *nix systems):

	chown -R PROJECT .
	chgrp -R SERVGROUP .

This setup allows your server to access the files and via your account you can
perform maintenance with out any risk of damaging other files on the server.
(The default server group is usually `www-data`.)

Make sure your user has SSH setup correctly to access to appropriate 
repositories. In the case of Github, this implies you have an account (any
free account will do), and the owner of the repository has either added you as 
a collaborator or to a team with appropriate access.

### Step 1.2: Installing PHP dependencies

Most project dependencies are external, so you will have pull them in.

In your project root run:

	bin/vendor/install
	
The command will install PHP dependencies using Composer. After the install 
process has completed you should run:

	bin/vendor/status

This will display information on all installed dependencies (version and 
description). Please confirm no inappropriate versions were installed for your 
use case (ie. unauthorized experimental development releases in production).

Once you've confirmed the integrity of the installed PHP dependencies run:

	./order

You should see a help list of commands. If you aren't seeing this something has
gone horribly wrong when installing your dependencies. Please review the 
previous steps. The system should also be telling you haven't set up neighter a
`.www.path` file, nor a `.key.path` file, ignore these for now, we'll deal with
them in step 2, and 3 respectively.

If all is well up to this point run:

	./order status

This will run dependency checks specified by project modules. If all 
dependencies are satisfied you should get a "passed" rating, this is 
appropriate for production, if the rating is "failed" the module is missing 
some key functionality but it is still able to function with out them (more or 
less), if the rating is "error" the module is missing a critical requirement, 
you will need to check your server setup and configuration to ensure the 
requirement is satisfied or otherwise the system will run in an unstable state. 
At this point you should see `[error]` ratings on various keys on the system; 
ignore them for the time being and check back after you have finished setting 
up the private files. Once you set up the public files and specify their 
location via a `.www.path` file on your project root you should see some extra 
tests pop up as well, which are verifying permissions are in order.

In production you should always aim for all "passed", in development you may
get away with some components on "failed" depending on what you're working on.

At this point you may also confirm you've gotten an appropriate version of the
application by running:

	./order versions

The command will output versioning information from all registered modules.

You may also run:

	./order cleanup

The command will perform a cleanup on various application controlled system 
files.

### Step 1.3: Installing style dependencies

To obtain a production ready version of the files run:

	./order compile

The process may occasionally stall for up to a minute if is require to download
some appropriate compiler.

*Note: the `./order compile` is for generating production files. If you are 
doing development on the files you may want to use the appropriate polling 
script (typically this takes the form of a `start.rb` file) to benefit from 
debug information such as source maps, etc.*

### Step 2: Setting up the key files

The private files are for the most part the configuration files containing your
secret keys. **It is imperative that you do NOT place ANY security information 
in your project files!**

To setup the files first copy the draft version of the files to a secure 
location preferably where only the root user and server has access, and then
create a file `.key.path` on the project root where you specify this path
so the system knows where to find them:

	cp -R drafts/keys.draft /secure/private/path/PROJECT
	echo "/secure/private/path/PROJECT/" > .key.path

Of course at this point you would `cd /secure/private/path/PROJECT/` and start
filling in the keys. The files should NEVER contain anything more then security
information such as public / private keys, users, passwords, database names, 
etc, because otherwise you will need to give access to your development team to
them if somehow they overwrite more then that; and you should never need to do
that.

### Step 2.1: Installing the database (optional)

**DO NOT PERFORM IF THE DATABASE ISNT EMPTY**

To set up your database run this command:

	./order db:install

This will *destroy* any copies of the components it needs to install (by this
we're referring to tables not entire databases), initialize and load in a copy
of the database structure with all channels updated to the latest version.

If you recieve an error on database access **DO NOT** go and insert your 
password / username in the project configuration. Not only is this wrong but 
likely won't work since the values in your private files will overwrite them.

Troubleshooting Checklist:

 1. did you create the database
 2. did you specify the correct path to your private key files in the file 
 `.key.path` on the root of your project
 3. did you insert the correct user / password in the database configuration in
 your private files
 4. are your dependencies installed correctly (see previous steps)
 5. are your permissions set up correctly

If you've gone though all that and still can't figure it out, debug it.

### Step 3: Setting up the public files

For web projects at this point you would want to setup your public files which
are accessible for your users. We will consider `/path/to/www` to point to your
publicly accessible files via the web server. If you are running the project in
a folder consider that folder to be `www`.

	cd /path/to/www

Then for domain based sites,

	cp -R /path/to/PROJECT/drafts/www .
	
Then for folder based sites,

	cp -R /path/to/PROJECT/drafts/www ./PROJECT
	
(You can obviously also have it in sub-sub-folders if you want.)

You should now have a `config.php` file on the project root. This is the domain
configuration. You may have multiple domains using the same project files, the
`config.php` files on their root specify their domain settings.

The configuration file should walk you though the important settings, but in
case you're having problems refer to the checklist bellow.

A quick checklist:
	
 * insert an appropriate domain name, ie. `www.exmple.com`, or `example.com`
 in development 127.0.0.1 is recomended
 * set up an apropriate base path, ie. `/` for sites directly on the domain, 
 `/some/path/` for folder based sites
 * set the site's development mode to `true` if you're doing development (by 
 default development mode is `false`)
 * set up caching (by default caching is turned on)
 * set the `key.path` value to the appropriate path to your private files,
 ie. `/secure/private/path/PROJECT/` in the examples above
 * set the `sys.path` to the appropriate system directory (ie. where you 
 cloned your project)

### Step 3.1: Setting up the server specific files

Most servers require additional files besides the base files required by 
your project's PHP code. Assuming your server is apache as an example, you 
would have to copy the extra files like this

	cd /path/to/PROJECT
	cp -ruT drafts/www.apache /path/to/public/files

Make sure to add the `T` flag, otherwise the directory `www.apache` will be 
copied inside the public files directory instead of the files inside it 
overwriting the files inside the public directory. **On windows** if you're 
using *git bash* you `cp` won't have the `T` flag, so you'll have to copy the 
files manually.

* You would of course also need to inspect the copies configuration files 
  and change accordingly (for the `www.apache` version you will only need to 
  change the `RewriteBase` in the main `.htaccess` file if you're not on the 
  domain root).
	
As another example in the case of nginx, you would need to do
	
	cd /path/to/PROJECT
	cp drafts/nginx/site.draft /path/to/sites/PROJECT
	
Where `PROJECT` in this case is a file and `/path/to/sites` is a directory from
which nginx loads location files into the main server (note: the setup 
described is a development friendly setup; you may wish to alter it for 
production). As with the previous apache configuration open the new file and
configure it to match your server settings.

*Please inspect your project's `drafts` folder for any additional dependencies, 
such as node server files, etc. The instructions here only cover the default 
ones. You will have to follow the instruction provided by each since covering 
them is outside the scope of this readme.*

## Congratulations on completing the setup

You should at this point have an working project. Regardless if you're doing
prototyping, development or are here to alter/enhance the project, you should
refer to the manual; sections for starting up, to working on an existing 
project are available.

Sections of the manual are maintained by each module. And modules may insert 
their own manual entries (this includes project specific modules). To generate
the latest copy run the following:

	./order librarian --manual

A html (and pdf) version will be generated on the project root.

## File Permission Testing & Dependency Checks

With the system setup, you can use various tools in the backend to manage the 
core features of the system. Two of these features is the System Information
panel and the File Permissions panel. 

These two panels will tell you if all your dependencies are in order, and if
your file permissions are correct respectively.

To access the panels you'll have to create a system administrator account, you
can do this from the command line by typing

	./order make:user -u <username> -p <password> -r admin

If you haven't setup any login system, you can access the internal default one
at the url:

	/access/signin

The system can no check your server configuration so if you encounter an error
and mjolnir is not reporting anything unusual then it is possible your server
configuration is off.
