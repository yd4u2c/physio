<?php

namespace Faker\Provider\ne_NP;

class Internet extends \Faker\Provider\Internet
{
    protected static $freeEmailDomain = array('gmail.com', 'yahoo.com', 'hotmail.com');
    protected static $tld = array('com', 'com', 'com', 'net', 'org');

    protected static $emailFormats = array(
        '{{userName}}@{{domainName}}',
        '{{userName}}@{{domainName}}',
        '{{userName}}@{{freeEmailDomain}}',
        '{{userName}}@{{domainName}}.np',
        '{{userName}}@{{domainName}}.np',
        '{{userName}}@{{domainName}}.np',
    );

    protected static $urlFormats = array(
        'http://www.{{domainName}}.np/',
        'http://www.{{domainName}}.np/',
        'http://{{domainName}}.np/',
        'http://{{domainName}}.np/',
        'http://www.{{domainName}}.np/{{slug}}',
        'http://www.{{domainName}}.np/{{slug}}.html',
        'http://{{domainName}}.np/{{slug}}',
        'http://{{domainName}}.np/{{slug}}',
        'http://{{domainName}}/{{slug}}.html',
        'http://www.{{domainName}}/',
        'http://{{domainName}}/',
    );
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Faker\Provider\ne_NP;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{middleNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{middleNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{middleNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{middleNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
    );

    protected static $firstNameMale = array(
        'Aadarsh', 'Aadesh', 'Aaditya', 'Aakash', 'Aanand', 'Abud', 'Achyut', 'Ajay', 'Ajit', 'Akhil', 'Akshar', 'Akshay', 'Amar', 'Amir', 'Amit', 'Amod', 'Amrit', 'Amulya', 'Ananta', 'Angel', 'Angikar', 'Anil', 'Ankit', 'Ankur', 'Anmol', 'Anshu', 'Anuj', 'Arjun', 'Arun', 'Ashish', 'Ashok', 'Ashutosh', 'Atal', 'Avinash', 'Ayush',
        'Babish', 'Badal', 'Badri', 'Baibhav', 'Bhagwam', 'Bhakti', 'Bhanu', 'Bibek', 'Bicky', 'Bidur', 'Bidwan', 'Bikal', 'Bikash', 'Bikesh', 'Bikram', 'Bimal', 'Binamra', 'Binay', 'Bipin', 'Biplav', 'Bipul', 'Biraj', 'Birendra', 'Bishal', 'Bisu', 'Biswas', 'Brijesh', 'Buddha',
        'Chaitanya', 'Chandan', 'Chandra', 'Chirag',
        'Darpan', 'Deep', 'Deepak', 'Dev', 'Dhairya', 'Dharma', 'Dharmendra', 'Dhiren', 'Diwakar', 'Diwash',
        'Eklavya',
        'Gajendra', 'Gaurav', 'Girish', 'Gokul', 'Gopal', 'Govinda', 'Grija', 'Gyanraj',
        'Hans', 'Hardik', 'Hari', 'Harsa', 'Hemant', 'Himal', 'Hitesh', 'Hridaya',
        'Ishwar',
        'Jitendra', 'Jivan',
        'Kabindra', 'Kailash', 'Kalyan', 'Kamal', 'Kamod', 'Kapil', 'Karan', 'Karna', 'Khagendra', 'Kishor', 'Kris', 'Krishna', 'Krisus', 'Kuber',
        'Lakshman', 'Lalit', 'Lava', 'Lochan', 'Lokesh',
        'Madhav', 'Madhukar', 'Madhur', 'Mandeep', 'Manish', 'Manjul', 'Manoj', 'Milan', 'Mohit', 'Mridul',
        'Nabin', 'Nakul', 'Narayan', 'Narendra', 'Naresh', 'Neil', 'Nerain', 'Nirajan', 'Nirajan', 'Nirmal', 'Nirupam', 'Nischal', 'Nishad', 'Nishant', 'Nutan',
        'Om',
        'Paras', 'Parikshit', 'Parimal', 'Pawan', 'Piyush', 'Prabal', 'Prabesh', 'Prabhat', 'Prabin', 'Prajwal', 'Prakash', 'Pramesh', 'Pramod', 'Pranaya', 'Pranil', 'Prasanna', 'Prashant', 'Prasun', 'Pratap', 'Pratik', 'Prayag', 'Prianshu', 'Prithivi', 'Purna', 'Pushkar',
        'Raghab', 'Rahul', 'Rajan', 'Rajesh', 'Rakesh', 'Ramesh', 'Ranjan', 'Ranjit', 'Ricky', 'Rijan', 'Rishab', 'Rishikesh', 'Rohan', 'Rohit', 'Roshan',
        'Sabin', 'Sachit', 'Safal', 'Sahaj', 'Sahan', 'Sajal', 'Sakar', 'Samir', 'Sanchit', 'Sandesh', 'Sanjay', 'Sanjeev', 'Sankalpa', 'Santosh', 'Sarad', 'Saroj', 'Sashi', 'Saumya', 'Sevak', 'Shailesh', 'Shakti', 'Sh