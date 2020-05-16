<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by piero.ir.
 * User: pirooz jenabi
 * Date: 6/26/18
 * Time: 3:01 PM
 */
class Plotly
{

    function __construct()
    {
        $CI =& get_instance();
        echo $CI->template->load_custom_js("plotly-latest.min");
    }

    //make to set array of x and y
    function make_array($in)
    {
        return json_encode($in);
    }

    //make place for do chart
    function make_div($name=null,$class=null)
    {
        $name=($name)?$name:"pir".rand(1, 999);
        $class="plotly ".$class;
        ?>
        <div id="<?php echo $name ?>" class="<?php echo $class?>" > </div>
        <?php
        return $name;
    }

    //line chart // mode= lines , markers , bar
    function simple($x,$y,$title="",$mode="lines+markers+text")
    {
        $div=$this->make_div();

        ?>

        <script>

            var trace = {
                x: <?php echo $this->make_array($x) ?>,
                y: <?php echo $this->make_array($y) ?>,
                type: '<?php echo $mode ?>',
                marker: {
                    color: '#4DB6AC'
                }
            };

            var data = [ trace];

            var layout = {
                title: '<?php echo $title ?>',
                font: {
                    family: '<?php echo _FONT_FAMILY ?>',
                    size: 15,
                    color: '#7f7f7f'
                }
            };

            Plotly.newPlot('<?php echo $div ?>', data, layout);

        </script>
        <?php

    }
}
