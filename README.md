# Copy ZenDesk data into MySQL db

Does what it says on the tin, for use in cron etc.

Written by @i1yaz
Comissioned by @foshdafosh

## Installation:
* Run 'composer install'
* Run 'php artisan migrate'
* Create and edit .env as appropriate
* Visit yourappdomain.com/key
* Copy string into .env APP_KEY= variable

## Planned additions:
- [x] ZenDesk
    - [x] Users
    - [X] Identities
    - [x] Organisations
    - [x] Tickets
- [ ] Xero
    - [ ] Contacts
    - [ ] Sales Invoices
    - [ ] Quotes
    - [ ] Inventory (Products and Services)
    - [ ] Staff Time Off
    - [ ] Staff Timesheets
- [ ] GoCardless
    - [ ] Customers
    - [ ] Payments
    - [ ] Plans
    - [ ] Payouts
    - [ ] Events
- [ ] ProcessSt
- [ ] TeamViewer
- [ ] Metis
- [ ] Uptime Robot
- [ ] Gandi
- [ ] Mailchimp
- [ ] MySQL Import
    - [ ] Import tables from multiple MySQL databases, adding a prefix to tables (db1_mytable, db2_thattable etc) for each database
- [ ] Denormalise data using Views 
