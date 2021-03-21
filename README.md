# Copy ZenDesk data into MySQL db

Does what it says on the tin, for use in cron etc.

Written by @i1yaz
Comissioned by @foshdafosh

## Installation:
* Run `composer install`
* Run `php artisan migrate`
* Create and edit .env as appropriate
* Visit yourappdomain.com/key
* Copy string into .env APP_KEY= variable

## Planned additions:
- [x] ZenDesk
    - [x] Users
    - [X] Identities
    - [x] Organisations
    - [x] Tickets
- [ ] [Xero](https://developer.xero.com/ "Xero Developer reference")
    - [ ] Contacts
    - [ ] Sales Invoices
    - [ ] Quotes
    - [ ] Items
    - [ ] Employee details
    - [ ] Staff Leave
    - [ ] Staff Timesheets
    - [ ] Users
- [ ] Date Dimension regeneration
    - [ ] [Template](https://gist.github.com/foshdafosh/9a5242f3df0e01d4ad782bf1379eefc2 "Date Dimension Gist")
    - [ ] Use first and last dates in available data as start and end
    - [ ] Create dates_holidays table, and automatically populate using [this file](https://www.gov.uk/bank-holidays/england-and-wales.ics "ics file from gov.uk")
- [ ] [ProcessSt](https://developer.process.st/ "Process St Developer reference")
    - [ ] Users
    - [ ] Templates
    - [ ] Checklists
    - [ ] Assignments
- [ ] TeamViewer
- [ ] [Metis (API in Beta)](http://metis2.pack-net.co.uk/api "Metis Developer reference, IP locked")
    - [ ] Channels
    - [ ] Customers
    - [ ] Calls
    - [ ] Invoices
- [ ] [Gandi](https://api.gandi.net/ "Gandi developer reference")
    - [ ] Domains
    - [ ] LiveDNS
    - [ ] Email
    - [ ] Billing
    - [ ] Organisation
    - [ ] Template
- [ ] [Uptime Robot](https://uptimerobot.com/api/ "Uptime Robot developer reference")
    - [ ] Monitors
    - [ ] Alert Contacts
    - [ ] Maintainance Windows
    - [ ] Public Status Pages
- [ ] WHM / cPanel
    - [ ] [Account Summary](https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+accountsummary)
    - [ ] [Disk Usage](https://documentation.cpanel.net/display/DD/WHM+API+1+Functions+-+getdiskusage)
- [ ] GoCardless
    - [ ] Customers
    - [ ] Payments
    - [ ] Plans
    - [ ] Payouts
    - [ ] Events
- [ ] [Square](https://developer.squareup.com/reference/square "Squareup Developer reference")
- [ ] Mailchimp
- [ ] MySQL Import
    - [ ] Import tables from multiple MySQL databases, adding a prefix to tables (db1_mytable, db2_thattable etc) for each database
- [ ] Denormalise data using Views
- [ ] Clockify - merge [original project](https://github.com/NotJustPCs/clockify-mysql) into this one
- [ ] Use webhooks etc to keep data up to date during the day
    - [ ] ZenDesk
    - [ ] Xero
    - [ ] ProcessSt
    - [ ] Metis
    - [ ] Uptime Robot
