---
layout: default
title: REDCap External Module Development for Developers
---

# REDCap External Module Development for Developers

This guide provides the technical background developers need to write and test module code. It describes the REDCap classes and resources that simplify module development. This guide has recommendations for reference materials and tools to aid in module development and a series of exercises to create simple modules that extend REDCap in different ways.

## Reference Materials

### REDCap Training Videos

It's essential that you understand how to use REDCap before trying to develop modules for it. Vanderbilt provides a series of videos that provide basic training in how to use REDCap to create and administer instruments and surveys. See [https://projectredcap.org/resources/videos/](https://projectredcap.org/resources/videos/)

The University of Colorado Denver has created a series of videos that address more advanced topics. You can access all of those videos at their [Youtube Playlist](https://www.youtube.com/playlist?list=PLrnf34ZtZ9FpHcZyZuNnNFZ9cEbhijNGf).


### Vanderbilt's External Module Documentation

You will likely find it helpful to keep Vanderbilt's [official External Module documentation](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md) available while completing these exercises; this document will link relevant sections for review.


### REDCap Repo 

Vanderbilt publishes modules submitted by the REDCap Community in the [REDCap Repo](https://redcap.vanderbilt.edu/consortium/modules/index.php). The source code for each of these modules is accessible in Github and linked from the entries in the REDCap Repo. These modules provide fully functional code examples. As each module in the REDCap Repo is required to have an open source license, their code can be used in other modules. 


### Github

Beyond those in the REDCap Repo, Github.com is commonly used by developers in the REDCap community to host and share modules. Many of these modules are tagged with the topic 'redcap-external-module' and can be located with a [Github topic search](https://github.com/search?q=topic%3Aredcap-external-module&type=Repositories)


## Setting Up Your Environment
Read the section of the official documentation on [naming a module](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#naming-a-module). You should copy the contents of this directory to the `modules` directory of your REDCap instance. Assuming you are using Andy Martin's [redcap-docker-compose environment](https://github.com/123andy/redcap-docker-compose), the modules directory is located at `www/modules/`.  
Please note that - with the exception of **Hello World** - you will need to mark the [semantic version](https://semver.org/) of each module - in short, you will need to append `_v0.0.0` to each directory - for it to be recognized by REDCap. These are intentionally left off to simulate having just `git clone`d a module from a public repository. Public repositories should _not_ have semantic versions in their titles. REDCap uses the directory name to determine module versions, each version will have its own directory, you should use `git tag`s and releases.


## External Module Development Exercises

The External Module Development Guide includes a set of [development exercises](https://github.com/ctsit/redcap_external_module_development_guide/exercises/) to use as a guide for module development. Each exercise teaches a different facet of module development. The majority of the exercises are missing essential functionality with comments denoting the regions where the functionality should be added.

### Hello World
This is a "complete" module intended to be used to make sure your development pipeline is set up properly.

Read the section on [module requirements](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#module-requirement) until the section on hooks.

### Hello Hook

Read [the official documentation on calling hooks](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#how-to-call-redcap-hooks).
