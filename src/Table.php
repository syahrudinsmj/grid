<?php
namespace Smjlabs\Grid;

class Table
{

    protected array $headers;

    protected array $data;
    protected array $data_alias;

    //pagination 
    protected int|string $page;
    protected int $per_page = 10;

    protected string $filter = '';

    protected string $sort_type = 'asc';

    protected string $sort_by = '0';

    protected array $show = [
        5 => "5",
        10 => "10",
        25 => "25",
        50 => "50",
        100 => "100",
    ];

    public function __construct()
    {
        $page = (!empty($_GET['page']))? $_GET['page'] : 1; 
        $per_page = (!empty($_GET['per_page']))? $_GET['per_page'] : $this->per_page; 
        $filter = (!empty($_GET['filter']))? $_GET['filter'] : $this->filter; 
        $sort_by = (!empty($_GET['order']))? $_GET['order'] : $this->sort_by; 
        $sort_type = (!empty($_GET['sort']))? $_GET['sort'] : $this->sort_type; 

        $this->page = intval($page);
        $this->per_page = $per_page;
        $this->filter = $filter;
        $this->sort_by = $sort_by;
        $this->sort_type = $sort_type;
    }

    /**
     * set default header 
     * @method setHeader
     * @var array $headers
     */
    public function setHeader(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * set data
     * @method setData
     * @var array $data
     * @var array $alias
     */
    public function setData(array $data, array $alias)
    {
        $this->data = $data;
        $this->data_alias = $alias;
        return $this;
    }

    public function render()
    {
       return $this->html();
    }

    protected function html()
    {
        $html = <<<EOT

            EOT;

        $html = <<<EOT
        <div class="smj-half-box">
            <div class="flex-container">
                <div class="flex-item-left">
        EOT;
            $html .= <<<EOT
                Tampilkan <select name="show" id="element_showing" style="margin:10px 0px;padding:4px">
            EOT;
        
            foreach($this->show as $k => $v){
                $selected = ($this->per_page === $k) ? 'selected' : '';
                $html .= <<<EOT
                    <option value="$k" $selected >$v</option>
                EOT;
            }
        $html .= <<<EOT
                </select> entri
            </div>
        EOT;
            
        $filter = $this->filter;    
        $html .= <<<EOT
                <div class="flex-item-right"  style="text-align:right;">
                    <input type="text" name="searching_table_default" value="$filter" id="searching_table_default" style="padding:4px" placeholder="Pencarian"/>
                </div>
            </div>
        </div>
        EOT;

        $html .= <<<EOT
            <table class="smj-table">
                <thead>
            EOT;
        
            if(count($this->headers)>0){
                $html .= <<<EOT
                    <tr>
                EOT;
                $order = $this->sort_by;
                $sort = $this->sort_type;
                foreach($this->headers as $key => $field){
                    
                    $html .= <<<EOT
                        <th scope="col"> $field 
                    EOT;
                    $active_asc = (strval($order) === strval($key) && $sort == 'asc')? 'active' : '';
                    $active_desc = (strval($order) === strval($key) && $sort == 'desc')? 'active' : '';
                    $html .= <<<EOT
                            <span class="sort_asc $active_asc" data-order="$key" data-sort="asc" > &#8593 </span>
                        EOT;
                    $html .= <<<EOT
                            <span class="sort_desc $active_desc" data-order="$key" data-sort="desc"> &#8595 </span>
                        EOT;

                    $html .= <<<EOT
                        </th>
                        EOT;
                }
                $html .= <<<EOT
                    </tr>
                    EOT;
            }

        $html .= <<<EOT
                </thead>
                <tbody>
            EOT;

            $datalist = $this->data;

            // filter
            if(strlen($filter)>0){
                $newdata = [];
                foreach($this->data as $kd => $vd){
                    $output = array_filter($vd, function($v, $k) use ($filter) {
                        return $this->qLike($v,$filter);
                    }, ARRAY_FILTER_USE_BOTH);
                    if(count($output)>0){
                        array_push($newdata,$vd);
                    }
                }
                $datalist = $newdata;
            }

            // order
            $data_order = (array_key_exists(0,$datalist))? $datalist[0] : [];
            if(count($data_order)>0){
                $order = '';
                $i = 0;
                foreach($data_order as $kk => $vv){
                    if(strval($i) === $this->sort_by){
                        $order = $kk;
                        $i++;
                    }
                }
                if(strlen($order)>0){
                    $keys = array_column($datalist, $order);
                    if(count($keys)>0){
                        array_multisort($keys, ( ($this->sort_type === 'asc')? SORT_ASC : SORT_DESC ) , $datalist);
                    }
                }
            }
            
            $total_records = count($datalist);
            $total_pages   = ceil($total_records / $this->per_page);
            if ($this->page > $total_pages) {
                $this->page = $total_pages;
            }

            if ($this->page < 1) {
                $this->page = 1;
            }

            $offset = ($this->page - 1) * $this->per_page;
            $data = array_slice($datalist, $offset, $this->per_page);
            if(count($data)>0){
                foreach($data as $key => $datas){
                    $html .= <<<EOT
                        <tr>
                    EOT;
                    foreach($datas as $kkey => $ddata){
                        $alias = (array_key_exists($kkey,$this->data_alias))? $this->data_alias[$kkey] : $kkey;
                        $html .= <<<EOT
                            <td data-label="{$alias}"> $ddata </td>
                            EOT;
                    }
                    $html .= <<<EOT
                        </tr>
                        EOT;
                }
            }else{
                $colspan = count($this->headers);
                $html .= <<<EOT
                    <tr>
                        <td colspan="$colspan" style="color:#d8d8d8"> Data tidak ada</td>
                    </tr>
                EOT;
            }
        $html .= <<<EOT
                </tbody>
            </table>
            EOT;
        if(count($data)>0){
            $html .= $this->pagination($total_pages,$offset,$total_records);
        }
        $html .= $this->javascript();
            
        return $html;
    }

    protected function javascript()
    {
        $js = <<<EOT
            <script>
                 var element_showing = document.getElementById("element_showing");
                 element_showing.addEventListener("change",function(){
                    var _value = element_showing.value;
                    var params = new URLSearchParams(window.location.search);
                    params.set('per_page', _value);
                    window.location.search = params.toString();
                 });

                 var searching_table_default = document.getElementById("searching_table_default");
                 searching_table_default.addEventListener("change",function(){
                    var _value = searching_table_default.value;
                    var params = new URLSearchParams(window.location.search);
                    params.set('filter', _value);
                    window.location.search = params.toString();
                 });

                 let order_sort_asc = document.querySelectorAll(".sort_asc");
                 order_sort_asc.forEach(function(class_current, index) {
                    class_current.addEventListener("click",  function () {  
                        var _order = class_current.getAttribute("data-order");
                        var _sort = class_current.getAttribute("data-sort");
                        var params = new URLSearchParams(window.location.search);
                        params.set('order', _order);
                        params.set('sort', _sort);
                        window.location.search = params.toString();
                    });   
                });
                let order_sort_desc = document.querySelectorAll(".sort_desc");
                order_sort_desc.forEach(function(class_current, index) {
                   class_current.addEventListener("click",  function () {  
                       var _order = class_current.getAttribute("data-order");
                       var _sort = class_current.getAttribute("data-sort");
                       var params = new URLSearchParams(window.location.search);
                       params.set('order', _order);
                       params.set('sort', _sort);
                       window.location.search = params.toString();
                   });   
               });
            </script>
        EOT;

        return $js;
    }

    protected function pagination($total_pages,$offset,$total_records)
    {
        
        $N = min($total_pages, 7);
        $pages_links = array();

        $tmp = $N;
        if ($tmp < $this->page || $this->page > $N) {
            $tmp = 2;
        }
        for ($i = 1; $i <= $tmp; $i++) {
            $pages_links[$i] = $i;
        }

        if ($this->page > $N && $this->page <= ($total_pages - $N + 2)) {
            for ($i = $this->page - 3; $i <= $this->page + 3; $i++) {
                if ($i > 0 && $i < $total_pages) {
                    $pages_links[$i] = $i;
                }
            }
        }

        $tmp = $total_pages - $N + 1;
        if ($tmp > $this->page - 2) {
            $tmp = $total_pages - 1;
        }
        for ($i = $tmp; $i <= $total_pages; $i++) {
            if ($i > 0) {
                $pages_links[$i] = $i;
            }
        }

        $start = $offset+1;
        $end = $offset+$this->per_page;
        $per_pagez = $this->per_page;
        $filter = $this->filter;
        $order = $this->sort_by;
        $sort = $this->sort_type;
        $html = <<<EOT
            <div class="smj-half-box">
                <div class="flex-container">
                    <div class="flex-item-left">
                        <p class="text-muted"> Menampilkan $start hingga $end dari $total_records entri </p>
                    </div>
                    <div class="flex-item-right" style="text-align:right;">
                        <div class="smj-pagination">
        EOT;
                        $prevx = 0;
                        foreach ($pages_links as $p) {
                            $p = intval($p);
                            $active = ($p === $this->page)? 'active' : '';

                            if($this->page > 1 && $p <= 1){
                                $html .= <<<EOT
                                    <a href="?page=1&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" > &laquo; First</a>
                                EOT;
                                $prev = $this->page - 1;
                                $html .= <<<EOT
                                    <a href="?page=$prev&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" > &laquo; </a>
                                EOT;
                            }

                            if($this->page === 1 && $p === 1){
                                $html .= <<<EOT
                                    <a href="?page=1&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" class="$active" > &laquo; First</a>
                                EOT;
                            }

                            if (($p - $prevx) > 1) {
                                $html .= <<<EOT
                                    <a href="#" > ... </a>
                                EOT;
                            }
                            $prevx = $p;

                            $html .= <<<EOT
                                <a href="?page=$p&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" class="$active"> $p </a>
                            EOT;

                            if($p == (max($pages_links)) && $this->page < (max($pages_links))){
                                $next = $this->page + 1;
                                $html .= <<<EOT
                                    <a href="?page=$next&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" > &raquo; </a>
                                EOT;
                                $last = (max($pages_links));
                                $html .= <<<EOT
                                    <a href="?page=$last&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" > Last &raquo; </a>
                                EOT;
                            }
                            if($this->page === intval(max($pages_links)) && $p === intval(max($pages_links))){
                                $last = (max($pages_links));
                                $html .= <<<EOT
                                <a href="?page=$last&per_page=$per_pagez&filter=$filter&order=$order&sort=$sort" class="$active"> Last &raquo; </a>
                                EOT;
                            }

                        }
        $html .= <<<EOT
                        </div>
                    </div>
                </div>
            </div>
        EOT;
        return $html;
    }

    protected function qLike($str, $searchTerm) {
        $searchTerm = strtolower($searchTerm);
        $str = strtolower($str);
        $pos = strpos($str, $searchTerm);
        if ($pos === false)
            return false;
        else
            return true;
    }
    
    
}

