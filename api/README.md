# quickdash icons

## Setup
To make this API work, you need to:
1. Create an icons folder in this directory.
2. Populate it with Bootstrap Icons (it won't work without this, as it uses Boostrap icons as default). Download it into a folder within icons called bootstrap, example svg path: `icons/bootstrap/all.svg`
3. To add other svg packages just add folders to the icons folder containing the desired svgs, and refer to them in the `data.json` file as `"type": "foldername"` and `"icon": "svgname"` (wihtout .svg).

## Bootstrap Icons
To install quickly get bootstrap icons:
- Download https://github.com/twbs/icons/archive/v1.8.1.zip and copy the icons from the icons folder to bootstrap folder.