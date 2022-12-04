# chattapp-php

## Table of content  
* [About the project](#about-the-project)  
* [Technologies](#technologies)  
* [Features](#features)
* [Requirements](#requirements)  
* [Setup](#setup)  

## About the project  
>A chat application made using the lamp stack .  

## Technologies  
* **linux**  
* **apache**  
* **mysql**  
* **php** 
* **javascript**
* **html/css**

## Features  
* use ***ajax*** to diynamically serve content and decrease loading time 
* hashing of ***password***
* searchs of ***users*** message

## Requirements  
To run this app you need to have **apache** installed with **mysql** and **php** working .

## Setup
```shell  
#clone the project into your web directory eg /var/www   
$git clone https://github.com/0script/chatapp-php
$cd chatapp/
#activate apache and mysql
$sudo systemctl start mariadb && systemctl start apache2 && systemctl status mariadb && systemctl status apache2
#copy website configuration
$sudo cp chatapp.conf /etc/apache2/site-availables/
#add website hostname 
$sudo echo "127.0.0.1 chatapp.local www.chatapp.local" >> /etc/hosts
#enable website 
$sudo a2ensite /etc/apache2/site-availables/chatapp.conf
#got to the home page
$nohup firefox www.chatapp.local
```
