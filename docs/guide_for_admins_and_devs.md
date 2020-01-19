---
layout: default
title: REDCap External Module Development for REDCap Admins and Developers
---

# REDCap External Module Development for REDCap Admins and Developers

This guide is a non-technical guide for extending the features of your REDCap with a focus on developing new modules. It provides an introduction to external modules and guidance in creating a team and plan for developing modules for one’s own needs and the larger REDCap community. The audience for this guide is both REDCap Admins _and_ developers. It explains why REDCap modules are an effective means of extending REDCap. It explains how decisions made by Vanderbilt's REDCap teams and research aims shape the how module development should be managed. 

If you actually want to _write_ a module, this guide is just the first step to understanding the work that needs to be done. After reading this material, developers and other aspiring module authors will want to read and do the exercises in [REDCap External Module Development for Developers](guide_for_devs).


## REDCap Extension History lesson

External Modules--referred to hereafter as simply _modules_--were introduced as a REDCap add-on in August of 2017 and formally released as part of REDCap 8.0.0 in November of 2017. Yet they are neither the first nor the only method of extending REDCap.

The first sanctioned method for extending REDCap was _plugins_. Plugins were introduced in REDCap 4.6.0 in 2011. In REDCap, a plugin is an entirely novel page in the REDCap web app. This new page was often presented in the left hand side bar via the Bookmark feature in REDCap.

REDCap 5.11.0 introduced the _hook_ extension in May 2014, though that was just a rebranding of REDCap Extensions from REDCap 5.8.0, which, in turn, was a rebranding of Custom REDCap Functions from who knows when. Ignoring all that history, the role of a hook is to allow an existing REDCap page to be modified without changing REDCap core code. A hook is a named function which--if it exists--will be called during a page load. Typically, the hook function will be called at the beginning of the page construction or the very end. Hook functions can be pure PHP, just enough PHP to load some novel JavaScript, or a mixture of PHP and JavaScript.

Hooks and plugins are relevant to modules because both concepts live on within modules. Their history is relevant as it influenced the module framework and Vanderbilt's rules used for developing modules. Their history also explains why they are on the way out as standalone extension methods.

Both hooks and plugins are powerful ways to modify REDCap. Some plugin and hook code was useful enough that it was shared within the REDCap community and posted to the community web site, Box.com, or in GitHub.

Yet in their original form, both hooks and plugins have issues. When they require configuration, it was generally difficult to manage. Some were written with configuration code embedded in the source code. To configure those, you had to have basic developer skills--or a developer--to change the lines of code that held the configuration details, then deploy the code. If the configuration details were wrong, talk to the developer again, ask them to make a fix, redeploy the code, and iterate that process until the configuration is correct.

This embedded configuration made code sharing harder. If you wanted the new version of the hook code you had to apply your configuration code to the new code then deploy that. Even within your own systems, if your staging and production systems needed different configuration details you couldn't use the same code on both systems.

Another configuration method was to store the configuration in a record in the redcap_log_event table. It's a little kludgy, but it worked. Yet when an extension that used log-event table method of configuration management failed, it was hard to debug and even harder to fix.

Code that was only supposed to be applied to a few projects presented further challenges. The methods for managing a per-project deployment were in the hands of the developer or system admin instead of the REDCap Admin.

When hooks worked right, they work great, but a PHP error in a hook or plugin can be unforgiving. With _PHP errors_ configuration option  turned off, a production system displays nothing but an empty white screen if the code contains a PHP syntax error. A buggy plugin could be toxic to a REDCap system. Reverting the code of a buggy plugin or hook was as tedious as the deployment.

Neither hooks nor plugins were well-labeled. There was no way for your REDCap system to tell you which extensions were deployed much less which _versions_ of those extensions were deployed. A particular bit of custom code might present its name or its version number clearly, but there was no convention where to present that information or system to present it.

The licensing and distribution methods for hooks and plugins were quite challenging. Almost no hooks or plugins had a license of any kind. If there were bugs in an extension and you had a fix, it wasn't clear if you had the right to redistribute the fix because there was almost never a license. As to the distribution of plugins, most were posted in the REDCap community. Yet some were distributed in Box while others were in repos on GitHub. You could look up many of the extensions in the REDCap community site, but that was not reliable. It was also hard to know if you had the latest code for the extension you found in the community.

These challenges are why you should avoid using Plugins and Hooks whenever possible. Yet you probably never will have to use those extensions because the _concepts_ of hooks and plugins are part of REDCap Modules and most of the popular hook and plugins have been ported to modules.


## What is “right” about modules?

All of the bad features of the older REDCap extension methods lead us to what modules get right. Modules can be located, downloaded, enabled and configured through the REDCap GUI by a REDCap Admin. The External Module Framework allows projects to be enabled and configured on a per-project basis. The list of enabled modules is visible in the REDCap interface. They can be disabled as easily as they were enabled.

The EM Framework requires modules have versions numbers when deployed. The version numbers integrate into the module upgrade features of the Framework. The REDCap Admin can see what version number is enabled, what versions have been downloaded to the server and what versions are ready to be enabled. The upgrade is simple. Should the new version prove flawed, the REDCap Admin can revert to the old version just as easily.

The EM framework can detect the some of the more egreious coding errors, prevent the code from running, and disable the module that caused the problem. This lets the REDCap server continue normal function.

These features are possible because the External Module Framework provides an infrastructure for software extension management. The EM Framework was designed to address the many management issues software extensions can create. It provides the rules for enabling, disabling, configuring, upgrading, downgrading, testing, and much more. It provides the interfaces the REDCap Admin sees. It defines rules modules--and their developers--must follow to integrate into those interfaces.

## REDCap Repo

Yet the EM Framework does not stand alone. Many of the features it provides are backed by the _REDCap Repo_. The REDCap Repo is a public collection of vetted REDCap modules maintained by the Vanderbilt UMC REDCap team. These modules have been submitted by the members of the REDCap community to be sharing within the community. VUMC reviews module submissions and publishes those that pass review in the REDCap Repo.

As of January 2020, the repo contains 133 published modules. This large and growing collection is the database the EM Framework queries for module location and download. It allows the EM Framework to locate module upgrades suitable for a REDCap version and deliver them quickly and easily to the REDCap server.

The vetting process performed by the VUMC REDCap team adds value to the modules in the REDCap Repo. The review process covers the basics but also addresses some esoteric and import details. Most important for the immediate need, the module must _work_. It must enable without errors, have a meaningful title and description, and do what it claims to do. The source code for the module must be published for public review in a software repository at [GitHub.com](https://github.com) and it must have an [open source software license](https://en.wikipedia.org/wiki/Open-source_license). The software must embrace coding styles that will make it reasonably easy to support as REDCap evolves. The software should also embrace REDCap's conventions for data access and data update where practicable. The module should follow EM Framework and software industry conventions for describing its software dependencies. The module should follow REDCap and software industry conventions for securing access to data and software features, sanitizing input, and resisting attack. The full details of the current review guidelines can be found at [External Modules: Module Review Guidelines](https://redcap.vanderbilt.edu/consortium/modules/external_modules_review_guidelines.pdf)

The VUMC team's vetting process should never be considered a guarantee of quality, but it definitely _increases_ and _enables_ quality. The  guidelines have specific details software developers can follow to improve the quality of their product. The guidelines also protect a module user's ability and right to do their own code review, provide feedback, make improvements, and publish those improvements.
