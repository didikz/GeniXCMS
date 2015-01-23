<?php if(!defined('GX_LIB')) die("Direct Access Not Allowed!");
/*
*    GeniXCMS - Content Management System
*    ============================================================
*    Build          : 20140925
*    Version        : 0.0.1 pre
*    Developed By   : Puguh Wijayanto (www.metalgenix.com)
*    License        : Private
*    ------------------------------------------------------------
* filename : posts.control.php
* version : 0.0.1 pre
* build : 20141006
*/


if(isset($_GET['act'])) $act = $_GET['act']; else $act = "";
switch ($act) {
    case 'add':
        # code...
        $data[] = '';
        switch (isset($_POST['submit'])) {
            case true:
                # code...
                if (!isset($_POST['date']) || $_POST['date'] == "") {
                    # code...
                    $date = date("Y-m-d H:i:s");
                }else{
                    $date = $_POST['date'];
                }
                $vars = array(
                                'title' => Typo::cleanX($_POST['title']),
                                'cat' => $_POST['cat'],
                                'content' => Typo::cleanX($_POST['content']),
                                'date' => $date,
                                'type' => 'post',
                                'author' => Session::val('username'),
                                'status' => $_POST['status'],
                            );
                //print_r($vars);
                Posts::insert($vars);
                $data['alertgreen'][] = "Post : {$_POST['title']} Added.";
                break;
            
            default:
                # code...
                
                break;
        }
        System::inc('posts_form', $data);
        //echo "add";
        break;

    case 'edit':
        //echo "edit";
        switch (isset($_POST['submit'])) {
            case true:
                # code...
                
                $moddate = date("Y-m-d H:i:s");
                $vars = array(
                                'title' => Typo::cleanX($_POST['title']),
                                'cat' => $_POST['cat'],
                                'content' => Typo::cleanX($_POST['content']),
                                'modified' => $moddate,
                                'date' => $_POST['date'],
                                'status' => $_POST['status'],
                            );
                //print_r($vars);
                
                Posts::update($vars);
                $data['alertgreen'][] = "Post : <b>{$_POST['title']}</b> Updated.";
                break;
            
            default:
                # code...
                //System::inc('posts_form', $data);
                break;
        }

        $data['post'] = Db::result("SELECT * FROM `posts` WHERE `id` = '{$_GET['id']}' ");
        System::inc('posts_form', $data);

        break;


    default:
        # code...
        if(isset($_GET['act']) && $_GET['act'] == 'del'){
            if(isset($_GET['id'])){
                $title = Posts::title($_GET['id']);
                $del = Posts::delete($_GET['id']);
                //echo $title['error'];
                if(isset($del['error'])){
                    $data['alertred'][] = $del['error'];
                }else{
                    $data['alertgreen'][] = 'Post <b>'.$title.'</b> Removed';
                }
                
            }else{
                $data['alertred'][] = 'No ID Selected';
            }
            
        }

        $max = "10";
        if(isset($_GET['paging'])){
            $paging = $_GET['paging'];
            $offset = ($_GET['paging']-1)*$max;
        }else{
            $paging = 1;
            $offset = 0;
        }
        
        $data['posts'] = Db::result("SELECT * FROM `posts` WHERE `type` = 'post' ORDER BY `date` DESC LIMIT {$offset},{$max}");
        $data['num'] = Db::$num_rows;
        System::inc('posts', $data);

        $page = array(
                    'paging' => $paging,
                    'table' => 'posts',
                    'where' => "`type` = 'post'",
                    'max' => 10,
                    'url' => 'index.php?page=posts',
                    'type' => 'pager'
                );
        echo Paging::create($page);
        break;
}

/* End of file posts.control.php */
/* Location: ./inc/lib/Control/Backend/posts.control.php */