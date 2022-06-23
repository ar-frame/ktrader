<?php
/**
 * Powerd by ArPHP.
 *
 * test service.
 *
 */
namespace arcz\ctl\main\service;
/**
 * Default Controller of webapp.
 */
class Page
{
    // 高级搜索 排序  $this->getPageService()->headForm($arrSearch, $arrSort, $search_col, $sort_col);
    public function headForm($arrSearch, $arrSort, $search_col, $sort_col)
    {
        $formStr = '<form class="form-inline">';

        // 排序字段选择
        $formStr .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">排序</div><label class="sr-only">选择排序字段</label><select id="sorting" name="sorting" class="form-control sorting">';
        $formStr .= '<option value="' . $sort_col . '">选择排序字段</option>';
        foreach($arrSort as $k2 => $v2){
            if($sort_col==$k2){
                $formStr .= '<option value="' . $k2 . '" selected>' . $v2 . '</option>';
            } else {
                $formStr .= '<option value="' . $k2 . '">' . $v2 . '</option>';
            }
        }

        // 排序按钮
        $formStr .= '</select></div><button type="button" id="sorting_asc" class="btn btn-xs btn-warning">升序</button><button type="button" id="sorting_desc" class="btn btn-xs btn-warning">降序</button></div>';

        // 高级搜索字段选择
        $formStr .= '<div class="form-group"><label class="sr-only">选择搜索字段</label><select id="search_col" name="search_col" class="form-control search_col">';
        $formStr .= '<option value="' . $search_col . '">选择搜索字段</option>';
        foreach($arrSearch as $k1 => $v1){
            $formStr .= '<option value="' . $k1 . '">' . $v1 . '</option>';
        }
        $formStr .= '</select></div>';

        // 搜索框
        $formStr .= '<div class="form-group"><label class="sr-only">搜索</label><input type="text" class="form-control" id="keyword" placeholder="请输入搜索关键字"></div><button type="button" id="search" class="btn btn-sm btn-primary">搜索</button>';


        $formStr .= '</form>';

        return $formStr;

    }

    // 搜索框  $this->getPageService()->searchSimple();
    public function searchSimple()
    {
        $formStr = '<form class="form-inline">';

        // 搜索框
        $formStr .= '<div class="form-group"><label class="sr-only">搜索</label><input type="text" class="form-control" id="keyword" placeholder="请输入搜索关键字"></div><button type="button" id="search" class="btn btn-sm btn-primary">搜索</button>';

        $formStr .= '</form>';

        return $formStr;

    }

    // 排序  $this->getPageService()->sortSimple($arrSort, $sort_col);
    public function sortSimple($arrSort, $sort_col)
    {
        $formStr = '<form class="form-inline">';

        // 排序字段选择
        $formStr .= '<div class="form-group"><div class="input-group"><div class="input-group-addon">排序</div><label class="sr-only">选择排序字段</label><select id="sorting" name="sorting" class="form-control sorting">';
        $formStr .= '<option value="' . $sort_col . '">选择排序字段</option>';
        foreach($arrSort as $k2 => $v2){
            if($sort_col==$k2){
                $formStr .= '<option value="' . $k2 . '" selected>' . $v2 . '</option>';
            } else {
                $formStr .= '<option value="' . $k2 . '">' . $v2 . '</option>';
            }
        }

        // 排序按钮
        $formStr .= '</select></div><button type="button" id="sorting_asc" class="btn btn-xs btn-warning">升序</button><button type="button" id="sorting_desc" class="btn btn-xs btn-warning">降序</button></div>';

        $formStr .= '</form>';

        return $formStr;

    }

    // 分页  $this->getPageService()->pageShowSimple($totalPages, $href, $count, $page, $keyword);
    public function pageShowSimple($totalPages, $href, $count, $page, $keyword)
    {
        // 下一页
        $nextPage = $page + 1;
        // 上一页
        $prevPage = $page - 1;
        // 当前页前面七页
        $prevPage1 = $page - 1;
        $prevPage2 = $page - 2;
        $prevPage3 = $page - 3;
        $prevPage4 = $page - 4;
        $prevPage5 = $page - 5;
        $prevPage6 = $page - 6;
        $prevPage7 = $page - 7;
        // 当前页后面七页
        $nextPage1 = $page + 1;
        $nextPage2 = $page + 2;
        $nextPage3 = $page + 3;
        $nextPage4 = $page + 4;
        $nextPage5 = $page + 5;
        $nextPage6 = $page + 6;
        $nextPage7 = $page + 7;
        $arrPage = [];
        for($i = 1; $i <= $totalPages; $i++) {
            array_push($arrPage,$i);
        }

        $pageStr = '<nav aria-label="Page navigation"><ul class="pagination">';

        // 首页
        if($page == 1){
            $pageStr .= '<li class="active disabled"><a href="#" class="first">首页</a></li>';
        } else {
            $pageStr .= '<li><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="first">首页</a></li>';
        }
        // 上一页
        if($prevPage == 0){
            $pageStr .= '<li class="previous disabled"><a href="#" class="prev">上一页</a></li>';
        } else {
            $pageStr .= '<li class="previous"><a href="' . $href . '/count/' . $count . '/page/' . $prevPage . 'keyword/' . $keyword . '" class="prev">上一页</a></li>';
        }

        // 中间页
        if($totalPages <= 10){
            foreach($arrPage as &$p){
                if($p == $page){
                    $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                } else {
                    $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $p . '/keyword/' . $keyword . '" class="">' . $p . '</a></li>';
                }
            }
        } else {
            if($prevPage1 == 0){
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/keyword/' . $keyword . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage6 . '/keyword/' . $keyword . '" class="">' . $nextPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage7 . '/keyword/' . $keyword . '" class="">' . $nextPage7 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage2 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/keyword/' . $keyword . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage6 . '/keyword/' . $keyword . '" class="">' . $nextPage6 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage3 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/keyword/' . $keyword . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage4 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage5 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage6 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/keyword/' . $keyword . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage6 > 0 && $nextPage6 < $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                // $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage6 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/keyword/' . $keyword . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage5 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/keyword/' . $keyword . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage4 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/keyword/' . $keyword . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage3 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/keyword/' . $keyword . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage2 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/keyword/' . $keyword . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/keyword/' . $keyword . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage1 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage6 . '/keyword/' . $keyword . '" class="">' . $prevPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/keyword/' . $keyword . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="">' . $totalPages . '</a></li>';
            } else if($page == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/keyword/' . $keyword . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage7 . '/keyword/' . $keyword . '" class="">' . $prevPage7 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage6 . '/keyword/' . $keyword . '" class="">' . $prevPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/keyword/' . $keyword . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/keyword/' . $keyword . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/keyword/' . $keyword . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/keyword/' . $keyword . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/keyword/' . $keyword . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
            }
        }


        // 下一页
        if($nextPage > $totalPages){
            $pageStr .= '<li class="next disabled"><a href="#" class="next">下一页</a></li>';
        } else {
            $pageStr .= '<li class="next"><a href="' . $href . '/count/' . $count . '/page/' . $nextPage . '/keyword/' . $keyword . '" class="next">下一页</a></li>';
        }
        // 尾页
        if($page == $totalPages){
            $pageStr .= '<li class="active disabled"><a href="#" class="end">尾页</a></li>';
        } else {
            $pageStr .= '<li><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/keyword/' . $keyword . '" class="end">尾页</a></li>';
        }

        // 每页显示数量
        $pageStr .= '<div class="form-group col-xs-2" style="width: 200px;"><div class="input-group"><div class="input-group-addon">每页显示</div><select id="pageCount" name="count" class="form-control pageCount">';

        $op1 = 10;
        $op2 = 15;
        $op3 = 20;
        $op4 = 30;

        if($op1==$count){
            $pageStr .= '<option value="' . $op1 . '" selected>' . $op1 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op1 . '">' . $op1 . '</option>';
        }
        if($op2==$count){
            $pageStr .= '<option value="' . $op2 . '" selected>' . $op2 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op2 . '">' . $op2 . '</option>';
        }
        if($op3==$count){
            $pageStr .= '<option value="' . $op3 . '" selected>' . $op3 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op3 . '">' . $op3 . '</option>';
        }
        if($op4==$count){
            $pageStr .= '<option value="' . $op4 . '" selected>' . $op4 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op4 . '">' . $op4 . '</option>';
        }

        $pageStr .= '</select><div class="input-group-addon">条</div></div></div>';

        // 跳转指定页面
        $pageStr .= '<div class="form-group col-xs-2" style="width: 240px;"><div class="input-group"><div class="input-group-addon">跳转到</div><select id="pageTo" name="page" class="form-control pageCount">';

        foreach($arrPage as &$p){
            if($p == $page){
                $pageStr .= '<option value="' . $p . '" selected>' . $p . '</option>';
            } else {
                $pageStr .= '<option value="' . $p . '">' . $p . '</option>';
            }
        }

        $pageStr .= '</select><div class="input-group-addon">页&nbsp;&nbsp;共 ' . $totalPages . ' 页</div></div></div>';

        $pageStr .= '</ul></nav>';

        return $pageStr;

    }

    // 多条件分页  $this->getPageService()->pageShow($totalPages, $href, $count, $page, $search_col, $keyword, $sort_col, $sort_type);
    public function pageShow($totalPages, $href, $count, $page, $search_col, $keyword, $sort_col, $sort_type)
    {
        // 下一页
        $nextPage = $page + 1;
        // 上一页
        $prevPage = $page - 1;
        // 当前页前面七页
        $prevPage1 = $page - 1;
        $prevPage2 = $page - 2;
        $prevPage3 = $page - 3;
        $prevPage4 = $page - 4;
        $prevPage5 = $page - 5;
        $prevPage6 = $page - 6;
        $prevPage7 = $page - 7;
        // 当前页后面七页
        $nextPage1 = $page + 1;
        $nextPage2 = $page + 2;
        $nextPage3 = $page + 3;
        $nextPage4 = $page + 4;
        $nextPage5 = $page + 5;
        $nextPage6 = $page + 6;
        $nextPage7 = $page + 7;
        $arrPage = [];
        for($i = 1; $i <= $totalPages; $i++) {
            array_push($arrPage,$i);
        }

        $pageStr = '<nav aria-label="Page navigation"><ul class="pagination">';

        // 首页
        if($page == 1){
            $pageStr .= '<li class="active disabled"><a href="#" class="first">首页</a></li>';
        } else {
            $pageStr .= '<li><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="first">首页</a></li>';
        }
        // 上一页
        if($prevPage == 0){
            $pageStr .= '<li class="previous disabled"><a href="#" class="prev">上一页</a></li>';
        } else {
            $pageStr .= '<li class="previous"><a href="' . $href . '/count/' . $count . '/page/' . $prevPage . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="prev">上一页</a></li>';
        }

        // 中间页
        if($totalPages <= 10){
            foreach($arrPage as &$p){
                if($p == $page){
                    $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                } else {
                    $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $p . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $p . '</a></li>';
                }
            }
        } else {
            if($prevPage1 == 0){
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage6 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage7 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage7 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage2 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage6 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage6 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage3 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage4 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage5 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage6 == 0){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($prevPage6 > 0 && $nextPage6 < $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                // $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage6 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage5 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage4 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage3 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage2 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $nextPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $nextPage1 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($nextPage1 == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage6 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $totalPages . '</a></li>';
            } else if($page == $totalPages){
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/1/search_col/' . $search_col .'/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">1</a></li>';
                $pageStr .= '<li class="disabled"><a href="#">...</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage7 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage7 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage6 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage6 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage5 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage5 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage4 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage4 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage3 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage3 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage2 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage2 . '</a></li>';
                $pageStr .= '<li class=""><a href="' . $href . '/count/' . $count . '/page/' . $prevPage1 . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="">' . $prevPage1 . '</a></li>';
                $pageStr .= '<li class="active"><a href="#">' . $page . '</a></li>';
            }
        }


        // 下一页
        if($nextPage > $totalPages){
            $pageStr .= '<li class="next disabled"><a href="#" class="next">下一页</a></li>';
        } else {
            $pageStr .= '<li class="next"><a href="' . $href . '/count/' . $count . '/page/' . $nextPage . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="next">下一页</a></li>';
        }
        // 尾页
        if($page == $totalPages){
            $pageStr .= '<li class="active disabled"><a href="#" class="end">尾页</a></li>';
        } else {
            $pageStr .= '<li><a href="' . $href . '/count/' . $count . '/page/' . $totalPages . '/search_col/' . $search_col . '/keyword/' . $keyword . '/sort_col/' . $sort_col . '/sort_type/' . $sort_type . '" class="end">尾页</a></li>';
        }

        // 每页显示数量
        $pageStr .= '<div class="form-group col-xs-2" style="width: 200px;"><div class="input-group"><div class="input-group-addon">每页显示</div><select id="pageCount" name="count" class="form-control pageCount">';

        $op1 = 10;
        $op2 = 15;
        $op3 = 20;
        $op4 = 30;

        if($op1==$count){
            $pageStr .= '<option value="' . $op1 . '" selected>' . $op1 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op1 . '">' . $op1 . '</option>';
        }
        if($op2==$count){
            $pageStr .= '<option value="' . $op2 . '" selected>' . $op2 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op2 . '">' . $op2 . '</option>';
        }
        if($op3==$count){
            $pageStr .= '<option value="' . $op3 . '" selected>' . $op3 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op3 . '">' . $op3 . '</option>';
        }
        if($op4==$count){
            $pageStr .= '<option value="' . $op4 . '" selected>' . $op4 . '</option>';
        } else {
            $pageStr .= '<option value="' . $op4 . '">' . $op4 . '</option>';
        }

        $pageStr .= '</select><div class="input-group-addon">条</div></div></div>';

        // 跳转指定页面
        $pageStr .= '<div class="form-group col-xs-2" style="width: 240px;"><div class="input-group"><div class="input-group-addon">跳转到</div><select id="pageTo" name="page" class="form-control pageCount">';

        foreach($arrPage as &$p){
            if($p == $page){
                $pageStr .= '<option value="' . $p . '" selected>' . $p . '</option>';
            } else {
                $pageStr .= '<option value="' . $p . '">' . $p . '</option>';
            }
        }

        $pageStr .= '</select><div class="input-group-addon">页&nbsp;&nbsp;共 ' . $totalPages . ' 页</div></div></div>';

        $pageStr .= '</ul></nav>';

        return $pageStr;

    }

}

