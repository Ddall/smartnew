<?php

namespace AppBundle\Controller;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Ob\HighchartsBundle\Highcharts\Highstock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zend\Json\Expr;

class ChartsController extends Controller {

    /**
     * @Route("/chart", name="chart")
     */
    public function indexAction(Request $request) {

        $series = array(
            array(
                'name'  => 'Rainfall',
                'type'  => 'column',
                'color' => '#4572A7',
                'yAxis' => 1,
                'data'  => array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4),
            ),
            array(
                'name'  => 'Temperature',
                'type'  => 'spline',
                'color' => '#AA4643',
                'data'  => array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6),
            ),
        );

        $yData = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " degrees C" }'),
                    'style'     => array('color' => '#AA4643')
                ),
                'title' => array(
                    'text'  => 'Temperature',
                    'style' => array('color' => '#AA4643')
                ),
                'opposite' => true,
            ),
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " mm" }'),
                    'style'     => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text'  => 'Rainfall',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );
        $categories = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $ob = new Highchart();
        $ob->chart->renderTo('linechart'); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text('Average Monthly Weather Data for Tokyo');
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(   false);
        $formatter = new Expr('function () {
                 var unit = {
                     "Rainfall": "mm",
                     "Temperature": "degrees C"
                 }[this.series.name];
                 return this.x + ": <b>" + this.y + "</b> " + unit;
             }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);

        return $this->render('@App/basechart.html.twig', array(
            'chart' => $ob,
        ));
    }

    public function stockAction(Request $request){
        $data = array(

        );


        $ob = new Highchart();
        $ob->chart->renderTo('linechart');

        $ob->series($data);


        return $this->render('@App/basechart.html.twig', array(
            'chart' => $ob,
        ));
    }


























}
