# Re-trigger Scheduled Posts

## Description

Originally adapted from [Scheduled Post Trigger](https://wordpress.org/plugins/scheduled-post-trigger/) to be more resource efficient.

Instead of running a query every time a visitor loads your site, Re-trigger Scheduled Posts runs on an hourly schedule to check if any scheduled posts have been missed. If any scheduled posts have been missed Re-trigger Scheduled Posts publishes them immediately.

There is no configuration required for this plugin to work, just install and activate it and it'll handle the rest.

## Installation

### Automatic installation

Automatic installation is the easiest option. WordPress will handle the file transfer, and you won’t need to leave your web browser. To automatically install Re-trigger Scheduled Posts, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New”.

In the search field type “Re-trigger Scheduled Posts”, then click “Search Plugins”. Once you’ve found the plugin, you can view details about it such as the release, rating, and description. Most importantly you can install it by clicking “Install Now” and WordPress will take it from there.

### Manual installation

Manual installation method requires downloading the Re-trigger Scheduled Posts plugin and uploading it to your web server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).

## Changelog
**1.1.2 - 07-27-2021**
- Updated functions prefix to "mlrtsp"

**1.1.1 - 07-23-2021**
- Updated code to be compatible with the WordPress plugin repository.

**1.0.1 - 07-14-2021**
- Simplified code and fixed bug where query was requesting lowercase id.
- Added composer.json to allow for installing from Github via composer. 
  
**1.0.0 - 08-27-2020**
- Initial release.