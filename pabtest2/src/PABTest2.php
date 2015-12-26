<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 22.12.2015
 * Time: 17:22
 */

namespace errogaht\PABTest2;



class PABTest2
{
    const COOKIE_NAME = 'adc54e5f3ca5d5e';
    const SESS_VAR = 'adc54e5f3ca5d5e';
    const SECRET = '353e5f35c53a3553b';
    private $values;
    private $weights;
    private $testName;
    private $canOperate = false;

    /**
     * Creates A/B test
     *
     *
     * Example:
     * $formTest = new ABTest('formTest', ['big' => 70, 'small' => 30]);
     * creates test «formTest» with two variants:
     * big - will flow ~ 70% traffic
     * small - will flow ~ 30% traffic
     * 70 and 30 is not percent, this is weight, 100/100 or 2/2 equivalent to 50%/50%
     * 1/2 equivalent to 33%/66%
     *
     * @param $name string|integer test name
     * @param $data array variants data
     *
     */
    public function __construct($name, $data)
    {
        if (empty($name) || empty($data) || count($data) < 2) {

        } else {
            if (is_int(reset($data))) {
                $this->testName = $name;
                $this->values = array_keys($data);
                $this->weights = array_values($data);
                $this->canOperate = true;

            }
        }
    }


    /**
     * Just session init, if your app not using session place
     * ABTest::init() before headers sent
     *
     */
    public static function init($config)
    {
        DB::setConfig($config);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Register reach goal
     *
     * Example:
     * ABTest::reachGoal('formTest')
     *
     * @param $name
     *
     * @return void
     */
    public static function reachGoal($name)
    {
        if (!empty($_SESSION[self::SESS_VAR][$name]['notReached'])) {
            $conn = DB::getConn();
            $sql = "UPDATE variants SET goals = goals + 1 WHERE test_name = ? AND variant = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $_SESSION[self::SESS_VAR][$name]['variant']);
            $stmt->execute();
            $_SESSION[self::SESS_VAR][$name]['notReached'] = false;
        }
    }

    /**
     * Returns variant
     *
     * Example:
     * $template = 'forms/ABTest/formTest-' . $formTest->getVariant() . '.twig';
     * $html = $twig->render($template);
     * in folder forms/ABTest/ :
     * formTest-big.twig
     * formTest-small.twig
     *
     * @return string
     */
    public function getVariant()
    {
        if ($this->canOperate) {
            if (!empty($_SESSION[self::SESS_VAR][$this->testName]['variant'])) {
                $selectedVariant = $_SESSION[self::SESS_VAR][$this->testName]['variant'];
            } else {
                $selectedVariant = $this->weightedRandom();

                $conn = DB::getConn();
                $result = $conn->fetchAssoc('SELECT * FROM variants WHERE test_name = ? AND variant = ?',
                    [$this->testName, $selectedVariant]);
                if (empty($result)) {
                    $conn->insert('variants',
                        [
                            'test_name' => $this->testName,
                            'variant'   => $selectedVariant,
                            'shows'     => 1
                        ]);
                } else {
                    $conn->update('variants', ['shows' => $result['shows'] + 1], array('id' => $result['id']));
                }
                $_SESSION[self::SESS_VAR][$this->testName]['variant'] = $selectedVariant;
                $_SESSION[self::SESS_VAR][$this->testName]['notReached'] = true;
            }

            return $selectedVariant;
        }

        return '';
    }

    /**
     * Выборка случайного элемента с учетом веса
     *
     * @return mixed выбранный элемент
     * @internal param array $values индексный массив элементов
     * @internal param array $weights индексный массив соответствующих весов
     *
     */
    private function weightedRandom()
    {
        $total = array_sum($this->weights);
        $n = 0;

        $num = mt_rand(1, $total);

        foreach ($this->values as $i => $value) {
            $n += $this->weights[$i];

            if ($n >= $num) {
                return $this->values[$i];
            }
        }
    }

    /**
     * @return boolean
     */
    public function isCanOperate()
    {
        return $this->canOperate;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return array
     */
    public function getWeights()
    {
        return $this->weights;
    }


}