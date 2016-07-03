<?php
class Paginator{

    private $_perPage; // so post 1 _page
    private $_instance; // biến để get page
    private $_page; // so trang (vd : trang _page )
    private $_limit; // limit số post 1 trang, dùng để truy vấn sql
    private $_totalRows = 0;

    public function __construct($perPage,$instance){ // $pages = new Paginator('5','p');
        $this->_instance = $instance; // $instance = 'p';
        $this->_perPage = $perPage; // = 5
        $this->set_instance(); // kiểm tra bằng hàm set_instance để nó trả về kq đúng và set _page
    }

    public function get_start(){ // lấy start limit để get ví dụ trang 1 sẽ là limit 0,5 nếu new Paginator('5','p');
        return ($this->_page * $this->_perPage) - $this->_perPage;
    }

    private function set_instance(){
        $this->_page = (int) (!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]);
        $this->_page = ($this->_page == 0 ? 1 : $this->_page); // khi p =2
    }

    public function set_total($_totalRows){ // lấy tổng số dòng (postID)
        $this->_totalRows = $_totalRows; // 49 dòng
    }

    public function get_limit(){ // p=1 lấy 0,5 tức là lấy 5 dòng bắt đầu từ dòng 0,
        // nếu p = 2 thì getstart trả về 5,5 là lấy 5 dòng bắt đầu từ dòng số 5
        return "LIMIT ".$this->get_start().",$this->_perPage"; //sử dụng để getpost với limit
    }

    public function page_links($path='?',$ext=null)
    {
        $adjacents = "2"; // số nút hiện trang khi tràn khỏi 10 nút
        $prev = $this->_page - 1; // 0
        $next = $this->_page + 1;  // 2
        $lastpage = ceil($this->_totalRows/$this->_perPage);// tổng số post / số post mỗi trang -> trang cuối
        $lpm1 = $lastpage - 1;  // hiện tại ta có 49 post, 5 post per page thì $lastpage =10
        //lpm1 = 9
        $pagination = "";
        if($lastpage > 1)// nếu có ít hơn số post yêu cầu 1 trang thì sẽ không có paginator
        {

            $pagination .= "<ul class='pagination'>"; //bootstrap paginator 
            //khai báo
            if ($this->_page > 1)
                $pagination.= "<li><a href='".$path."$this->_instance=$prev"."$ext'>Previous</a></li>";
                //<li><a href='?p=1'>Previous</a></li>
            else
                $pagination.= "<li ><span class='disabled'>Previous</span></li>";
            // trường hợp bé hơn 11 page , show 10 nút 10 trang
            if ($lastpage < 7 + ($adjacents * 2)) // nếu bé hơn 11 tức là 10trang trở xuống
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $this->_page) // == 1
                        $pagination.= "<li class='active'><span class='current'>$counter</span></li>"; // trang 1 đang current
                    else
                        $pagination.= "<li><a href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
                                        //     href='?p=2'
                }   // in ra hết các phần tử trang tiếp theo
            } // kết thúc trường hợp show 10 trang

            elseif($lastpage > 5 + ($adjacents * 2)) // tức là 10 trang trở lên bao gồm trường hợp trên sẽ là từ 11 trở lên
            {
                if($this->_page < 1 + ($adjacents * 2)) // nếu trang hiện tại < 5
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) // chạy từ 1 tới 7
                    {
                        if ($counter == $this->_page)
                            $pagination.= "<li class='active'><span class='current'>$counter</span></li>";
                            // current
                        else
                            $pagination.= "<li><a href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
                            // tạo hết các nút các còn lại
                    }
                    $pagination.= "<li><span>...</span></li>"; // nốt ...
                    $pagination.= "<li><a href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a></li>"; // nốt 19
                    $pagination.= "<li><a href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a></li>"; // nốt 20
                    // vd đang ở trang 1, và bạn có 20 trang
                    // thì cái paginator sẽ là 1,2,3,4,5,6,7,...,19,20
                    // 1,2,3,4,5,6,7,...,10,11 <--- trường hợp nhỏ nhất của điều kiện này
                }
                elseif($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2))
                {    // nếu trang cuối 20 - 4 = 16  > 14 và 14 > 4
                    $pagination.= "<li><a href='".$path."$this->_instance=1"."$ext'>1</a></li>";
                    $pagination.= "<li><a href='".$path."$this->_instance=2"."$ext'>2</a></li>";
                    $pagination.= "<li><span>...</span></li>";
                    for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++)
                    {    // chạy từ 14-2 là 12  đến 16, nếu  == thì current
                        if ($counter == $this->_page)
                            $pagination.= "<li class='active'><a><span class='current'>$counter</span></a></li>";
                        else // in các nút cho tới 16
                            $pagination.= "<li><a href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
                    }
                    $pagination.= "<li><span>...</span></li>"; // chấm chấm
                    $pagination.= "<li><a href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a></li>"; //nốt kề cuối
                    $pagination.= "<li><a href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a></li>"; // nốt cuối
                }
                else
                { //nếu đang ở trang mà 4 nốt tiếp theo là 4 nốt cuối
                    $pagination.= "<li><a href='".$path."$this->_instance=1"."$ext'>1</a></li>";
                    $pagination.= "<li><a href='".$path."$this->_instance=2"."$ext'>2</a></li>";
                    $pagination.= "<li><span>...</span></li>"; // 2 nốt đầu và .. là hết 3 ô
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $this->_page)
                            $pagination.= "<li class='active'><span class='current'>$counter</span></li>"; // in ra tới khi nào trùng thì active
                        else
                            $pagination.= "<li><a href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
                        //còn không thì in ra nút bt`
                    }
                }
            }
            if ($this->_page < $counter - 1) // nếu trang hiện tại vẫn bé hơn $counter (counter đếm đến lastpage)
                $pagination.= "<li><a href='".$path."$this->_instance=$next"."$ext'>Next</a></li>";
            else // thì nút next sẽ đến trang ?p=$next next được khởi tạo trên cùng
                $pagination.= "<li><span class='disabled'>Next</span></li>";
            $pagination.= "</ul>\n"; // nếu đã là page cuối cùng thì nút next bị disable
        }
        return $pagination; //xong pagination, sẵn sàng nhúng vào trang
    }
}
