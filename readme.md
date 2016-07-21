# Dummy Data Generator

Go to `ERP Settings => Tools`

**Warning:** This will delete your all existing employees, departments and designations

![Tools Page](http://i.imgur.com/R5R5YlF.png)

## Installation

1. Clone the repo
1. Run the command `composer install`

## CLI Commands

```bash
wp erp-seeder seed customer --num=1000
// or
wp erp-seeder seed employee --num=1000
```

```bash
wp erp-seeder truncate employee
```