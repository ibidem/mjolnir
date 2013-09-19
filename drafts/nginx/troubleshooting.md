Common Problems
===============

 * CSS, images, etc don't work. If this happens please check any extra rules
   you have in place. Typically you may have a rule that covers css and images,
   adding cache headers and so on. Due to it being specific to the file the
   try_files won't ever trigger. The simple solution is to remove the file
   extentions from the rule in question.

 * GET queries don't work. Add ?$args at the end of the try_files.