# Restaurant Prototype

This is a website and MySQL database created and designed for a fictional restaurant called "Le Bistro". The website is complete with costumer, kitchen and manager interfaces. The database contains all costumers, menu items and staff (kitchen staff or management) registered.

# Table of Contents
* [Repo Structure](https://github.com/jgspires/restaurant-prototype#repo-structure)
  * [Website Source](https://github.com/jgspires/restaurant-prototype#website-source)
  * [Screenshots](https://github.com/jgspires/restaurant-prototype#screenshots)
  * [bd_restaurante.sql](https://github.com/jgspires/restaurant-prototype#bd_restaurantesql)
* [How does it work?](https://github.com/jgspires/restaurant-prototype#how-does-it-work)
  * [For Costumers](https://github.com/jgspires/restaurant-prototype#costumers)
  * [For Staff](https://github.com/jgspires/restaurant-prototype#staff)
* [Gallery](https://github.com/jgspires/restaurant-prototype#gallery)
* [Authors](https://github.com/jgspires/restaurant-prototype#authors)
* [License](https://github.com/jgspires/restaurant-prototype#license)

# Repo Structure

## [**Website Source**](https://github.com/jgspires/restaurant-prototype/tree/main/Website%20Source):

Contains all of the web pages, JavaScript code, and images used in the website. Engineering wise, the website was developed using multiple design patterns, such as model-view-controller (MVC) to help organize and sectionalize the code, data-access-object (DAO) to interact with the database as well as singleton and factories to more easily and intuitively use some objects and classes.

The website was built using HTML, CSS, PHP, Bootstrap and JavaScript (using jQuery and AJAX requests).

## [**Screenshots**](https://github.com/jgspires/restaurant-prototype/tree/main/Screenshots):

Contains many screenshots of the website's various pages and modals.
The text is only available in Portuguese, but the aesthetic design and page structure can be easily observed regardless of language.

All screenshots are also available near the end of this readme, in [Gallery](https://github.com/jgspires/restaurant-prototype#gallery).

## **bd_restaurante.sql**:

This is the MySQL import script used to create the database and all necessary tables to make the website work correctly. It can be executed as is and will fill all tables with enough content so that the website can be properly tested without a time-consuming setup.

**P.S.**: All of the website's interface and some of its source code are in Portuguese, as this project was first developed when the authors were Computer Science undergraduates in Brazil.

# How does it work?

## Costumers

Once they have signed in, costumers can choose multiple items from a menu, including the items' descriptions, ingredients and price, place orders and finally pay when they are done eating.
Whenever costumers pay for their food, they accrue 10% of the price paid as a "bonus" (discount) on their next bill, as long as the next bill is not paid on the same day as the last one. Please keep in mind that, as this is a prototype, paying a bill will simply tag that bill as "paid" and will NOT actually establish connection with any billing service.

## Staff

Kitchen staff have a watchlist containing all placed orders, where they can also tag an order as done, delete it or check its ingredients.

Management can add staff (kitchen staff or more managers) and add, remove, update and check all items currently on the menu. Additionally, they can also see all clients who have registered themselves on the restaurant's system and delete them, if need be.

# Gallery

### Landing Page (All Users):

![alt text](Screenshots/landing.png?raw=true "Landing Page")

### Menu (All Users):

![alt text](Screenshots/menu.png?raw=true "Menu")

### Checkout (Costumers):

![alt text](Screenshots/checkout.png?raw=true "Checkout")

### Placed Orders (Kitchen Staff & Management):

![alt text](Screenshots/kitchenOrders.png?raw=true "Placed Orders / Kitchen")

### Update Menu Item Dialog (Management):

![alt text](Screenshots/updateMenuItem.png?raw=true "Update Menu Item Dialog")

## Authors

* [**João Gabriel Setubal Pires**](https://github.com/jgspires)
* [**Marcela Braga Bahia**](https://github.com/mrssolarisdev)

## License

This project is licensed under the MIT License - see the LICENSE.md file for details.
