# DocMark

[![Author](http://img.shields.io/badge/author-@mikebarlow-red.svg?style=flat-square)](https://twitter.com/mikebarlow)
[![Source Code](http://img.shields.io/badge/source-snscripts/docmark-brightgreen.svg?style=flat-square)](https://github.com/snscripts/docmark)
[![Latest Version](https://img.shields.io/github/release/snscripts/docmark.svg?style=flat-square)](https://github.com/snscripts/docmark/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/snscripts/docmark/blob/master/LICENSE)

## Introduction

DocMark is a markdown to html documentation (or standard site) generator. DocMark will take the folder and markdown file structure from the docs folder and turn it into a fully fledge site either on the fly or from a cached version (Cache / static site generation coming in a later version).

## Requirements

* Apache
* PHP 5.4.0+
* Composer

## Installation

* Check DocMark out from Git.
* Navigate to root of project and run `composer install` to install dependencies
* Edit any values required within `DocMarkRoot/System/Config.php`
* Make `DocMarkRoot/assets` writable.
* Place your markdown files in the `doc` directory (or which ever directory you have specified in Config.php)
* Visit your installation of DocMark in the browser to view the On-The-Fly generation of your files.

### Webhooks

If you are going to be using the Webhooks, `github_update.php`, `Storage`, `docs` all need writable / executable permissions. 755 is usually the standard across hosts, if you are unsure contact your host.

## Customising

### Template Engine & Setup

Themes and assets in DocMark are handled by [Plates](http://platesphp.com/), so for more in depth documentation on the template engine see the official Plates Documentation.

DocMarks Plates configuration is setup to use Themes and the fallback options, withing `/themes/` you will find folders named `default` and `fallback`. `Fallback` contains all the templates each theme can use to fallback on. This allows each theme to only set the templates it needs to.

As `default` is our original theme, no overriding templates are needed so this folder will be empty.

### Overriding Templates

If you wish to change a portion of the design, simply copy the file path and the file itself from the fallback folder (keeping the original file intact) and duplicate it into your themes folder. Make your changes and save, DocMark will now use this template, simple!

### Assets

Assets are handled by our custom Plates Extension. Assets are now handled like the templates with folders and fallback directories.

All assets are located in `DocMarkRoot/themes/fallback/assets`. These can be overridden by change those files directly or if you wish to keep them intact, create a new file within `DocMarkRoot/themes/YOURTHEMENAME/assets` to override the original asset.

For full documentation on assets, please see [this readme](https://github.com/snscripts/advanced-assets/blob/master/README.md).

## Documenting

### Intro

DocMark currently uses [CommonMark PHP League Package](http://commonmark.thephpleague.com/) to parse all the markdown files. This means all markdown files are processed to the [CommonMark Specification](http://commonmark.org/).

### Creating

Creating your site is as simple as creating files within the `/docs/` folder (default value, this however can be changed).
All files must be created with a `.md` file extension, full markdown documentation can be found [here](https://daringfireball.net/projects/markdown/).

Each folder **must** have an `index.md` to act as a landing page for that directory \(*We are looking into changing this behaviour*\). Any other files within that folder will appear in the menu as normal.

### Ordering

Folders will always appear before files, but within each group of folders and files you can amend the order of them by prefixing the file with a number followed by an underscore.

e.g. **10\_My-File.md** will appear before **20\_A\_File.md**

If your file starts with a number as part of the filename, prefix the file with an underscore.

e.g. **\_3\_Steps\_to\_success.md**


### File Formats

See below for examples of file name formatting and how they will appear in the system

* 10\_My-File.md **->** My-File
* 20\_A\_File.md **->** A File
* A\_File\_with-mixed_elements.md **->** A File with-mixed elements
* \_3\_Steps\_to\_success.md **->** 3 Steps to success

## GitHub WebHook

If you currently store your site / documentation on GitHub you can use the bundled webhook to automatically update the site when a push to the repository is made.

### Setup

To setup the webhook, first set `repo` and `repoBranch` settings within `System/Config.php`. Simply set the `repo` to the read only URL to your repo and usually `repoBranch` can be left as `master`.

Next in GitHub, visit the settings for your repository and visit the `Webhooks & Services` tab.

Select Add Webhook and set the following details:

* Payload URL: `http://yoursite.com/github_update.php`
* Content Type: `application/json`
* Secret: (Leave this item blank, currently not supported)
* Which Events: `Just the push event`
* Active: `check`

Click to add the webhook when finished. The `github_update.php` file should have executable permissions on the server so that it can be run by the Post Request from GitHub. Usually 755 should suffice but check with your host if you're unsure.

The `Storage` and `docs` folders will also need to be made writable so DocMark can pull in the repo from GitHub and set it up correctly within the `docs` folder.

### Testing

To test, simple make a change on the correct branch, commit and push the change and the updater should take care of the rest.

## Licence

This script is released under the MIT licence and as such you agree to use this script under the terms specified within the MIT licence, a copy of the licence can be found in root directory.

## Support

Create an issue here on GitHub or contact me on twitter [@mikebarlow](https://twitter.com/mikebarlow).