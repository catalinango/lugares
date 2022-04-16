# Lugares
_Simple PHP proyect with Google Cloud Api's integration_

## Description
Web application build to fulfill an assignment of the subject System Engineering II in the System Engineering bachelor.

For more information about this assignment go to [docs](https://gitlab.com/catalinango/lugares/-/tree/master/docs).

## Website

Watch a live demo in: \
_<https://www.catalinaguerrero.com/lugares>_

Access data:
- user: 11223344 
- password: 11223344

## Technologies

* [Google Cloud APIs](https://cloud.google.com/apis/docs/overview) - Maps & Places
* [PHP](https://www.php.net/) - Version 5.6
* [MySql](https://www.mysql.com/) - Version 5.7.6
* [Bootstrap3](https://getbootstrap.com/docs/3.3/)
* [w3layouts](https://w3layouts.com/) - Free Bootstrap Themes
* [DataTables](https://datatables.net/) - Interaction controls for HTML tables

## Installation

Install Apache, PHP y MariaDB o MySQL
 - [Apache](http://httpd.apache.org/docs/current/en/install.html)
 - [PHP](https://www.php.net/manual/en/install.php)
 - [MariaDB](https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/)

Or you could install [XAMPP](https://www.apachefriends.org/es/index.html) instead. For any SO.

## Configuration

Download the contents of this repository in your web server.
Edit the file [app/config.php](https://gitlab.com/catalinango/lugares/-/blob/master/app/config.php) as it follows:

- Change the content of the session variable *apy_key* with your own key and activate Maps and Places in your Google Cloud project. \
  More information about this in: _<https://cloud.google.com/docs/authentication/api-keys?hl=es&visit_id=637390864732639626-2853894516&rd=1>_
- Change the session variable *email* with your own email. Make shure you had activated the Sendmail service in your host.


  _*Configuring PHP for sending mail [source](https://pepipost.com/tutorials/sendmail-in-php-complete-guide/)*_

  In order to configure anything related to PHP you need to change `php.ini` file. So, we will be editing php.ini file in order to configure Sendmail.

  You can easily locate or search your php.ini file in Linux using below command: locate php.ini

  The default location is `/etc/php.ini` 

  You can find the same in windows where XAMPP or LAMPP is installed:

  `C:\xampp\php\php.ini`

  Clarification:

    Xampp (X (for "some OS"), Apache, MySQL, Perl, PHP)
    Lampp (Linux, Apache, MySQL, Perl, PHP)

  Changing  php.ini file to add mail configuration.

  1. Open your php.ini file using below:

    For Linux/Mac OS:

    vim /etc/php.in 


    For Windows:
    using notepad


  2. Search [mail function] in the file. It will be as shown below:

    [mail function]
    ; For Win32 only.
    ; http://php.net/smtp
    SMTP = localhost
    ; http://php.net/smtp-port
    smtp_port = 25
    ; For Win32 only.
    ; http://php.net/sendmail-from
    ;sendmail_from = me@example.com
    ; For Unix only.  You may supply arguments as well (default: "sendmail -t -i").
    ; http://php.net/sendmail-path
    sendmail_path = /usr/sbin/sendmail -t -i
    ; Force the addition of the specified parameters to be passed as extra parameters
    ; to the sendmail binary. These parameters will always replace the value of
    ; the 5th parameter to mail(), even in safe mode.
    ;mail.force_extra_parameters =
    ; Add X-PHP-Originating-Script: that will include uid of the script followed by the filename
    mail.add_x_header = On
    ; The path to a log file that will log all mail() calls. Log entries include
    ; the full path of the script, line number, To address and headers.
    ;mail.log =

  3. Add your mail server details to the file or incase you have one you can change it (mail server can be your own ie. local mail server or you can use any ESP as a mail server).
      
    For Linux/Mac OS:
    - Check for `sendmail_path` and ensure; is not (semicolon is used to show the line is commented).
    - By default it will use `/usr/bin/sendmail -t -i` you can change it if you are using any custom path.For Window:
    - Check for `SMTP = localhost` and change it to your desired mail server (any ESP or localhost) no changes are required if you are using your own local server.
    - Or you can also use the smtp server of any Email Service Provider like Pepipost, Sendgrid, Mailgun, Sparkpost.

  4. Save/close the php.ini file

  5. The final step, don’t forget to restart your webserver/php-fpm.

    Pro tip: You can host a simple “info.php” on your webserver to check each and every configuration of your PHP using below 2 liner code:

    vim php_info.php
    <?php
    phpinfo();
    ?>

    Save and exit the file.
  6. Reload you webserver and php-fpm.
  7. Hit http://localhost/php_info.php on your web browser.
  
