# Log Viewer

Log Viewer is a web-based application that helps you view and navigate log files on a Linux system. With an easy-to-use interface, you can quickly browse through log files

## Requirements

- PHP 8.0 or higher
- Composer
- A web server (e.g., Apache, Nginx)

## Installation

1. Clone the repository.
2. Run `composer install` to install the dependencies.
3. Start the PHP built-in web server with `php -S localhost:8000`.

## Usage

1. Open your browser and go to `http://localhost:8000`.

2. Log in with the username `admin` and password `admin`.

2. enter the path of file to view `it must start with /var/log`.

3. Navigate through the log file using the pagination controls. 

4. Log out when you are done.

## Running Tests

To run the unit tests, execute the following command:

`vendor/bin/phpunit` 

PHPUnit will execute the tests located in the `tests` directory and display the results.
