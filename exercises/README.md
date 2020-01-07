# External Module Development Exercises

This directory contains test modules to use as a guide for module development. The majority of them are missing essential functionality, the regions where you need to introduce this functionality are cordoned off with comments.  

## Preface

### Reference Materials
You will likely find it helpful to keep Vanderbilt's [official External Module documentation](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md) available while completing these exercises; this document will link relevant sections for review.

### Setting Up Your Environment
Read the section of the official documentation on [naming a module](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#naming-a-module).  
You should copy the contents of this directory to the `modules` directory of your REDCap instance. Assuming you are using a [Docker environment](https://github.com/123andy/redcap-docker-compose), the modules directory is located at `www/modules/`.  
Please note that - with the exception of **Hello World** - you will need to mark the [semantic version](https://semver.org/) of each module - in short, you will need to append `_v0.0.0` to each directory - for it to be recognized by REDCap. These are intentionally left off to simulate having just `git clone`d a module from a public repository. Public repositories should _not_ have semantic versions in their titles. REDCap uses the directory name to determine module versions, each version will have its own directory, you should use `git tag`s and releases.

## Modules

### Hello World
This is a "complete" module intended to be used to make sure your development pipeline is set up properly.

Read the section on [module requirements](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#module-requirement) until the section on hooks.

### Hello Hook

Read [the official documentation on calling hooks](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#how-to-call-redcap-hooks).
