# Final-Year-Project

## Requirements
#### LAMP
Install Apache: sudo apt-get install apache2

Install Mysql: sudo apt-get mysql-server

Install php5.6: $ sudo add-apt-repository ppa:ondrej/php
		$ sudo apt-get update
		$ sudo apt-get -y install php5.6 php5.6-mcrypt php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-gd php5.6-intl php5.6-xsl php5.6-zip


#### JOBE - https://github.com/trampgeek/jobe
Should be installed on the machine following the instructions on the github page.

#### CakePHP - https://cakephp.org/
Follow instructions to install CakePHP. to run the server enter 'cake server' from the command line in the bin directory.

## Set Up
#### Database
MySQL commands to create the database can be found in the tables file. Database should be name 'ml'.

#### Start the Server
Go in the project's root directory, run bin/cake server

#### Admin
http://localhost:8765/users/add to add an admin user.

## Question Example
#### Description
static int  multiplyTwoInts  (int a, int b)

Given two integer arguments, return their product.

#### Field 1
class main{

  public static void main(String[] args){
  
    System.out.println(multiplyTwoInts(2,4));
    
    System.out.println(multiplyTwoInts(3,0));
    
    System.out.println(multiplyTwoInts(-4,3));
    
    System.out.println(multiplyTwoInts(-1,-5));
    
  }

#### Field 2
}

#### Output
80-125
