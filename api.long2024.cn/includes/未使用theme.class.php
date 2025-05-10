<?php

    /**
     * 视图控制
     * @copyright (c) OUZERO All Rights Reserved.
     */
    class View {
        /**
         * 获取视图路径
         * @param $template
         * @param string $ext
         * @return string
         */
        public static function getView($template, $ext = 'php') {
            if(!is_dir(theme)) {
                die('当前模板可能不存在，或者已被删除或损坏！');
            } elseif(!is_file(theme . $template . '.' . $ext)) {
                return404();
            }
            return theme . $template . '.' . $ext;
        }

        /**
         * 视图输出
         */
        public static function outPut() {
            $page = Page::getInstance();
            $page->dispatch();
        }

        /**
         * 显示站点列表
         */
        public static function displaySiteList() {
            global $DATA, $CONFIG;
            $sorts = $DATA->getSiteSorts();
            $number = is_numeric($CONFIG['number']) ? $CONFIG['number'] : null;
            foreach($sorts as $key => $sort) {
                $sorts[$key]['sites'] = $DATA->getSitesBySortId($sort['id'], $number);
            }
            $ads = $DATA->getAdsByPage('list');
            $webTitle = $CONFIG['title'];
            $webKeywords = $CONFIG['keywords'];
            $webDescription = $CONFIG['description'];
            unset($number);
            include self::getView('header');
            include self::getView('list');
        }

        /**
         * 显示文章列表
         */
        public static function displayPostList() {
            global $DATA, $CONFIG;
            $sorts = $DATA->getPostSorts();
            $number = is_numeric($CONFIG['number']) ? $CONFIG['number'] : null;
            foreach($sorts as $key => $sort) {
                $sorts[$key]['posts'] = $DATA->getPostsBySortId($sort['id'], $number);
            }
            $ads = $DATA->getAdsByPage('postList');
            $webTitle = $CONFIG['title'];
            $webKeywords = $CONFIG['keywords'];
            $webDescription = $CONFIG['description'];
            unset($number);
            include self::getView('header');
            include self::getView('list_post');
        }

        /**
         * 显示分类站点
         * @param $params
         */
        public static function displaySiteSort($params) {
            global $DATA, $CONFIG;
            $nowPage = isset($params[2]) && $params[2] == 'page' ? intval($params[3]) : 1;
            $number = is_numeric($CONFIG['sitePaging']) ? $CONFIG['sitePaging'] : null;
            $startNum = is_numeric($number) && is_numeric($nowPage) ? ($nowPage - 1) * $number : null;
            if(is_numeric($params[1])) {
                $sortId = intval($params[1]);
            } else {
                $alias = myAddSlashes(urldecode(trim($params[1])));
                $sortId = $DATA->getSortIdByAlias($alias);
                !$sortId && return404();
            }
            $sort = $DATA->getSortById($sortId);
            (!$sort || $sort['type'] != '1') && return404();
            $sort['sites'] = $DATA->getSitesBySortId($sortId, $number, $startNum);
            $siteNum = $DATA->getCount('site', 'sortId = ' . $sortId);
            $ads = $DATA->getAdsByPage('siteSort');
            $webTitle = $sort['name'] . ' - ' . $CONFIG['name'];
            $webKeywords = $sort['name'] . ',' . $CONFIG['keywords'];
            $webDescription = $sort['name'] . ',' . $CONFIG['description'];
            unset($params, $number, $startNum);
            include self::getView('header');
            include self::getView('sort');
        }

        /**
         * 显示分类文章
         * @param $params
         */
        public static function displayPostSort($params) {
            global $DATA, $CONFIG;
            $nowPage = isset($params[2]) && $params[2] == 'page' ? intval($params[3]) : 1;
            $number = is_numeric($CONFIG['postPaging']) ? $CONFIG['postPaging'] : null;
            $startNum = is_numeric($number) && is_numeric($nowPage) ? ($nowPage - 1) * $number : null;
            if(is_numeric($params[1])) {
                $sortId = intval($params[1]);
            } else {
                $alias = myAddSlashes(urldecode(trim($params[1])));
                $sortId = $DATA->getSortIdByAlias($alias);
                !$sortId && return404();
            }
            $sort = $DATA->getSortById($sortId);
            (!$sort || $sort['type'] != '2') && return404();
            $sort['posts'] = $DATA->getPostsBySortId($sort['id'], $number, $startNum);
            $postNum = $DATA->getCount('post', 'sortId = ' . $sortId);
            $ads = $DATA->getAdsByPage('postSort');
            $webTitle = $sort['name'] . ' - ' . $CONFIG['name'];
            $webKeywords = $sort['name'] . ',' . $CONFIG['keywords'];
            $webDescription = $sort['name'] . ',' . $CONFIG['description'];
            unset($params, $number, $startNum);
            include self::getView('header');
            include self::getView('sort_post');
        }

        /**
         * 显示站点
         * @param $params
         * @param null $siteId
         */
        public static function displaySite($params, $siteId = null) {
            global $DATA, $CONFIG;
            if(!$siteId) {
                if(is_numeric($params[1])) {
                    $siteId = intval($params[1]);
                } else {
                    $alias = myAddSlashes(urldecode(trim($params[1])));
                    $siteId = $DATA->getSiteIdByAlias($alias);
                    !$siteId && return404();
                }
            }
            $viewNum = is_numeric($CONFIG['viewNum']) ? $CONFIG['viewNum'] : 1;
            $DATA->getDao()->updateById(TABLE_SITE, $siteId, [
                'dayView' => 'dayView+' . $viewNum,
                'monthView' => 'monthView+' . $viewNum,
                'totalView' => 'totalView+' . $viewNum,
                'lastDate' => "'" . date('Y-m-d') . "'"
            ], false);
            $site = $DATA->getSiteById($siteId);
            !$site && return404();
            $sort = $DATA->getSortById($site['sortId']);
            $ads = $DATA->getAdsByPage('site');
            $webTitle = $site['name'] . ' - ' . $sort['name'] . ' - ' . $CONFIG['name'];
            $webKeywords = !empty($site['keywords']) ? ($site['keywords'] . ',' . $sort['name'] . ',' . $CONFIG['name']) : ($site['name'] . ',' . $sort['name'] . ',' . $CONFIG['keywords']);
            $webDescription = !empty($site['description']) ? ($site['description'] . ',' . $CONFIG['name']) : $CONFIG['description'];
            unset($params, $viewNum);
            include self::getView('header');
            include self::getView('site');
//            echo '<script>updateSiteInfo("' . $site['url'] . '")</script>';
        }

        /**
         * 显示文章
         * @param $params
         * @param null $postId
         */
        public static function displayPost($params, $postId = null) {
            global $DATA, $CONFIG;
            if(!$postId) {
                if(is_numeric($params[1])) {
                    $postId = intval($params[1]);
                } else {
                    $alias = myAddSlashes(urldecode(trim($params[1])));
                    $postId = $DATA->getPostIdByAlias($alias);
                    !$postId && return404();
                }
            }
            if($page = $DATA->getPageById($postId)) {
                self::displayPage($page);
                return;
            }
            $DATA->getDao()->updateById(TABLE_POST, $postId, [
                'view' => 'view+' . (is_numeric($CONFIG['viewNum']) ? $CONFIG['viewNum'] : 1)
            ], false);
            $post = $DATA->getPostById($postId);
            !$post && return404();
            $sort = $DATA->getSortById($post['sortId']);
            $ads = $DATA->getAdsByPage('post');
            $webTitle = $post['title'] . ' - ' . $sort['name'] . ' - ' . $CONFIG['name'];
            $webKeywords = ($post['sortId'] != '0' ? ($sort['name'] . ',') : '') . $CONFIG['keywords'];
            $webDescription = $CONFIG['description'];
            unset($params);
            include self::getView('header');
            include self::getView('post');
        }

        /**
         * 显示单页
         * @param $page
         */
        public static function displayPage($page) {
            global $DATA, $CONFIG;
            $ads = $DATA->getAdsByPage('page');
            $webTitle = $page['title'] . ' - ' . $CONFIG['name'];
            $webKeywords = $page['title'] . ',' . $CONFIG['keywords'];
            $webDescription = $CONFIG['description'];
            include self::getView('header');
            $template = !empty($page['template']) && is_file(theme . $page['template'] . '.php') ? $page['template'] : 'page';
            include self::getView($template);
            $viewNum = is_numeric($CONFIG['viewNum']) ? $CONFIG['viewNum'] : 1;
            $DAO = $DATA->getDao();
            $DAO->updateById(TABLE_POST, $page['id'], [
                'view' => 'view+' . $viewNum
            ], false);
        }

        /**
         * 显示搜索
         * @param $params
         */
        public static function displaySearch($params) {
            global $DATA, $CONFIG;
            $nowPage = isset($params[2]) && $params[2] == 'page' ? intval($params[3]) : 1;
            $number = is_numeric($CONFIG['sitePaging']) ? $CONFIG['sitePaging'] : null;
            $startNum = is_numeric($number) && is_numeric($nowPage) ? ($nowPage - 1) * $number : null;
            $keyword = myAddSlashes(htmlspecialchars(urldecode(trim($params[1]))));
            $keyword = str_replace(['%', '_'], ['\%', '\_'], $keyword);
            $sites = $DATA->getSitesByKeyword($keyword, $number, $startNum);
            $posts = $DATA->getPostsByKeyword($keyword, $number, $startNum);
            $ads = $DATA->getAdsByPage('search');
            $webTitle = '搜索「' . $keyword . '」的结果 - ' . $CONFIG['name'];
            $webKeywords = $CONFIG['keywords'];
            $webDescription = $CONFIG['description'];
            unset($params, $number, $startNum);
            include self::getView('header');
            include self::getView('search');
        }

        /**
         * 检测类型
         * @param $params
         */
        public static function checkType($params) {
            is_numeric($params[1]) && return404();
            global $DATA;
            $alias = myAddSlashes(urldecode(trim($params[1])));
            if($siteId = $DATA->getSiteIdByAlias($alias)) {
                self::displaySite($params, $siteId);
            } elseif($postId = $DATA->getPostIdByAlias($alias)) {
                self::displayPost($params, $postId);
            } else {
                return404();
            }
        }

        /**
         * 显示跳转
         * @param $params
         */
        public static function displayGoto($params) {
            $url = myAddSlashes(htmlspecialchars(urldecode(trim($params[1]))));
            unset($params);
            if(is_file(theme . 'goto.php')) {
                include theme . 'goto.php';
            } elseif(is_file(SYSTEM_ROOT . 'goto.php')) {
                include SYSTEM_ROOT . 'goto.php';
            } else {
                header('location:' . $url);
            }
            die();
        }

        /**
         * 显示站点地图
         */
        public static function displaySiteMap() {
            include SYSTEM_ROOT . 'sitemap.php';
        }
    }
