# Please read carefully!

This project (blog) is a site that has two areas Administrator and standard user. Each user can see the posts either by searching with the search bar or by searching by category. Once connected a user can post, modify and delete his post. The administrator is able to do everything: see all the users of the site, add a user, change the role of a user ie named administrator as him and especially delete any user. He can also add a new category in which posts can be stored, modify but also delete if necessary. And of course post, modify and delete as any standard user.


# Create a "blog_db" database

Import the file blog_db.sql in phpmyadmin or create manually a database "blog_db". In the file blog_db.php, you will find the tables of the database "blog_db". For those who are more comfortable with sql this is only a formality 🙂 everything is in the file you can copy and paste or just change a couple of things to adapt to a database other than mysql.

# change the "http://localhost/TP/" by the root url of your project

This one is in the class folder in the Constants.php file. Don't forget the slash "/" at the end of the url🙂

# change the database connection logins to your own. 

they are in the class folder, more precisely the Database.php file.


# normally register once to discover the standard user part 

any registration on the site puts directly as a standard user role no concern at this level.

# Change the value of the "is_admin" field from 0 to 1

Register again with a new account that you will transform into your administrator account. Change the 0 in the "is_admin" field to 1 in the user table, more precisely in the new user you have created, and you will be able to name the user of your choice as admin and do all the actions that only the admin can.



Well done!


