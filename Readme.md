# DocMark

DocMark is a markdown to html documentation (or standard site) generator. DocMark will take the folder and markdown file structure from the docs folder and turn it into a fully fledge site either on the fly or from a cached version (Cache / static site generation coming in a later version).

## Requirements

* Apache
* PHP 5.3.3+
* Composer

## Installation

After checking out DocMark from Git, navigate to the root of the project and run a composer install to install all the dependencies.

You will also want to edit some of the site title / link values found in the config file at `DocMarkRoot/System/Config.php`

## Customising

CSS / JS / Images are all stored in the assets directory and you should place any of your own assets in this directory within the correct subdirectory.

Templates are stored within the `/templates/` directory, filenames for these should not be changed unless you know what you are doing. Changing of filenames would involve amending any template includes or amending the template name on the individual View Classes located at `/System/View/`.

The contents of each of the template files is simple HTML mixed with PHP to populate the content, swap out the HTML as needed for your design.

## Documenting

Creating your documentation is as simple as creating files within the `/docs/` folder (default value, this however can be changed).
All files must be created with a `.md` file extension, full markdown documentation can be found [here](https://daringfireball.net/projects/markdown/).

Each folder **must** have an `index.md` to act as a landing page for that directory. Any other files within that folder will appear in the menu as normal.

### Ordering

Folders will always appear before files, but within each group of folders and files you can amend the order of them by prefixing the file with a number followed by an underscore.

e.g. **10_My-File.md** will appear before **20_A_File.md**

If your file starts with a number as part of the filename, prefix the file with an underscore.

e.g. **_3_Steps_to_success.md**


### File Formats

See below for examples of file name formatting and how they will appear in the system

* 10_My-File.md **->** My-File
* 20_A_File.md **->** A File
* A_File_with-mixed_elements.md **->** A File with-mixed elements
* _3_Steps_to_success.md **->** 3 Steps to success


## Licence

This script is released under the MIT licence and as such you agree to use this script under the terms specified within the MIT licence, a copy of the licence can be found in root directory.

## Support

Support is currently only through GitHub so please create an issue with any problems you may have.