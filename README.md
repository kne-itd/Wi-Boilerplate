# Wi-Boilerplate
A boilerplate/framework for WI-students at SDE

Use:
1. Create a database according to your project's demands.
2. Copy the content of the directory "wi-boilerplate" to your project's location.
3. Edit the file "config.php" according to your own info.
4. Edit the file "Scaffold/index.php":
    1. Set the prefix-string to look for in your database tables.
    2. Set the target directory name where you want the PHP class files saved (preferably "Model").
    3. Decide if you need a seeder script created.
    4. Run the script ("Scaffold/index.php").
5. If you created a seeder script in step 4.4 download and open this file in your editor.
    1. Rearrange the script blocks according to your database constrains. Taje care of foreign key values
       (eg. a "category" table needs to be populated before a "product" table).
    2. Populate the script with data
    3. Run the script ("Scaffold/seeder.php").
6. You are good to go!
