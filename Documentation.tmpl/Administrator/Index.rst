.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

.. _admin-installation:

Installation
------------

To install the extension, perform the following steps:

#. Go to the Extension Manager
#. Install the extension
#. Load the static template
#. Create a Sysfolder where you will store your events
#. Set the PID form the Sysfolder, with the Events, in the Extension Constants under "Default storage PID"
#. Add the Plugin

.. _admin-configuration:

Plugin Configuration
--------------------

You have 2 Plugins at disposition.

**gce Events:**
Here you can choose between the list view and the detail/single view.
In the majority of cases you will need both. So you can show a list of events, with few details, and each event will link to the detail view, where all details will be shown.
In order to achieve this you need to setup one plugin with the list view on one page, with the setting **PID for the Detail view** set. On the set PID(must be on a different page as the list plugin) you need to setup the second plugin with the Detail view.

**gce Events Map:**
With this plugin you can setup a Google map. On the map will be shown the events that meets the filter settings. For events with frequency, will be shown only the next date of the event on the map

Typoscript Configuration
------------------------
In the Typoscript constants you can set:

# The default receiver for the form evaluation E-Mail (email is used if no one is set in the event self but the event has still a form attached)
# The default form sender E-Mail (e.g automailer@domain.com)
# You can choose, if after the submit of the event form, it should be send a conformation mail to the costumer
# You can enter your google API key, it seems to work also without it.
# You can setup different country codes
