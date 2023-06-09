@extends('arx::layouts.bootstrap')

@section('body')
<body class="page-blog">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ $project['link'] ?: Lang::get('project.link') }}">{{ $project['name'] ?: Lang::get('project.name') }}</a>
            </div>
            <div class="collapse navbar-collapse">
                @section('nav')
                <?php
                echo  \Arx\BootstrapHelper::nav(
                    $nav,
                    array('parent@' => array('class' => 'nav navbar-nav')));
                ?>
                @show
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Blog Home 1 <small>Blog Homepage</small></h1>
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Blog Home 1</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <h1><a href="blog-post.html">A Blog Home Template for Bootstrap 3</a></h1>
                <p class="lead">by <a href="#">Start Bootstrap</a></p>
                <hr>
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Posted on August 28, 2013 at 10:00 PM</p>
                <hr>
                <a href="blog-post.html"><img src="http://placehold.it/900x300" class="img-responsive"></a>
                <hr>
                <p>This is a very basic starter template for a blog homepage. It makes use of Font Awesome icons that are built into the 'Modern Business' template, and it makes use of the Bootstrap 3 pager at the bottom of the page.</p>
                <a class="btn btn-primary" href="blog-post.html">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>

                <hr>

                <h1><a href="blog-post.html">Another Blog Post</a></h1>
                <p class="lead">by <a href="#">Start Bootstrap</a></p>
                <hr>
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <a href="blog-post.html"><img src="http://placehold.it/900x300" class="img-responsive"></a>
                <hr>
                <p>Science cuts two ways, of course; its products can be used for both good and evil. But there's no turning back from science. The early warnings about technological dangers also come from science...</p>
                <a class="btn btn-primary" href="blog-post.html">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>

                <hr>

                <h1><a href="blog-post.html">Third Blog Post Entry</a></h1>
                <p class="lead">by <a href="#">Start Bootstrap</a></p>
                <hr>
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <a href="blog-post.html"><img src="http://placehold.it/900x300" class="img-responsive"></a>
                <hr>
                <p>Science cuts two ways, of course; its products can be used for both good and evil. But there's no turning back from science. The early warnings about technological dangers also come from science...</p>
                <a class="btn btn-primary" href="blog-post.html">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>

                <hr>

                <ul class="pager">
                    <li class="previous"><a href="#">&larr; Older</a></li>
                    <li class="next"><a href="#">Newer &rarr;</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                      </span>
                    </div><!-- /input-group -->
                </div><!-- /well -->
                <div class="well">
                    <h4>Popular Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#dinosaurs">Dinosaurs</a></li>
                                <li><a href="#spaceships">Spaceships</a></li>
                                <li><a href="#fried-foods">Fried Foods</a></li>
                                <li><a href="#wild-animals">Wild Animals</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#alien-abductions">Alien Abductions</a></li>
                                <li><a href="#business-casual">Business Casual</a></li>
                                <li><a href="#robots">Robots</a></li>
                                <li><a href="#fireworks">Fireworks</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Bootstrap's default well's work great for side widgets! What is a widget anyways...?</p>
                </div><!-- /well -->
            </div>
        </div>
    </div><!-- /.container -->

    <div class="container">
        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Company 2013</p>
                </div>
            </div>
        </footer>
    </div><!-- /.container -->

</body>
@stop
