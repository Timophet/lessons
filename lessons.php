<html>
    <head>
        <title> Lessons Class </title>
        <meta charset="UTF-8">
    </head>
    <body
        <?php
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

        ?>
    </body>
</html>
