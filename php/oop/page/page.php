<?php  
    header("Content-Type:text/html;charset=utf-8");  
    mysql_connect('localhost','root','root');  
    mysql_select_db('test');  
    $sql="select * from test where 1";  
    $result=mysql_query($sql);  
    $total_num=mysql_num_rows($result);//查出一共有多少条记录  
    $show_num=3;//显示多少条  
    $total_pages=ceil($total_num/$show_num);//获取总的页数，ceil向上去整，floor向下  
    $current=isset($_GET['page'])?$_GET['page']:1;//当前页号  
    $next=($current==$total_pages)?false:$current+1;  
    $prev=($current==1)?false:$current-1;  
    $offset=($current-1)*$show_num;  
    $sql="select * from goods limit $offset,3";//offset为偏移量，代表查询时候，数据库起始位置  
    $result=mysql_query($sql);  
    mysql_close();  
?>

<table>  
    <tr><th>id</th><th>name</th><th>price</th><th>mprice</th></tr>  
    <?php while($arr=mysql_fetch_assoc($result)){  
        $id=$arr['id'];  
        $name=$arr['name'];  
        $price=$arr['price'];  
        $mprice=$arr['mprice'];  
    ?>  
        <tr><td><?php echo $id ?></td><td><?php echo $name ?></td><td><?php echo $price ?></td><td><?php echo $mprice ?></td></tr>  
    <?php } ?>  
    <tr><td colspan="4">  
        <?php  
            echo "一共有{$total_num}条记录，显示{$show_num}条，{$current}/{$total_pages}";  
            echo "首页";  
            if(!$prev){  
                echo "上一页";  
            }else{  
                echo "<a href='fenye.php?page={$prev}'>上一页</a>";  
            }  
            if(!$next){  
                echo "下一页";  
            }else{  
                echo "<a href='fenye.php?page={$next}'>下一页</a>";  
            }  
            echo "尾页";  
            unset($result);  
        ?>  
    </td></tr>  
</table>