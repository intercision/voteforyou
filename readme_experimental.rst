###################
Experimental Tools
###################

There is an Experimental.php controller (in application/controllers/) that contains some alpha things to use.  You have to uncomment them for them to work.

**bdays999** - this is required to run after loading the database (if you imported the data going the YAML > CSV > SQL route instead of the SQL tables one).  It puts the Congressional birthdays in the correct date format.

**add_fields** - this lets you add fields to a mailing list that has gone through a geocod.io geocoding.  Any field from the govtrack_congress_member table including names, party, phone number, address, etc.. can be used. More on this on the next heading

**images_from_bioguide** - this gets all the images from the Bioguide in case you want to save them locally.  Note that not every official has an image.

**yaml_to_csv** - very experimental YAML to CSV parsing.  Please note that this is inferior to the one alternate_bulk_formats.py at https://github.com/unitedstates/congress-legislators/tree/master/scripts which you should run instead (just need Python 3)

############################################
Engaging Congress with Segmented Lists
############################################

This is an attempt to engage the Beltline on a shoestring.  You need deeper targeting than traditional lists where everyone gets the same thing (usually an online petition which does little besides collecting updated contact information).  On your list you want the ability to segment by constituents' congressional districts.  Let's say there was a representative in a particular district that was wavering on a position that you wanted just your constituents in that locale to engage.  This tool allows you to segment the list and pull fields you need so that you can put the information in front of the constituent that they need to take action (for example their elected official's phone number).  You could even put the representative's name in the email title so your constituents know the message has been customized.

What you need for this. 

1. Intermediate level PHP and email or postal mail marketing tool skill
2. This script installed on a local or remote PHP/MySQL host with a high as possible max_execution_time parameter in php.ini
3. A `Geocod.io <https://geocod.io>`_ account to upload a CSV version of your list
4. A mailing list provider such as Mail Chimp that supports list segmentation

The first thing you'll want to do is go to `Geocod.io <https://geocod.io>`_ and sign up for an account.  It will let you upload a CSV file.  You want to make sure to check Congressional Districts (and possible State Legislative Districts if you need that in the future).  Please note that larger lists do incur a cost to do this.  It might be good to start with just a part of your list to test it with our system.

Next you will need to install the `voteforyou <https://github.com/intercision/voteforyou>`_ application on PHP/MySQL web space.  Then you'll uncomment out the **add_fields** function.  You'll want to save your list that was put through geocod.io in the /media/ directory of the voteforyou install as **list.csv** (if there is no media directory create one).  At this point you will run experimental/add_fields and hopefully it should work.  You may have to increase the max_execution_time parameter in the php.ini if possible (that is why it might be better to host it locally with something like WAMP than on shared hosting).  If everything works out you will get a file list_dest.csv in the media directory with the added fields.

Note that you can add any parameter that's in the govtrack_congress_member database table.  Just prefix it with either sen\_ or rep\_ the default parameters there are first name, last name, and phone number for both Senator and Representative.

Note that this script currently doesn't support updating fields so when you run it through this script you will have to delete the fields it has generated every time (for example rep_first_name, rep_last_name, etc..)

Assuming this worked you are now ready to import it into your mailing list provider.  If your provider supports segmentation like Mail Chimp you can segment by state or district and use the additional fields throughout your message.  Refer to your provider's documentation on how to do this.

Enjoy, but realize this is alpha software so it may not work.







