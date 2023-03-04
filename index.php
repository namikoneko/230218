<?php
ini_set('display_errors', 1);

require_once '../libs/flight/Flight.php';
//require_once '../libs/Parsedown.php';

//require_once '../libs/Michelf/MarkdownExtra.inc.php';
//use \Michelf\MarkdownExtra;

require_once ("../libs/blade/BladeOne.php");
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new BladeOne($views,$cache,BladeOne::MODE_DEBUG);
Flight::set('blade', $blade);

$baseUrl = "/230218/";
Flight::set('baseUrl', $baseUrl);


//pageList
Flight::route('/pageList', function(){//################################################## datasTop

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("select * from page order by id desc");
    //$array = array($id);
    $stmt->execute();

    $rows = makeRows($stmt);

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("pageList",array("rows"=>$rows,"baseUrl"=>$baseUrl)); //
});

//catList
Flight::route('/@page/catList', function($page){//################################################## datasTop

    $db = new PDO('sqlite:data.db');

//pageRowを取得
    $stmt = $db->prepare("select * from page where id = ?");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $pageRow = $rows[0];

    $stmt = $db->prepare("select * from cat where page = ? order by id desc");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("catList",array("rows"=>$rows,"baseUrl"=>$baseUrl,"pageRow"=>$pageRow)); //
});

//dataList
Flight::route('/@page/dataList', function($page){//################################################## datasTop

    $db = new PDO('sqlite:data.db');

//pageRowを取得
    $stmt = $db->prepare("select * from page where id = ?");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $pageRow = $rows[0];

//catを、pageで絞り込み

    $stmt = $db->prepare("select * from cat where page = ? order by id desc");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);

//catの配列を作成
$catArr = [];
foreach($rows as $row){
    $catArr[] = $row["id"];
}

$innerIn = substr(str_repeat(',?', count($catArr)), 1); // '?,?,?'

    $stmt = $db->prepare("select * from data where cat in ({$innerIn})");
    $stmt->execute($catArr);

    $rows = makeRows($stmt);

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("dataList",array("rows"=>$rows,"baseUrl"=>$baseUrl,"pageRow"=>$pageRow)); //
});

//pageInsExe
Flight::route('/pageInsExe', function(){//################################################## datasTop

    $title = Flight::request()->data->title;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into page (title,updated,sort) values (?,?,?)");
    $array = array($title,time(),0);
    $stmt->execute($array);
    Flight::redirect('/pageList');
});

//pageUpd
Flight::route('/pageUpd', function(){//################################################## catUpd

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("select * from page where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("pageUpd",array("row"=>$row,"baseUrl"=>$baseUrl)); //
});

//pageUpdExe
Flight::route('/pageUpdExe', function(){//################################################## catUpdExe

    $id = Flight::request()->data->id;
    $title = Flight::request()->data->title;//
    $sort = Flight::request()->data->sort;//


    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update page set title = ?,sort = ? where id = ?");
    $array = array($title, $sort, $id);
    $stmt->execute($array);

    Flight::redirect('/pageList');
});

//pageDel
Flight::route('/pageDel/@id', function($id){//################################################## catDel
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("delete from page where id = ?");
    $array = array($id);
    $stmt->execute($array);

    Flight::redirect('/pageList');
});

//catInsExe
Flight::route('/catInsExe', function(){//################################################## datasTop

    $page = Flight::request()->data->page;
    $title = Flight::request()->data->title;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into cat (page,title,updated,sort) values (?,?,?,?)");

//    $stmt = $db->prepare("insert into cat (title,updated,sort) values (?,?,?)");

    $array = array($page,$title,time(),0);

//    $array = array($title,time(),0);
    $stmt->execute($array);
    Flight::redirect('/' . $page . '/datas');

    //Flight::redirect('/datas');
});

//catUpd
Flight::route('/@page/catUpd', function($page){//################################################## catUpd

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("catUpd",array("row"=>$row,"baseUrl"=>$baseUrl)); //
//  echo $blade->run("catUpd",array("row"=>$row,"baseUrl"=>$baseUrl,"page"=>$page)); //

});

//catUpdExe
Flight::route('/@page/catUpdExe', function($page){//################################################## catUpdExe

    //$page = Flight::request()->data->page;
    $id = Flight::request()->data->id;
    $title = Flight::request()->data->title;//
    $sort = Flight::request()->data->sort;//


    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update cat set title = ?,sort = ? where id = ?");
    $array = array($title, $sort, $id);
    $stmt->execute($array);

/*

//pageのためにrowを取得する
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];
*/

    Flight::redirect('/' . $page . '/datas');

//    Flight::redirect('/' . $row["page"] . '/datas');
});

//catDel
Flight::route('/@page/catDel/@id', function($page,$id){//################################################## catDel

    $db = new PDO('sqlite:data.db');

/*
//削除前にrow（page）を取得する
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];
*/

//delete
    $stmt = $db->prepare("delete from cat where id = ?");
    $array = array($id);
    $stmt->execute($array);

    Flight::redirect('/' . $page . '/datas');

//    Flight::redirect('/' . $row["page"] . '/datas');

});

//datas
Flight::route('/@page/datas', function($page){//################################################## datasTop

    //echo "data";

    $db = new PDO('sqlite:./data.db');

//pageRowを取得
    $stmt = $db->prepare("select * from page where id = ?");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $pageRow = $rows[0];


    $stmt = $db->prepare("select * from cat where page = ? order by sort desc");
    $array = array($page);
    $stmt->execute($array);
    $rowsCat = makeRows($stmt);

$str = "";

foreach($rowsCat as $rowCat){

    $stmt = $db->prepare("select * from data where cat = " . $rowCat["id"] . " and parent = 0 order by sort desc");

    $stmt->execute();

    $rows0 = makeRows($stmt);

//$rowsBox = [];
//$i = 0;

//$str .= $rowCat["sort"];



$str .= '<div class="row">';

$str .= '<h3 class="col-4 mt-2">';
$str .= $rowCat["title"];
$str .= '</h3>';

$baseUrl = Flight::get('baseUrl');//

//cat update
$str .= '<span class="ms-2 col-1  d-flex align-items-center"><a href="';
$str .= "catUpd?id=" . $rowCat["id"];

//$str .= $baseUrl . "catUpd?id=" . $rowCat["id"];
$str .= '">';
$str .= "update";
$str .= '</a></span>';

$str .= '</div>';



//$str .= '<div class="col-8">';

$str .= '<form class="ins-form mt-2 row" action="' . $baseUrl . 'dataInsExe" method="post">';

$str .= '<input type="hidden" class="" name="cat" value=' . $rowCat["id"] . '>';

$str .= '<div class="row">';

    $str .= '<div class="col-3">';
    $str .= "parent";
    $str .= '<input type="text" class="inputText form-control" name="parent">';
    $str .= '</div>';

    $str .= '<div class="col-3">';
    $str .= "title";
    $str .= '<input type="text" class="inputText form-control" name="title">';
    $str .= '</div>';

    $str .= '<div class="col-3">';
    $str .= "url";
    $str .= '<input type="text" class="inputText form-control" name="url">';
    $str .= '</div>';

    $str .= '<div class="col-3 d-flex align-items-end">';
    $str .= '<input class="btn btn-light mt-2" type="submit" value="insert">';
    $str .= '</div>';

$str .= '</div>';


$str .= '</form>';

//$str .= '</div>';

/*
$str .= '<div class="col-4">';
//update
$str .= '<form class="ins-form mt-2 row" action="' . $baseUrl . 'dataUpd" method="get">';
$str .= '<div class="col-6">';
$str .= "id";
$str .= '<input type="text" class="inputText form-control" name="id">';
$str .= '</div>';
$str .= '<div class="col-6 d-flex align-items-end">';
$str .= '<input class="btn btn-light mt-2" type="submit" value="send">';
$str .= '</div>';

$str .= '</form>';
$str .= '</div>';
*/

//1階層目----------------------------------------------------------------------------------------------------

$str .= '<ul class="gnav mt-2">';

foreach($rows0 as $row0){

$str .= '<li class="row">';
//$str .= '<li class="">';

//update
$str .= '<a class="col-2" href="';
$str .= 'dataUpd?id=';
$str .= $row0["id"];
$str .= '">';
$str .= $row0["id"];
$str .= '</a>';
/*
*/

//$str .= "</span>";

$str .= '<a class="col-10" href="';
$str .= $row0["url"];
$str .= '" target="_blank">';
$str .= $row0["title"];
//$str .= $row0["id"] . " " . $row0["title"];
$str .= '</a>';

//1つ下のレベルに要素があるか調べる
    $stmt = $db->prepare("select * from data where parent = " . $row0["id"] . " order by sort desc");
    $stmt->execute();
    $rows1 = makeRows($stmt);

//2階層目----------------------------------------------------------------------------------------------------
    //0でなければ
    if(count($rows1) <> 0){

        $str .= '<ul class="">';

        foreach($rows1 as $row1){

            $str .= '<li class="row">';
            //$str .= '<span class="">' . $row1["id"] . '</span>';//id

//update
            $str .= '<a class="col-2" href="';
            $str .= 'dataUpd?id=';
            $str .= $row1["id"];
            $str .= '">';
            $str .= $row1["id"];
            $str .= '</a>';

            $str .= '<a class="col-10" href="';
            $str .= $row1["url"];
            $str .= '" target="_blank">';

            //$str .= '">';
            $str .= $row1["title"];
//            $str .= $row1["id"] . " " . $row1["title"];
            $str .= '</a>';

        //1つ下のレベルに要素があるか調べる
            $stmt = $db->prepare("select * from data where parent = " . $row1["id"] . " order by sort desc");
            $stmt->execute();
            $rows2 = makeRows($stmt);

//3階層目----------------------------------------------------------------------------------------------------
                //0でなければ
                if(count($rows2) <> 0){

                    $str .= '<ul class="">';

                    foreach($rows2 as $row2){

                        $str .= '<li class="row">';
                        //$str .= '<span class="">' . $row2["id"] . '</span>';//id

                        $str .= '<a class="col-2" href="';
                        $str .= 'dataUpd?id=';
                        $str .= $row2["id"];
                        $str .= '">';
                        $str .= $row2["id"];
                        $str .= '</a>';

                        $str .= '<a class="col-10" href="';
                        $str .= $row2["url"];
                        $str .= '" target="_blank">';

                        //$str .= '">';
                        $str .= $row2["title"];
                        //$str .= $row2["id"] . " " . $row2["title"];
                        $str .= '</a>';
/*
                        //update
                        $str .= '<span class="ms-2"><a href="';
                        $str .= $baseUrl . "dataUpd/" . $row2["id"];
                        $str .= '">';
                        $str .= "update";
                        $str .= '</a></span>';
*/
                        $str .= '</li>';

                    }//foreach $rows2

                    $str .= '</ul>';

                }//if count $rows2
//----------------------------------------------------------------------------------------------------

            $str .= '</li>';

        }//foreach $rows1

        $str .= '</ul>';

    }//if count $rows1
//----------------------------------------------------------------------------------------------------

$str .= '</li>';

}//foreach $rows0

$str .= '</ul>';

}//foreach($rowsCat

//echo $str;


    $blade = Flight::get('blade');
    echo $blade->run("data",array("str"=>$str,"page"=>$page,"pageRow"=>$pageRow)); //

});

//dataInsExe
Flight::route('/dataInsExe', function(){//################################################## datasTop

    $parent = Flight::request()->data->parent;
    if($parent == ""){$parent = 0;}
    $title = Flight::request()->data->title;
    $url = Flight::request()->data->url;
    $cat = Flight::request()->data->cat;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("insert into data (parent,title,url,updated,sort,cat) values (?,?,?,?,?,?)");
    $array = array($parent,$title,$url,time(),0,$cat);
    $stmt->execute($array);

//pageのためにrowを取得する
    $stmt = $db->prepare("select * from cat where id = ?");
    $array = array($cat);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

    Flight::redirect('/' . $row["page"] . '/datas');

//    Flight::redirect('/datas');
});

//dataUpd
Flight::route('/@page/dataUpd', function($page){//################################################## catUpd

    $id = Flight::request()->query->id;

    $db = new PDO('sqlite:./data.db');
    $stmt = $db->prepare("select * from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

    $rows = makeRows($stmt);
    $row = $rows[0];

  $baseUrl = Flight::get('baseUrl');//
  $blade = Flight::get('blade');//
  echo $blade->run("dataUpd",array("row"=>$row,"baseUrl"=>$baseUrl)); //
});

//dataUpdExe
Flight::route('/@page/dataUpdExe', function($page){//################################################## dataUpdExe

    $id = Flight::request()->data->id;
    $parent = Flight::request()->data->parent;
    $title = Flight::request()->data->title;//
    $url = Flight::request()->data->url;//
    $sort = Flight::request()->data->sort;//

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set parent = ?,title = ?,url = ?,sort = ? where id = ?");
    $array = array($parent, $title, $url, $sort, $id);
    $stmt->execute($array);

    Flight::redirect('/' . $page . '/datas');

//    Flight::redirect('/datas');
});

//dataDel
Flight::route('/@page/dataDel/@id', function($page,$id){//################################################## dataDel

    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("delete from data where id = ?");
    $array = array($id);
    $stmt->execute($array);

//echo "$id";

    Flight::redirect('/' . $page . '/datas');

    //Flight::redirect('/datas');
});

//dataUp
Flight::route('/dataUp/@id', function($id){//################################################## dataUp
    $db = new PDO('sqlite:data.db');
    $stmt = $db->prepare("update data set updated = ? where id = ?");
    $array = array(time(), $id);
    $stmt->execute($array);

    Flight::redirect('/datas');
});





Flight::route('/test', function(){//################################################## datasTop

    //echo "test";

$page = 3;

    $db = new PDO('sqlite:./data.db');

//catを、pageで絞り込み
    $stmt = $db->prepare("select * from cat where page = ? order by id desc");
    $array = array($page);
    $stmt->execute($array);

    $rows = makeRows($stmt);

print_r($rows);

echo "<hr>";

//catの配列を作成
$catArr = [];
foreach($rows as $row){
    $catArr[] = $row["id"];
}

print_r($catArr);

echo "<hr>";

$innerIn = substr(str_repeat(',?', count($catArr)), 1); // '?,?,?'

    $stmt = $db->prepare("select * from data where cat in ({$innerIn})");
    $stmt->execute($catArr);

//    $stmt = $db->prepare("select * from data where cat in (?)");
//    $stmt->execute(array($catArr));

    $rows = makeRows($stmt);
//    $row = $rows[0];

print_r($rows);

//echo "count:" . $row["count"];

/*

*/

});

function makeRows($stmt){
    $i = 0;
    $rows = [];
    while($row = $stmt->fetch()){
        $row["i"] = $i;
        $rows[$i] = $row;
        $i++;
    }
    return $rows;
}


Flight::start();

