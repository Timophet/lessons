<html>
    <head>
        <title> Lessons Class </title>
        <meta charset="UTF-8">
    </head>
    <body
        <?php
            
            //-----------------------------------------------------------------
            class Lesson
            {
                private $duration;
                private $costStrategy;
                function __construct($duration, CostStrategy $strategy)
                {
                    $this->duration = $duration;
                    $this->costStrategy = $strategy;
                }
                function cost()
                {
                    return $this->costStrategy->cost($this);
                }
                function chargeType()
                {
                    return $this->costStrategy->chargeType();
                }
                function getDuration()
                {
                    return $this->duration;
                }
            }
            /*
            class Lecture extends Lesson
            {
                //private type = "lecture";
                
            }
            */
            
            abstract class CostStrategy 
            {
                abstract function cost (Lesson $lesson);
                abstract function chargeType();
            }
            class TimedCostStrategy extends CostStrategy
            {
                function cost(Lesson $lesson)
                {
                    return ($lesson->getDuration() * 5);
                }
                function chargeType()
                {
                    return "Почасовая оплата";
                }
            }
            class FixedCostStrategy extends CostStrategy
            {
                function cost(Lesson $lesson)
                {
                    return 30;
                }
                function chargeType()
                {
                    return "Фиксированная ставка";
                }    
            }
            
            $lessons[] = new Lesson(4, new TimedCostStrategy());
            $lessons[] = new Lesson(5, new FixedCostStrategy());
            foreach ($lessons as $lesson)
            {
                $str = "Стоимость " . $lesson->cost() . ";"; // . lesson->cost() . ; 
                $str .= " Тип " . $lesson->chargeType();
                print "<a> $str; </a> <br>";
            }
            
            //-----------------------------------------------------------------
            
            class Preferences
            {
                private $prop = array();
                private static $instance;
                private function __construct() 
                {
                    ;
                }
                
                public function getInstance()
                {
                    if(empty (self::$instance))
                    {
                        self::$instance = new Preferences();
                    }
                    return self::$instance;
                }

                public function setProperty ($key, $val)
                {
                    $this->prop[$key] = $val;
                }
                public function getProperty ($key)
                {
                    return $this->prop[$key];
                }
                
            }
            $prep = Preferences::getInstance();
            $prep->setProperty("name", "Иван");
            unset($prep);
            
            $prep2 = Preferences::getInstance();
            
            $str = $prep2->getProperty("name");
            print "<a> $str </a>"; 

            //------------------------------------------------------------------
            
            abstract class ApptEncoder
            {
                abstract function encode();
            }
            
            class BloggsApptEncoder extends ApptEncoder
            {
                function encode() 
                {
                    return "Данные о встрече в формате BloggsCal";
                }
            }
            class MegaApptEncoder extends ApptEncoder
            {
                function encode() 
                {
                    return "Данные о встрече в формате MegaCal";
                }
            }
            
            abstract class CommsManager
            {
                abstract function getHeaderText();
                abstract function getApptEncoder();
                abstract function getFooterText();
                            
            }
            
            class BlogsCommsManager extends CommsManager
            {
                function getHeaderText()
                {
                    return "BloggsCal верхний колонтитул";
                }
                function getApptEncoder() 
                {
                    return new BloggsApptEncoder();
                }
                function getFooterText()
                {
                    return "BloggsCal нижний колонтитул";
                }
            }
            
            $blog = new BlogsCommsManager();
            $str = "header -" . $blog->getHeaderText() . "; Footer - " . $blog->getFooterText() . "<br>";
            $str .= "отправка в  формате Bloggs: " . $blog->getApptEncoder()->encode();
            
             print "<a> $str </a>"; 
            
             
             //-----------------------------------------------------------------
             abstract class Sea
             {
                 abstract function getSea();
                 abstract function setId($id);
                 abstract function printId();
             }
             
             class EarthSea extends Sea
             {
                 private $id;
                 function setId($id)
                 {
                     $this->id = $id;
                     print "<br> $this->id <br>";
                 }
                 function printId()
                 {
                     print "<br> $this->id <br>";
                 }
                 function getSea() 
                 {
                     return "EarthSea";
                 }
             }
             
             class MarsSea extends Sea
             {
                 function setId($id)
                 {
                     $this->id = $id;
                 }
                 function printId()
                 {
                     print "<br> $this->id <br>";
                 }
                 function getSea()
                 {
                     return "MarsSea";
                 }
             }
             
             abstract class Plaints
             {
                 abstract function getPlaints();
                 
             }
             
             class EarthPlaints extends Plaints
             {
                 function getPlaints() 
                 {
                     return "EarthPlaints";
                 }
             }
             
             class MarsPlaints extends Plaints
             {
                 function getPlaints()
                 {
                     return "MarsPlaints";
                 }
             }
            
             abstract class Forest
             {
                 abstract function getForest();
                 
             }
             
             class EarthForest extends Forest
             {
                 function getForest() 
                 {
                     return "EarthForest";
                 }
             }
             
             class MarsForest extends Forest
             {
                 function getForest()
                 {
                     return "MarsForest";
                 }
             }
             
             class TerrainFactory
             {
                 private $sea;
                 private $plaints;
                 private $forest;
                 
                 function __construct(Sea $sea, Plaints $plaints, Forest $forest) 
                {
                     $this->sea = $sea;
                     $this->plaints = $plaints;
                     $this->forest = $forest;
                 }
                 function setSeaId($id)
                 {
                     $this->sea->setId($id);
                 }
                 function printSea()
                 {
                     $this->sea->printId();
                 }


                 function cloneSea()
                 {
                     return clone $this->sea;
                 }
                 
                 function clonePlaints()
                 {
                     return clone $this->plaints;
                 }
                 function cloneForest()
                 {
                     return clone $this->forest;
                 }
                 
             }
             
             $earthFactory = new TerrainFactory(new EarthSea(), new EarthPlaints, new EarthForest);
             $marsFactory = new TerrainFactory(new MarsSea(), new MarsPlaints, new EarthForest);
             print "<br>";
             $earthStr = "Sea - " . $earthFactory->cloneSea()->getSea() . "; "; 
             $earthStr .= "Plaints - " . $earthFactory->clonePlaints()->getPlaints() . "; ";
             $earthStr .= "Forest - " . $earthFactory->cloneForest()->getForest() . "; ";
             
             $marsStr = "Sea - " . $marsFactory->cloneSea()->getSea() . "; "; 
             $marsStr .= "Plaints - " . $marsFactory->clonePlaints()->getPlaints() . "; ";
             $marsStr .= "Forest - " . $marsFactory->cloneForest()->getForest() . "; ";
             
             $earthFactory->setSeaId(10);
            // $earthFactory->printSea();
             $cloneFactory = clone $earthFactory;
             $cloneFactory->printSea();
             $earthFactory->setSeaId(20);
             $cloneFactory->printSea();
             
                     
             print "<br> $earthStr <br>";
             
             print "<br> $marsStr <br>";
             
             
             
        ?>
    </body>
</html>
