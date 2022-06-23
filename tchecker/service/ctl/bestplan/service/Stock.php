<?php
/**
 * Coop-Auth service.
 *
 * 靠谱云开发 Coop api
 *
 * 成达传网络科技旗下[靠谱云开发]版权所有2018/03
 *
 * PHP version 7.0.22
 *
 * @category PHP
 * @package  CDC-ORI
 * @author   ycassnr <ycassnr@gmail.com>
 * @license  http://www.coopcoder.com/licence COOP-3
 * @version  GIT: COOP-3.1.0
 * @link     http://www.coopcoder.com
 */
namespace service\ctl\bestplan\service;

/**
 * 申请模块
 *
 * @category  PHP
 * @package   CDC-ORI-SERVICE
 * @author    ycassnr <ycassnr@gmail.com>
 * @copyright 2012-2018 成都成达传网络科技-COOP Technology GP
 * @license   http://www.coopcoder.com/licence ar licence 5.1
 * @version   Release: @靠谱云开发@
 * @link      http://www.coopcoder.com
 */
class Stock
{
    public function getShareslist($KeyWord = '', $pageRow, $page = 1, $phoneId, $collection, $filterString = '')
    {
//\ar\core\comp('tools.log')->record([$collection, $filterString], 'fstring');
        if ($collection) {
            // $filterString = '';
        }
        $columns = ['code', 'res', 'cbj', 'last_cl_point', 'profy', 'point', 'update_datetime', 'price', 'stock'];
        $needRestore = false;
        // 筛选字符串
        if ($filterString) {
            $fileterArray = json_decode($filterString, true);
//\ar\core\comp('tools.log')->record($fileterArray, 'fstring');

            if ($fileterArray) {

                $profit = $fileterArray['profit'];
                $stockStatus = $fileterArray['stock'];
                $tdStatus = $fileterArray['td'];

                
                if ($profit['status'] != 2 || $stockStatus != 2 || $tdStatus != 2) {
                    $needRestore = true;
                }

                if ($needRestore) {
                    
                    $allrows = \service\lib\model\stock\StockSummary::model()->getDb()
                        ->select($columns)
                        ->queryAll();

                    $newRows = [];

                    foreach ($allrows as $row) {

                        if ($profit['status'] == 0) {
                            if ($row['res'] != 'succ') {
                                continue;
                            }
                        } elseif ($profit['status'] == 1)  {
                            if ($row['res'] != 'fail') {
                                continue;
                            }
                        }

	                if ($profit['status'] != 2) {
                            $pmin = (int)$profit['rmin'];
                            $pmax = (int)$profit['rmax'];
                        }

                        if ($pmin) {
                            if ((int)$row['point'] < $pmin) {
                                continue;
                            }
                        }

                        if ($pmax) {
                            if ((int)$row['point'] > $pmax) {
                                continue;
                            }
                        }

                        if ($stockStatus == 0) {
                            if ($row['stock'] <= 0) {
                                continue;
                            }
                        }

                        if ($stockStatus == 1) {
                            if ($row['stock'] != 0) {
                                continue;
                            }
                        }

                        if ($tdStatus == 0) {
                            $lastClPoint = json_decode($row['last_cl_point'], true);
                            if ($lastClPoint && $lastClPoint['buy_luckey'] > 50) {
                            } else {
                                continue;
                            }
                        }

                        if ($tdStatus == 1) {
                            $lastClPoint = json_decode($row['last_cl_point'], true);
                            if ($lastClPoint && $lastClPoint['sell_luckey'] > 50) {
                            } else {
                                continue;
                            }
                        }
                        $newRows[] = $row;

                    }
                }
            }
        }

        // \ar\core\comp('tools.log')->record([$newRows], 'nr');

        // 筛选组装
        if ($needRestore) {
            $tcount = count($newRows);
            if ($tcount > 0) {
                // $pageObj = new \service\lib\ext\Page($tcount, $tcount, 1);
                $pageObj = new \service\lib\ext\Page($tcount, $pageRow, $page);

                $rows = $newRows;

                if ($page == 1) {
                    $rows = array_slice($newRows, 0, $pageRow);
                } elseif ($page == $pageObj->totalPage) {
                    $rows = array_slice($newRows, ($page - 1) * $pageRow);
                } else {
                    $rows = array_slice($newRows, ($page - 1) * $pageRow, $pageRow);
                }
                
            } else {
                $rows = [];
            }
        } else {

            $KeyWord = trim($KeyWord);
            $con = [];

            // 从搜藏的库里查询
            if ($collection == 1) {
                $scCodes = \service\lib\model\stock\StockCollection::model()->getDb()->where(['uid' => $phoneId])
                ->queryAll('code');

                if (!$scCodes) {
                    $dataobj = [
                        'data' => [[]],
                        'page_obj' => [
                            'totalPage' => 0,
                            'totalRecord' => 0,
                            'currentPage' => $page,
                        ]
                    ];
                    return $dataobj;
                } else {
                    $con['code'] = array_keys($scCodes);
                }
            }

            // 搜股票或者名字 简称
            if ($KeyWord) {
                $nameCodes = \service\lib\model\stock\StockList::model()
                    ->getDb()
                    ->where(['name like ' => '%' . $KeyWord . '%'])
                    ->queryAll('code');

                $jm = strtoupper($KeyWord);

                $jmCodes = \service\lib\model\stock\StockList::model()
                    ->getDb()
                    ->where(['jm like ' => '%' . $jm . '%'])
                    ->queryAll('code');

                $codes = \service\lib\model\stock\StockList::model()
                    ->getDb()
                    ->where(['code like ' => '%' . $KeyWord . '%'])
                    ->queryAll('code');

                $codeAll = array_merge(array_keys($nameCodes), array_keys($jmCodes), array_keys($codes));

                // 在关注里搜索
                if ($collection) {
                    $con['code'] = array_intersect($con['code'], $codeAll);
                } else {
                    $con['code'] = $codeAll;
                }
            }

            $tcount = \service\lib\model\stock\StockSummary::model()->getDb()->where($con)->count();
            $pageObj = new \service\lib\ext\Page($tcount, $pageRow, $page);
            $rows = \service\lib\model\stock\StockSummary::model()->getDb()
                ->select($columns)
                ->limit($pageObj->limit())
                ->where($con)
                ->order('profy desc')
                ->queryAll();
        }
    	

    	$data = [];
        for ($i = 0; $i < count($rows); $i++) {
        	$summary = $rows[$i];

        	$stock = \service\lib\model\stock\StockList::model()
        		->getDb()
        		->where(['code' => $summary['code']])
        		->queryRow();

            if ($summary['stock'] > 0) {
                $direction = '0';
            } else {
                $direction = '1';
            }

            if ($summary['res'] == 'fail' && $summary['stock'] > 0) {
                $direction = '2';
            }

        	$cbj = sprintf("%.2f", $summary['cbj']);
            $nPrice = sprintf("%.2f", $summary['price']);
        	$fprice = sprintf("%.2f", ($cbj + $cbj * 5 / 100));

            $hasCrow = \service\lib\model\stock\StockCollection::model()->getDb()->where(['uid' => $phoneId, 'code' => $summary['code']])->queryRow();
            if ($hasCrow) {
                $iscollection = 1;
            } else {
                $iscollection = 0;
            }

            $alyinfo = \ar\core\service("bestplan.Stock")->getCodeAlyInfo($summary['code']);
            $chance = \ar\core\service("bestplan.Stock")->getChance($stock['code']);

            $data[] = [
                'sharesName' => $stock['name'],
                'sharesCode' => $stock['code'],
                'direction' => $direction,
                'sharesTime' => $alyinfo['sharesTime'],
                'nPrice' => $nPrice,
                'fprice' => $fprice,
                'rPrice' => $cbj,
                'accuracy' => $alyinfo['accuracy'],
                'collection' => $iscollection,
                'res' => $summary['res'],
                'chance' => $chance,
                'profit' => (int)$summary['profy'],
                'point' => sprintf("%.2f", $summary['point']),
                'update_datetime' => $summary['update_datetime'],
            ];
        }

        $dataobj = [
            'data' => $data,
            'page_obj' => [
                'totalPage' => $pageObj->totalPages,
                'totalRecord' => $tcount,
                'currentPage' => $page,
            ]
        ];
        return $dataobj;
    }

    // \ar\core\service("bestplan.Stock")->getCodeAlyInfo($code)
    public function getCodeAlyInfo($code)
    {
        $records = \service\lib\model\stock\StockRecords::model()->getDb()->where(['code' => $code])->queryAll();

        $buyCount = 0;
        $sellCount = 0;
        foreach ($records as $key => $record) {
            $opt = $record['opt'];
            if ($opt == 'buy') {
                $buyCount++;
            } else {
                $sellCount++;
            }
        }

        $fbuyPrice = 0;
        $succCount = 0;
        foreach ($records as $key => $record) {
            $opt = $record['opt'];
            if ($opt == 'buy') {
                $fbuyPrice = $record['price'];
            } else {
                if ($record['price'] > $fbuyPrice) {
                    $succCount++;
                }
            }
        }

        if ($buyCount > 0 && $sellCount >0) {
            $accuracy = sprintf("%.2f", $succCount / $buyCount * 100);
        } else {
            $accuracy = '--';
        }

        if ($buyCount > $sellCount) {
            $sharesTime = $records[count($records) - 1]['tm'];
        } else {
            $sharesTime = '--';
        }

        return [
            'sharesTime' => $sharesTime,
            'accuracy' => $accuracy,
            'recommendNo' => $buyCount,
        ];

    }

    // \ar\core\service("bestplan.Stock")->getSummary($code)
    public function getSummary($code, $phoneId)
    {
        $alyinfo = \ar\core\service("bestplan.Stock")->getCodeAlyInfo($code);
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $code])
            ->queryRow();

        $stock = \service\lib\model\stock\StockList::model()
                ->getDb()
                ->where(['code' => $summary['code']])
                ->queryRow();

        if ($summary['stock'] > 0) {
            $direction = '0';
        } else {
            $direction = '1';
        }

        if ($summary['res'] == 'fail' && $summary['stock'] > 0) {
            $direction = '2';
        }

        $hasCrow = \service\lib\model\stock\StockCollection::model()->getDb()->where(['uid' => $phoneId, 'code' => $summary['code']])->queryRow();
        if ($hasCrow) {
            $iscollection = 1;
        } else {
            $iscollection = 0;
        }

        $cbj = sprintf("%.2f", $summary['cbj']);
        $nPrice = sprintf("%.2f", $summary['price']);

        $obj = [
            'sharesName' => $stock['name'],
            'sharesCode' => $stock['code'],
            'sharesTime' => $alyinfo['sharesTime'],
            'direction' => $direction,
            'nPrice' => $nPrice,
            'fprice' => sprintf("%.2f", ($summary['price'] + $summary['price'] * 5 / 100)),
            'rPrice' => $cbj,
            'price' => $nPrice,
            'accuracy' => $alyinfo['accuracy'],
            'collection' => $iscollection,
            'profit' => $summary['point'],
            'recommendNo' => $alyinfo['recommendNo'],
            'profit' => (int)$summary['profy'],
            'update_datetime' => $summary['update_datetime'],
            'retCode' => 3,
            'retMsg' => '',
        ];

        return $obj;

    }

    // \ar\core\service("bestplan.Stock")->getRecords($pageRow, $page, $sharesCode)
    public function getRecords($pageRow, $page, $sharesCode)
    {
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $sharesCode])
            ->queryRow();

        $recs = json_decode($summary['opt_points'], true);

        $stock = \service\lib\model\stock\StockList::model()
                ->getDb()
                ->where(['code' => $sharesCode])
                ->queryRow();

        $data = [];
        for ($i = 0; $i < count($recs); $i++) {
            $record = $recs[$i];

            if ($record['opt'] == 'buy') {
                $direction = 0;
            } else {
                $direction = 1;
            }

            $rPrice = sprintf("%.2f", $record['price']);

            if ($ePrice > $rPrice) {
                $result = 1;
            } else {
                $result = 0;
            }

            $data[] = [
                'sharesName' => $stock['name'],
                'sharesCode' => $sharesCode,
                'direction' => $direction,
                'sharesTime' => $record['tm'],
                'endTime' => $record['tm'],
                'fprice' => $rPrice,
                'rPrice' => $rPrice,
                'ePrice' => $rPrice,
                'result' => $result,
                'p' => $record['p'],
                't_num' => $record['t_num'],
                't_assets' => $record['t_assets'],
            ];
        }

        $dataobj = [
            'data' => $data,
            'page_obj' => [
                'totalPage' => 1,
                'totalRecord' => count($data),
                'currentPage' => 1,
            ]
        ];
        return $dataobj;
    }

    // \ar\core\service("bestplan.Stock")->addSearchHistory($key, $phoneId)
    public function addSearchHistory($key, $phoneId)
    {
    	if (\service\lib\model\stock\StockSearhistory::model()->getDb()->where(['key' => $key, 'uid' => $phoneId])->count() == 0) {
			return \service\lib\model\stock\StockSearhistory::model()->getDb()->insert(['key' => $key, 'uid' => $phoneId]);
    	} else {
    		return false;
    	}
    }

    // \ar\core\service("bestplan.Stock")->getSearchHistory($phoneId)
    public function getSearchHistory($phoneId)
    {
        $res = \service\lib\model\stock\StockSearhistory::model()->getDb()->where([
            'uid' => $phoneId,
        ])->queryAll();
        $data = [];
        if ($res) {
            foreach ($res as $r) {
                $data[] = [
                    'searchId' => 'SQ_H_' . $r['id'],
                    'searchContent' => $r['key'],
                ];
            }
        }
        return $data;
    }

    // \ar\core\service("bestplan.Stock")->cleanSearchHistory($phoneId)
    public function cleanSearchHistory($phoneId)
    {
        $res = \service\lib\model\stock\StockSearhistory::model()->getDb()->where([
            'uid' => $phoneId,
        ])->delete();
        
        return true;
    }

    // \ar\core\service("bestplan.Stock")->collection($$phoneId, $sharesCode, $mode)
    public function collection($phoneId, $sharesCode, $mode)
    {
        if ($mode == 1) {
            \service\lib\model\stock\StockCollection::model()->getDb()->insert(['uid' => $phoneId, 'code' => $sharesCode]);
        } else {
            \service\lib\model\stock\StockCollection::model()->getDb()->where(['uid' => $phoneId, 'code' => $sharesCode])->delete();
        }
        return true;
    }

    // \ar\core\service("bestplan.Stock")->getNewslist($pageRow, $page)
    public function getNewslist($pageRow, $page)
    {
        $con = [
            'status' => 1,
        ];

        $tcount = \service\lib\model\stock\StockNews::model()
            ->getDb()
            ->where($con)
            ->count();

        $pageObj = new \service\lib\ext\Page($tcount, $pageRow, $page);

        $news = \service\lib\model\stock\StockNews::model()->getDb()
            ->where($con)
            ->limit($pageObj->limit())
            ->queryAll();

        $data = [];
        for ($i = 0; $i < count($news); $i++) {
            $newRecord = $news[$i];

            $data[] = [
                'newsId' => $newRecord['id'],
                'newsTime' => date('Y/m/d H:i', $newRecord['create_time']),
                'newsTitle' => $newRecord['title'],
                'cover1' => $newRecord['cover1'],
                'cover2' => $newRecord['cover2'],
                'cover3' => $newRecord['cover3'],
            ];
        }
        $dataobj = [
            'data' => $data,
            'page_obj' => [
                'totalPage' => $pageObj->totalPages,
                'totalRecord' => $tcount,
                'currentPage' => $page,
            ]
        ];
        return $dataobj;
    }

    // \ar\core\service("bestplan.Stock")->getNewsdetail($newsId)
    public function getNewsdetail($newsId)
    {
        $con = [
            'id' => $newsId,
            'status' => 1,
        ];

        $newRecord = \service\lib\model\stock\StockNews::model()->getDb()
            ->where($con)
            ->queryRow();

        $obj = [
            'newsTitle' => $newRecord['title'],
            'newsTime' => date('Y/m/d H:i', $newRecord['create_time']),
            'newsDetail' => $newRecord['content'],
            'retCode' => 1000,
            'retMsg' => '',
        ];
        return $obj;
    }

    // \ar\core\service("bestplan.Stock")->getService()
    public function getService()
    {
        $con = [
            // 'status' => 1,
        ];
        $records = \service\lib\model\stock\StockServicesInfo::model()->getDb()
            ->where($con)
            ->queryAll();

        $data = [];
        for ($i = 0; $i < count($records); $i++) {
            $info = $records[$i];
            $data[] = [
                'serviceId' => $info['id'],
                'serviceTitle' => $info['name'],
                'serviceDetail' => $info['content'],
            ];
        }
        return $data;
    }

    // \ar\core\service("bestplan.Stock")->getFeedbackList($pageRow, $page, $phoneId)
    public function getFeedbackList($pageRow, $page, $phoneId)
    {
        // 正常状态
        $con = [
            'status' => 1,
            'uid' => $phoneId,
        ];

        $tcount = \service\lib\model\stock\StockFeedback::model()
            ->getDb()
            ->where($con)
            ->count();

        $pageObj = new \service\lib\ext\Page($tcount, $pageRow, $page);


        $records = \service\lib\model\stock\StockFeedback::model()->getDb()
            ->where($con)
            ->limit($pageObj->limit())
            ->order('id desc')
            ->queryAll();

        $data = [];
        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];

            $data[] = [
                'feedbackId' => $record['id'],
                'fbContent' => $record['content'],
                'fbTime' => date('Y/m/d H:i', $record['create_time']),
                'reply' => $record['is_reply'],
            ];
        }
        $dataobj = [
            'data' => $data,
            'page_obj' => [
                'totalPage' => $pageObj->totalPages,
                'totalRecord' => $tcount,
                'currentPage' => $page,
            ]
        ];
        return $dataobj;
    }

    // \ar\core\service("bestplan.Stock")->getReply($phoneId, $feedbackId)
    public function getReply($phoneId, $feedbackId)
    {
        $con = [
            'uid' => $phoneId,
            'id' => $feedbackId,
            'status' => 1,
        ];

        $reply = \service\lib\model\stock\StockFeedback::model()->getDb()
            ->where($con)
            ->queryRow();

        $obj = [
            'fbContent' => $reply['content'],
            'replyDetail' => $reply['reply_content'],
            'retCode' => 1000,
            'retMsg' => '',
        ];
        return $obj;
    }

    // \ar\core\service("bestplan.Stock")->submitFeedback($phoneId, $fbContent)
    public function submitFeedback($phoneId, $fbContent)
    {
        $content = [
            'uid' => $phoneId,
            'content' => $fbContent,
            'status' => 1,
            'is_reply' => 0,
            'create_time' => time(),
        ];
        \service\lib\model\stock\StockFeedback::model()->getDb()->insert($content);
        $obj = [
            'retCode' => 1000,
            'retMsg' => '',
        ];
        return $obj;
    }

    // \ar\core\service("bestplan.Stock")->getUprecordList($pageRow, $page)
    public function getUprecordList($pageRow, $page)
    {   
        $con = [
        ];

        $tcount = \service\lib\model\stock\StockUpgradeLogs::model()
            ->getDb()
            ->where($con)
            ->count();

        $pageObj = new \service\lib\ext\Page($tcount, $pageRow, $page);

        $records = \service\lib\model\stock\StockUpgradeLogs::model()->getDb()
            ->where($con)
            ->limit($pageObj->limit())
            ->order('id desc')
            ->queryAll();

        $data = [];
        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];
            $data[] = [
                'upId' => $record['id'],
                'upTitle' => $record['title'],
                'upTime' => date('Y/m/d H:i', $record['create_time']),
            ];
        }

        $dataobj = [
            'data' => $data,
            'page_obj' => [
                'totalPage' => $pageObj->totalPages,
                'totalRecord' => $tcount,
                'currentPage' => $page,
            ]
        ];
        return $dataobj;
    }

    // \ar\core\service("bestplan.Stock")->getUprecordDetail($upId)
    public function getUprecordDetail($upId)
    {
        $con = [
            'id' => $upId,
        ];
        $row = \service\lib\model\stock\StockUpgradeLogs::model()->getDb()
            ->where($con)
            ->queryRow();

        $obj = [
            'upTitle' => $row['title'],
            'upDetail' => $row['content'],
            'upTime' => date('Y/m/d H:i', $row['create_time']),
            'retCode' => 1000,
            'retMsg' => '',
        ];

        return $obj;
    }

    // \ar\core\service("bestplan.Stock")->getAppDownVersion()
    public function getAppDownVersion()
    {
        $con = [
            'name' => 'NEW_VERSION_DOWN_INFO',
        ];

        $upinfo = \service\lib\model\stock\StockAppVersion::model()->getDb()
            ->where($con)
            ->order('id desc')
            ->queryRow();

        return $upinfo;

    }

    // \ar\core\service("bestplan.Stock")->getChance($code)
    public function getChance($code)
    {
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $code])
            ->queryRow();
        
        $lastClPoint = $summary['last_cl_point'];

        $pointObject = json_decode($lastClPoint, true);

        $updateTime = date('Y/m/d H:i', strtotime($pointObject['time']));
        $obj = [
            'upChance' => $pointObject['buy_luckey'],
            'downChance' =>  $pointObject['sell_luckey'],
            'keepChance' =>  $pointObject['st_luckey'],
            'updateTime' => $updateTime,
            'retCode' => '1000',
            'retMsg' => '获取成功',
        ];
        return $obj;

    }

    // \ar\core\service("bestplan.Stock")->getBack($code)
    public function getBack($code)
    {
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $code])
            ->queryRow();
        if ($summary['res'] == 'succ') {
            $result = '1';
        } else {
            $result = '0';
        }

        $obj = [
            'principal' => $summary['assets'],
            'result' => $result,
            'amount' => sprintf("%.2f", $summary['profy']),
            'percent' => sprintf("%.2f", $summary['point']),
            'buyNo' => $summary['trade_buy_count'],
            'sellNo' => $summary['trade_sell_count'],
            'nPrice' => $summary['price'],
            'costPrice' => $summary['cbj'],
            'position' => $summary['stock'],
            'surplus' => $summary['res_asssets'],
            'retCode' => '1000',
            'retMsg' => '获取成功',
        ];
        
        return $obj;

    }

    // \ar\core\service("bestplan.Stock")->getTd($code, $sort)
    public function getTd($code, $sort)
    {
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $code])
            ->queryRow();

        $tdList = json_decode($summary['td30'], true);
        $list = [];
        $length = count($tdList);
        if ($length > 0) {
            for ($i = 0 ; $i < $length; $i++) {
                $point = $tdList[$i];
                if ($point['opt'] == 'buy') {
                    $direction = '0';
                } else {
                    $direction = '1';
                }
                
                $list[] = [
                    'sort' => $i + 1 ,
                    'direction' => $direction,
                    'price' => $point['price'],
                    'chance' => sprintf("%.2f", $point['p']) . '%',
                    'tdTime' => $point['tm'],
                ];
            }
        }

        if ($sort) {
            $list = array_reverse($list);
        }

        return $list;

    }

    // \ar\core\service("bestplan.Stock")->getNkLines($code)
    public function getNkLines($code)
    {
        $summary = \service\lib\model\stock\StockSummary::model()
            ->getDb()
            ->where(['code' => $code])
            ->queryRow();

        // {"id":"9287","all_point":"39.599999999999994","up_point":"0","down_point":"21.6","st_point":"18","stmi":"279780","time":"20201231 14:34","price":"17.96","buy_luckey":"0.0","sell_luckey":"54.55","st_luckey":"45.45"}

        $clPoints = json_decode($summary['cl_points'], true);

        $obj = [];
        foreach ($clPoints as $point) {
            $obj[] = [
                'datetime' => $point['time'],
                'price' => $point['price'],
                'buy' => $point['buy_luckey'],
                'st' => $point['st_luckey'],
                'sell' => $point['sell_luckey']
            ];
        }

        // $obj = array_reverse($obj);
        return $obj;
    }

    // \ar\core\service("bestplan.Stock")->getRank()
    public function getRank()
    {
        $searchList = \service\lib\model\stock\StockSearhistory::model()->getDb()->queryAll();

        $list = [];
        foreach ($searchList as $keyword) {
            if (isset($list[$keyword['key']])) {
                $list[$keyword['key']]['rank'] = $list[$keyword['key']]['rank'] + 1;
            } else {
                $list[$keyword['key']] = ['search' => $keyword['key'], 'rank' => 0];
            }
        }

        $list = array_values($list);

        $list = $this->sortArr($list, 'rank', SORT_DESC, SORT_NUMERIC);


        $newList = [];
        foreach ($list as $item) {
            if ($item['rank'] > 0) {
                $newList[] = $item;
            }
        }

        if (count($newList) > 10) {
            $newList = array_slice($newList, 0, 10);
        }
        return $newList;

    }

    // 二维数组排序
    public function sortArr($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC )
    {
        $key_arrays =array();
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }

}
