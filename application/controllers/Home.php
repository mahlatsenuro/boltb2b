<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends App_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('base_model');
    }

    public function index(){
       	$this->render_page('home/index', array());
    }


    public function shop(){
        $this->render_page('home/shop', array());
    }

    public function details(){

        $this->assets_js = array(
            'parallax.js',
            'jquery-waypoints.js',
            'jquery-countTo.js',
            'jquery.countdown.js',
            'owl.carousel.min.js',
            'gmap3.min.js',
            'https://maps.googleapis.com/maps/api/js?key=AIzaSyAIEU6OT3xqCksCetQeNLIPps6-AYrhq-s&amp;region=GB',
            'jquery-ui.js',
            'jquery.cookie.js'
        );

        $this->render_page('home/details', array());
    }
}