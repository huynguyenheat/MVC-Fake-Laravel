<?php
class App{
    public $controller = 'HomeController';
    public $method = 'index';
    public $params = [];

    public function __construct(){
        $url = $this->parseURL();
        if(isset($url[0]) && file_exists('app/controllers/'.$url[0].'Controller.php')){
            $this->controller = $url[0].'Controller';
            unset($url[0]);
        }
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        if(isset($url[1]) && method_exists($this->controller, $url[1])){
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        //RedirectFilters
        if($redirectUrl = self::redirectFilters($this->controller, $this->method, $this->params)){
            header("Location: $redirectUrl");
            return;
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
        //var_dump($url);
    }

    private function parseURL(){
        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }



    // Giai thich co che annotation: 
    // 1/ Khi constructor app duoc khoi tao, den buoc gan controller va method thi: 
    // 2/ Thuc hien check annotation xxFilter co duoc khai bao cho class controller hoac cho mot method nao do trong controller hay khong (bang ham redirectfilter), neu co se goi function xxFilter trong app de tra ve string url redirect va return khong cho qua buoc goi method sau cung 
    // 3/ Ham redirect tao 1 PHP Reflection class de su dung method getDocComment, lay ra annotate document cua class va method trong class (neu co)
    // 4/ Xu ly docComment do thanh 1 array chua cac filter duoc khai bao trong annotate thong qua Regex string va explode boi dau phay de tao array filter cua class va array filter cua method trong class (neu co)
    // 5/ Tap hop array lai, filter null, 0 v.v loai di va dung array_value de index lai theo numeric key cho cac filter sau cung
    // 6/  chay array filter do bang vong lap while, neu moi phan tu function xx filter ma co khai bao trong class app thi se excute function xxFilter do, thiet lap xxFilter return ve string url muon redirect truoc do roi, nen khi do lai quay ve buoc 1, neu ham redirectfilter co tra ve ket qua thi se goi Header Location de dieu huong ngan khogn cho user truy cap method ho da chi dinh

    //LoginFilter
    private static function redirectFilters($class, $method, $params){
        $reflection = new ReflectionClass($class);

        $classDocComment = $reflection->getDocComment();
        $methodDocComment = $reflection->getMethod($method)->getDocComment();

        //parse and extract the filters
        $classFilters = self::getFiltersFromAnnotations($classDocComment);
        $methodFilters = self::getFiltersFromAnnotations($methodDocComment);

        $filters = array_values(array_filter(array_merge($classFilters, $methodFilters)));

        $redirect = self::runFilters($filters, $params);

        return $redirect;
    }

    private static function getFiltersFromAnnotations($docComment){
        preg_match('/@accessFilter:{(?<content>.+)}/i', $docComment, $content);
        $content = (isset($content['content'])?$content['content']:'');
        $content = explode(',', str_replace(' ', '', $content));
        return $content; //this is an array 
    }

    //runFilters
    private static function runFilters($filters, $params){
        $redirect = false;
        $max = count($filters);
        $i = 0;
        while(!$redirect && $i<$max){
            if(method_exists('Filter', $filters[$i])){
                $redirect = Filter::{$filters[$i]}($params);
            }else{
                throw new Exception("No policy named $filters[$i]");
            }
            $i++;
        }
        return $redirect;
    }

}

?>
