<!DOCTYPE html>
<!--
Template Name: Enigma - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        @include('layouts.head')
        
    </head>
    <!-- END: Head -->
    <body class="py-5 md:py-0">
        <!-- BEGIN: Mobile Menu -->
        @include('layouts.mobilemenu')
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        @include('layouts.topbar')
        <!-- END: Top Bar -->
      
        <div class="flex overflow-hidden">
            
            <!-- BEGIN: Side Menu -->
            @include('layouts.sidebar')
            <!-- END: Side Menu -->
          
            <!-- BEGIN: Content -->
            <div id="fm" style="height: 600px;"></div>
            <div class="content">
                {{-- @include('layouts.content') --}}
                {{-- @include('layouts.notification') --}}
                @yield('content')
            </div>
            <!-- END: Content -->
        </div>
        
        @include('layouts.footer')
    </body>
</html>