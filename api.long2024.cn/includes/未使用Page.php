<?php

    /**
     * 页面控制
     * @copyright (c) OUZERO All Rights Reserved.
     */
    class Page {
        /**
         * 页面路径
         * @var string|string[]
         */
        private $_path;

        /**
         * 路由方法
         * @var string
         */
        private $_method = '';

        /**
         * 页面参数
         * @var array|null
         */
        private $_params;

        /**
         * 内部实例对象
         * @var object|null
         */
        private static $_instance = null;

        public function __construct() {
            $this->_path = $this->_getPath();
            $routingTable = $this->_getRoutingTable();
            foreach($routingTable as $route) {
                $reg = isset($route['reg2']) ? $route['reg2'] : $route['reg1'];
                if(preg_match($reg, $this->_path, $matches)) {
                    $this->_method = $route['method'];
                    $this->_params = $matches;
                    break;
                } elseif(preg_match($route['reg1'], $this->_path, $matches)) {
                    $this->_method = $route['method'];
                    $this->_params = $matches;
                    break;
                }
            }
        }

        public static function getInstance() {
            !self::$_instance && self::$_instance = new Page();
            return self::$_instance;
        }

        /**
         * 路由分发
         */
        public function dispatch() {
            $method = $this->_method;
            empty($method) && return404();
            View::$method($this->_params);
        }

        /**
         * 获取页面路径
         * @return mixed|string|string[]
         */
        public function getPath() {
            return $this->_path;
        }

        /**
         * 判断是否首页
         * @return bool
         */
        public static function isHome() {
            $page = self::getInstance();
            return OZDAO_URL . trim($page->_path, '/') == OZDAO_URL;
        }

        /**
         * 获取路由表
         * @return string[][]
         */
        private function _getRoutingTable() {
            //reg1为默认链接，reg2为第二种。若method出现多次说明有多种伪静态链接
            return [
                [
                    'method' => 'displaySiteSort',
                    // /?sort=站点分类ID[&page=页数]
                    'reg1' => '|^.*/\?sort=(\d+)(?:&(page)=(\d+))?([\?&#]+.*)?$|i',
                    // /sort/站点分类ID[.html[?page=页数]]
                    'reg2' => '|^.*/sort/(\d+)(?:\.html)?(?:\?(page)=(\d+))?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displaySiteSort',
                    // /sort/分类链接别名[.html[?page=页数]]
                    'reg1' => '|^.*/sort/([^\./\?=]+)(?:\.html)(?:\?(page)=(\d+))?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displayPostSort',
                    // /?article=文章分类ID[&page=页数]
                    'reg1' => '|^.*/\?article=(\d+)(?:&(page)=(\d+))?([\?&#]+.*)?$|i',
                    // /article/文章分类ID[.html[?page=页数]]
                    'reg2' => '|^.*/article/(\d+)(?:\.html)?(?:\?(page)=(\d+))?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displayPostSort',
                    // /article/文章链接别名[.html[?page=页数]]
                    'reg1' => '|^.*/article/([^\./\?=]+)(?:\.html)(?:\?(page)=(\d+))?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displaySite',
                    // ?site=站点ID
                    'reg1' => '|^.*/\?site=(\d+)([\?&#]+.*)?$|i',
                    // /site-站点ID[.html]
                    'reg2' => '|^.*/site-(\d+)(?:\.html)?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displayPost',
                    // ?site=分类ID
                    'reg1' => '|^.*/\?post=(\d+)([\?&#]+.*)?$|i',
                    // /site-分类ID[.html]
                    'reg2' => '|^.*/post-(\d+)(?:\.html)?([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displaySiteList',
                    // /sort 显示站点列表
                    'reg1' => '|^/sort/?([\?&#].*)?$|i'
                ],
                [
                    'method' => 'displayPostList',
                    // /article 显示文章列表
                    'reg1' => '|^/article/?([\?&#].*)?$|i'
                ],
                [
                    'method' => 'displaySearch',
                    // /?keyword=关键词[?page=页数]
                    'reg1' => '|^.*/\?keyword=([^/&]+)(?:&(page)=(\d+))?([\?&#].*)?$|'
                ],
                [
                    'method' => 'displayGoto',
                    // /?goto=链接
                    'reg1' => '|^.*/\?goto=(.*)([\?&#].*)?$|',
                    // /goto/链接
                    'reg2' => '|^.*/goto/(.*)([\?&#].*)?$|'
                ],
                [
                    'method' => 'displaySiteMap',
                    // /sitemap.xml
                    'reg1' => '|^.*/sitemap\.xml$|i'
                ],
                [
                    'method' => 'checkType',
                    // /站点详情或文章链接别名[.html] 检测类型
                    'reg1' => '|^.*/([^\./\?=]+)(?:\.html)([\?&#]+.*)?$|i'
                ],
                [
                    'method' => 'displaySiteList',
//                    'method' => 'displayIndex',
                    // /?各种符号文字 显示首页
                    'reg1' => '|^/?([\?&#].*)?$|i'
                ]
            ];
        }

        /**
         * 获取当前访问的路径
         * @return string|string[]
         */
        private function _getPath() {
            if(isset($_SERVER['HTTP_X_REWRITE_URL'])) { //iis
                $path = $_SERVER['HTTP_X_REWRITE_URL'];
            } elseif(isset($_SERVER['REQUEST_URI'])) {
                $path = $_SERVER['REQUEST_URI'];
            } else {
                if(isset($_SERVER['argv'])) {
                    $path = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
                } else {
                    $path = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
                }
            }
            //for iis6 path is GBK
            if(isset($_SERVER['SERVER_SOFTWARE']) && false !== stristr($_SERVER['SERVER_SOFTWARE'], 'IIS')) {
                if(function_exists('mb_convert_encoding')) {
                    $path = mb_convert_encoding($path, 'UTF-8', 'GBK');
                } else {
                    $path = @iconv('GBK', 'UTF-8', @iconv('UTF-8', 'GBK', $path)) == $path ? $path : @iconv('GBK', 'UTF-8', $path);
                }
            }
            //for ie6 header location
            $r = explode('#', $path, 2);
            $path = $r[0];
            //for iis6
            $path = str_ireplace('index.php', '', $path);
            //for subdirectory
            $t = parse_url(OZDAO_URL);
            $path = str_replace($t['path'], '/', $path);
            return $path;
        }
    }