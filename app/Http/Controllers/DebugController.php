<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function sessionInfo()
    {
        echo "<h1>Session Debug Info</h1>";
        echo "<pre>";
        print_r(session()->all());
        echo "</pre>";

        echo "<h1>Server Info</h1>";
        echo "<pre>";
        echo "PHP Version: " . PHP_VERSION . "\n";
        echo "Laravel Version: " . app()->version() . "\n";
        echo "URL: " . url()->current() . "\n";
        echo "Full URL: " . url()->full() . "\n";
        echo "</pre>";

        echo '<h1><a href="/standard/transactions">Test Transactions</a></h1>';
        echo '<h1><a href="/standard/financial-notes">Test Financial Notes</a></h1>';
        echo '<h1><a href="/standard/savings">Test Savings</a></h1>';
    }

    public function testTransactions()
    {
        echo "<h1>Testing Transactions Route</h1>";
        echo "<p>If you can see this, transactions route is working</p>";
        echo '<a href="/debug/session">Back to Session Debug</a>';
    }

    public function testFinancialNotes()
    {
        echo "<h1>Testing Financial Notes Route</h1>";
        echo "<p>If you can see this, financial notes route is working</p>";
        echo '<a href="/debug/session">Back to Session Debug</a>';
    }

    public function testSavings()
    {
        echo "<h1>Testing Savings Route</h1>";
        echo "<p>If you can see this, savings route is working</p>";
        echo '<a href="/debug/session">Back to Session Debug</a>';
    }
}
