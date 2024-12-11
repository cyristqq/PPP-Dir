# PPP-Dir file management system  V24.12
### （PHPDisk Personal Professional Directory Manage）

##### It is a powerful database free PHP file management system with WYSIWYG storage, responsive design, and simplicity.
###### This is another refined yet powerful cloud storage application from PHPDisk Team, providing an ultimate storage sharing experience and addressing user pain points, making cloud storage application installation and use more convenient.

----------


#### Imortant Feature：

- **Ready to install and use PHP file management system without the need for a database**
- Just use a browser to access the same website without the need for a client
- At present, it supports the deletion and renaming of directories and files, and supports Chinese directories
- **Quick data indexing, file filtering ability in seconds, ultimate user experience**
- Ultra simple login management settings
- Contains a backend management panel that allows you to set the format of uploaded files
- Contains online preview files and download file functions
- **Support scanning QR codes on mobile devices to download, share, and adapt HTML5 pages**
- **Just configure the specified website directory, and the program will automatically parse and display files and directories in the directory**
- On the server, you can perform the same operations as managing regular desktop files, without the need to re upload files to the program


----------


####  Applicable Scenarios：

- Personal file management, upload the server to the specified directory for easy management and use
- Files can be directly uploaded, moved, or accessed on the server, and displayed in real-time synchronously
- The web version can be set to only be used for downloading and displaying files, greatly reducing server security issues
- Files can be uploaded directly to the corresponding directory on the server using FTP or by an administrator, without the need to upload through the web, which speeds up file transfer
- **This is a powerful C-end application that is suitable for all file storage and sharing applications**

----------
#### Program screenshot
![1](http://www.phpdisk.net/pppdir-snapshot/1.png)
![1](http://www.phpdisk.net/pppdir-snapshot/2.png)
![1](http://www.phpdisk.net/pppdir-snapshot/3.png)
![1](http://www.phpdisk.net/pppdir-snapshot/4.png)
![1](http://www.phpdisk.net/pppdir-snapshot/5.png)
![1](http://www.phpdisk.net/pppdir-snapshot/6.png)
![1](http://www.phpdisk.net/pppdir-snapshot/7.png)
![1](http://www.phpdisk.net/pppdir-snapshot/8.png)

----------


#### How to install:
Extract the compressed file and place the files in the *upload* directory into the corresponding website directory,
You can test the access in the browser,
Open and modify *config.php* using a professional code editor


    
    // Fill in freely, only for display
    $cfg['username'] = 'PPPAdmin'; 
    
    // User Frontend login password
    $cfg['login_pass'] = '11'; 
    
    // Admin Backend login password
    $cfg['admin_login_pass'] = '12'; 
    
    // The file parsing directory is based on the directory name of the website root directory. The program will read files in this directory, which can be modified without using special characters.
    // Please make sure to modify the name of the parsing directory. To ensure security, it is recommended to disable the execution permission of this directory, and the directory name can be modified from time to time
    $cfg['phpdisk_dir'] = '@dir'; 
    
    // The default language pack in the _phpdisk/languages/ , zh_cn is the Chinese language pack, en_us is an English language pack
    $cfg['default_lang'] = 'en_us'; 
    
    // Program access address, add at the end /
    $cfg['phpdisk_url'] = 'http://yourdomain/'; 
    
    // Browser character encoding
    $cfg['charset'] = 'utf-8'; 
    
    // Enable debug mode
    $cfg['debug'] = 0; // 1 open , 0 close 
    
    // File name not allowed to appear in the characters
    $cfg['deny_chars'] = array('\\','/',':','<','>','?','"','*',"'",'`'); 




> ####File parsing: The *$cfg['phpdisk_dir']* directory requires Windows system write and read permissions, Linux system 755 permissions, or direct 777 permissions. To ensure security, it is recommended to disable the execution permission of this directory and modify its name from time to time


----------

#### Run environment:
Fit for PHP 5.4.x - PHP 7.3.x ，no need database!

----------

#### Developers：
Official Site： [www.phpdisk.net](http://www.phpdisk.net/?utm=md)

Community： [support.phpdisk.net](http://support.phpdisk.net/?utm=md)

