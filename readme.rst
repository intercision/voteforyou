###################
Vote For You
###################

This the code base behind a CodeIgniter based tool that lets US people easily contact their congress people.  It is just being uploaded and has run successfully on a LAMP shared hosting site and a Windows 10 + Apache, MySQL host.  You can see a working copy at the `Vote for You Website <https://www.voteforyou.co>`_

#######################################
What You'll Need Before Getting Started
#######################################

1. A host with a relatively recent version of PHP and MySQL
2. Medium level PHP and CodeIgniter skill
3. A `Geocod.io <https://geocod.io>`_ account to access congressional districts (you will need the API Key)
4. A `RECAPCHA <https://www.google.com/recaptcha/intro/comingsoon/index.html>`_ account from Google
5. An SSL certificate or a $20/month CloudFlare membership which gets you one (this is so the browser will allow you to get your geographic location)

###############
Setting Up
###############

Pull down the code.  In the **application/config/** directory there will be **config.php.template**, **database.php.template**, and **recaptcha.php.template**.  You will need to take the .template extension off of them on your end.  Please note that these may be modified and added to and then you will have to merge the changes into your existing files.

Create a database and import the SQL file in the root directory.

Configure your database in the **application/config/database.php**  you will also have to put your Geocode.io API key in the **config.php**.  There are API limit,  feedback link, and local/remote host settings there too.  Lastly you'll have to go to **recaptcha.php** and add your RECAPCHA keys from Google

###############
API Limit
###############

Please note that the Geocod.io API is limited to 2,500 free lookups per day but because our code is using 2 per lookup to geocode and get congressional district you really only get 1,250 lookups.  That company has plans for higher traffic sites where you can pay per lookup but my code allows you to only allow a certain amount of lookups per day if you think you are going for a cost overrun.

####################
A Note on the Design
####################

This code is released under an MIT license but the design is released into the commons under a public domain license.  The mechanism that allows one to push a few buttons and contact their congress people seamlessly shall not be under any patent and this code and design will be considered prior art against any of those claims.


###############
Other Notes
###############

This is my first GitHub project so it might not work at all.  I cannot be held liable for any damages this code may cause.
