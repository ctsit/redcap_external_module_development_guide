# REDCap Development Class

These instructions were drafted for the UAMS REDCap Development Class. 

## Required Resources
- Laptop
- Admin rights to that laptop
- Slack client
- Github account - [https://github.com/](https://github.com/)
- Github Desktop - [https://desktop.github.com/](https://desktop.github.com/)
- Docker and Docker Compose
    - Mac and Windows users get Docker Desktop - [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)
- A little experience with docker and docker-compose
- Redcap-docker-compose - A docker environment tailored for running and developing for REDCap. See [https://github.com/123andy/redcap-docker-compose](https://github.com/123andy/redcap-docker-compose)
- redcap9.3.5.zip - Ask your local REDCap Admin for `redcap9.3.5.zip` downloaded from the REDCap Community. If you _are_ that REDCap Admin with access to the community, the download link is [https://community.projectredcap.org/page/download.html](https://community.projectredcap.org/page/download.html).
- Text editor or PHP IDE - VS Code, PHPStorm, or Atom are good.
- Firefox or Chrome - we will be using the developer tools


## Pre-req Setup Tasks

- Accept slack invite in your email inbox
- Set Slack password for our workspace
- Keep [https://uf-and-uams.slack.com](https://uf-and-uams.slack.com) open
- (Philip will send this list of instructions via our Slack workspace so you can click on the links. No transcription required.)
- Install [https://code.visualstudio.com/Download](https://code.visualstudio.com/Download) (Because friends don't let friends use Notepad.)
- Create a Github account - [https://github.com/](https://github.com/)
- Install Github Desktop - [https://desktop.github.com/](https://desktop.github.com/)
- Feed GitHub credentials into Github Desktop
- Install Docker Desktop from [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)


## REDCap-Specific Setup

- Use GitHub Desktop to clone `123andy/redcap-docker-compose` (i.e., [https://github.com/123andy/redcap-docker-compose](https://github.com/123andy/redcap-docker-compose))
- Open `redcap-docker-compose` in VS Code
- Open the file `.env`
- Paste this block at the end of the file and save it.

```
TZ=America/Chicago
DOCKER_PREFIX=redcap
WEB_PORT=1935
MYSQL_PORT=2935
PHPMYADMIN_PORT=3935
MAILHOG_PORT=4935
```

- In Github Desktop open a terminal cd'd to the `redcap-docker-compose` folder with the keystroke \<ctrl\>```
- Change directories into the `rdc` folder with the command `cd rdc`
- In the terminal start the containers with this command `docker-compose up -d`
- Wait for the containers to build. This takes a few minutes the first time.
- Wait one more minute.
- Access web-based redcap installer at [http://localhost:1935](http://localhost:1935) You should see this:

![REDCap Docker-Compose Installer](/assets/img/installer.png)

- Select 'Use a local copy of the full zip installer...'. Click Browse, locate redcap9.3.5.zip and upload it. 
- Select 'Prepopulate with table-based users and activate table authentication' and provide your email address.
- Click 'INSTALL REDCAP'

## Getting the development exercises

- Use Github Desktop to clone `ctsit/redcap_external_module_development_guide` (Go to File > Clone Repository, then paste `ctsit/redcap_external_module_development_guide` in the "github.com" tab).
- Use Github Desktop to open this new repo (REMDG) in Finder/Explorer. Copy everything in the `exercises/` folder to folder `redcap-docker-compose/www/modules/`. Don't copy the `exercises` folder; copy its _contents_.  These files should be inside the `redcap-docker-compose/www/modules/` folder 

```
accessing_variables
hello_world_v0.0.0
intro_to_hooks
intro_to_js
intro_to_plugins
intro_to_queries
README.md
record_wrangling
```

## Add an extension to VS Code

VSCode can show you syntax errors as you type them if you add an extension. Add the _PHP Intellisense_ extension to VS Code to get this functionality.  On Mac access _Code > Preferences > Extensions_ and type "PHP". You'll see _PHP Intellisense_ in the list. Install it.

Open some PHP code, delete a semicolon or a comma and watch for the red wiggle lines undwer the text. Hover on one next to the text you just changed and consider what the editor is telling you.
