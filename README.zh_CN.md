# PPP-Dir文件管理系统  V24.12
### （全称：PHPDisk Personal Professional Directory Manage）

##### 是一款功能强大的无数据库PHP文件管理系统，所见即所得存储，响应式设计，简约不简单。
###### 这是PHPDisk Team 的又一款精细化却不失功能强大的云盘存储应用，极致的存储分享体验，直击用户需求痛点，让云盘的应用安装使用更加便捷化。

----------


#### 重点功能列表：

- **即装即用，无需数据库的PHP的文件管理系统**
- 只需要使用浏览器访问网址一样的操作，无需客户端
- 目前支持可以实现目录、文件的删除，重命名操作，支持中文目录
- **秒级迅速的数据索引搜索文件过滤能力，极致用户体验**
- 超简单的设置登录管理方式
- 含有后台管理面板，可以设置上传文件的格式
- 含有在线预览文件，下载文件功能
- **支持手机端扫二维码下载分享及适配HTML5页面**
- **只需要配置指定网站目录，程序会自动解析显示目录下的文件及目录**
- 在服务器上面可以跟管理平时的桌面文件一样的操作，无需重新上传文件到程序中


----------


####  适用场景：

- 个人的文件管理，服务器上传到指定目录，即可管理使用
- 文件同时可直接在服务器上操作上传，移动，或网页端操作，同步实时显示
- 网页端可设置直接只做下载、展示文件使用，大大降低服务器安全问题
- 文件可用FTP或管理员直接上传文件到服务器相应目录中，无需通过WEB上传，加快文件传输
- **这是一款强大的C端应用，适用于所有的文件存储分享方向的应用**

----------
#### 程序截图
![1](http://www.phpdisk.com/pppdir-snapshot/1.png)
![1](http://www.phpdisk.com/pppdir-snapshot/2.png)
![1](http://www.phpdisk.com/pppdir-snapshot/3.png)
![1](http://www.phpdisk.com/pppdir-snapshot/4.png)
![1](http://www.phpdisk.com/pppdir-snapshot/5.png)
![1](http://www.phpdisk.com/pppdir-snapshot/6.png)
![1](http://www.phpdisk.com/pppdir-snapshot/7.png)
![1](http://www.phpdisk.com/pppdir-snapshot/8.png)

----------


#### 如何安装:
解压压缩包，upload 目录下的文件放到相应的网站目录中，
可以在浏览器中测试访问，
使用专业的代码编辑器打开修改 configs.php


    
    $cfg['username'] = 'PPPAdmin'; 
    // 随便填写，只用于显示
    
    $cfg['login_pass'] = '11'; 
    // 用户前台登录密码
    
    $cfg['admin_login_pass'] = '12'; 
    // 管理后台登录密码
    
    $cfg['phpdisk_dir'] = '@dir'; 
    // !!文件解析目录 基于网站根目录的目录名称，程序会读取此目录下的文件，可修改不要使用特殊字符
    // 请务必修改解析目录名称，为确保安全，推荐设置禁用此目录执行权限，同时可不定时修改此目录名称 
    
    $cfg['default_lang'] = 'zh_cn'; 
    // 默认语言 语言包在 _phpdisk/languages/ 目录下  zh_cn 为中文语言包 , en_us 为英文语言包
    
    $cfg['phpdisk_url'] = 'http://yourDomain/'; 
    // 程序访问完整地址，结尾要加 /
    
    $cfg['charset'] = 'utf-8'; 
    // 浏览器字符编码
    
    $cfg['debug'] = 0; // 1 open , 0 close 
    // 是否开启调试模式
    
    $cfg['deny_chars'] = array('\\','/',':','<','>','?','"','*',"'",'`'); 
    // 文件名中不允许出现的字符



> ####文件解析 $cfg['phpdisk_dir'] 目录需要Window系统需要写入读取权限或Linux系统 755权限或直接 777权限,为确保安全，推荐设置禁用此目录执行权限，同时可不定时修改此目录名称 


----------

#### 技术说明:
适用于 PHP 5.4.x - PHP 7.3.x ， 无需数据库

----------

#### 开发商：
官方网址： [www.phpdisk.com](http://www.phpdisk.com/?utm=md)

交流论坛： [bbs1.phpdisk.com](http://bbs1.phpdisk.com/?utm=md)

