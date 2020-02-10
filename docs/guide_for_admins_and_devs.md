---
layout: default
title: REDCap External Module Development for REDCap Admins and Developers
---

# REDCap External Module Development for REDCap Admins and Developers

This guide is a non-technical guide for extending the features of your REDCap with a focus on developing new modules. It provides an introduction to external modules and guidance in creating a team and plan for developing modules for one's own needs and the broader REDCap community. The audience for this guide is both REDCap Admins _and_ developers. It explains why REDCap modules are an effective means of extending REDCap. It explains how decisions made by Vanderbilt's REDCap teams and research funding modules suggest a path for module development.

If you want to _write_ a module, this guide is just the first step to understanding the work you need to do. After reading this material, developers and other aspiring module authors will want to read and do the exercises in [REDCap External Module Development for Developers](guide_for_devs).


## REDCap Extension History lesson

External Modules--referred to hereafter as simply *modules*--were introduced as a REDCap add-on in August of 2017 and formally released as part of REDCap 8.0.0 in November of 2017. Yet they are neither the first nor the only method of extending REDCap.

The first sanctioned method for extending REDCap was *plugins*. The REDCap developers introduced plugins in REDCap 4.6.0 in 2011. In REDCap, a plugin is an entirely new page in the REDCap web app. REDCap admins would often present the plugin in the left-hand sidebar via the Bookmark feature in REDCap.

REDCap 5.11.0 introduced the *hook* extension in May 2014, though that was just a rebranding of REDCap Extensions from REDCap 5.8.0, which, in turn, was a rebranding of Custom REDCap Functions from who knows when. The role of a hook is to allow custom code to modify and existing REDCap page without changing the REDCap core code. A hook is a named function which--if it exists--will be called during a page load. Typically, REDCap calls the hook function at the beginning of the page construction or the very end. Hook functions can be pure PHP, just enough PHP to load some novel JavaScript, or a mixture of PHP and JavaScript.

Hooks and plugins are relevant to modules because both concepts live on within modules. Their history influenced the module framework and Vanderbilt's rules used for developing modules. Their history also explains why they are on the way out as standalone extension methods.

Both hooks and plugins are powerful ways to modify REDCap. Some plugin and hook code was useful enough that it was shared within the REDCap community and posted to the community web site, Box.com, or in GitHub.

Yet in their original form, both hooks and plugins have issues. When they require configuration, it was generally difficult to manage. Some authors embedded configuration code in the source code of the extension. To configure those extensions, you had to have developer skills to change the configuration details before deploying the code. If the configuration details were wrong, you had to talk to the developer again, ask them to make a fix, redeploy the code, and iterate that process until the configuration is correct.

This embedded configuration made code sharing harder as well. If you wanted the latest version of the hook code, you had to apply your configuration code to that version then deploy the revised file. Even within your own systems, if your staging and production systems needed different configuration details, you couldn't use the same code on both systems.

Another configuration method was to store the configuration in a record in the redcap_log_event table. It's a little kludgy, but it worked. Yet when an extension that used log-event table method of configuration management failed, it was hard to debug and even harder to fix.

Code that was only supposed to apply to a few projects presented further challenges. The methods for managing a per-project deployment were in the hands of the developer or system admin instead of the REDCap Admin.

When hooks worked right, they worked great, but a PHP error in a hook or plugin could be unforgiving. With the *PHP errors* configuration option turned off, a production system displays nothing but an empty white screen if the code contains a PHP syntax error. A buggy plugin could be toxic to a REDCap system. Reverting the code of a buggy plugin or hook was as tedious as the deployment.

Neither hooks nor plugins were well-labeled. There was no way for your REDCap system to tell you which extensions were deployed much less which *versions* of those extensions were deployed. A particular bit of custom code might present its name or its version number clearly, but there was no convention where to show that information or system to display it.

The licensing and distribution methods for hooks and plugins were quite challenging. Almost no hooks or plugins had a license of any kind. If there were bugs in an extension and you had a fix, it wasn't clear if you had the right to redistribute the repair because there was rarely a license. As to the distribution of plugins, most developers posted them in the REDCap community. Yet some were distributed in Box while others were in repositories on GitHub. You could look up many of the extensions in the REDCap community site, but that was not reliable. It was also hard to know if you had the latest code for the extension you found in the community.

These challenges are why you should avoid using Plugins and Hooks whenever possible. Yet you probably never will have to use those extensions because the *concepts* of hooks and plugins are part of REDCap Modules, and most of the popular hook and plugins have been ported to modules.


## What is “right” about modules?

All of the bad features of the older REDCap extension methods lead us to what modules get right. Modules can be located, downloaded, enabled, and configured through the REDCap GUI by a REDCap Admin. The External Module Framework allows projects to be enabled and configured on a per-project basis. The list of enabled modules is visible in the REDCap interface. They can be disabled as easily as they were enabled.

The EM Framework requires modules have version numbers when deployed. The version numbers integrate into the module upgrade features of the Framework. The REDCap Admin can see what version number is enabled, what versions have been downloaded to the server, and what versions are ready to be enabled. The upgrade is simple. Should the new version prove flawed, the REDCap Admin can revert to the old version just as easily.

The EM framework can detect some of the more egregious coding errors, prevent the code from running, and disable the module that caused the problem. The protective features of the EM framework let the REDCap server continue normal function.

These features are possible because the External Module Framework provides an infrastructure for software extension management. It defines the rules for enabling, disabling, configuring, upgrading, downgrading, testing, and much more. It provides the interfaces the REDCap Admin sees. It defines rules modules--and their developers--must follow to integrate into those interfaces.

## REDCap Repo

Yet the EM Framework does not stand alone. Many of the features it provides are backed by the _REDCap Repo_. The REDCap Repo is a public collection of vetted REDCap modules maintained by the Vanderbilt UMC REDCap team. These modules have been submitted by the members of the REDCap community to be shared within the community. VUMC reviews module submissions and publishes those that pass inspection in the REDCap Repo.

As of January 2020, the repo contains 133 published modules. This large and growing collection is the database the EM Framework queries for module location and download. It allows the EM Framework to locate module upgrades suitable for a REDCap version and deliver them quickly and easily to the REDCap server.

The vetting process performed by the VUMC REDCap team adds value to the modules in the REDCap Repo. The review process covers the basics but also addresses some esoteric and essential details. Most importantly, for the immediate need, the module must _work_. It must enable without errors, have a meaningful title and description, and do what it claims to do. The source code for the module must be published for public review in a software repository at [GitHub.com](https://github.com), and it must have an [open source software license](https://en.wikipedia.org/wiki/Open-source_license). The software must embrace coding styles that will make it reasonably easy to support as REDCap evolves. The software should also adopt REDCap's conventions for data access and data update where practicable. The module should follow the EM Framework and software industry conventions for describing its software dependencies. The module should follow REDCap and software industry conventions for securing access to data and software features, sanitizing input, and resisting attack. The full details of the current review guidelines are at [External Modules: Module Review Guidelines](https://redcap.vanderbilt.edu/consortium/modules/external_modules_review_guidelines.pdf)

The VUMC team's vetting process is not a guarantee of quality, but it _increases_ and _enables_ quality. The guidelines have specific details software developers can follow to improve the quality of their product. The guidelines also protect a module _user's_ ability and right to review module code, provide feedback to the developer, make improvements, and publish those improvements.


## Where to find modules

The REDCap Repo contains the most popular REDCap modules. The web interface for the repo is publicly accessible at [https://redcap.vanderbilt.edu/consortium/modules/index.php](https://redcap.vanderbilt.edu/consortium/modules/index.php). The repo's interface allows you to search the database of modules and sort the search results. It provides links to each module's git repo on GitHub.com, which can give details on the state and history of the module.

The REDCap Repo is also accessible from the REDCap Control Center's _External Module_ page. While all the features of the public page are also available from the  Control Center link, the REDCap Repo will add links to download modules to the REDCap host when accessed via the Control Center.

Yet not all modules have been released via the REDCap Repo. Some are not yet ready for publication, while others were are more site or project-specific. A great deal of this development work is happening on Github. Many of those modules can be located by searching Github for specific topics the module development community has been using. Those topics--*redcap-external-module* and _redcap-repo_--can be accessed with these URLs: [https://github.com/topics/redcap-external-module](https://github.com/topics/redcap-external-module), [https://github.com/topics/redcap-repo](https://github.com/topics/redcap-repo).

If you locate a module of interest to you, you can use the [GitHub.com](https://github.com) web interface to explore the module's state and history. A README.md is the first stop to understand a module's capabilities. A CHANGELOG.md should provide a history of the module's development. The commit history can also offer a development history though it is less curated. Browse through open issues to see outstanding questions, ideas, and bugs. Look at closed issues to find corrected bugs, discarded ideas, and completed features.

If you want to install a module that is in Github but not the REDCap Repo, access the repo's _releases_ in Github to download a zipped copy of the module. In many cases, the zip file is 100% of that you need to install the module. You can download it, extract it, rename the unzipped folder with a suffix like "\_v1.0.0" using the version number of the module, then copy that whole folder to the `./modules/` folder of your REDCap server. At that point, it is ready to be enabled as if you had downloaded it from the REDCap Repo.

If you want to follow the development of a module in GitHub, you can create a GitHub account and then [_watch_](https://help.github.com/en/github/receiving-notifications-about-activity-on-github/watching-and-unwatching-repositories#watching-a-single-repository) the module. A GitHub account will also allow you to create and comment on issues for any module.

One potential point of confusion when you view a module from GitHub is that each module visible in Github is in a _git repository_, a term often shortened to _git repo_ or just _repo_. A git repo is not the same kind of repo as the REDCap Repo. They happen to share the same name.


## Contributing to modules

While this guide is ostensibly about developing modules, writing code is hardly the only way to contribute to the creation, maintenance, and quality of modules or any other software. Even a small program can generate plenty of work that is not writing code. Every program needs documentation that describes how to install, configure, and use it. Contributors should be acknowledged in the documentation. Questions about the software need to be answered. Bugs need to be written up. Feature requests need to be reviewed and improved until they make sense to everyone. Software changes need to be tested.

While you can give all of these tasks to software developers, most developers appreciate not having to do _everything_. At the same time, adding the perspective of another person to a project can significantly improve the quality.

Such contributions need not even be to your own team's project. It is easy to contribute to any project being developed publicly in GitHub. One need only create a GitHub account and start helping through the GitHub issues list on the project. Issues are the first place to pose questions, offer assistance, contribute to a discussion, or find tasks to work on. Everything else can flow from there.


## Developing your own modules

If you are going to develop modules, there are several issues to address to increase your odds of success. Someone needs to design and write the code. You will need to acquire or hire those skills. If you are hiring a developer, they will require some REDCap training. The developer's work needs to be reviewed by someone else. The reviewer needs the technical means to test the software and a good workflow for providing feedback. The software requires the right home that lends itself to software development workflows. The choice of homes for the software could be influenced by a need to share the software. Sharing software means a good license agreement will be relevant.

Ignore these details at your peril.


## Finding and training a developer

While a non-developer can make a great many contributions, if your team is going to develop modules, you will need the skills of a software developer. The developer you hire will need the right skills and training to do the job well.

At an educational institution, students in computer science, data science, or informatics programs often make good hires; other technical programs also expose their students to programming languages during data analysis.  If you have the means to hire a professional developer, do it. Professional experience will generally allow your new hire to be productive sooner than someone who has not worked with as many of the tools involved.

The right candidate for the job will be someone who can demonstrate curiosity and initiative. No one--not even the professional developer--will know everything they need to develop a REDCap module. They will need a willingness to learn REDCap both as a user and an admin while also learning enough of the REDCap code to extend it.

The technical skills needed are in JavaScript and PHP. Front-end web developers should have the required JavaScript skills. Developers with PHP skills might be harder to find than those with Javascript skills. You might have to accept a candidate who has not coded in PHP but seems able to learn.

Ask candidates if they have a public GitHub repository. Not everyone has this, but where they exist, they provide an opportunity to see the candidate's code first-hand. These repositories also demonstrate some experience with GitHub, git, and open-source software development. All of these are important for module development.

Once you have hired a developer, you will need to train them. Even the best candidates are not likely to know anything about REDCap. Train every developer as if they are to become a REDCap Admin. Have them watch all of VUMC's [REDCap training videos](https://projectredcap.org/resources/videos/). Assign them a complicated project building task or a series of tasks that will require they use all the popular features of REDCap. At the University of Florida's CTS-IT, every REDCap Admin and every REDCap developer must build a REDCap project based on Taryn Stoffs' [Practice CRFs for Training Admins](download/Practice_CRFs_for_Training_Admins.docx). This exercise uses most of the core REDCap features a REDCap admin should know.

After REDCap admin skills, every developer will need to learn REDCap *development* skills. Have your new hire read the [REDCap External Module Development Guide](https://ctsit.github.io/redcap_external_module_development_guide/) Have them build all of the exercise modules at [https://ctsit.github.io/redcap_external_module_development_guide/guide_for_devs](https://ctsit.github.io/redcap_external_module_development_guide/guide_for_devs)

Your new developer should not work alone. Connect them to the REDCap community. Sign them up for the [REDCap Community website](https://projectredcap.org/resources/community/). Introduce them to developers you know so they can feel a part of that sub-community as well. Invite them to [REDCapCon](https://projectredcap.org/about/redcapcon/).

## Finding a home for your software

Every software project needs a good home to be successful. The most foundational part of that home is _version control_. Version control software tracks the changes to files that make up a computer program, web site, documentation suite, or _anything_. It documents the history of who did what when to which files. It documents the branching and rejoining any project experiences when there are multiple authors involved.

There are multiple version control packages to choose from, but the dominant player is [_git_](https://git-scm.com/). It's high functioning, free, open-source, well-documented, works on the command line, and has multiple GUI interfaces. Git houses the software that runs the Internet. VUMC moved the REDCap code into git a few years back. They also require git for all modules submitted to the REDCap Repo.

Git stores the documents of a project in a repository or _repo_. Outwardly it looks like a folder full of files, but it contains a hidden folder that holds the entire history of the repository from creation to its current state. Every version of every file ever added to the repository is in the hidden folder. Git even preserves deleted files there. This history records who made each revision, when they made the revision and what other files changed at the same time. There's a description for each change as well. The history is immutable. You can't go back and pretend a change made two years ago didn't happen without rewriting all the history since then.

Yet git is only one dimension of finding a home for your project. While the software lives in a git repo, the repo must live somewhere as well. Such a service is called _source code hosting_. A good host for your project's repo will make it accessible to everyone who needs to get to it. The host will provide access controls to make sure the right people can read and write to the repo. The source code host offers a place to talk about the evolution of the software, see proposed changes, review them, and merge them into the master branch of the project.

One of the big players in source code hosting is [GitHub.com](https://github.com). They provide all of the above services and more on their platform--a web-based service that specializes in hosting git repositories. They offer both free and paid levels of service. The free service is well-suited to hosting open-source software projects and has captured a lot of that market.
    
VUMC requires teams to host their modules in publicly-accessible software repositories on GitHub before submitting them to be included in the REDCap Repo. The public repo allows for REDCap community members to share their work with both the VUMC REDCap team and the entire REDCap community.

Even without VUMC's requirement to use it, GitHub is still an excellent choice for hosting the development of a REDCap module or any software development project. GitHub's software enables a collaborative development process for the software and its documentation. It allows anyone to participate as a peer in the process of creating, enhancing, and maintaining a project. The service is free for public repositories, and it embraces free tools. The absence of a cost for the means of software development lowers potential barriers to entry for collaborators.

Easy paths to sharing the tools of clinical and translation research are essential. In some cases, the funding sources for REDCap teams at academic health centers in the USA require sharing the works created with that funding. Many NIH-funded projects and specifically the Clinical and Translational Science Awards (CTSAs) that fund many of the largest clinical research universities in the US require sharing of methods and products. Those requirements arguably apply to REDCap modules created at those institutions.

Yet sharing a continually evolving product can be challenging. The pace of change in software development can leave fixes untested or not shared. Using a good hosting platform makes sharing and collaboration much more straightforward. GitHub provides tools and workflows to reduce the labor of sharing and more quickly and reliably deliver the latest iteration of a software package to those who need it.


## Eat your own dog food

One impediment to reliable and quick delivery of software changes is a reluctance to embrace the product we deliver. Some teams like to use two software repositories for the same project. There is a public-facing repository that has code judged to be safe, clean, sound, and suitable for public consumption. Then there is a private repository that has the real code that gets work done for the team. The two-repository model might seem like an effective way to share one's product, but it is the very opposite. It allows the authors to claim to share their work while doing a crummy job of it.

In this all-too-common development workflow, ideas are implemented in the private repo first. The team tests and refines the designs until they work. The code might be ugly; it might have local details; it might have passwords and other secrets embedded in it. Yet all of that is considered OK because the code works.

When it's time to share the code, the developer makes it pretty; they make it configurable, take the passwords out, take out the secrets, and remove everything embarrassing and unshareable. Yet all of this takes time because it's hard to make non-portable software portable. Then someone realizes there's no documentation for the software; this adds more delays to the process of making a public release of the software.

Meanwhile, internal priorities have forced the private repo to evolve to meet local needs. The team just released the public repo, but it has already fallen behind the private repo. Changing the local deployment workflow to use the public repo would cost even more time, so it doesn't happen. The cycle repeats with minor variants with every improvement to the software.

The public repo remains a second class citizen forever. The consumers' questions annoy the developers because they have already encountered those bugs and fixed them, but only in the local version. Porting those fixes into the public repo is always extra work. It grates on the developers' nerves. They grow to hate the public code and its consumers, but they never realize they are part of the problem. The developers' masters enjoy taking credit for sharing, but, with the developers talking about the additional labor of porting the local code to the public repo, they get the impression that sharing is expensive. They question the value of sharing without ever realizing they are part of the problem. The team does not understand they are lowering the quality of what they share while increasing its cost.

The problem in this scenario is the authors of the software are not willing to use their product. In the parlance of the software industry, they are unwilling to "eat their own dog food." An author who won't use their product will never understand what is wrong with it and will never make it better.

To drive quality, the team should use the same product they share with the public. Configuration features should be baked in from the start to make the software portable. If the software is configurable from the beginning, there is no motivation to commit local configuration and secrets into the software. The test datasets the developers create to test their work should become part of the repo so other people can more rapidly test and demonstrate the software. Test datasets must not have any identifiable data. Developers should not be exposed to PHI or PII until they have shown respect for the risks it creates. If the team follows each of these rules when writing the software, the software will be ready for a public-facing repo on the day the project starts.

Yet there remains a tendency for people to think their code is not good enough to share. Nothing could be further from the truth. If the software works for the author, it is good enough to share. It might not work for the next person, but if they give feedback, the problems they encounter can help make the code better. Sharing early is always better. It makes better products. It lowers the cost of sharing.


## Working as a team

Once the coding starts, REDCap Admins and developers have to work together on the shared mission of making useful REDCap modules. Github provides excellent tools to aid that collaboration. Github has documented those tools in the [GitHub Guides](https://guides.github.com/). The most important of these is [Understanding the GitHub flow](https://guides.github.com/introduction/flow/) as it teaches the concepts behind GitHub's tools. If you don't already know _Markdown_, also read [Mastering Markdown](https://guides.github.com/features/mastering-markdown/). Markdown should be your go-to language for documenting your module from the `README.md` file to the text of Github issues and comments. Everyone--REDCap Admins and developer--should know the basics of Markdown.

A reviewer needs to inspect every change to a module. The reviewer offers a different perspective on how the software should work, whether it works, if the documentation makes sense, or if the code is unclear. A good testing workflow forces the author to commit changes into a git repo while the tester checkouts out those changes and reviews the work in a different computer without asking the author questions. This process assures the repo has all the changes the author intended and the documentation to implement those changes.

The rule about using a different computer is *extremely* important. This constraint will help the team avoid the dreaded "It works on my machine" syndrome when the module moves to production. Every member of the team can have their own "different computer" by using the [REDCap Docker Compose Environment](https://github.com/123andy/redcap-docker-compose). This software helps you build a personal REDCap on your computer. redcap-docker-compose is built on a technology called _Docker_ that allows a user to create a local REDCap host in seconds. After that, a web-based installer allows the user to install and configure a REDCap instance in about a minute. The [Developer Guide](guide_for_devs/) builds upon this environment with 
instructions for checking out a module to make it available to REDCap Docker Compose in [Setting Up Your Environment](guide_for_devs/#setting-up-your-environment).

Every developer _must_ use REDCap Docker Compose or a similar local development environment to do their development and testing. A local testing environment keeps the developer from placing a shared environment at risk. It gives them the freedom to test different REDCap versions, various PHP versions, module upgrades, module re-enabling, create test users, etc. It will also challenge the developer to not hard-code facts about the production environment into the module. A local testing environment will result in more-configurable, more portable modules that are easier to share both inside and outside the organization that wrote them.

REDCap Admins would also be well-served to use a local REDCap. It will allow them to test module revisions earlier without any risks to a shared REDCap instance. A local REDCap for the REDCap Admin is crucial if there is only one developer on the team. _Someone_ needs to run the first _local_ test of the code.

Wherever they test, REDCap Admins must check the new module before they install it in production. They will have the best perspective on how the module will integrate into the typical REDCap workflows. They will be the person who has to enable the module and configure it in production. If the admin is not the end-user of the new module's features, they will at least be explaining and documenting it for the REDCap users. The REDCap Admin will bear the burden of any failings in the module.


## Sharing your work

Sharing is caring
    CTSA funding begs for it
    It’s not automatic
Open source licenses
    Freedom to use, reuse, and adapt
    Protection from my apathy, reassignment, retirement, death, etc.
    Assurance that your business is not at risk
    Eases collaboration
    Vandy requires you use an open-source license for submitting to the REDCap Repo.
Releasing/publishing modules - the workflow
    Make a release
    Deploy it locally
    Test it locally in prod.
    Publish it in the REDCap repo
    https://redcap.vanderbilt.edu/consortium/modules/index.php
Get DOI
    Git repos and Zenodo
    Figshare


## Talk about your work

The hard work invested in making a module useful, portable, and impressive might seem wasted if no one but you ever uses it. It's essential to promote your work in the REDCap community so that other REDCap Admins know there is a tool that solves a problem they might also have. By telling the REDCap Community about the modules you have developed and the ideas you have for new and existing modules, you help REDCap administrators and module developers at other sites know the tools available to them. REDCap admins might want the new feature your module adds. Module developers might see that your module has code that would help them solve a related problem. You could even find collaborators for your work who are willing to share ideas, test code, write up bugs, and promote your work. The REDCap Community is rich with subject matter experts not only on REDCap but on clinical research, data collection, survey design, and human factors. They can provide valuable insight and a different perspective on how end-users will view your work.

The promotion of your work can talk a few forms. You can share new ideas, new modules, and new module features with the [REDCap Community](http://community.projectredcap.org/). Anyone who is a member of the REDCap Community can create a post on the REDCap Community website. The post will be visible to all the registered members. You can create a post that lets other developers and admins know what you're working on, or to solicit feedback and collaboration on the module.

The REDCap Friday call provides a forum to do a talk about your work and demonstrate it to the community. This call reaches an average live audience of 90 REDCap admins world-wide. It is the most visible way to advertise and show your work. It also allows other community members to ask questions and suggest features that your team may not have thought of.

The annual REDCap conference provides another way to reach the REDCap community. Each year the conference attracts over 400 REDCap Admins, developers, and leaders in the REDCap community. It offers opportunities to engage in face-to-face conversations about your work, solicit ideas, and meet collaborators. A poster presentation is a great way to start a dialog about your work and meet people who are interested in it.
