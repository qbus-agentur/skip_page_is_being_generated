Disable the TYPO3 "Page is being generated" message
===================================================

This extension disables the "Page is being generated" message which is shown
when two requests try to render the same page simultaneously.

TYPO3 implements the "Page is being generated" through a "temporary page content".
This extesion invalidates the timeout of that temporary page cache content so that
it is never shown to the user. Thus the user will always see the real page content.

No configuration needed.
Just install:

.. code-block:: bash

  typo3/cli_dispath.phpsh extbase extension:install skip_page_is_being_generated
