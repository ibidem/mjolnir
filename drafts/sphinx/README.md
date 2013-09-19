Use `./order db:sphinx -r` to generate sphinx configuration files.

The `debug` directory is meant to facilitate testing.

	* copy and rename debug/ to a location of your choosing
	* open test.sh and replace the `YOUR_*` placeholders

You will then be able to open and close `test.sh` which will run sphinx for you.
Note: the script won't run sphinx as a service; in production you should!

When sphinx is not running any attempt to use sphinx functions will result in a
empty result. Logs will still issue the warning.