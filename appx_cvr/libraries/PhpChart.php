<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Library settings */ 
 define("CLASS_PATH", APPPATH."/third_party/pChart/class"); 
 define("FONT_PATH" , APPPATH."/third_party/pChart/fonts"); 

 /* pChart library inclusions */ 
 require(CLASS_PATH."/pData.class.php"); 
 require(CLASS_PATH."/pDraw.class.php"); 
 require(CLASS_PATH."/pImage.class.php"); 
 require(CLASS_PATH."/pPie.class.php");

/**
 * Description of Pdf
 *
 * @author edumu
 */
class PhpChart  { 
    
function PhpChart()
{

}
   
public function verticalChart()
{  
 $MyData = new pData();  
 $MyData->addPoints(array(13251,4118,3087,1460,1248,156,26,9,8),"Hits");
 $MyData->setAxisName(0,"Hits");
 $MyData->addPoints(array("Firefox","Chrome","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers");
 $MyData->setSerieDescription("Browsers","Browsers");
 $MyData->setAbscissa("Browsers");
 $MyData->setAbscissaName("Browsers");
 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);

 /* Create the pChart object */
 $myPicture = new pImage(500,500,$MyData);
 $myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
 $myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6));

 /* Draw the chart scale */ 
 $myPicture->setGraphArea(100,30,480,480);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); // 

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw the chart */ 
 $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30));

 /* Write the legend */ 
 $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->Render("charts/verticalChart.png");
}

public function edoCtaAcumBarChart($param)
{  
/* Create and populate the pData object */
 $MyData = new pData();  
 $MyData->addPoints($param['datosCuotas'], "Cuotas");
 $MyData->addPoints($param['datosGastos'], "Gastos");
 $MyData->setAxisName(0,"$");
 $MyData->addPoints( $param['leyendas'], "Meses");
 $MyData->setSerieDescription("Meses", "Mes");
 $MyData->setAbscissa("Meses");
 
 $myPicture = new pImage(400,230,$MyData);
 $myPicture->Antialias = FALSE; 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/verdana.ttf","FontSize"=>6));
 $myPicture->setGraphArea(50,30,400,200);
 $myPicture->drawScale(array("CycleBackground"=>FALSE,"DrawSubTicks"=>FALSE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"GridAlpha"=>10));
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 
 $settings = array("Gradient"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>FALSE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
 $myPicture->drawBarChart($settings);
 $myPicture->drawText(140, 10, $param['titulo'], array("DrawBox"=>TRUE, "BoxRounded"=>TRUE, "R"=>0, "G"=>0, "B"=>0, "Align"=>TEXT_ALIGN_TOPMIDDLE));
 $myPicture->drawLegend(280,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 
 $chart = "charts/edoCtaAcumBarChart_".$param['id'].".png";
 $myPicture->Render($chart);
 
 return $chart;
}

public function edoCtaMessPieChart($param)
{
 $MyData = new pData();   
 $MyData->addPoints($param['datos']   ,"Edo Cta");  
 $MyData->addPoints($param['leyendas'],"Labels");
 $MyData->setAbscissa("Labels");
 
 $myPicture = new pImage(280,200,$MyData,TRUE);
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/verdana.ttf","FontSize"=>11,"R"=>0,"G"=>0,"B"=>0));

 $PieChart = new pPie($myPicture,$MyData);
 $PieChart->setSliceColor(0,array("R"=>67 ,"G"=>150 ,"B"=>255 ));
 $PieChart->setSliceColor(1,array("R"=>204,"G"=>204 ,"B"=>204 ));

 $PieChart->draw3DPie(140,100,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
 
 $myPicture->setShadow(TRUE,array("X"=>3, "Y"=>3, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>10));  
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/verdana.ttf","FontSize"=>10));
 $myPicture->setShadow(TRUE, array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>20)); 
 $myPicture->drawText(140, 10, $param['titulo'], array("DrawBox"=>TRUE, "BoxRounded"=>TRUE, "R"=>0, "G"=>0, "B"=>0, "Align"=>TEXT_ALIGN_TOPMIDDLE));
 $PieChart->drawPieLegend(30, 150, array("Style"=>LEGEND_NOBORDER, "Mode"=>LEGEND_HORIZONTAL));

 $chart = "charts/edoCtaMespieChart_".$param['id'].".png";
 $myPicture->Render($chart);
 
 return $chart;
}

public function pieChart_II()
{
/* Create and populate the pData object */
 $MyData = new pData();   
 $MyData->addPoints(array(40,30,20),"ScoreA");  
 $MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $MyData->addPoints(array("A","B","C"),"Labels");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(700,230,$MyData,TRUE);

 /* Draw a solid background */
 $Settings = array("R"=>173, "G"=>152, "B"=>217, "Dash"=>1, "DashR"=>193, "DashG"=>172, "DashB"=>237);
 $myPicture->drawFilledRectangle(0,0,700,230,$Settings);

 /* Draw a gradient overlay */
 $Settings = array("StartR"=>209, "StartG"=>150, "StartB"=>231, "EndR"=>111, "EndG"=>3, "EndB"=>138, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));

 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Silkscreen.ttf","FontSize"=>6));
 $myPicture->drawText(10,13,"pPie - Draw 3D pie charts",array("R"=>255,"G"=>255,"B"=>255));

 /* Set the default font properties */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 /* Create the pPie object */ 
 $PieChart = new pPie($myPicture,$MyData);

 /* Define the slice color */
 $PieChart->setSliceColor(0,array("R"=>67 ,"G"=>150 ,"B"=>255 ));
 $PieChart->setSliceColor(1,array("R"=>204,"G"=>204 ,"B"=>204 ));
 $PieChart->setSliceColor(2,array("R"=>97 ,"G"=>113,"B"=>63   ));

 /* Draw a simple pie chart */ 
 $PieChart->draw3DPie(120,125,array("SecondPass"=>FALSE));

 /* Draw an AA pie chart */ 
 $PieChart->draw3DPie(340,125,array("DrawLabels"=>TRUE,"Border"=>TRUE));

 /* Enable shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw a splitted pie chart */ 
 $PieChart->draw3DPie(560,125,array("WriteValues"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));

 /* Write the legend */
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>6));
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
 $myPicture->drawText(120,200,"Single AA pass",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));
 $myPicture->drawText(440,200,"Extended AA pass / Splitted",array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 /* Write the legend box */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Silkscreen.ttf","FontSize"=>6,"R"=>255,"G"=>255,"B"=>255));
 $PieChart->drawPieLegend(600,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

 /* Render the picture (choose the best way) */
 $myPicture->Render("charts/pieChartII.png");
}

public function pieChart_III()
{
/* Create and populate the pData object */
 $MyData = new pData();   
 $MyData->addPoints(array(50,2,3,4,7,10,25,48,41,10),"ScoreA");  
 $MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $MyData->addPoints(array("A0","B1","C2","D3","E4","F5","G6","H7","I8","J9"),"Labels");
 $MyData->setAbscissa("Labels");

 /* Create the pChart object */
 $myPicture = new pImage(300,260,$MyData);

 /* Draw a solid background */
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
 $myPicture->drawFilledRectangle(0,0,300,300,$Settings);

 /* Overlay with a gradient */
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
 $myPicture->drawGradientArea(0,0,300,260,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,299,259,array("R"=>0,"G"=>0,"B"=>0));

 /* Write the picture title */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Silkscreen.ttf","FontSize"=>6));
 $myPicture->drawText(10,13,"pPie - Draw 2D pie charts",array("R"=>255,"G"=>255,"B"=>255));

 /* Set the default font properties */ 
 $myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 /* Create the pPie object */ 
 $PieChart = new pPie($myPicture,$MyData);

 /* Draw an AA pie chart */ 
 $PieChart->draw3DPie(160,140,array("Radius"=>70,"DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE));

 /* Write the legend box */ 
 $myPicture->setShadow(FALSE);
 $PieChart->drawPieLegend(15,40,array("Alpha"=>20));

 /* Render the picture (choose the best way) */
 $myPicture->Render("charts/pieChartIII.png");
}

}
