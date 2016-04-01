Disable the TYPO3 "Page is being generated" message
==================================================

This extension disables the "Page is being generated" which is shown
when two requests try to render the same page at the simultaneously.

It invalidates the timeout of that temporary page cache content so that
it is never shown to the user. The user will always see the real page content.

No configuration needed.
Just install:

.. code-block:: bash

  typo3/cli_dispath.phpsh extbase extension:install skip_page_is_being_generated
