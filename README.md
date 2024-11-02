# geminstaller
installer package for gemvc framework
# how to install with project name folder
composer create-project gemvc/installer [your_project_name]
# how to install in current folder
composer create-project gemvc/installer . 
# database 
you need to create table users as follows:
    1. id : int index primary
    2. email: string (varchar 255) unique indexed
    3. password: string (varchar 255)
