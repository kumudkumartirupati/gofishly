<?php
    require_once("includes/initialize.php");
    $title = "Go Fishly";
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    include "views/header.php";
?>
<section id="main-slider" class="carousel">
    <div class="carousel-inner" style="height:250px">
        <div class="item active">
            <div class="container">
                <div class="carousel-content">
                    <h1>Go Fishly</h1>
                    <p class="lead">The first Online Portal for Shopping Fish..</p>
                    <a href="#portfolio" class="btn btn-primary btn-lg">Go Fishing</a>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-content">
                    <h1>Exclusive Offers for Members</h1>
                    <p class="lead">Get best offers, Customized cutting and many more..</p>
                    <a href="#portfolio" class="btn btn-primary btn-lg">Go Fishing</a>
                </div>
            </div>
        </div>
    </div>
    <a class="prev" href="#main-slider" data-slide="prev"><i class="icon-angle-left"></i></a>
    <a class="next" href="#main-slider" data-slide="next"><i class="icon-angle-right"></i></a>
</section>
<section id="portfolio" style="">
    <div class="container">
    </br></br></br></br>
        <div class="box">
            <div class="center">
                <h2>Go Fishly</h2>
            </div><!--/.center-->
            <ul class="portfolio-items col-4">
                <?php
                    $fishes = Fish::find_all();
                    foreach ($fishes as $fish) {
                        if ($fish->hasPrm == 1) {
                            $index = 1;
                            $caption = 'Type : '.convert_to_camel_case($fish->type).'; Breed : '.convert_to_camel_case($fish->breed).'; Premium Chopping Styles: '.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'; Premium Cleaning Styles: '.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'; Premium Packing Options: '.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).';';
                        } elseif ($fish->hasPrm == 0) {
                            $index = 0;
                            $caption = 'Type : '.convert_to_camel_case($fish->type).'; Breed : '.convert_to_camel_case($fish->breed).'; Regular Chopping Styles: '.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'; Regular Cleaning Styles: '.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'; Regular Packing Options: '.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).';';
                        } else {
                            $index = 0;
                            $caption = 'Type : '.convert_to_camel_case($fish->type).'; Breed : '.convert_to_camel_case($fish->breed).'; Premium Chopping Styles: '.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'; Premium Cleaning Styles: '.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'; Premium Packing Options: '.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).'; Regular Chopping Styles: '.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'; Regular Cleaning Styles: '.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'; Regular Packing Options: '.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).';';
                        }
                        echo '<li class="portfolio-item apps">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img src="images/portfolio/thumb/'.$fish->img_tmb.'" width="235" height="170" alt="">
                                    <div class="overlay">
                                        <a class="preview btn btn-danger" title="'.$caption.'" href="images/portfolio/full/'.$fish->img_ful.'">
                                            <i class="icon-eye-open"></i>
                                        </a>
                                        <a class="overlay-link btn btn-primary" type="button" href="views/place_order.php?fsh_id='.$fish->id.'&prem='.$index.'">
                                            <i class="icon-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <h5>Type : '.convert_to_camel_case($fish->type).'; Breed : '.convert_to_camel_case($fish->breed).'</h5>
                            </div>
                        </li>';
                    }
                ?>
            </ul>   
        </div>
    </div>
</section>
<section id="contact">
    <div class="container"></br></br></br></br></br>
        <div class="box last">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Contact Form</h1>
                    <p>For any further Queries or Information, Please feel free to contact us..</p>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" required="required" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" required="required" placeholder="Email address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Message"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <h1>Our Address</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Go Fishly Pvt. Ltd</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                Dubai 94107<br>
                                <abbr title="Phone">Ph:</abbr> (123) 456-7890
                            </address>
                        </div>
                        <div class="col-md-6">
                            <address>
                                <strong>Go Fishly Pvt. Ltd</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                Kerala, India 94107<br>
                                <abbr title="Phone">Ph:</abbr> (123) 456-7890
                            </address>
                        </div>
                    </div>
                    <h1>Connect with us</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="social">
                                <li><a href="#"><i class="icon-facebook icon-social"></i> Facebook</a></li>
                                <li><a href="#"><i class="icon-google-plus icon-social"></i> Google Plus</a></li>
                                <li><a href="#"><i class="icon-pinterest icon-social"></i> Pinterest</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="social">
                                <li><a href="#"><i class="icon-linkedin icon-social"></i> Linkedin</a></li>
                                <li><a href="#"><i class="icon-twitter icon-social"></i> Twitter</a></li>
                                <li><a href="#"><i class="icon-youtube icon-social"></i> Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    include "views/footer.php";
    if(isset($database)) { $database->close_connection(); }
?>