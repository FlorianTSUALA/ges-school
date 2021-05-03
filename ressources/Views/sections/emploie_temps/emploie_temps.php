
<?php

use Core\Routing\URL;

$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/calendars/fullcalendar.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/calendars/fullcalendar.css">';
$include_res_header .= '';

$include_res_footer = '';    
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/moment.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/fullcalendar.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/locale-all.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>';    

ob_start();
include "emploie_temps-script.php";
$include_footer_script = ob_get_clean();

?>

<div class="app-content content">
    <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Full Calendar Advance</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Full Calendar
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-4 col-12">
                    <div class="btn-group float-md-right">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
                        <div class="dropdown-menu arrow"><a class="dropdown-item" href="#"><i class="fa fa-calendar mr-1"></i> Calender</a><a class="dropdown-item" href="#"><i class="fa fa-cart-plus mr-1"></i> Cart</a><a class="dropdown-item" href="#"><i class="fa fa-life-ring mr-1"></i> Support</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fa fa-cog mr-1"></i> Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="content-body">
            <!-- Full calendar advance example section start -->
            <section id="advance-examples">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">External Dragging</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <p class="card-text">Add extended dragging functionality with droppable option. Data can be attached to the element in order to specify its duration when dropped. A <code>Duration</code>-ish value can be provided. This can either be
                                        done via jQuery or via an <code>data-duration</code> attribute. This option operates with jQuery UI draggables. You must <code>download</code> the appropriate jQuery UI files and initialize a <code>draggable</code>                                            element. Additionally, you must set the calendar's <code>droppable</code> option to <code>true</code>.</p>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div id='external-events'>
                                                <h4>Cours </h4>
                                                <div class="fc-events-container">
                                                    <div class='fc-event' data-color='#2D95BF'>All Day Event</div>
                                                    <div class='fc-event' data-color='#48CFAE'>Long Event</div>
                                                    <div class='fc-event' data-color='#50C1E9'>Meeting</div>
                                                    <div class='fc-event' data-color='#FB6E52'>Birthday party</div>
                                                    <div class='fc-event' data-color='#ED5564'>Lunch</div>
                                                    <div class='fc-event' data-color='#F8B195'>Conference Meeting</div>
                                                    <div class='fc-event' data-color='#6C5B7B'>Party</div>
                                                    <div class='fc-event' data-color='#355C7D'>Happy Hour</div>
                                                    <div class='fc-event' data-color='#547A8B'>Dance party</div>
                                                    <div class='fc-event' data-color='#3EACAB'>Dinner</div>
                                                    <p>
                                                        <input type='checkbox' id='drop-remove' />
                                                        <label for='drop-remove'>remove after drop</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div id='fc-external-drag'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
            <!-- // Full calendar advance example section end -->
        </div>
    </div>  
</div>  