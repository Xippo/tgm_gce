.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
=======================



.. _configuration-templates:

Change the default templates
----------------------------
the default templates aren't optimized for a default usage please change it. You can do this like in other TYPO3 extension:

.. code-block:: typoscript

	plugin.tx_tgmgce {
		view {
			templateRootPaths {
				150 = fileadmin/some/path/tgmgce/Templates/
			}
			partialRootPaths {
				150 = fileadmin/some/path/tgmgce/Partials/
			}
			layoutRootPaths {
				150 = fileadmin/some/path/tgmgce/Layouts/
			}
		}
	}

.. _configuration-calendarize:

Use the standard views from calendarize
---------------------------------------
You can easily use also the default views from calendarize, the only thing you have to do is to adapt the templates.
Setup your path to your templates:

.. code-block:: typoscript

	plugin.tx_calendarize {
		view {
			templateRootPaths {
				150 = fileadmin/some/path/calendarize/Templates/
			}
			partialRootPaths {
				150 = fileadmin/some/path/calendarize/Partials/
			}
			layoutRootPaths {
				150 = fileadmin/some/path/calendarize/Layouts/
			}
		}
	}

then under partial you have to create a ListItem.html. You can use the same ListItem.html you use for the list view from gce events. So you have todo the work only one time and you have the same style.
But you have to change the link action a bit, it should be like that:

.. code-block:: typoscript

	<f:link.action pageUid="{settings.detailPid}" pluginName="main" extensionName="tgmGce" action="show" controller="Events" arguments="{index:index}"><f:translate key="LLL:EXT:myext/Resources/Private/Language/locallang.xlf:show_event" /></f:link.action>

.. hint:: use the same link.action on other default calendarize templates if you want to link on the gce show action

.. _configuration-email:

Form E-Mails and Templates
--------------------------
If you activate the from for one of your events, the form will rendered after the event information.

Receiver E-Mail template
^^^^^^^^^^^^^^^^^^^^^^^^
You will find the receiver E-Mail template under Templates/nameOfTheForm/Receiver. Here you have the fluid object "{formEntrys}" here are stored all the data from the form.
You can change the template form the default form like a normal fluid template.

Costumer E-Mail template
^^^^^^^^^^^^^^^^^^^^^^^^
You will find the costumer E-Mail template under Templates/nameOfTheForm/Customer. Here you have the fluid object "{formEntrys}" here are stored all the data from the form.
If you need one for the default form you have to add it.

Activate Costumer E-Mail
^^^^^^^^^^^^^^^^^^^^^^^^
To enable the costumer E-Mail you have to activate the checkbox in the typoscript constants "Send confirmation to the costumer" and your from must have a field with the name email

.. _configuration-addCustomForm:

Add a custom form
-----------------
To add a custom form you need only to add the item via pageTsConfig

.. code-block:: typoscript

    TCEFORM.tx_tgmgce_domain_model_events.form {
        addItems.newform = new form
    }

..
and than you need to add the form template Partials/Form/Newform.html

**!!important:**

- The form action must be formDispatcher and the objectName must be form like the standard form.
- If you will send a confirmation mail you need the field email


