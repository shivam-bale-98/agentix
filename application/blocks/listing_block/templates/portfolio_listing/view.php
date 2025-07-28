<?php defined("C5_EXECUTE") or die("Access Denied."); ?>



<div class="tp-perspective-area">
    <div class="container container-1685">
        <div class="row">
            <div class="col-xl-12 js-filter--section">
                <div class="">
                    <div class="filters w-full flex justify-center lg:gap-5 gap-3 flex-wrap">
                        <div class="select-box tabs relative multi-select">
                            <select class="select2" name="business_category" id="bussiness_category" multiple="multiple">
                                <option value="all">All Categories</option>
                                <option value="R & B">R & B</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Lifestyle">Lifestyle</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Advertising">Advertising</option>         
                            </select>
                            <span class="arrow"></span>
                         <div class="dropdown-result" data-lenis-prevent></div>
                        </div>


                        <div class="select-box tabs relative single-select">
                            <select class="select2" name="sector" id="sector">
                                <option value="all">All Sectors</option>
                                <option value="Web Development">Web Development</option>
                                <option value="App Development">App Development</option>
                                <option value="Marketing">Marketing</option>       
                            </select>
                            <span class="arrow"></span>
                         <div class="dropdown-result" data-lenis-prevent></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-perspective-slider">
                    <?php View::element("portfolio/view", ["pages" => $pages]); ?>
                </div>
            </div>
        </div>
    </div>
</div>