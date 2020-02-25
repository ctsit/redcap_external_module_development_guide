# REDCap External Module Development Guide

[![DOI](https://zenodo.org/badge/223246066.svg)](https://zenodo.org/badge/latestdoi/223246066)

The REDCap External Module Development Guide is a guide to the development of software extensions to Vanderbilt University's Research Electronic Data CAPture (REDCap) using REDCap's External Module framework. Added to REDCap in the Fall of 2017, the external module framework has proven to be an effective and popular way to change REDCap's behavior to meet the needs of specific sites and projects. This guide provides an introduction to external modules and guidance in creating a team and plan for developing modules for one's own needs and the broader REDCap community.

This software repository contains the source documents to render the Guide into a website use Jekyll. That web site is accessible at [https://ctsit.github.io/redcap\_external\_module\_development\_guide/](https://ctsit.github.io/redcap_external_module_development_guide/). This repository also contains the coding exercises referenced in the guide.

## How is this web site managed?

The web site is rendered via [Jekyll](jekyllrb.com), a static website generator. It is based on Github's [Minimal](https://github.com/pages-themes/minimal) Jekyll theme. It's hosted by Github using their GitHub Pages feature. This combination makes for an extremely simple, zero-cost website.

Managing a Jekyll web site requires skills common amongst software developers. If you have that skill set or have a volunteer who does, such a web site is cheap and secure. If you are non-technical, you can learn this too.


## Sharing

All of the content for this web site is available under the Apache 2.0. See [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0) for more details.


## Site Development

If you would like to manage this web site, you will need to some software tools on your computer and some technical skills to manage them. This is your 10 cent tour.


### Prerequisites

Install these tools on your computer.

* Any git client - [Github Desktop](https://desktop.github.com/) is good and it provides easy integration with GitHub's service where this repository lives.

* Jekyll - The [Jekyll Quickstart](https://jekyllrb.com/docs/) guide provides installation instructions for Jekyll and its prereqs.


### Recommended training

You'll be well-served to read the [Getting started](https://jekyllrb.com/docs/) section of the Jekyll docs. You won't have to create the web site, as one is provided in the GitHub repo, but the concepts described in the tutorial will help you understand what Jekyll will do with the changes you make to the files in the repo and how those will become part of the web site.


### Setup

Once the software is installed, clone the git repo at [https://github.com/ctsit/redcap_external_module_development_guide](https://github.com/ctsit/redcap_external_module_development_guide). `cd` into the cloned repo, then `cd` in the `docs` folder, and run `script/serve.sh`. That script will run Jekyll in dev mode, use `_config_local.yaml` if it exists, and serve the content it creates at [localhost:4000](http://localhost:4000).

Access the web site to verify it works before you make any changes.
