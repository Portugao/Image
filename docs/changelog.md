CHANGELOG
---------

Changes in 1.3.0

# closed #5 Xinha plugin is implemented

# closed #22 Scribite 5.0 plugins are available

# closed #32 user defined security schemata, it's possible give set all, users, freinds, password

# closed #45 refactored with MOST

# closed #58 possible to set album to not in frontend, only visible for creator and admins

# closed #66 flexible thumbnails independent of orientation

# closed #67 selection of pictures by select field - shown id and title

# closed #73 all hook providers deleted - TODO later

# closed #74 shrinking of pictures implemented

# closed #75 possible to enable shrinking of pictures in settings

# closed #76 all entries set to 'approved' - upgrade possible

# closed #77 entry into workflow table for each item - upgrade possible

# closed #78 cosmetic in album view

# closed #79 cosmetic in album display

# closed #80 upgrade possible

# closed #82 import function deleted

# closed #83 creating albums possible

# closed #84 creting pictures possible

# closed #85 multi upload of pictures possible

# closed #86 picture invocations not shown if disabled in setting

# closed #87 controller are deleted except delete controller

# closed #88 controller permissions in frontend ruled

# closed #89 album image implemented

# closed #90 pagesize setting work again

# closed #92 fixed, main album get saved creating sub album

# closed #94 plugins are working like expected

# closed #95 deletion of several pictures seems to work

# closed #96 in edit multi function we get the relevant informations about settings

# closed #97 it is possible to edit after multi upload

# closed #98 state now approved

# closed #101 no provider hook

# closed #103 form for password is working for sub albums now

# closed #104 fixed problems with field

# closed #105 file validation is working now

# closed #106 picture access depends on album access now

# closed #107 one item block updated

# closed #108 display of album and pictures better now

# closed #109 redirect after deletion of picture is working like expected

# closed #114 CKeditor does not block the editor anymore

# closed #117 possible now to take file name as picture name

# closed #118 password not in backend anymore

# closed #119 we have an option to set a group for common access

# closed #120 album menu modified to more logic

# closed #121 logic in edit multi template improved

# closed #122 new pot file and german translation completed

# closed #123 all pictures get state 'approved' in multi and zip upload

# closed #124 all pictures with state initial now

some more fixes:

increment of picture view only if the viewer is not the creator


Changes in 1.2.0

# closed #23 now it is possible to set no ending in urls

# closed #27 we have no hook container if no hooks enabled

# closed #43 better performance for albums with many subalbums
             for subalbums only the first picture will be oaded
             
# closed #53 import of mediashare is possible with having a prefix in the tables
             thanks to nmpetkov
             
# closed #54 albums may have the same title, no error editing albums

# closed #55 we can set a maximum width and maximum height for pictures

# closed #56 we have one slideshow impletended now

# closed #59 to set 0 for allowed albums and pictures we can set -1 now;
             we have an information in the template
             
# closed #60 changing album view is possible now with shorturls with no ending
             without error message 

# closed #61 titles with apostrophe are possible now

# closed #62 gettext fix in album display

# closed #63 cleaning of templates

# closed #65 missing type parameter in module calling fixed

# closed #68 line brek fixed

# closed #71 readme updated

# closed #72 layout with rectangular pictures fixed 

Changes in 1.1.1

# closed #44 now we can manage elements per page for albums in frontend
  and for albums and pictures in backend
  
# closed #50 Editing of block 'itemlist' is possible now

# closed #51 The readme was updated for better install informations
  
# now the editing and the functions of blocks are working as expected
  
some missing translation done now
some layout cosmetics with block itemlist done

Changes in 1.1.0
  
# closed #8 it is now possible to set a min width for pictures

# closed #30 concrete datas of pictures and albums moved to the bottom of the edit template
  in backend and frontend
  
# closed #31 now we can find links to upload pictures near the view of pictures in
  a album display 
  
# closed #34 there is an option in the backend configuration now to allow users to 
  delete their own pictures
  
# fixed #39 import of albums with umlauts is possible now

# closed #40 uninstall is possible now after import

# closed #41 better feedback if album to support is not found

# closed # 42 better feedback if album to support already exists

# closed #47 link to overview deleted in pictures detail view

# fixed #49 layout problems in detail view of albums and pictures in frontend 
  
  
------ some fixes ------

# Deleting of an image coming from the display of an image,
  gives error in frontend; now we return the redirect.
  
# Guests contingent is now correct, 0 albums, 0 subalbums, 0 pictures