Event Driven Microservice

### GITHUB add Token to push branch

Github.com -> Settings -> Developer Settings -> Personal acces tokens -> Generate new token
git remote add origin https://<token>@github.com/birneos/event-driven-symfony-promotions-microservice.git
git push -u origin main

git checkout -b project-start
git push origin project-start

#### Switch PHP Version

php -v
/etc/php
sudo apt install 8.2 8.3 8.4
sudo update-alternatives --set php /usr/bin/php8.x

### Code Quality with PHPStand, Codesniffer and PHPLint

ddev exec composer run-phpstan
ddev exec composer run-phpcs
ddev exec composer run-phplint

### What is the problem, what the Story

Think backwards
By starting at the end and having absolute clarity as to what you need to produce, you'll avoid less rework and you'll write less code, and more importantly..you will successfully produce what you need to produce, bug free and most likely, within the allotted timescale. Companies love developers that can be depended upon to do this.

1. What need our CDP (Customer Data Platform) from us ?

Which format?

- JSON Format

CDP (Customer Data Platform) need to wich pieces of data?

We are looking for two different pieces of data?

    - first data - new subscription or users first interaction for specific user, for specific event (Identify Model)
    - other data - for all user interactions and events, we want track the behaviors, things user interested in, might
    wish to subscribe to or to buy (Track Event)

2. The idea to represent this?

   - we create 2 Models Identify Model and Track Model
   - we need an model interface for objects
   - objects has toArray Method to output in array format

3. Create temporary Model

   - create models.php that has a anonymous class which implement model interface an return array with data

4. Create Client with 2 Endpoints to send data for indifiying or tracking

5. Create WebhookController and Application Tests and Unit Tests
