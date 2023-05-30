@extends('layouts.arx_bootstrap')
<?php
/**
 * This is a starter template for Demo Purpose
 *
 * You should never use this in production
 */
?>
@section('css')
    @parent
    <style>
        body {
            padding-top: 50px;
        }
        .starter-template {
            padding: 20px 0;
        }
    </style>
@stop

@section('body')
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                    @section('nav')
         µ           @show
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <div class="container starter-template">
        @section('content')
        <?php
        if (isset($content)):
            echo $content;
        else:
        ?>
        <div class="starter-template">
            <h1>Bootstrap starter template</h1>
            <p class="lead">Define a $content var to change this content.</p>
        </div>
        <?php
        endif;
        ?>
        @show
    </div> <!-- /container -->
@stop
