= containers for elgg 2.0 =
adds a dropdown selector to the edit/save forms of common elgg mods such as blogs, pages, files, videolist and tidypics to allow the container to be set for the current item.
available containers are the user profile of the current user and the groups to which the user is associated (a member). this allows items to be moved between groups and profiles.

supports blog_tools, pages_tools and file_tools plugins.

== 1. Features ==
adds container field to edit pages
adds output label to show which group the entity is contained by
updates access fields via AJAX when container is change to reflect the privacy settings for the selected container


version >= 0.6 of this plugin is designed for blog_tools version >= 4.0. if you are using blog_tools with a version lower than 4.0 then you may need to use an earlier version of this plugin.

THIS CODE IS CREATED AND MAINTAINED AS A FREE FOR ALL TO USE AND OPEN SOURCE RESOURCE BY URA SOUL OF UREKA.ORG.
AS ALL-WAYS, DONATIONS ARE WELCOME TO ASSIST WITH THIS CREATIVE PROCESS:
https://www.ureka.org/donation

changelog
---------
2.0.1 - fixed: full list of containers was not available when adding an item inside a group
2.0 - fixed: label for container of a new item was not identifying if current page owner was a group
changed: compatibility check for 2.0.

pre 2.0 is for versions of elgg below 2.0
