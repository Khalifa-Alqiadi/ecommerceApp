<?php


function lang($phrase){

    static $lang = array(

        // Navbar Links

        
       
        'ADMIN'           => 'Admin Login',
            'USERNAMEADMIN'                  => 'Username',
            'PASSWORDADMIN'                  => 'Password',
            'LOGINADMIN'                     => 'Login',
        'HOME'            => 'Home',
            'DASHBOAEDS'                     => 'Dashboard',
            'TOTALMEMBERS'                   => 'Total Members',
            'PENDINGMEMBERS'                 => 'Pending Members',
            'TOTALITEMS'                     => 'Total Items',
            'TOTALCOMMENTS'                  => 'Total Comments',
            'LATESTREGISTERDUSER'            => 'Latest Registerd Users',
            'LATESTITEMS'                    => 'Latest Items',
        'CATEGORISE'      => 'Categorise',
        'ITEMS'           => 'Items',
        'MEMBERS'         => 'Members',
        'STATISTICS'      => 'Statistics',
        'COMMENTS'      => 'Comments',
        'LOGS'            => 'Logs',
        'EDIT_PROFILE'    => 'Edit Profile',
        'SETTINGS'        => 'Settings',
        'LOGOUT'          => 'Logout'

    );

    return $lang[$phrase];
}