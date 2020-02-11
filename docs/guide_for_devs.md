---
layout: default
title: REDCap External Module Development for Developers
---

# REDCap External Module Development for Developers

This guide provides the technical background developers need to write and test module code. It describes the REDCap classes and resources that simplify module development. This guide has recommendations for reference materials and tools to aid in module development and a series of exercises to create simple modules that extend REDCap in different ways.

## Reference Materials

### REDCap Training Videos

It's essential that you understand how to use REDCap before trying to develop modules for it. Vanderbilt provides a series of videos that provide basic training in how to use REDCap to create and administer instruments and surveys. See [https://projectredcap.org/resources/videos/](https://projectredcap.org/resources/videos/)

The University of Colorado Denver has created a series of videos that address more advanced topics. You can access all of those videos at their [YouTube Playlist](https://www.youtube.com/playlist?list=PLrnf34ZtZ9FpHcZyZuNnNFZ9cEbhijNGf).


### Vanderbilt's External Module Documentation

You will likely find it helpful to keep Vanderbilt's [official External Module documentation](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md) available while completing these exercises; this document will link relevant sections for review.


### REDCap Repo

Vanderbilt publishes modules submitted by the REDCap Community in the [REDCap Repo](https://redcap.vanderbilt.edu/consortium/modules/index.php). The source code for each of these modules is accessible in GitHub and linked from the entries in the REDCap Repo. These modules provide fully functional code examples. As each module in the REDCap Repo is required to have an open source license, their code can be used in other modules.


### GitHub

Beyond those in the REDCap Repo, [GitHub](https://github.com) is commonly used by developers in the REDCap community to host and share modules. Many of these modules are tagged with the topic 'redcap-external-module' and can be located with a [GitHub topic search](https://github.com/search?q=topic%3Aredcap-external-module&type=Repositories)


## Setting Up Your Environment
Read the section of the official documentation on [naming a module](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#naming-a-module). You should copy the contents of this directory to the `modules` directory of your REDCap instance. Assuming you are using Andy Martin's [redcap-docker-compose environment](https://github.com/123andy/redcap-docker-compose), the modules directory is located at `www/modules/`.  
Please note that - with the exception of **Hello World** - you will need to mark the [semantic version](https://semver.org/) of each module - in short, you will need to append `_v0.0.0` to each directory - for it to be recognized by REDCap. These are intentionally left off to simulate having just `git clone`d a module from a public repository. Public repositories should _not_ have semantic versions in their titles. REDCap uses the directory name to determine module versions, each version will have its own directory, you should use `git tag`s and releases.


## External Module Development Exercises

The External Module Development Guide includes a set of [development exercises](https://github.com/ctsit/redcap_external_module_development_guide/exercises/) to use as a guide for module development. Each exercise teaches a different facet of module development. The majority of the exercises are missing essential functionality with comments denoting the regions where the functionality should be added.

---

### [Hello World]({{ site.repo_root }}exercises/hello_world_v0.0.0/)
This is a "complete" module intended to be used to make sure your development pipeline is set up properly.

Read the section on [module requirements](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#module-requirement) until the section on hooks.

---

### [Hello Hook]({{ site.repo_root }}exercises/intro_to_hooks/)

This module serves as an introduction to hooks. You will learn how to utilise hook functions to run arbitrary code - in this case, a small bit of JavaScript that displays an alert. While you will not be _writing_ any JavaScript for this portion, you will see how to load in JavaScript files, and how to expose backend variables to the frontend.

Read [the official documentation on calling hooks](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#how-to-call-redcap-hooks).

<details>
<summary>Example Solution
</summary>

`ExternalModule.php`
```php
    // FIXME
    /* Write your code here */
    function redcap_every_page_top($project_id) {
    /* Stop writing code here */
        $this->includeJs('js/hello_hook.js');
```

`config.json`
```json
    "permissions": [
        "redcap_every_page_top"
    ],
```

</details>
<br />

---

### [Intro JS]({{ site.repo_root }}exercises/intro_to_js/)

This module is intended to be used to teach best practices when including JavaScript in your External Modules. It also introduces the use of the REDCap core class, `RCView`; the source for this class is located in the root of your REDCap folder at `Classes/RCView.php` (while clever use of an `onclick` attribute may allow you to complete this module, the purpose is to work with a separate JavaScript file).

Read [the official documentation on module functions, specifically `getUrl`](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/framework/v3.md). You may also find it helpful to refer to previous exercises where JavaScript was used.

While this module does not use any variables, note that when working with JavaScript it is [recommended to scope the variables within an object](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#javascript-recommendations). Two sample helper functions to accomplish this goal in PHP are written below.

```php
    protected function setJsSettings($settings) {
        echo '<script>myModuleName = ' . json_encode($settings) . ';</script>';
    }

    // Recall that you must instantiate an empty JS object prior to the first call of this function, i.e.
    // echo '<script>myModuleName = {};</script>';
    protected function setSingleJsSetting($key, $value) {
        echo "<script>myModuleName." . $key . " = " . json_encode($value) . ";</script>";
    }
```

<details>
<summary>Example Solution
</summary>

`ExternalModule.php`
```php
        // FIXME
        // include a JavaScript file that increments the contents of incrementValue
        // upon clicking the incrementButton
        /* write your code below */
        $this->includeJs('js/intro.js');
    }

    protected function includeJs($file) {
        // Use this function to use your JavaScript files in the frontend
        echo '<script src="' . $this->getUrl($file) . '"></script>';
    }
```

`js/intro.js`
```javascript
$( document ).ready(function() {
    /* Write your code below */
    $('#incrementButton').click(function() {
        increase();
    });
});

/* If you wish, make a function */
function increase() {
    let inc = $('#incrementValue').text();
    $('#incrementValue').text(++inc);
}
```

</details>
<br />

---

### [Hello Plugin]({{ site.repo_root }}exercises/intro_to_plugins/)

This module introduces the use of plugins. The provided module already has a plugin page available for admins in the Control Center; the goal of this exercise is to add an additional plugin page accessible _at the project level_. Unlike other modules, you will need to create an entirely new PHP file for this project, referring to `pages/control_center_custom_page.php` should be useful.

Read [the official documentation on creating plugin pages](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#how-to-create-plugin-pages-for-your-module).

Plugins appear as links in the left-hand menu. These links can be decorated with icons set in a `link` object under `config.json`. In framework version >= 3, you have access to [Font Awesome](https://fontawesome.com/icons?d=gallery) icons.  
When assigning Font Awesome icons, the entry will appear as follows: `fa<style> fa-<icon_name>`, where available `<style>`s are:
- s: solid
- r: regular
- l: light
- d: duotone

<details>
<summary>Example Solution
</summary>

`config.json`
```json
   "links": {
      "control-center": [
         {
            "name": "Hello Admin",
            "icon": "fas fa-globe",
            "url": "pages/control_center_custom_page.php"
         }
      ],
      "project": [
         {
            "name": "Hello Project",
            "icon": "fas hand-paper",
            "url": "pages/project_custom_page.php"
         }
      ]
   }
```

`pages/project_custom_page.php`
```php
<?php
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';

$title = RCView::img(['src' => APP_PATH_IMAGES . 'bell.png']) . ' ' . REDCap::escapeHtml('Control Center Page');
echo RCView::h4([], $title);

$module->sayHello();

require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';
```

Don't forget to update docs when you add new features!  
`README.md`
```markdown
Provides pages that say "Hello, world" in the control center and in projects.
```

</details>
<br />

---

### [Accessing Variables]({{ site.repo_root }}exercises/accessing_variables/)

While working on this module, you will learn how to access constants and variables defined by REDCap. You will also cover using `project-settings` to allow users to set variables and accessing those variables.

You may display this via a hook or a project plugin page.

The goal of this exercise is to create a module that displays a user's:
1. Username
1. Admin (aka superuser) status
1. Their user rights
1. The current page path
1. The current project's `project_id`
1. The value of a variable set in the module's configuration menu

Check the [official External Module documentation on functions](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/framework/intro.md) for functions which provide this information for you. Useful phrases to search for are "User" and "projectSetting".

Note that there is an unlisted property of the [`User` object](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/framework/intro.md#user-method) that you will need: 

```php
$User = $this->framework->getUser();
$User->username;
```

If your programming environment has a debugger available, you can use it to see the accessible constants. If you do not have a debugger or cannot connect it to your REDCap docker container, please view the list below. Note that most of these are available as functions.  
<details>
<summary>Useful global constants
</summary>

- **PAGE**: The current loaded file and its path with the root being the active REDCap folder, (root being, i.e. `redcap_v9.3.5/`); this is the only constant listed that is not easily determined by a function
- **PROJECT_ID**: The numerical ID of the project being viewed
- **USERID**: The username of the user viewing the page
- **SUPER_USER**: A boolean integer indication if the user from **USERID** has admin privileges

</details>
<br />

As before, documentation _must_ be updated when introducing features. This is even more important when adding functionality that users interact with (e.g. an entry in `project-settings` in the `config.json`)!

<details>
<summary>Example Solution Via a Hook
</summary>

Note that this is a _bare minimum_ implementation; because the goal of this exercise is to find out how to access the variables needed, this solution only aims to show how to access those variables. When displaying information to users, you should _not_ use basic functions like `print_r` (unless the contents will be showing up in the body of a plugin page).  
`ExternalModule.php`
```php
    //FIXME: Write and use functions to show users pertinent information
    function redcap_every_page_top() {
        $this->displayVars();
    }

    function displayVars() {
        print_r("<pre>"); // Wrap the display area in <pre> tag for formatting

        $userobj = $this->framework->getUser();

        print_r("Username: " . $userobj->username . "\n");
        print_r("You are " . ( ($userobj->isSuperUser()) ? "" : "not " ) . "a superuser.\n");
        print_r("Your user rights: \n");
        var_dump($userobj->getRights());

        print_r("Page path: " . PAGE . "\n");
        print_r("Project ID: " . $this->framework->getProjectId() . "\n"); // Display project ID via framework function
        // OR
        //print_r("Project ID: " . PROJECT_ID . "\n"); // Display project ID via constant
        print_r("Custom Setting: " . $this->framework->getProjectSetting('custom_setting'));

        print_r("</pre>");
    }
```

`config.json`
```json
    "permissions": [
        "redcap_every_page_top"
    ],
    "project-settings": [
        {
            "key": "custom_setting",
            "name": "Custom Setting",
            "type": "text"
        }
    ]
```

An unordered list is a great way to explain simple options to users.  
`README.md`
```markdown
Displays information relevant to users, including their user permissions and location in REDCap.

...

## Project Configuration
- **Custom Setting**: A message that will be displayed along with other information

```

</details>
<br />
