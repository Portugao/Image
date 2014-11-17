CHANGELOG
---------

Changes in 1.3.0

# closed #5 Xinha plugin is implemented

# closed #22 Scribite 5.0 plugins are available

# closed #77 upgrade possible

# closed #77 upgrade possible

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

# closed #77 upgrade possible

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