---
layout: default
title: REDCap External Module Development for Developers
---

# REDCap External Module Development for Developers

This guide provides the technical background developers need to write and test module code. It describes the REDCap classes and resources that simplify module development. This guide has recommendations for reference materials and tools to aid in module development and a series of exercises to create simple modules that extend REDCap in different ways.

## Reference Materials

### REDCap Training Videos

You must understand how to use REDCap before trying to develop modules for it. Vanderbilt provides a series of videos that provide basic training in how to use REDCap to create and administer instruments and surveys. See [https://projectredcap.org/resources/videos/](https://projectredcap.org/resources/videos/)

The University of Colorado Denver has created a series of videos that address more advanced topics. You can access all of those videos at their [YouTube Playlist](https://www.youtube.com/playlist?list=PLrnf34ZtZ9FpHcZyZuNnNFZ9cEbhijNGf).


### Vanderbilt's External Module Documentation

You will likely find it helpful to keep Vanderbilt's [official External Module documentation](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md) available while completing these exercises; this document will link relevant sections for review.


### REDCap Repo

Vanderbilt publishes modules submitted by the REDCap Community in the [REDCap Repo](https://redcap.vanderbilt.edu/consortium/modules/index.php). The source code for each module is accessible in GitHub and linked from the entries in the REDCap Repo. These modules provide fully functional code examples. As each module in the REDCap Repo must have an open-source license, you are free to use their code in other modules.


### GitHub

Beyond those in the REDCap Repo, [GitHub](https://github.com) is commonly used by developers in the REDCap community to host and share modules. Many module developers tag their modules with the topic 'redcap-external-module'. This shared topic allows you to find them with a [GitHub topic search](https://github.com/search?q=topic%3Aredcap-external-module&type=Repositories)


## Setting Up Your Environment
Read the section of the official documentation on [naming a module](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#naming-a-module). You should copy the contents of this directory to the `modules` directory of your REDCap instance. Assuming you are using Andy Martin's [redcap-docker-compose environment](https://github.com/123andy/redcap-docker-compose), the modules directory is located at `www/modules/`.  
Please note that - except for **Hello World** - you will need to mark the [semantic version](https://semver.org/) of each module - in short, you will need to append `_v0.0.0` to each directory - for the EM Framework to recognize it is a module. These are intentionally left off to simulate having just `git clone`d a module from a public repository. Public repositories should _not_ have semantic versions in their titles. REDCap uses the directory name to determine module versions. As such, each version will have a separate directory. Use `git tag`s to apply version numbers to the appropriate commit.


## External Module Development Exercises

The External Module Development Guide includes a set of [development exercises](https://github.com/ctsit/redcap_external_module_development_guide/exercises/) to use as a guide for module development. Each activity teaches a different facet of module development. Most of the modules are intentionally incomplete. They generally have comments denoting regions where you will need to add code to implement a missing feature.

---

### [Hello World]({{ site.repo_root }}exercises/hello_world_v0.0.0/)
This is a "complete" module intended to be used to make sure your development pipeline is set up properly.

Read the section on [module requirements](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#module-requirement) until the section on hooks.

---

### [Hello Hook]({{ site.repo_root }}exercises/intro_to_hooks/)

This module serves as an introduction to hooks. You will learn how to utilize hook functions to run arbitrary code - in this case, a small bit of JavaScript that displays an alert. While you will not be _writing_ any JavaScript for this portion, you will see how to load in JavaScript files, and how to expose backend variables to the frontend.

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

This module teaches best practices when including JavaScript in your External Modules. It also introduces the use of the REDCap core class, `RCView`. The source for this class is located in the root of your REDCap folder at `Classes/RCView.php`. Note that while clever use of an `onclick` attribute might allow you to complete this module, the purpose is to work with a separate JavaScript file.

Read [the official documentation on module functions, specifically `getUrl`](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/framework/v3.md). You might also find it helpful to refer to previous exercises for examples of JavaScript use.

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

This module introduces the use of plugins. The provided module already has a plugin page available for admins in the Control Center; the goal of this exercise is to add a second plugin page accessible _at the project level_. Unlike other modules, you will need to create an entirely new PHP file for this project, referring to `pages/control_center_custom_page.php` should be useful.

Read [the official documentation on creating plugin pages](https://github.com/vanderbilt/redcap-external-modules/blob/testing/docs/official-documentation.md#how-to-create-plugin-pages-for-your-module).

Plugins appear as links in the left-hand menu. The EM framework allows you to decorate the links with icons set in a `link` object under `config.json`. In framework version >= 3, you have access to [Font Awesome](https://fontawesome.com/icons?d=gallery) icons.  
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
