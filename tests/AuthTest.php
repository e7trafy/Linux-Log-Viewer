<?php

use App\Auth;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    public function testIsAuthenticated()
    {
        // Test for an authenticated user.
        $_SESSION['loggedin'] = true;
        $this->assertTrue(Auth::isAuthenticated());

        // Test for a non-authenticated user.
        $_SESSION['loggedin'] = false;
        $this->assertFalse(Auth::isAuthenticated());
    }

    public function testLogin()
    {
        // Test successful login
        $this->assertTrue(Auth::login('admin', 'admin'));
        $this->assertTrue(Auth::isAuthenticated());

        // Test unsuccessful login
        $this->assertFalse(Auth::login('admin', 'wrong_password'));
        $this->assertFalse(Auth::login('wrong_username', 'admin'));
        $this->assertFalse(Auth::login('wrong_username', 'wrong_password'));
    }

    public function testLogout()
    {
        // Log in first
        Auth::login('admin', 'admin');
        $this->assertTrue(Auth::isAuthenticated());

        // Test logout
        Auth::logout();
        $this->assertFalse(Auth::isAuthenticated());
    }
}
