<?php
/**
 * Created by PhpStorm.
 * User: Trah
 * Date: 27/09/2016
 * Time: 08:48
 */


$msg = $this->vars['msg'];
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];

$title = $this->vars['title'];
$description = $this->vars['description'];

include_once  'views/header.inc'; ?>

    <div class="content">
        <div class="container">
            <div class="col-lg-6">
                <h2 style="margin-top: 6px;"><?php if(isset($title)){ echo $title;} else { echo "No Data";};?></h2>
            </div>
            <div class="col-lg-6">

                <a  href="sorties/inscription" class="btn btn-danger btn-large pull-right">Je veux participer <i class="fa fa-angle-double-right"></i></a>
                <a  href="#" class="btn btn-info btn-large pull-right">Trouver itinéraire <i class="fa fa-angle-double-right"></i></a>
            </div>

            <br>
            <!-- Generate map -->
            <img class="center-block" src="http://placehold.it/1140x250">
            <div class="row features-two">

                <div class="col-md-12 col-sm-12">
                    <div class="f-block bblue">
                        <a href="#"><i class="fa fa-briefcase"></i></a>
                        <a href="#"><h3><?php if(isset($title)){ echo $title;} else { echo "No Data";};?></h3></a>
                        <p>
                            <?php if(isset($description)){ echo $description;} else { echo "No Data";};?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <img class="center-block" src="http://placehold.it/600x150">
            </div>



        </div>
    </div>

<?php
include_once 'views/footer.inc';