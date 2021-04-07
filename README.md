# Restaurant Prototype

# What is this?

This is a website and MySQL database created and designed for a fictional restaurant called "Le Bistro". The website is complete with costumer, kitchen and manager interfaces. The database contains all costumers, menu items and staff (kitchen staff or management) registered.

# Contents

## [**Website Source**](https://github.com/jgspires/restaurant-prototype/tree/main/Website%20Source):

Contains all of the web pages, JavaScript code, and images used in the website. Engineering wise, the website was developed using multiple design patterns, such as model-view-controller (MVC) to help organize and sectionalize the code, data-access-object (DAO) to interact with the database as well as singleton and factories to more easily and intuitively use some objects and classes.

The website was built using HTML, CSS, PHP, Bootstrap and JavaScript (using jQuery and AJAX requests).

## **bd_restaurante.sql**:

This is the MySQL import script used to create the database and all necessary tables to make the website work correctly. It can be executed as is and will fill all tables with enough content so that the website can be properly tested without a time-consuming setup.

**P.S.**: All of the website's interface and some of its source code are in Portuguese, as this project was first developed when I was a Computer Science undergraduate in Brazil.

# How does it work?

## Costumers

Once they have signed in, costumers can choose multiple items from a menu, including the items' descriptions, ingredients and price; place orders and finally pay when they are done eating.
Whenever costumers pay for their food, they accrue 10% of the price paid as a "bonus" (discount) on their next bill, as long as the next bill is not paid on the same day as the last one. Please keep in mind that, as this is a prototype, paying a bill will simply tag that bill as "paid" and will NOT actually establish connection with any billing service.

## Staff

Kitchen staff have a watchlist containing all placed orders, where they can also tag an order as done, delete it or check its ingredients.

Management can add staff (kitchen staff or more managers) and add, remove, update and check all items currently on the menu. Additionally, they can also see all clients who have registered themselves on the restaurant's system and delete them, if need be.

## Authors

* [**João Gabriel Setubal Pires**](https://github.com/jgspires)
* [**Marcela Braga Bahia**](https://github.com/mrssolarisdev)

## License

This project is licensed under the MIT License - see the LICENSE.md file for details.
