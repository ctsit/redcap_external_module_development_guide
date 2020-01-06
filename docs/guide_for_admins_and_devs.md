---
layout: default
title: REDCap External Module Development for REDCap Admins and Developers
---

# REDCap External Module Development for REDCap Admins and Developers

This guide is a non-technical guide for extending the features of your REDCap with a focus on developing new modules. It provides an introduction to external modules and guidance in creating a team and plan for developing modules for one’s own needs and the larger REDCap community. The audience for this guide is both REDCap Admins _and_ developers. It explains why REDCap modules are an effective means of extending REDCap. It explains how decisions made by Vanderbilt's REDCap teams and research aims shape the how module development should be managed. 

If you actually want to _write_ a module, this guide is just the first step to understanding the work that needs to be done. After reading this material, developers and other aspiring module authors will want to read and do the exercises in [REDCap External Module Development for Developers](guide_for_devs/).


## REDCap Extension History lesson

External Modules--referred to hereafter as simply _modules_--are neither the first nor the only method of extending REDCap. The first sanctioned method for extending REDCap was _plugins_. Plugins were introduced in REDCap 4.6.0 in 2011. In REDCap, a plugin is an entirely novel page in the REDCap web app. This new page was often presented in the left hand side bar via the Bookmark feature in REDCap.

Hooks were introduced in May 2014 in REDCap 5.11.0 though that was just a rebranding of REDCap Extensions from REDCap 5.8.0, which, in turn, was a rebranding of Custom REDCap Functions from who knows when. Ignoring all that history, the role of a hoook is to allow an existing REDCap page to be modified without changing REDCap core code. A hook is a named function which--if it exists--will be called during a page load. Typically, the hook function will be called at the beginning of the page construction or the very end. Hook functions can be pure PHP, just enough PHP to load some novel Javascript, or a mixture of PHP and Javascript.

Both hooks and functions are (were?) powerful ways to modify REDCap. Some plugin and hook code was useful enough that it was shared within the REDCap community and posted to the community web site, Box.com, or in Github.

Yet in their original form, both hooks and plugins have issues. When they require configuration, it is generally difficult to manage. Some were written with configuration code embedded in the source code. To configure those, you had to have basic developer skills to change the lines of code that held the configuration details, then deploy the code. If the configuration details were wrong, talk to the developer again, get a fix, then redeploy the code.

This embedded configuration made code sharing harder. If you wanted the new version of the hook code you had to apply your configuration code to the new code then deploy that. Even within your own systems, if your staging and production systems needed different configuration details you couldn't use the same code on both systems.

Another configuration method was to store the configuration in a record in the redcap_log_event table. It's a little kludgy, but it works. Yet when an extension that uses log-event table method of configuration management fails, it's hard to debug and even harder to fix.

Code that was only supposed to be applied to a few projects presented further challenges. The methods for managing a per-project deployment were in the hands of the developer or system admin instead of the REDCap Admin.

When hooks are working right, they work great, but a PHP error in a hook or plugin can be unforgiving. With PHP errors turned off, a production system displays nothing but an empty white screen if the code contains a PHP syntax error. A buggy plugin could be toxic to a REDCap system. Reverting the code of a buggy plugin or hook is as tedious as a deployment.

Neither hooks nor plugins were well-labeled. There was no way for your REDCap system to tell you which extensions were deployed much less which _versions_ of those extensions were deployed. A particular bit of custom code might present its name or its version number clearly, but there was no convention where to present that information or system to present it.

The licensing and distribution methods for hooks and plugins were quite challenging. Almost no hooks or plugins had a license of any kind. If there were bugs in an extension and you had a fix, it wasn't clear if you had the right to redistribute the fix because there was no license. As to the distribution of plugins, most were posted on in the REDCap community. Yet some were distributed in Box while others were in repos on GitHub. You could look up many of the extensions in the REDCap community site, but that was not reliable. It was also hard to know if you had the latest code for the extension you found in the community.

These challenges are why you should avoid using Plugins and Hooks whenever possible. Yet you probably never will have to use those extensions as the _concepts_ of hooks and plugins are part of REDCap Modules and most of the popular hook and plugins have been ported to modules.
